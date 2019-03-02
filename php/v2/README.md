
                                             CEDIPLUS PHP API DOCUMENTATION
CediPlus API is designed to send bill or check bill, this documentation runs users through the process of sending and recieving bills using the CediPlus API.

**BASE URL: https://www.cediplus.com/api/v2**

PHASES
1. SEND BILL ---- **POST REQUEST**
2. CHECK BILL ---- **POST REQUEST**

                                                SEND BILL(POST REQUEST)
                                               
This sends a prompt to the users mobile device to authorize payments.

IMPLEMENTATION


| Parameters | Status | Values | Description |
| --- | --- | --- | --- |
| action | `required` | sendbill | This is to indicate transaction type whether to send bill or check bill |                               
| wallet_type | `required` | m,t | This is to indicate the wallet type to use for the transaction Where ‘m’ is for MTN and ‘t’ is for AirtelTigo wallets respectively |  
| wallet | `required` | 000 000 0000 | This is the phone number for the transaction |
| amount | `required` | 1.00 | Amount of money (maximum of 2,000.00 cedis and minimum of 1.00 cedis). |
| api_key | `required` | xxxxxxxxxxxxxxxxxxxxxx | This is your Business or Demo API key |
| description | `required` | testing | This is to give a description of the transaction. | 
| callback_url | `optional` | http://www.yourwebisteurl.com/callback_file | This is to receive a response via a post request when the transaction is successful or has failed. | 

Sample PHP code
```php
<?php
/** Parameter values declared as a variable and assigned example values
** m for MTN and t for AirtelTigo
**/


$cediplus_api_key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
$callback_url = 'http://www.yourwebisteurl.com/callback_file';
$wallet_number = '0240000000';
$amount = '2';
$description = 'description of the transaction';
            

$data = array(
  "action" => "sendbill", 
  "api_key" => $cediplus_api_key, 
  "wallet_type" => "m", 
  "wallet" => $wallet_number, 
  "amount" => $amount, 
  "description" => $description, 
  "callback_url" => $callback_url
); // POST data included in your query

$ch = curl_init("https://www.cediplus.com/api/v2"); // Set url to query 

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Send via POST                                         
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Set POST data                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response text   
curl_setopt($ch, CURLOPT_HEADER, "Content-Type: application/x-www-form-urlencoded"); // send POST data as form data

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, True);
echo $result;

?>
```
                                                SENDBILL RESPONSE(JSON)
**SUCCESSFUL BILLSENT RESPONSE**                                               

| state | invoice_number | response_msg | JSON | DESCRIPTION |
| --- | --- | --- | --- | --- | 
| 200 | xxxxxxxxxxxxxxxxxxxxxx | Transation Initiated | **{"state": "200","invoice_number": "xxxxxxxxxxxxxxxxxxx","response_msg":”Transaction Initiated”}** | bill sent response |


**SUCCESSFUL CALL BACK URL RESPONSE**   

The response will be sent to the call back url as a **POST REQUEST** 

Sample PHP code for your call back url
```php
<?php

if(isset($_POST['response']) && $_POST['response']){
    $response = $_POST['response'];
    $data = json_decode($response, True);
    $state = $data['state'];
    if($state == 200){
    /**
    ** get the rest of the successful state data...
    **/
    }else{
    /**
    ** get the rest of the failed state data...
    **/
    }
}

?>
```


| state | invoice_number | transaction_number | response_msg | status_code | JSON | DESCRIPTION |
| --- | --- | --- | --- | --- | --- | --- | 
| 200 | xxxxxxxxxxxxxxx | xxxxxxxxxxxxxxxxxxx | Payment Succesful | 1000 | **{"state": "200","invoice_number": "xxxxxxxxxxxxxxxxxxx","transaction_number": "xxxxxxxxxxxxxxxxxxx","response_msg":”payment successful”,"status_code": "1000"}** | Succesful Payment |




**UNSUCCESSFUL CALL BACK URL RESPONSE**                                               

| state | invoice_number | response_msg | status_code | JSON |
| --- | --- | --- | --- | --- |
| 200 | xxxxxxxxxxxxxxx | wallet number is not registere | 5000 | **{"state": "200","invoice_number": "xxxxxxxxxxxxxxxxxxx", "status_code": "5000","response_msg ": "wallet number is not registered"}** |
| 200 | xxxxxxxxxxxxxxx | transaction failed | 4000 | **{"state": "200","invoice_number": "xxxxxxxxxxxxxxxxxxx","status_code": "4000","response_msg ": "transaction failed"}** |




**UNSUCCESSFUL BILLSENT RESPONSE**                                               

| state | response_msg | JSON |
| --- | --- | --- |
| 400 | invalid parameters | **{"state": "400"," response_msg ": "invalid parameters"}** |
| 400 | required parameters missing | **{"state": "400"," response_msg ": "required parameters missing"}** |
| 400 | demo transaction limit | **{"state": "400"," response_msg ": "demo transaction limit"}** |
| 400 | invalid demo testing number | **{"state": "400"," response_msg ": "invalid demo testing number"}** |


                                                CHECKBILL(POST REQUEST)
                                               
 The generated invoice number from the send bill is used to check the status of the bill to see if it was successful, failed or yet to be paid
 
                                                
IMPLEMENTATION

| Parameters | Status | Values | Description |
| --- | --- | --- | --- |
| action | `required` | checkbill | This is to indicate transaction type whether to send bill or check bill |
| api_key | `required` | xxxxxxxxxxxxxxxxxxxxxx | This is your Business or Demo API key |
| invoice | `required` | xxxxxxxxxx | This is an invoice id used to check status of bill sent. | 

Sample PHP code
```php
<?php

/**Parameter values declared as a variable and assigned example values**/
$cediplus_api_key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
$invoice_number = '0000000000000000';           

$data = array(
  "action" => "checkbill", 
  "api_key" => $cediplus_api_key, 
  "invoice" => $invoice_number
); // POST data included in your query

$ch = curl_init("https://www.cediplus.com/api/v2"); // Set url to query 

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); // Send via POST                                         
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Set POST data                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response text   
curl_setopt($ch, CURLOPT_HEADER, "Content-Type: application/x-www-form-urlencoded"); // send POST data as form data

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, True);
echo $result;
?>
```

                                               CHECKBILL RESPONSE(JSON)
**SUCCESSFUL CHECKBILL RESPONSE**                                               

| state | transaction_number | response_msg | status_code | JSON | DESCRIPTION |
| --- | --- | --- | --- | --- | --- | 
| 200 | xxxxxxxxxxxxxxxxxxxxxx | Payment Succesful | 1000 | **{"state": "200","transaction_number": "xxxxxxxxxxxxxxxxxxx","response_msg":”payment successful”,"status_code": "1000"}** | Succesful Payment |

**UNSUCCESSFUL CHECKBILL RESPONSE**                                               

| state | response_msg | status_code | JSON |
| --- | --- | --- | --- |
| 200 | wallet number is not registere | 5000 | **{"state": "200", "status_code": "5000","response_msg ": "wallet number is not registered"}** |
| 200 | transaction failed | 4000 | **{"state": "200","status_code": "4000","response_msg ": "transaction failed"}** |
| 200 | yet to be paid | 2000 | **{"state": "200","status_code": "2000","response_msg ": "yet to be paid"}** |
| 400 | invalid parameters |      | **{"state": "400","response_msg ": "invalid parameters"}** |
| 400 | required parameters missing |      |**{"state": "400"," response_msg ": "required parameters missing"}** |
| 200 | unkown error | 0000 |**{"state": "200","status_code": "0000","response_msg ": "unkown error"}** |



                    

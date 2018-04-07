                                             CEDIPLUS PHP API DOCUMENTATION
CediPlus API is designed to send bill or check bill, this documentation runs users through the process of sending and recieving bills using the CediPlus API.

**BASE URL: https://www.cediplus.com/apiplus/plus_v1**

PHASES
1. SEND BILL ---- **POST REQUEST**
2. CHECK BILL ---- **POST REQUEST**

                                                SEND BILL(POST REQUEST)
                                               
This sends a prompt to the users mobile device to authorize payments.

IMPLEMENTATION


| Parameters | Status | Values | Description |
| --- | --- | --- | --- |
| action | `required` | sendbill | This is to indicate transaction type whether to send bill or check bill |                               
| wallet_type | `required` | m,t | This is to indicate the wallet type to use for the transaction Where ‘m’ is for mtn and ‘t’ is for tigo wallets respectively |  
| wallet | `required` | 000 000 0000 | This is the phone number for the transaction |
| amount | `required` | 1.00 | Amount of money (max of 999,999.00 cedis). |
| api_key | `required` | xxxxxxxxxxxxxxxxxxxxxx | This is your Business or Demo API key |
| description | `required` | testing | This is to give a description of the transaction. | 

Sample PHP code
```php
<?php

/** Parameter values declared as a variable and assigned example values
** M for MTN and T for Tigo
**/
$wallet_type = 'm';
$wallet = '0248499091';
$amount = '1.00';
$description = 'personal';
$api_key = 'xxxxxxxxxxxxxxx'; 

$base_url = "https://www.cediplus.com/apiplus/plus_v1";
$base_url_parameters = 'wallet_type='.$wtype.'&wallet='.$wallet.'&amount='.$amount.'&description='.$description.'&api_key='.$api_key.'&action=sendbill'; 
   $aHTTP = array(
     'http' => array(
       'method'  => 'POST',
       'header'  => 'Content-type: application/x-www-form-urlencoded',
       'content' => $sPD
     )
   );
   $context = stream_context_create($aHTTP);
   $resultx = file_get_contents($sURL, false, $context);
   $result = json_decode($resultx, TRUE);

?>
```
                                                SENDBILL RESPONSE(JSON)
**SUCCESFUL BILLSENT RESPONSE**                                               

| state | invoice_number | response_msg | status_code | JSON | DESCRIPTION |
| --- | --- | --- | --- | --- | --- | 
| 200 | xxxxxxxxxxxxxxxxxxxxxx | Transation Initiated | 0000 | **{"state": "200","invoice_number": "xxxxxxxxxxxxxxxxxxx","response_msg":”Transaction Initiated”,"status_code": "0000",}** | bill sent response |

**UNSUCCESFUL BILLSENT RESPONSE**                                               

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
$invoice = 'xxxxxxxxxxx';
$api_key = 'xxxxxxxxxxxxxxx';

$base_url = "https://www.cediplus.com/apiplus/plus_v1";
$base_url_parameters = 'invoice='.$invoice.'&api_key='.$api_key.'&action=checkbill'; 
   $aHTTP = array(
     'http' => array(
       'method'  => 'POST',
       'header'  => 'Content-type: application/x-www-form-urlencoded',
       'content' => $sPD
     )
   );
   $context = stream_context_create($aHTTP);
   $resultx = file_get_contents($sURL, false, $context);
   $result = json_decode($resultx, TRUE);

?>
```

                                               CHECKBILL RESPONSE(JSON)
**SUCCESFUL CHECKBILL RESPONSE**                                               

| state | transaction_number | response_msg | status_code | JSON | DESCRIPTION |
| --- | --- | --- | --- | --- | --- | 
| 200 | xxxxxxxxxxxxxxxxxxxxxx | Payment Succesful | 1000 | **{"state": "200","transaction_number": "xxxxxxxxxxxxxxxxxxx","response_msg":”payment successful”,"status_code": "1000",}** | Succesful Payment |

**UNSUCCESFUL CHECKBILL RESPONSE**                                               

| state | response_msg | status_code | JSON |
| --- | --- | --- | --- |
| 200 | wallet number is not registere | 5000 | **{"state": "200", "status_code": "5000","response_msg ": "wallet number is not registere"}** |
| 200 | transaction failed | 4000 | **{"state": "200","status_code": "4000","response_msg ": "transaction failed"}** |
| 200 | yet to be paid | 2000 | **{"state": "200","status_code": "2000","response_msg ": "yet to be paid"}** |
| 400 | invalid parameters |      | **{"state": "400","response_msg ": "invalid parameters"}** |
| 400 | required parameters missing |      |**{"state": "400"," response_msg ": "required parameters missing"}** |
| 200 | unkown error | 0000 |**{"state": "200","status_code": "0000","response_msg ": "unkown error"}** |



                    

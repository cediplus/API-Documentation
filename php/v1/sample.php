<?php
$response=$form= '';
//SEND BILL(POST REQUEST) SAMPLE CODE
if (isset($_POST['submit'])) {
  $error = 0;
  
	$wallet = $_POST['wallet'];//wallet number 
	$amount = $_POST['amount'];//amount of money
	$api_key = 'xxxxxxxxxxxxxxx';//api key generated by system
	$wallet_type = 'm'; //wallet type('m' for MTN, 't' for Tigo)
	$description = 'Demo'; //Description of transaction
	if (empty($wallet)) {
		$error++;
	}
	if (empty($amount)) {
		$error++;
	}
	if (empty($api_key)) {
		$error++;
	}
	if (empty($wallet_type)) {
		$error++;
	}
	if (empty($description)) {
		$error++;
	}

	if ($error == 0) {
		$response = sendbill($wallet_type, $wallet, $amount, $description, $api_key);
		$json = json_decode($response,TRUE); 	
		
    
    if($json['state'] == 200){
      $invoice = $json['invoice_number'];
      $form = '<form method="POST" action="">
                <input type="hidden" name="invoice" value="'.$invoice.'"/>
                <button type="submit" name="check">check</button>
              </form>';
    }
		
  }
  else{
    $response = 'Invalid Parameters';
  }
}
if (isset($_POST['check'])) {
  $error = 0;
	$invoice = $_POST['invoice'];
	$api_key = 'xxxxxxxxxxxxxxx';
	if (empty($invoice) || empty($api_key)) {
		$error++;
	}
	if ($error == 0) {
		$response = checkbill($invoice, $api_key);
  }
  else{
    $response = 'Invalid Parameters';
  }
}
function sendbill($wallet_type,$wallet,$amount,$description,$api_key){
  $base_url = "https://www.cediplus.com/apiplus/plus_v1";
  $base_url_parameters = 'wallet_type='.$wallet_type.'&wallet='.$wallet.'&amount='.$amount.'&description='.$description.'&api_key='.$api_key.'&action=sendbill'; 
   $header = array(
     'http' => array(
       'method'  => 'POST',
       'header'  => 'Content-type: application/x-www-form-urlencoded',
       'content' => $base_url_parameters
     )
   );
   $context = stream_context_create($header);
   $result = file_get_contents($base_url, false, $context);
   return $result;
}
//CHECK BILL(POST REQUEST) SAMPLE CODE
function checkbill($invoice,$api_key){
	//Parameter values declared as a variable and assigned example values

  $base_url = "https://www.cediplus.com/apiplus/plus_v1";
  $base_url_parameters = '&invoice='.$invoice.'&api_key='.$api_key.'&action=checkbill'; 
   $header = array(
     'http' => array(
       'method'  => 'POST',
       'header'  => 'Content-type: application/x-www-form-urlencoded',
       'content' => $base_url_parameters
     )
   );
   $context = stream_context_create($header);
   $result = file_get_contents($base_url, false, $context);
   return $result;
}
?>

<html>
	<form method="POST" action="">
		<input type="text" name="wallet" placeholder="Phone Number"/>
		<input type="number" name="amount" placeholder="Amount" />
		<button type="submit" name="submit">Send</button>
	</form>
	<p>Response: <span><?php echo $response;?></span></p></br>
	<span><?php echo $form;?></span>
</html>

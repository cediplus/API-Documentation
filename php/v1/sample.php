<?php
//SEND BILL(POST REQUEST) SAMPLE CODE

//Parameter values declared as a variable and assigned example values
$wtype = 'm';
$wallet = '0248499091';
$amount = '1.00';
$description = 'personal';
$api_key = 'xxxxxxxxxxxxxxx';

$sURL = "https://www.cediplus.com/apiplus/plus_v1";
$sPD = 'wallet_type='.$wtype.'&wallet='.$wallet.'&amount='.$amount.'&description='.$description.'&api_key='.$api_key.'&action=sendbill'; 
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
   

//CHECK BILL(POST REQUEST) SAMPLE CODE

//Parameter values declared as a variable and assigned example values
$invoice = 'xxxxxxxxxxx';
$api_key = 'xxxxxxxxxxxxxxx';

$sURL = "https://www.cediplus.com/apiplus/plus_v1";
$sPD = '&invoice='.$invoice.'&api_key='.$api_key.'&action=checkbill'; 
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
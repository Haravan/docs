<?php
//http://haravanapi.com/webhook.php
require 'config.php';

session_start();

function verify_webhook($data, $hmac_header)
{
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, HARAVAN_SECRET, true));
  return ($hmac_header == $calculated_hmac);
}

$hmac_header = "";
$shopdomain = "";
$topic = "";

if($_SERVER['HTTP_X_HARAVAN_HMAC_SHA256'])   $hmac_header = $_SERVER['HTTP_X_HARAVAN_HMAC_SHA256'];
if($_SERVER['HTTP_HARAVAN_SHOP_DOMAIN'])   $shopdomain = $_SERVER['HTTP_HARAVAN_SHOP_DOMAIN'];
if($_SERVER['HTTP_X_HARAVAN_TOPIC'])   $topic = $_SERVER['HTTP_X_HARAVAN_TOPIC'];


$data = file_get_contents('php://input');
$verified = verify_webhook($data, $hmac_header);


//echo "<pre>";
//var_dump($verified );
//echo "</pre>";

if($verified){
    echo "OK";
}else{
    echo "Unauthorized";
}
header("Status: 200 OK");

?>
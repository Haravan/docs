<?php

require 'haravan.php';
require 'config.php';

session_start();

if($_SESSION['token']){
    $sc = new HaravanClient($_SESSION['shop'], $_SESSION['token'], HARAVAN_API_KEY, HARAVAN_SECRET);

    try
    {
        // Get shop
        $shopjson = $sc->call('GET', '/admin/shop.json', array());
        
        echo "shop: " . $_SESSION['shop'];
        echo "<br/>token: " . $_SESSION['token'];
        echo "<br/>";
        
        echo "<pre>";
        var_dump($shopjson);
        echo "</pre>";

        /*
        //tạo webhook
        $data = array(
           "webhook" => array(
            "topic" => "orders/create",
            "address" => "http://haravanapi.com/webhook.php",
            "format" => "json"
           )
          );
  
        $registerhook = $sc->call('POST', '/admin/webhooks.json', $data);
        echo "<pre>";
        var_dump($registerhook);
        echo "</pre>";
        */
        
 
        /*
        //Get webhook
        $gethook = $sc->call('GET', '/admin/webhooks.json?topic=orders/create&address=http://haravanapi.com/webhook.php', array());
        echo "<pre>";
        var_dump($gethook);
        echo "</pre>";
        */
        
        
	}
    catch (HaravanApiException $e)
    {
		echo "<pre>";
        var_dump($e);
        echo "</pre>";
        die();
        /* 
         $e->getMethod() -> http method (GET, POST, PUT, DELETE)
         $e->getPath() -> path of failing request
         $e->getResponseHeaders() -> actually response headers from failing request
         $e->getResponse() -> curl response object
         $e->getParams() -> optional data that may have been passed that caused the failure

        */
    }
    catch (HaravanCurlException $e)
    {
        // $e->getMessage() returns value of curl_errno() and $e->getCode() returns value of curl_ error()
    }
	
}else{
    echo "Hello world! haha";
}


    
    
?>
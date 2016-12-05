<?php

require 'haravan.php';
require 'config.php';

if(HARAVAN_SHOP && HARAVAN_API_KEY && HARAVAN_API_PASSWORD){
    $sc = new HaravanClient(HARAVAN_SHOP, HARAVAN_API_KEY, HARAVAN_API_PASSWORD);

    try
    {
      
      /*
        // Get shop
        echo "shop: " . $_SESSION['shop'];
        $shopjson = $sc->call('GET', '/admin/shop.json?page=1', array());
        echo "<pre>";
        var_dump($shopjson);
        echo "</pre>";
    */

        /*
        //Get Product
        $LstProducts = $sc->call('GET', '/admin/products.json?limit=1', array());
        echo "<pre>";
        var_dump($LstProducts);
        echo "</pre>";
        */
     
/*
        //tạo Product
        $data = array(
           "product" => array(
            "body_html" => "dddddd",
            "product_type" => "Khác",
            "vendor" => "Khác",
            "title" => "Combo 2 túi vải đựng đồ cao cấp",
            "variants" => array(
                array(
                "barcode" => "CMC002294",
                "inventory_management" => "haravan",
                "inventory_policy" => "continue",
                "inventory_quantity" => 5,
                "price" => 118000,
                "sku" => "CMC002294",
                "option1"=>  "Default Title",
                "option2"=>  "",
                "option3"=>  ""
               ),
                array(
                "barcode" => "CMC002295",
                "inventory_management" => "haravan",
                "inventory_policy" => "continue",
                "inventory_quantity" => 10,
                "price" => 118000,
                "sku" => "DMC002295",
                "option1"=>  "màu xanh",
                "option2"=>  "",
                "option3"=>  ""
               )
            ),
            "options" => array(
                array(
                "name" => "Tiêu đề"
               )
            )
           )
          );
        $newProduct = $sc->call('POST', '/admin/products.json', $data);
        echo "<pre>";
        var_dump($newProduct);
        echo "</pre>";
*/


        //update Product
        $data = array(
           "product" => array(
            "variants" => array(
                array(
                "id" => 1009533173,
                "inventory_quantity" => 15,
               ),
                array(
                "id" => 1009533174,
                "inventory_quantity" => 20
               )
            )
           )
          );
        $newProduct = $sc->call('PUT', '/admin/products/1003736621.json', $data);
        echo "<pre>";
        var_dump($newProduct);
        echo "</pre>";



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
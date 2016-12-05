<?php
require 'haravan.php';
require 'config.php';

session_start();

    if (isset($_GET['code'])) { // if the code param has been sent to this page... we are in Step 2
    
        //die("if the code param has been sent to this page... we are in Step 2");
    
        // Step 2: do a form POST to get the access token
        $haravanClient = new HaravanClient($_GET['shop'], "", HARAVAN_API_KEY, HARAVAN_SECRET);
        session_unset();

        if(!$haravanClient->validateSignature($_GET)) die('Error: invalid signature.');

        // Now, request the token and store it in your session.
        $token =  $haravanClient->getAccessToken($_GET['code'], REDIRECT_URI);
        $_SESSION['token'] = $token;
        if ($_SESSION['token'] != '')
            $_SESSION['shop'] = $_GET['shop'];

        echo $token;
		
        if(IS_EMBED_APP){
            //nếu app nhúng thì cài app xong chuyển trang qua link App
    		//https://shopname.myharavan.com/admin/app#/embed/17920187d99a47bff0f5fe937d4c4383
            header("Location: " . 'https://' . $_SESSION['shop'] . '/admin/app#/embed/' . HARAVAN_API_KEY);
        }else{
            header("Location: home.php"); 
        }

        exit;       
    }
    // if they posted the form with the shop name
    else if (isset($_POST['shop']) || isset($_GET['shop'])) {

        //die("Step 1: get the shopname from the user and redirect the user to the haravan authorization page where they can choose to authorize this app");

        // Step 1: get the shopname from the user and redirect the user to the
        // haravan authorization page where they can choose to authorize this app
        $shop = isset($_POST['shop']) ? $_POST['shop'] : $_GET['shop'];
        $haravanClient = new HaravanClient($shop, "", HARAVAN_API_KEY, HARAVAN_SECRET);

        //if(!$haravanClient->validateSignature($_GET)) die('Error: invalid signature.');
        
        // redirect to authorize url
        header("Location: " . $haravanClient->getAuthorizeUrl(HARAVAN_SCOPE, REDIRECT_URI));
        exit;
    }

    // first time to the page, show the form below
?>
    <p>Install this app in a shop to get access to its private admin data.</p> 

    <p style="padding-bottom: 1em;">
        <span class="hint">Don&rsquo;t have a shop to install your app in handy? <a href="https://app.haravan.com/services/partners/">Create a test shop.</a></span>
    </p> 

    <form action="" method="post">
      <label for='shop'><strong>The URL of the Shop</strong> 
        <span class="hint">(enter it exactly like this: myshop.myharavan.com)</span> 
      </label> 
      <p> 
        <input id="shop" name="shop" size="45" type="text" value="" /> 
        <input name="commit" type="submit" value="Install" /> 
      </p> 
    </form>
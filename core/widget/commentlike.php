<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://", "/"]; 
    
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
if (isset($_POST['agree'])) {
    $result = array(
    'code' => 1,
    'agree' => agreeforcomment($_POST['agree']),
    'coid' => $_POST['agree']
);
      exit(json_encode($result));
}
    }
    else{
        $result = array(
    'code' => 2,
    'message' => 'error'
);
      exit(json_encode($result));  
    }
<?php
function GetCheck()
{
    $options = Helper::options();
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $options->Assets_Custom.'/assets/return.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    $data = curl_exec($curl);
    curl_close($curl);
    $output = json_decode($data,true);
    if ($output['message'] == 'success'){
    return '<a style="color:green">连接成功,该自定义储存库可用!</a>';
    }
    else{
        return '<a style="color:red">连接失败,该自定义储存库不可用!</a>';
    }
}

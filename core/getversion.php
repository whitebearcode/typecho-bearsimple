<?php
function GetVersion()
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://version.typecho.bearlab.in/version-bearsimple.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    $data = curl_exec($curl);
    curl_close($curl);
    echo $data;
}

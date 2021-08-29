<?php
function GetVersion()
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://upgrade.bear-studio.net/Typecho/Bearsimple/version.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    $data = curl_exec($curl);
    curl_close($curl);
    $datas = json_decode($data,true);
    echo $datas['version'];
}
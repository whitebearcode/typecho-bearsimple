<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    use Typecho\Db;
use Typecho\Common;
use Widget\Options;

    $options = Helper::options();
    $temoptions = bsOptions::getInstance()::get_option('bearsimple');
    $removeChar = ["https://", "http://"]; 
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) { 
$data = [];

$i = 0;
if($temoptions['AIService_Blacklist'] !== '' && @is_array($temoptions['AIService_Blacklist'])){
foreach($temoptions['AIService_Blacklist'] as $val){
$this->widget('Widget_Archive@aitools'.$i.'post', 'pageSize=1&type=post', 'cid='.$val)->to($arr);
$data['blackurls'][] = $arr->permalink;
$i++;
}
}
if($temoptions['AIService_Blacklist_Page'] !== '' && @is_array($temoptions['AIService_Blacklist_Page'])){
foreach($temoptions['AIService_Blacklist_Page'] as $val){
$this->widget('Widget_Archive@aitools'.$i.'page', 'pageSize=1&type=page', 'cid='.$val)->to($arrs);
$data['blackurls'][] = $arrs->permalink;
$i++;
}
}
echo json_encode($data);
}
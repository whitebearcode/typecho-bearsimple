<?php
ob_clean();
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    use Typecho\Db;
use Typecho\Common;
use Widget\Options;

    $options = Helper::options();
    $temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
    $removeChar = ["https://", "http://"]; 
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) { 
$n = count($temoptions['AIService_Blacklist']);
$data = [];
for($i=0;$i<$n;$i++){
$this->widget('Widget_Archive@lunbo'.$i, 'pageSize=1&type=post', 'cid='.$temoptions['AIService_Blacklist'][$i])->to($arr);
$data['blackurls'][] = $arr->permalink;
}
echo json_encode($data);
}
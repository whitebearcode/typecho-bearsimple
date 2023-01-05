<?php 
header("HTTP/1.1 200 OK");
require_once 'pclzip.lib.php';
$options = Helper::options();
    $removeChar = ["https://", "http://", "/"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false && $user->hasLogin()) {   
$action = @$_GET['action'];
function convert($size)
  {
     $unit=array('b','kb','mb','gb','tb','pb');
     return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
  }

function remote_filesize($url)
{
    ob_start();
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    $ok = curl_exec($ch);
    curl_close($ch);
    $head = ob_get_contents();
    ob_end_clean();
    $regex = '/Content-Length:\s([0-9].+?)\s/';
    $count = preg_match($regex, $head, $matches);
    return isset($matches[1]) ? $matches[1] : "unknown";
}
$file_url  = 'http://upgrade.typecho.co.uk/Bearsimple/bearsimple_lastest_update.zip';
$tmp_path = __DIR__.'/bearsimple_lastest_update.zip';
switch($action){
    case 'prepare-download':
        $file_size   = convert(remote_filesize($file_url));
$data['code']     = '1';
	$data['message']  = 'success';
	$data['filesize']  = $file_size;
echo json_encode($data, JSON_UNESCAPED_UNICODE);
break;
case 'getsize':
         if (file_exists($tmp_path)) {
             $total = remote_filesize($file_url);
            $num = filesize($tmp_path);
            $round=round($num/$total*100,2);
if($round > 100){
   $round = '100'; 
}
 clearstatcache();
    $data['code']     = '1';
	$data['message']  = 'success';
	$data['filesize'] = $round;
echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        break;
case 'download':
session_write_close();
        if ($fp = fopen($file_url, "rb")) {

                if (!$download_fp = fopen($tmp_path, "wb")) {
                    exit;
                }

                while (!feof($fp)) {
                    if (!file_exists($tmp_path)) {
                        fclose($download_fp);
                        exit;
                    }
                    fwrite($download_fp, fread($fp, 1024 * 8 ), 1024 * 8);
                }

                fclose($download_fp);
                fclose($fp);

            } else {
                exit;
            }
        break;
case 'finish':
        $archive = new PclZip(__DIR__.'/bearsimple_lastest_update.zip');
$archive->extract(PCLZIP_OPT_PATH,'./usr/plugins',PCLZIP_OPT_BY_PREG, "/^BsCore/",PCLZIP_OPT_REPLACE_NEWER);
$archive->extract(PCLZIP_OPT_PATH,'./usr/themes',PCLZIP_OPT_BY_PREG, "/^bearsimple/",PCLZIP_OPT_REPLACE_NEWER);
unlink($tmp_path);
$data['code']     = '1';
	$data['message']  = 'success';
echo json_encode($data, JSON_UNESCAPED_UNICODE);
        break;
}
}
else{
    $data['code']     = '0';
	$data['message']  = 'Sorry，Not authorization.';
echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
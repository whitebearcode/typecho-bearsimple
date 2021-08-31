<?php
header("HTTP/1.0 200 OK");
/**
 * 
 * 生成文章微海报
 * 根据原有Typecho插件修改集成至Bearsimple主题
 * Date 25/08/2021
 * 
**/

$action = $_GET['bearsimple-action'];


function make()
{
$options = Helper::options();
if (empty($_GET['cid'])) {
   exports("请填写cid",-100);
    	}
else{
    	$cid = $_GET['cid'];
    	 $array = get_artcle($cid);
        if(!$array){
        	exports("获取文章失败",-100);
        }
        
        $folder = dirname(__FILE__).'/images/';
        is_dir($folder) OR mkdir($folder, 0777, true);
       	if(file_exists($folder.'cid-'.$cid.'.png')){
        	exports(Helper::options()->themeUrl.'/modules/MakePost/images/cid-'.$cid.'.png');
       	}
       	else{
        $qq_setting = 'close';
        if(empty($options->Poster_Webname)){
            $sitename = $options->title;
        }
        else{
          $sitename = $options->Poster_Webname; 
        }
        
        if(empty($options->Poster_WebDec)){
            $sitedec = $options->description;
        }
        else{
          $sitedec = $options->Poster_WebDec; 
        }
        
         if(empty($options->Poster_Bloger)){
            $sitemaster = $options->title;
        }
        else{
          $sitemaster = $options->Poster_Bloger; 
        }
        
        if(empty($options->Poster_QQ)){
            $qq = '123456789';
        }
        else{
          $qq = $options->Poster_QQ; 
        }
        
        if(empty($options->Poster_QQsetting)){
            $qqsetting = 'close';
        }
        else{
          $qqsetting = $options->Poster_QQsetting; 
        }
       $timestamp = md5(date("Y-m-d H:i:s"));
       $token = 0 + mt_rand()/mt_getrandmax()*(1-0);
        $result = get_curl("https://poster-api.typecho.bear-studio.net/service/api.php"."?t=".$token,"sitename=".$sitename."&introduction=".$sitedec."&link=". urlencode($array['link'])."&title=".$array['title']."&content=".$array['content']."&time=".$array['time']."&author=".$sitemaster."&qq=".$qq."&type=".$qq_setting."&timestamp={$timestamp}");
        if(empty($result)){
        	exports('当前节点不可用！',-100);
        }
        $res = json_decode($result,true);
        if($res['code'] != 1){
        	exports($res['msg'],-100);
        }
        $a = file_put_contents($folder.'cid-'.$cid.'.png',base64_decode($res['img']));
        if($a){
        	exports(Helper::options()->themeUrl.'/modules/MakePost/images/cid-'.$cid.'.png');
        }else{
        	exports("海报保存失败!",-100);
        }
    }
}
}
 function get_artcle($cid){
     $db = Typecho_Db::get();
    	$options = Typecho_Widget::widget('Widget_Options');
        $select = $db->select('cid', 'title', 'created', 'text', 'type')->from('table.contents')->where('status = ?', 'publish')->where('created < ?', time())->where('cid = ?', $cid);
        $posts  = $db->fetchAll($select);
        if(!$posts){
        	return false;
        }
        $posts[0]['created'] = date("Y-m-d H:i:s",$posts[0]['created']);
        $posts[0]['title'] = $posts[0]['title'];
        $posts[0]['text'] = $posts[0]['text'];
        Typecho_Widget::widget('Widget_Archive', 'pageSize=1&type=post', 'cid='.$cid)->to($link);
        return array('title'=>$posts[0]['title'],'content'=>$posts[0]['text'],'time'=>$posts[0]['created'],'link'=>$link->permalink);
    }
    function get_curl($url, $post = 0, $referer = 0, $cookie = 0, $header = 0, $ua = 0, $nobody = 0)
	{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $httpheader[] = "Accept:*/*";
    $httpheader[] = "Accept-Encoding:gzip,deflate,sdch";
    $httpheader[] = "Accept-Language:zh-CN,zh;q=0.8";
    $httpheader[] = "Connection:close";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    if ($header) {
        curl_setopt($ch, CURLOPT_HEADER, true);
    }
    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    if ($referer) {
        curl_setopt($ch, CURLOPT_REFERER, $referer);
    }
    if ($ua) {
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
    } else {
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 4.0.4; es-mx; HTC_One_X Build/IMM76D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0");
    }
    if ($nobody) {
        curl_setopt($ch, CURLOPT_NOBODY, 1);
    }
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
	}
    
    function exports($data = array(), $status = 200)
    {
        $a = new Typecho_Response();
        $a->throwJson(array(
            'status' => $status,
            'data' => $data
        ));
       exit;
    }
    
    
	
call_user_func($action);

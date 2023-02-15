<?php
use Utils\Markdown as Markdown;
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);
$cid = $_POST["id"];

function getCustom($cid, $key){
    $db = Typecho_Db::get();
    $rows = $db->fetchAll($db->select('table.fields.str_value')->from('table.fields')
        ->where('table.fields.cid = ?', $cid)
        ->where('table.fields.name = ?', $key)
    );
    // 如果有多个值则存入数组
    foreach ($rows as $row) {
        $img = $row['str_value'];
        if (!empty($img)) {
            $values[] = $img;
        }
    }
    return $values;
}

function posterPic($cid) {

    $db = Typecho_Db::get();
    $rs = $db->fetchRow($db->select('table.contents.text')
                               ->from('table.contents')
                               ->where('cid=?', $cid));
    $text = $rs['text'];
	//获取文章首张图片
	preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $text, $thumbUrl);
	$img_src = $thumbUrl[1][0];
	// 获取自定义随机图片
	$options = bsOptions::getInstance()::get_option( 'bearsimple' );
	$thumbs = explode("|",$options['Article_forma_pic']);
	// 获取文章封面
	$cover = getCustom($cid, 'cover');
	//--------------->
	    if($options['Article_forma_randapi'] == 1){
	        $rand = '?'.mt_rand(1,1000);
	    }
	if($options['Article_forma_randchoose'] == false || $options['Article_forma_randchoose'] == ''){
	if($cover){
	    $thumb = $cover;
	}else if($img_src){
		$thumb = $img_src;
	}else if(!empty($options['Article_forma_pic']) && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)].$rand;
	}
	else{
	    $thumb = $options['Poster__AttUrl'];
	}
	
	}
	else{
	    
	   if(!empty($options['Article_forma_pic']) && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)].$rand;
	}
	   elseif($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}
	else{
	    $thumb = $options['Poster__AttUrl'];
	}
	   
	    
	}
	return $thumb;
}


function image_to_base64($image){
		$site_domain = parse_url(Helper::options()->siteUrl, PHP_URL_HOST);
		$img_domain = parse_url($image, PHP_URL_HOST);
		if ( $img_domain != $site_domain ) {
			if(preg_match('/^\/\//i', $image)) $image = 'http:' . $image;
			 $img_base64 = '';
			 $img_url = $image;
    $imageInfo = getimagesize($img_url);
    if (!$imageInfo) {
        return false;
    }
    $img_base64 = "" . chunk_split(base64_encode(file_get_contents($img_url)));
        $img_base64 = 'data:' . $imageInfo['mime'] . ';base64,'.$img_base64;
    return $img_base64;
		}
		$image = preg_replace('/^(http:|https:)/i', '', $image);
		return $image;
	}
	
if(isset($cid) && $cid){
    $md = new Markdown();
            $db = Typecho_Db::get();
            $prefix = $db->getPrefix();
            $posts = $db->fetchAll($db
                ->select()->from('table.contents')
                ->Where('table.contents.cid = ?', $cid));
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($posts[0]);
                $targetSummary = excerpt($md::convert($result['text']), 80);
                $targetTitle = $result['title'];
                $targetUrl = $result['permalink'];
                $targetDate = $result['created'];
                $expert = getCustomFields($cid, 'excerpt');
                if($expert){
                    $targetSummary = $expert[0];
                }
                $targetSummary = rtrim( trim( strip_tags($targetSummary)),'[原文链接]');
			$targetSummary = preg_replace('/\\s+/',' ',$targetSummary);
                $res = array(
				'head' => image_to_base64(posterPic($cid)),
				'logo' => image_to_base64(Bsoptions('Poster__LogoUrl')),
				'title' => $targetTitle,
				'excerpt' => $targetSummary,
				'textlogo' => Helper::options()->title,
				'timestamp' => $targetDate
			);
                echo json_encode($res,JSON_UNESCAPED_UNICODE);
                exit;
}

<?php
use Utils\Markdown as Markdown;
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);
$cid = $_POST["id"];

function getCustomx($cid, $key){
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
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    $db = Typecho_Db::get();
    $md = new Markdown();
   $post = $db->fetchRow($db->select()
       ->from('table.contents')
       ->where('table.contents.cid=?', $cid)
       ->limit(1));
$result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($post);
                    $content = $md::convert($result['text']);
   preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $content, $pic);  //通过正则式获取图片地址
   $img_src = $pic[1][0];
	// 获取文章封面
	$cover = getCustomx($cid, 'cover');
if($cover){
	    $thumb = $cover[0];
	}else if($img_src){
		$thumb = $img_src;
	}
	else{
	   $thumb = $options['Poster__AttUrl']; 
	}
	 
	return $thumb;
}


function image_to_base64($image){
		$site_domain = parse_url(Helper::options()->siteUrl, PHP_URL_HOST);
		$img_domain = parse_url($image, PHP_URL_HOST);
		if ( $img_domain !== $site_domain ) {
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
                    $targetSummary = excerpt($md::convert($result['text']),80);
                $targetTitle = $result['title'];
                $targetUrl = $result['permalink'];
                $targetDate = $result['created'];
                $expert = getCustomFields($cid, 'excerpt');
                if($expert){
                    $targetSummary = $expert[0];
                }
                $targetSummary = trim(strip_tags($targetSummary));
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

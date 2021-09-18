<?php

//输出文章标题字数
function articletitlenum(){
    $options = Helper::options();
    if(empty($options->articletitlenum)){
        return '20';
    }
    else{
     return $options->articletitlenum;
    }
    
}

//输出文章描述字数
function articledecnum(){
    $options = Helper::options();
    if(empty($options->articleexcerptnum)){
        return '40';
    }
    else{
     return $options->articleexcerptnum;
    }
    
}

// 简介图文获取图片
function thumb($obj) {
    //获取附件首张图片
	$attach = $obj->attachments(1)->attachment;
	//获取文章首张图片
	preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $thumbUrl);
	$img_src = $thumbUrl[1][0];
	// 获取自定义随机图片
	$options = Typecho_Widget::widget('Widget_Options');
	$thumbs = explode("|",$options->Article_forma_pic);
	// 获取文章封面
	$cover = $obj->fields->cover;
	//--------------->
	if($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}else if($options->thumbs && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)];
	}
	else{
	    $thumb = 'null';
	}
	return $thumb;
}

// 图底文字获取图片
function thumb2($obj) {
    //获取附件首张图片
	$attach = $obj->attachments(1)->attachment;
	//获取文章首张图片
	preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $thumbUrl);
	$img_src = $thumbUrl[1][0];
	// 获取自定义随机图片
	$options = Typecho_Widget::widget('Widget_Options');
	$thumbs = explode("|",$options->Article_forma_pic2);
	// 获取文章封面
	$cover = $obj->fields->cover;
	//--------------->
	if($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}else if($options->thumbs && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)];
	}
	else{
	    $thumb = 'null';
	}
	return $thumb;
}



/**简单的标签转换**/
function BearSimpleChange($article){
    $article = str_replace('[bs-style=', '<div class="', $article);
    $article = str_replace('[/bs-style]', '</div>', $article);
    $article = str_replace(']', '">', $article);
    return $article;
}

function BearSimpleFriendLinkBr($friendlink){
    $friendlink = str_replace('<friendlink>', '<ul></ul>', $friendlink);
    $friendlink = str_replace(',', '<ul></ul>', $friendlink);
    return $friendlink;
}


/** 获取操作系统信息 */
function getOs($agent)
{
    $os = false;

    if (preg_match('/win/i', $agent)) {
        if (preg_match('/nt 6.0/i', $agent)) {
            $os = 'Windows Vista';
        } else if (preg_match('/nt 6.1/i', $agent)) {
            $os = 'Windows 7';
        } else if (preg_match('/nt 5.1/i', $agent)) {
            $os = 'Windows XP';
        } else if (preg_match('/nt 5/i', $agent)) {
            $os = 'Windows 2000';
        } else {
            $os = 'Windows';
        }
    } else if (preg_match('/android/i', $agent)) {
        $os = 'Android';
    } else if (preg_match('/ubuntu/i', $agent)) {
        $os = 'Ubuntu';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/mac/i', $agent)) {
        $os = 'Mac OS X';
    } else if (preg_match('/unix/i', $agent)) {
        $os = 'Unix';
    } else if (preg_match('/symbian/i', $agent)) {
        $os = 'Nokia SymbianOS';
    } else {
        $os = '其它操作系统';
    }

    echo $os;
}

//**字数统计**/
function art_count ($cid){ 
    $db=Typecho_Db::get (); $rs=$db->fetchRow ($db->select ('table.contents.text')->from ('table.contents')->where ('table.contents.cid=?',$cid)->order ('table.contents.cid',Typecho_Db::SORT_ASC)->limit (1)); $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $rs['text']); echo mb_strlen($text,'UTF-8'); }

// 统计阅读数
function get_post_view($archive){
	$cid    = $archive->cid;
	$db     = Typecho_Db::get();
	$prefix = $db->getPrefix();
	if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
		$db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
		echo 0;
		return;
	}
	$row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
	if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
		if(empty($views)){
			$views = array();
		}else{
			$views = explode(',', $views);
		}
        if(!in_array($cid,$views)){
	        $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
			$views = implode(',', $views);
			Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
		}
	}
	echo $row['views'];
}


// 留言加@
function getPermalinkFromCoid($coid) {
	$db = Typecho_Db::get();
	$row = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
	if (empty($row)) return '';
	return '<a href="#comment-'.$coid.'">@'.$row['author'].'</a>';
}

             

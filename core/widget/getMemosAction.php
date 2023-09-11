<?php
use Typecho\Db;
use Typecho\Common;
use Widget\Options;
require_once $_SERVER['DOCUMENT_ROOT'].'/usr/plugins/BsCore/modules/Markdown/ParsedownExtension.php';
//use ParsedownExtension;
header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Origin: *");
date_default_timezone_set('PRC');
error_reporting(0);
$options = Helper::options();
    $temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
    $removeChar = ["https://", "http://", "/"]; 



//获取memos数据方法
function memos_getRequest($url, $type,$postdata = '') {
    if($postdata)$data = http_build_query($postdata);
    $options    = array(
        'http' => array(
            'method'  => $type,
            'header'  => "Content-type: application/json",
            'content' => $data,
            'timeout' => 5
        ),
        "ssl" => array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    )
    );
    $context = stream_context_create($options);

    $result    = file_get_contents($url, false, $context);
    if($http_response_header[0] != 'HTTP/1.1 200 OK'){
        $result = array(
            "result" => "success",
            "reason" => "memos error"
        );
        return json_encode($result);
    }else{
        return json_decode($result,true);
    }
}

//转换memos发布时间
function memos_getTime($time)
    {
        $rtime = date("Y年m月d日 H:i", $time);
        $htime = date("H:i", $time);
        $time = time() - $time;
        if ($time < 60) {
            $str = '刚刚';
        } elseif ($time < 60 * 60) {
            $min = floor($time / 60);
            $str = $min . '分钟前';
        } elseif ($time < 60 * 60 * 24) {
            $h = floor($time / (60 * 60));
            $str = $h . '小时前 ' . $htime;
        } elseif ($time < 60 * 60 * 24 * 3) {
            $d = floor($time / (60 * 60 * 24));
            if ($d == 1){
                $ztime = time() - $time;
       $zztime = date("H:i", $ztime);
                $str = '昨天 ' . $zztime;
            }else{
                $qtime = time() - $time;
       $qqtime = date("H:i", $qtime);
                $str = '前天 ' . $qqtime;
        }} else {
            $str = $rtime;
        }
         return $str;
}


if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
    $db = \Typecho\Db::get();
    \Typecho\Widget::widget('Widget_User')->to($user);
if($_POST['action'] == 'getmemo'){

$result = array(
    'list' => array()
);
$markdown = new ParsedownExtension;
$markdownParser = $markdown::instance();
        
        
//resource逻辑
$data = [];
if(Bsoptions('Lazyload') == true){
$lazyload = 'class="lazy" data-';
}
if($_POST['action'] == 'getmemo'){

$result['number']  = $_POST['number'];   
$memos_all = memos_getRequest($temoptions['memos_Url'].'/api/v1/memo/all','GET');
$memos = memos_getRequest($temoptions['memos_Url'].'/api/v1/memo/all?limit='.$_POST['number'],'GET');
$result['total'] = count($memos_all);
$result['stin'] = $_POST['stin'];
$result['numberx']  = array_column($memos,'id');  
foreach($memos as $key => $val){
  $agree = $db->fetchRow($db->select()->from('table.bscore_memos_agree_data')->where('memosid = ? ', $val['id']));
    if(!$agree){
        $val['memos_agree'] = 0;
    }
    else{
        $val['memos_agree'] = $agree['agree'];
    }
if(!$val['resourceList']){
  $data = '';  
}
else{
$data = [];
        foreach($val['resourceList'] as $v){
            //当类型为图片的时候直接使用img标签包裹
            if (strpos($v['type'], 'image/') !== false) {
            if($v['publicId']){
            $data[] = '<img data-fancybox="memo-image" data-caption="'.$v['filename'].'" '.$lazyload.'src="'.$temoptions['memos_Url'].'/o/r/'.$v['id'].'/'.$v['publicId'].'" data-memo-image>';  
            }
            else{
            $data[] = '<img data-fancybox="memo-image" data-caption="'.$v['filename'].'" '.$lazyload.'src="'.$v['externalLink'].'" data-memo-image>';      
            }
            }
            //反之则当做超链接处理
            else{
              
              if($v['publicId']){
            $data[] = '<a href="'.$temoptions['memos_Url'].'/o/r/'.$v['id'].'/'.$v['publicId'].'" target="_blank" data-memo-file><i class="file alternate outline icon"></i>'.$v['filename'].'</a>';  
            }
            else{
                $data[] = '<a href="'.$v['externalLink'].'" target="_blank" data-memo-file><i class="file alternate outline icon"></i>'.$v['filename'].'</a>';  
            }
                
            }
        }  
        
}
 $content = $val['content'];
        if(strpos($content,'- [x]')!==false||strpos($content,'- [ ]')!==false){
            $attributes = array("style"=>"list-style: none;");
            $content = str_replace(array('- [x]','- [ ]'), array(
                '<input type="checkbox" checked="true" disabled="true">',
                '<input type="checkbox" disabled="true">',
            ), $content);
        }
   
    
         $content =  reEmo($markdownParser->setBreaksEnabled(true)->text($content),'comment');
         $pattern = '/<\s*img[\s\S]+?(?:src=[\'"]([\S\s]*?)[\'"]\s*|alt=[\'"]([\S\s]*?)[\'"]\s*|[a-z]+=[\'"][\S\s]*?[\'"]\s*)+[\s\S]*?>/i';
   
 $replacement = '
  <img data-fancybox="memo-image" data-caption="$2" '.$lazyload.'src="$1">'; 
    $content = preg_replace($pattern, $replacement, $content);
    
             $result['list'][] = array(
                    'memos_id'=> $val['id'],
                    'memos_time' =>memos_getTime($val['createdTs']),
                    'memos_uid' =>$val['creatorId'],
                    'memos_name'=>$val['creatorName'],
                    'memos_content'=> $content,
                    'memos_agree'=>$val['memos_agree'],
                    'resource'=>$data
                    );
                    //土办法，前台传入判断是否为next以及上一次输出的memos id数组，然后在这一次输出中删除存在这个数组id的数据
           if($_POST['stin'] == 'next'){
           foreach($_POST['numberx'] as $nu){
        if($val['id'] == $nu)
        unset($result['list'][$key]);
    }
            }
}
}
            exit(json_encode($result,JSON_UNESCAPED_UNICODE));
}
elseif($_POST['action'] == 'getmemolike'){
        if(!is_numeric($_POST['memoid'])){
                $result = array(
    'code' => 0,
    'message' => 'error'
);
exit(json_encode($result));  
    }
    if(\Typecho\Cookie::get('memo_agree_'.$_POST['memoid']) == '1'){
                $result = array(
    'code' => 0,
    'message' => '啊哦，您已经点赞过了~'
);
exit(json_encode($result));  
    }
    $oldlikenum = $db->fetchRow($db->select('table.bscore_memos_agree_data.agree')->from('table.bscore_memos_agree_data')->where('memosid = ?', $_POST['memoid']));
    if(!$oldlikenum){
    $memo_agree = array(
                'memosid' => $_POST['memoid'],
                'agree' => 1,
            );
    $db->query($db->insert('table.bscore_memos_agree_data')->rows($memo_agree));    
    }
    else{
             $db->query($db->update('table.bscore_memos_agree_data')->rows(array('agree' => (int)$oldlikenum['agree'] + 1))->where('memosid = ?', $_POST['memoid']));
    }
    $newlikenum = $db->fetchRow($db->select()->from('table.bscore_memos_agree_data')->where('memosid = ? ', $_POST['memoid']));     
    \Typecho\Cookie::set('memo_agree_'.$_POST['memoid'],'1');    
 $result = array(
    'code' => 1,
    'memo_id' => $_POST['memoid'],
    'memo_agree'=>$newlikenum['agree'],
    'msg' => 'success',
);
        exit(json_encode($result,JSON_UNESCAPED_UNICODE));
        
        
}

}

   
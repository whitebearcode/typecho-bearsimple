<?php
ob_clean();
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    header('Content-type: application/json');
    $options = Helper::options();
    $removeChar = ["https://", "http://"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
   $db = \Typecho\Db::get();
    switch($_POST['action']){
       case 'like':
           $like = $db->fetchRow($db->select()->from('table.bscore_friendcircle_data')->where('coid = ?', $_POST['coid']));
           if($user->hasLogin()){
               if($like['likeUser'] !== null && strpos($like['likeUser'],$user->screenName)!== false){
                 exit(json_encode(array(
        "code" => 500,
        "msg" => '您已点过赞，请勿重复点赞！',
        )));  
               }
          
           if($like['likeUser'] == null){
               $userName = $user->screenName;
           }
           else{
              $userName = $like['likeUser'] .'，'.$user->screenName; 
           }
            $db->query($db->update('table.bscore_friendcircle_data')->rows(array('likeUser' => $userName))->where('coid = ?', $_POST['coid']));
            
            $like = $db->fetchRow($db->select()->from('table.bscore_friendcircle_data')->where('coid = ?', $_POST['coid']));
          if(!empty($like['likeVisitor'])){
             $like['likeVisitor'] = $like['likeVisitor'].'位访客'; 
          }
          if(!$like['likeVisitor']){
              $like['likeVisitor'] = '';
          }
          if(!$like['likeUser']){
              $like['likeUser'] = '';
          }
          exit(json_encode(array(
        "code" => 200,
        "msg" => '点赞成功',
        "likeVisitor" => $like['likeVisitor'],
        "likeUser" => $like['likeUser'],
        )));
        
        
           }
           else{
            if(Typecho_Cookie::get('like_circle_'.$_POST['coid']) == '1'){
                exit(json_encode(array(
        "code" => 500,
        "msg" => '您已点过赞，请勿重复点赞！',
        )));  
            }
               if($like['likeVisitor'] == null){
                   $visitorNum = 1;
               }
               else{
                   $visitorNum = (int)$like['likeVisitor'] + 1;
               }
                $db->query($db->update('table.bscore_friendcircle_data')->rows(array('likeVisitor' => $visitorNum))->where('coid = ?', $_POST['coid']));
                
                $like = $db->fetchRow($db->select()->from('table.bscore_friendcircle_data')->where('coid = ?', $_POST['coid']));
          if(!empty($like['likeVisitor'])){
             $like['likeVisitor'] = $like['likeVisitor'].'位访客'; 
          }
          if(!$like['likeVisitor']){
              $like['likeVisitor'] = '';
          }
          if(!$like['likeUser']){
              $like['likeUser'] = '';
          }
          Typecho_Cookie::set('like_circle_'.$_POST['coid'],'1');
          exit(json_encode(array(
        "code" => 200,
        "msg" => '点赞成功',
        "likeVisitor" => $like['likeVisitor'],
        "likeUser" => $like['likeUser'],
        )));
        
        
           }
          
           break;
           case 'delete':
               if($user->hasLogin() && $user->pass('administrator', true)){
               $coid = $_POST['coid'];
               $db->query($db->delete('table.bscore_friendcircle_data')->where('coid = ?', $coid));
               $db->query($db->delete('table.comments')->where('parent = ?', $coid));
               
               exit(json_encode(array(
        "code" => 200,
        "msg" => '删除成功',
        )));
               }
               break;
   }
  
   
   
   
   
        
    }
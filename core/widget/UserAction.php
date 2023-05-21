<?php
use Typecho\Db;
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://", "/"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    $db = \Typecho\Db::get();
$id = $this->user->uid;
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false  && $user->hasLogin()) {   
        
        if($_POST['type'] == 'getallpost'){
            if(empty($_POST['page'])){
    $i = 1;
}
else{
    $i = $_POST['page']; 
}
$total = count($db->fetchAll($db->select()->from('table.contents')
            ->where('authorId = ?',$id)
            ->where('type = ?', 'post')));

        $post = $db->fetchAll($db->select()->from('table.contents')
            ->where('authorId = ?',$id)
            ->where('type = ?', 'post')
            ->order('cid', Typecho_Db::SORT_DESC)
            ->page($i,6));
        $max = ceil($total / 6);
        $result = array(
            'total' => $total,
    'max' => $max,
    'list' => array()
);
    if($post){
            foreach($post as $val){                
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                $post_title = htmlspecialchars($val['title']);
                $permalink = $val['permalink'];
                if($val['status'] == 'publish'){
                    $post_title = '<a href="'.$permalink.'" target="_blank">'.$post_title.'</a>';
                }
                switch($val['status']){
                    case 'publish':
                        $val['status'] = '<i class="check green icon"></i>审核通过';
                        break;
                    case 'hidden':
                        $val['status'] = '<i class="eye slash outline icon"></i>已被隐藏';
                        break;
                    case 'password':
                        $val['status'] = '<i class="user lock icon"></i>密码保护';
                        break;
                    case 'private':
                        $val['status'] = '<i class="user shield icon"></i>私密不公开';
                        break;
                    case 'waiting':
                        $val['status'] = '<i class="hourglass half icon"></i>等待审核';
                        break;
                }
                $result['list'][] = array(
                    'post_title'=> $post_title,
                    'post_time' =>date('Y年m月d日',$val['created']),
                    'post_category' =>getCategoryName(categeid($val['category'])),
                    'post_status'=>$val['status']
                    );
                    
            }
           
    }

 echo json_encode($result);
        }
        elseif($_POST['type'] == 'searchuser' && $user->pass('administrator', true)){
            if(empty($_POST['page'])){
    $i = 1;
}
else{
    $i = $_POST['page']; 
}
if($_POST['searchval']){
             $searchQuery = '%' . str_replace(' ', '%', $_POST['searchval']) . '%';
       $total = count($db->fetchAll($db->select()->from('table.users')->where('name LIKE ? ', $searchQuery)));
       $userlist = $db->fetchAll($db->select()->from('table.users')->where('name LIKE ? ', $searchQuery)->page($i,6));
       $max = ceil($total / 6);
       
        $result = array(
           'total' => $total,
    'max' => $max,
    'list' => array()
);
if($userlist){
            foreach($userlist as $val){ 
                if($val['submission'] == 1){
                    $val['submission'] = '开启';
                }
                else{
                    $val['submission'] = '关闭';
                }
                switch($val['group']){
                    case 'administrator':
                      $val['group'] = '管理员';
                      break;
                      case 'editor':
                       $val['group'] = '编辑';
                       break;
                       case 'subscriber':
                       $val['group'] = '关注者';
                       break;
                       case 'contributor':
                       $val['group'] = '贡献者';
                       break;
                       default:$val['group'] = '访问者';
                       
                }
                if(Bsoptions('UserCenter_coin_name') !== ''):$coin_name = Bsoptions('UserCenter_coin_name');else:$coin_name = '积分';endif;
$result['list'][] = array(
                    'uid'=> $val['uid'],
                    'name' =>$val['name'],
                    'screenName' =>$val['screenName'],
                    'mail'=>$val['mail'],
                    'group'=>$val['group'],
                    'coins'=>$val['coins'],
                    'submission'=>$val['submission'],
                    'post_num'=>allpostnum($val['uid']),
                    'coin_name'=>$coin_name
                    );
}
}
}
else{
    $total = 0;
    $max = ceil($total / 6);
    $userlist = array();
     $result = array(
           'total' => $total,
    'max' => $max,
    'list' => array()
);
$result['list'] = $userlist;
}
      
         echo json_encode($result);
        }
       
      elseif($_POST['type'] == 'edituser' && $user->pass('administrator', true)){
          if($_POST['submission_type'] == 'open'){
              $submission = 1;
          }
          else{
              $submission = 0;
          }
         
          $user_data = array(
                'coins' =>  preg_replace("/[^0-9]/", "", htmlspecialchars($_POST['coins'],ENT_QUOTES,'UTF-8')),
                'submission' => $submission,
            );
            $db->query($db->update('table.users')->rows($user_data)->where('uid = ?', $_POST['uid']));
            echo 1;
      }
	 elseif($_POST['type'] == 'editUserSignature'){
          $user_data = array('person_Signature' =>  htmlspecialchars($_POST['person_Signature'],ENT_QUOTES,'UTF-8'));
            $db->query($db->update('table.users')->rows($user_data)->where('uid = ?', $this->user->uid));
            echo 1;
      }
      elseif($_POST['type'] == 'submitsays'){
          if($_POST['saysprivate'] == 'on'){
              $saysprivate = 'on';
          }
          else{
              $saysprivate = 'off';
          }
          if($_POST['sid']){
           $user_data = array(
                'saystext' => htmlspecialchars($_POST['saystext'],ENT_QUOTES,'UTF-8'),
                'saysprivate' => $saysprivate,
                );
            $db->query($db->update('table.bscore_says_data')->where('id = ?',$_POST['sid'])->rows($user_data));   
            $result = array(
    'code' => 1,
    'sid' => $_POST['sid'],
    'message' => 'success'
);
exit(json_encode($result));  
          }
          else{
          $user_data = array(
                'saysuid' =>  $this->user->uid,
                'saystime' => time(),
                'saystext' => htmlspecialchars($_POST['saystext'],ENT_QUOTES,'UTF-8'),
                'saysprivate' => $saysprivate,
                );
            $db->query($db->insert('table.bscore_says_data')->rows($user_data));
            $result = array(
    'code' => 1,
    'sid' => '',
    'message' => 'success'
);
exit(json_encode($result));  
          }
            
          
      }
      elseif($_POST['type'] == 'getsays'){
          
                      if(empty($_POST['page'])){
    $i = 1;
}
else{
    $i = $_POST['page']; 
}
if($_POST['index'] == '2'){
$total = count($db->fetchAll($db->select()->from('table.bscore_says_data')
            ->where('saysuid = ?',$this->user->uid)));

        $says = $db->fetchAll($db->select()->from('table.bscore_says_data')
            ->where('saysuid = ?',$this->user->uid)
            ->order('id', Typecho_Db::SORT_DESC)
            ->page($i,6));
}
else{
$total = count($db->fetchAll($db->select()->from('table.bscore_says_data')
            ->where('saysuid = ?',$this->user->uid)->where('saysprivate != ?','on')));

        $says = $db->fetchAll($db->select()->from('table.bscore_says_data')
            ->where('saysuid = ?',$this->user->uid)
            ->where('saysprivate != ?','on')
            ->order('id', Typecho_Db::SORT_DESC)
            ->page($i,6));    
}
        $max = ceil($total / 6);
        $result = array(
            'total' => $total,
    'max' => $max,
    'list' => array()
);
    if($says){
            foreach($says as $val){                
          if($_POST['index'] == '2'){
                $result['list'][] = array(
                    'saysid'=> $val['id'],
                    'saystime' =>date('Y年m月d日',$val['saystime']),
                    'saysprivate' =>$val['saysprivate'],
                    'sayslike' =>$val['sayslike'],
                    'saystext'=>ParseCross(reEmo($val['saystext'],'comment')),
                    'saystext_sim'=>$val['saystext']
                    );
          }
          else{
             $result['list'][] = array(
                    'saysid'=> $val['id'],
                    'saystime' =>date('Y年m月d日',$val['saystime']),
                    'sayslike' =>$val['sayslike'],
                    'saystext'=>ParseCross(reEmo($val['saystext'],'comment'))
                    ); 
          }
            }
           
    }

 echo json_encode($result);
          
          
          
      }
elseif($_POST['type'] == 'deletesays'){
    if(is_numeric($_POST['saysid'])){
    $db->query($db->delete('table.bscore_says_data')->where('id = ?', $_POST['saysid']));
    echo 1;
}
else{
   echo 0; 
}
}
    }
 if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
if($_POST['type'] == 'getsays_index'){
          
                      if(empty($_POST['page'])){
    $i = 1;
}
else{
    $i = $_POST['page']; 
}

$total = count($db->fetchAll($db->select()->from('table.bscore_says_data')
            ->where('saysuid = ?',$_POST['authorId'])->where('saysprivate != ?','on')));

        $says = $db->fetchAll($db->select()->from('table.bscore_says_data')
            ->where('saysuid = ?',$_POST['authorId'])
            ->where('saysprivate != ?','on')
            ->order('id', Typecho_Db::SORT_DESC)
            ->page($i,6));    

        $max = ceil($total / 6);
        $result = array(
            'total' => $total,
    'max' => $max,
    'list' => array()
);
    if($says){
            foreach($says as $val){                
          
             $result['list'][] = array(
                    'saysid'=> $val['id'],
                    'saystime' =>date('Y年m月d日',$val['saystime']),
                    'sayslike' =>$val['sayslike'],
                    'saystext'=>ParseCross(reEmo($val['saystext'],'comment')),
                    ); 
          
            }
           
    }

 echo json_encode($result);
          
          
          
      }
      
      elseif($_POST['type'] == 'like'){
    if(!is_numeric($_POST['sid'])){
                $result = array(
    'code' => 0,
    'message' => 'error'
);
exit(json_encode($result));  
    }
    $oldlikenum = $db->fetchRow($db->select('table.bscore_says_data.sayslike')->from('table.bscore_says_data')->where('saysuid = ?', $_POST['authorId'])->where('id = ?', $_POST['sid']));
             $db->query($db->update('table.bscore_says_data')->rows(array('sayslike' => (int)$oldlikenum['sayslike'] + 1))->where('saysuid = ?', $_POST['authorId'])->where('id = ?', $_POST['sid']));
 $result = array(
    'code' => 1,
    'sid' => $_POST['sid'],
    'msg' => 'success',
);
        exit(json_encode($result));
}

}
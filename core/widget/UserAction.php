<?php
use Typecho\Db;
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://", "/"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false  && $user->hasLogin()) {   
        $db = \Typecho\Db::get();
$id = $this->user->uid;
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
	 
    }
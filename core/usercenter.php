<?php

//签到
function user_sign($uid){
    $today = date('Y-m-d',time());
    $db = Typecho_Db::get();
    $result = $db->fetchAll($db->select()->from('table.bscore_sign_data')
            ->where('signuid = ?',$uid)
            ->where('signtime = ?', $today)
            ->limit(1)
        );
        if(!$result){
            echo '<div class="ui mini blue icon button" id="b-sign"><i class="grin outline icon"></i> 今日尚未签到，点击这里签到</div>';
        }
        else{
            echo '<div class="ui mini icon green button" id="b-sign" style="pointer-events:none"><i class="grin beam outline icon"></i> 今日已签到</div>';
        }
}
//输出用户文章总数
function allpostnum($id){
    $db = Typecho_Db::get();
    $postnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'allpostnum'))->from ('table.contents')->where ('table.contents.authorId=?',$id)->where('table.contents.type=?', 'post'));
    $postnum = $postnum['allpostnum'];
    return $postnum;
}

//输出用户所投稿的文章
function authorPosts($id){
    if($id){ 
        $limit = 6;
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.contents')
            ->where('authorId = ?',$id)
            ->where('type = ?', 'post')
            ->limit($limit)
            ->order('cid', Typecho_Db::SORT_DESC)  
            
        );
        if($result){
            foreach($result as $val){                
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
                
                echo '<tr>
      <td>'.$post_title.'</td>
      <td>'.date('Y年m月d日',$val['created']).'</td>
      <td>'.getCategoryName(categeid($val['category'])).'</td>
      <td>'.$val['status'].'</td>
    </tr>';
            }
        }
    }else{
        echo '';
    }
}
//用户等级判断
function user_tier($coin){
    $options = bsOptions::getInstance()::get_option('bearsimple');
    if($options['UserCenter_tab']['UserCenter_rank'][0] !== ''){
        foreach(Bsoptions('UserCenter_tab')['UserCenter_rank'] as $rank){
            if($coin >= $rank['UserCenter_rank_min'] && $rank['UserCenter_rank_max'] >= $coin){
                $res = $rank['UserCenter_rank_Name'];
                if($rank['UserCenter_rank_Pic']){
                $res .=  '<img src="'.$rank['UserCenter_rank_Pic'].'" style="display:inline;max-width:100%;height:30px;vertical-align: middle;">';  
                }
                return $res;
            }
        }
         if($res == ''){
                        $res = '暂未定义等级';    
return $res;
            }
    }

}

//用户通知
function userNotify($id){
    if($id){ 
        $db = Typecho_Db::get();
        $result = $db->fetchAll($db->select()->from('table.bscore_notify_data')
            ->where('notifyuid = ?',$id)
        );
        return $result;
    }
}
<?php

function imgravatarq($email)

{

    $options = Helper::options();
    //自定义头像
$avatar = explode(",",$options->DiyAvatar);
    $Avatar = $avatar[rand(0,count($avatar)-1)];
    //
    if(!empty($options->DiyAvatar)){
    return $Avatar;
    return;
    }
    else{
    $b=str_replace('@qq.com','',$email);
    if(stristr($email,'@qq.com')&&is_numeric($b)&&strlen($b)<11&&strlen($b)>4&&$options->Avatar_qq == '2'){
    return '//q.qlogo.cn/g?b=qq&nk=' . $b. '&s=100';
    return;
    }
    
    else{
                $email = md5($email);
                if($options->Gravatar == '1'){
                return "//cn.gravatar.com/gravatar/" . $email . "?";
                return;
            }
            else if($options->Gravatar == '2'){
                return "//gravatar.loli.top/avatar/" . $email . "?";
                return;
            }
            else if($options->Gravatar == '3'){
                return "//cdn.v2ex.com/gravatar/" . $email . "?";
                return;
            }
            else if($options->Gravatar == '4'){
                return "//gravatar.loli.net/avatar/" . $email . "?";
                return;
            }
            else if($options->Gravatar == '5'){
                return "//sdn.geekzu.org/avatar/" . $email . "?";
                return;
            }
            else if($options->Gravatar == '6'){
                return "//dn-qiniu-avatar.qbox.me/avatar/" . $email . "?";
                return;
            }
            else if($options->Gravatar == '7'){
                return "//".$options->GravatarUrl . $email . "?";
                return;
            }
    }
}
}
<?php

function imgravatarq($email)

{

    $options = Helper::options();
    //自定义头像
$avatar = explode(",",$options->DiyAvatar);
    $Avatar = $avatar[rand(0,count($avatar)-1)];
    //
    if(!empty($options->DiyAvatar)){
    echo $Avatar;
    }
    else{
$b=str_replace('@qq.com','',$email);
    if(stristr($email,'@qq.com')&&is_numeric($b)&&strlen($b)<11&&strlen($b)>4){
        $nk = 'https://s.p.qq.com/pub/get_face?img_type=3&uin='.$b;
        $c = get_headers($nk, true);
        $d = $c['Location'];
        $q = json_encode($d);
        $k = explode("&k=",$q)[1];
        echo 'https://q.qlogo.cn/g?b=qq&k='.$k.'&s=100';
    }else{
                $email = md5($email);
                if($options->Gravatar == '1'){
                echo "//cn.gravatar.com/gravatar/" . $email . "?";
            }
            else if($options->Gravatar == '2'){
                echo "//gravatar.loli.top/avatar/" . $email . "?";
            }
            else if($options->Gravatar == '3'){
                echo "//cdn.v2ex.com/gravatar/" . $email . "?";
            }
            else if($options->Gravatar == '4'){
                echo "//gravatar.loli.net/avatar/" . $email . "?";
            }
            else if($options->Gravatar == '5'){
                echo "//sdn.geekzu.org/avatar/" . $email . "?";
            }
            else if($options->Gravatar == '6'){
                echo "//dn-qiniu-avatar.qbox.me/avatar/" . $email . "?";
            }
            else if($options->Gravatar == '7'){
                echo "//".$options->GravatarUrl . $email . "?";
            }
            }
}
}
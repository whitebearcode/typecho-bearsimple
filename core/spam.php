<?php
//加法
function spam_protection_mathjia(){
   
    $num1=rand(1,49);
    $num2=rand(1,49);

    echo "<div class=\"field\">
    <label class=\"required\">验证码</label>
  <input type=\"text\" name=\"sum\" class=\"text\" value=\"\" size=\"10\" tabindex=\"4\" style=\"width:180px\" placeholder=\"$num1 + $num2 = ?\">
</div>\n";
    echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
    echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\">";
}

function spam_protection_prejia($comment, $post, $result){
    $sum=$_POST['sum'];

    switch($sum){
        case $_POST['num1'] + $_POST['num2']:
        break;
        case null:
        throw new Typecho_Widget_Exception(_t('
        对不起，请输入验证码。','评论失败'),200);
        break;
        default:
        throw new Typecho_Widget_Exception(_t('对不起，验证码错误，请重试。','评论失败'),200);
    }
    return $comment;
}

//减法
function spam_protection_mathjian(){
   
    $num1=rand(1,49);
    $num2=rand(1,49);

    echo "<div class=\"field\">
    <label class=\"required\">验证码</label>
  <input type=\"text\" name=\"sum\" class=\"text\" value=\"\" size=\"10\" tabindex=\"4\" style=\"width:180px\" placeholder=\"$num1 - $num2 = ?\">
</div>\n";
    echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
    echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\">";
}

function spam_protection_prejian($comment, $post, $result){
    $sum=$_POST['sum'];

    switch($sum){
        case $_POST['num1'] - $_POST['num2']:
        break;
        case null:
        throw new Typecho_Widget_Exception(_t('
        对不起，请输入验证码。','评论失败'),200);
        break;
        default:
        throw new Typecho_Widget_Exception(_t('对不起，验证码错误，请重试。','评论失败'),200);
    }
    return $comment;
}



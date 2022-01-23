<?php


//加法
function spam_protection_mathjia(){
   
    $num1=rand(1,49);
    $num2=rand(1,49);

    echo "<div class=\"ui labeled input\"><div class=\"ui label\"> 
    <code>$num1</code>+<code>$num2</code>=?</div>
  <input type=\"text\" name=\"sum\" class=\"text\" value=\"\" size=\"10\" tabindex=\"4\" style=\"width:180px\" placeholder=\"计算结果：\">
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
        对不起，请输入验证码。<a href="javascript:history.back(-1)">返回上一页</a>','评论失败'));
        break;
        default:
        throw new Typecho_Widget_Exception(_t('对不起，验证码错误，请<a href="javascript:history.back(-1)">返回</a>重试。','评论失败'));
    }
    return $comment;
}

//减法
function spam_protection_mathjian(){
   
    $num1=rand(1,49);
    $num2=rand(1,49);

    echo "<div class=\"ui  labeled input\"> <div class=\"ui label\">
    <code>$num1</code>-<code>$num2</code>=?
  </div><input type=\"text\" name=\"sum\" class=\"text\" value=\"\" size=\"10\" tabindex=\"4\" style=\"width:180px\" placeholder=\"计算结果：\">
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
        对不起，请输入验证码。<a href="javascript:history.back(-1)">返回上一页</a>','评论失败'));
        break;
        default:
        throw new Typecho_Widget_Exception(_t('对不起，验证码错误，请<a href="javascript:history.back(-1)">返回</a>重试。','评论失败'));
    }
    return $comment;
}



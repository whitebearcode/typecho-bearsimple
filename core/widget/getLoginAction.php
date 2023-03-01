<?php

header("HTTP/1.1 200 OK");

    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);
if($_POST['action'] == 'login'){

echo Helper::options()->loginAction;
return;
}
else if($_POST['action'] == 'protect'){

echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($_POST['permalink']);
return;
}
else if($_POST['action'] == 'cross'){

echo Typecho_Widget::widget('Widget_Security')->index('/action/comments-edit?do=edit&coid=' . $_POST['coid']);
return;
}
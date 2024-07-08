<?php
use Typecho\Db;
use Typecho\Common;
use Widget\Options;
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://"]; 
    $temoptions = bsOptions::getInstance()::get_option('bearsimple');
    Typecho_Widget::widget('Widget_User')->to($user);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false && $user->hasLogin() && $user->pass('administrator', true)) {   
        $db = \Typecho\Db::get();
    switch($_POST['type']){
        case 'editmedia':
            $db->query($db->update('table.contents')->rows(array(
                'parent' => '999999999'))
                ->where('cid = ?', $_POST['media-cid']));
                        echo 1;
            break;
    }    
    }
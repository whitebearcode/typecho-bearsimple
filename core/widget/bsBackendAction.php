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
        case 'rebuildCron':
            $table = $db->getPrefix() . 'bscore_cron_data';
                 $sql = "DROP TABLE IF EXISTS $table";
    $db->query($sql);
 $result = array(
    'code' => 1,
    'message' => '计划任务表重建成功~'
    
);
exit(json_encode($result));
            break;
            case 'fixTable':
            $option_val_type = $db->fetchObject($db->query('SELECT DATA_TYPE as dt FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = \''.$db->getPrefix().'bscore_wechat_data\' and column_name=\'content\''))->dt;
    if($option_val_type !== 'longtext'){
    $db->query('alter table `'.$db->getPrefix().'bscore_wechat_data` modify column `content` longtext');
    }
 $result = array(
    'code' => 1,
    'message' => '修复成功~'
    
);
exit(json_encode($result));
            break;
    }    
    }
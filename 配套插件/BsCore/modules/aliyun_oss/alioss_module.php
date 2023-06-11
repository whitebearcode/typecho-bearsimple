<?php
/**
 * 阿里OSS
 * https://www.bearnotion.ru/
 */

namespace TypechoPlugin\BsCore\modules\aliyun_oss;

use CSF;
use Utils\Helper;

global $cfs_options;
$cfs_options = [];

class Plugin
{

    public static function activate()
    {
        \Typecho\Plugin::factory('Widget_Upload')->uploadHandle         = [__CLASS__, 'ali_uploadHandle'];
        \Typecho\Plugin::factory('Widget_Upload')->modifyHandle         = [__CLASS__, 'ali_modifyHandle'];
        \Typecho\Plugin::factory('Widget_Upload')->deleteHandle         = [__CLASS__, 'ali_deleteHandle'];
        \Typecho\Plugin::factory('Widget_Upload')->attachmentHandle     = [__CLASS__, 'ali_attachmentHandle'];
        \Typecho\Plugin::factory('Widget_Upload')->attachmentDataHandle = [__CLASS__, 'ali_attachmentDataHandle'];
    }


    public function ali_uploadHandle()
    {
       
    }

     public function ali_modifyHandle()
    {
       
    }
     public function ali_deleteHandle()
    {
       
    }
     public function ali_attachmentHandle()
    {
       
    }
     public function ali_attachmentDataHandle()
    {
       
    }
}


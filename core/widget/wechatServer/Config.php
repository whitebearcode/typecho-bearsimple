<?php
$db = \Typecho\Db::get();
$amapSecret = '';
$options = bsOptions::getInstance()::get_option('bearsimple');
$config = [
    'app_id' => $options['wechat_appid'],
    'secret' => $options['wechat_appsecret'],
    'token' => $options['wechat_verifyToken'],
 	'aes_key' => $options['wechat_aeskey'],
    'response_type' => 'array',
   'log' => [
        'default' => 'prod',
        'channels' => [
            'dev' => [
                'driver' => 'single',
                'path' => __DIR__.'/tmp/wechat.log',
                'level' => 'debug',
            ],
            'prod' => [
                'driver' => 'single',
                'path' =>__DIR__.'/tmp/wechat.log',
                'level' => 'info',
            ],
        ],
    ],
];
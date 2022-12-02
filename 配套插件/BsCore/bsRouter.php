<?php
/**
 * Rules
 * https://www.bearnotion.org/
 */
namespace TypechoPlugin\BsCore;
require_once 'functions/defines.php';
require_once 'bsoptions-framework.php';

use CSF;
use Utils\Helper;

global $cfs_options;
$cfs_options = [];

class bsRouter extends \Typecho\Widget
{

    public static function initRouter()
    {
        // form action by submit
        Helper::addRoute('saveBSoptions', '/bsoptions/save', __CLASS__, 'saveBSoptions');
        Helper::addRoute('saveBSoptions_ajax', '/bsoptions/ajax', __CLASS__, 'saveBSoptionsByAjax');
    }

    public static function removeRouter()
    {
        Helper::removeRoute('saveBSoptions');
        Helper::removeRoute('saveBSoptions_ajax');
    }

    public function saveBSoptions()
    {
        $user = \Typecho\Widget::widget('Widget_User');
        if (!$user->hasLogin()) {
            echo '用户未登录';
            die();
        }

        // Set variables.
        $plugin = $this->request->get('plugin');

        $obj = get_bs_key_params($plugin);
        $obj->set_options(true);

//        if ( wp_verify_nonce( $nonce, 'csf_options_nonce' ) ) {
//            if ( ! empty( $transient['reset'] ) ) {
//
//                update_option($plugin, []);
//
//            }  else {
//
//                update_option($plugin, $_POST[$plugin]); //
//
//            }
//        }

//        $result = \CSF_Options::set_options(true);
        $this->response->goBack();
    }

    public function saveBSoptionsByAjax()
    {
        $user = \Typecho\Widget::widget('Widget_User');
        if (!$user->hasLogin()) {
            $data = [
                'data' => [
                    'notice' => '未登录',
                    'errors' => []
                ],
                'success' => false
            ];
            $this->response->throwJson($data);
        }

        $action = $this->request->get('action', null);
        if (!$action) {
            $data = [
                'data' => [
                    'notice' => '参数错误',
                    'errors' => []
                ],
                'success' => false
            ];
            $this->response->throwJson($data);
        }
        if (preg_match('/csf_(.*)_ajax_save/i', $action)) {
            $data = json_decode($_POST['data'], true);
            $plugin = $data['plugin'];


            $obj = get_bs_key_params($plugin);
            $ret = $obj->set_options(true);

            if ($ret and empty($obj->errors)) {
                $data = [
                    'data' => [
                        'notice' => $obj->notice,
                        'errors' => $obj->errors
                    ],
                    'success' => true
                ];
                $this->response->throwJson($data);
            } else {
                $data = [
                    'data' => [
                        'notice' => $obj->notice,
                        'errors' => $obj->errors
                    ],
                    'success' => true
                ];
                $this->response->throwJson($data);
            }

            //
//            update_option($plugin, $data[$plugin]); //

//            $data = [
//                'data' => [
//                    'notice' => '设置已保存',
//                    'errors' => []
//                ],
//                'success' => true
//            ];
//            $this->response->throwJson($data);
        } else {
            $action = str_replace('-', '_', $action);
            CSF::include_plugin_file('functions/actions.php');
            $action($this->response);
        }

    }
}


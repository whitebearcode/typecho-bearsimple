<?php
$options = Helper::options();
require_once('general.php');
require_once('assetsdir.php');
require_once('codehightlight.php');
require_once('compresshtml.php');
require_once('getversion.php');
require_once('getcheck.php');
require_once('gravatar.php');
require_once('replyview.php');
require_once('spam.php');
require_once('vaptcha.php');
require_once('captcha.php');
require_once('cache.php');
require_once('editor.php');
require_once('tongji.php');

function sliderget(){
    $options = Helper::options();
    $str = explode("|",$options->SliderPics);
    return $str;
}

function parseMultilineData($str, $columnCount)
    {
        $result = array();
        if (!empty($str)) {
            $data = explode("\n", $str);
            foreach ($data as $item) {
                $item = trim($item);
                if (!empty($item)) {
                    $itemData = explode('|', $item, $columnCount);
                    if (count($itemData) == $columnCount) {
                        foreach ($itemData as $k => $v) {
                            $itemData[$k] = trim($v);
                        }
                        $result[] = $itemData;
                    }
                }
            }
        }
        return $result;
    }

function getMenu()
    {
    $options = Helper::options();
        return parseMultilineData($options->Menu, 2);
    }

function getLink()
    {
    $options = Helper::options();
        return parseMultilineData($options->WebLink, 2);
    }
    
//主题开启后的设定


        
function themeInit($self){

    $options = Helper::options();
    if ($options->VerifyChoose == '1'){
$comment = spam_protection_prejia($self, $post, $result);
}
else if ($options->VerifyChoose == '11'){
$comment = spam_protection_prejian($self, $post, $result);
}
else{
$comment = spam_protection_prejia($self, $post, $result);
}
Helper::options()->commentsAntiSpam = false;

         if (Helper::options()->SiteMap && Helper::options()->SiteMap !== 'close') {
        if (strpos($self->request->getRequestUri(), 'sitemap.xml') !== false) {
            $self->response->setStatus(200);
            $self->setThemeFile("modules/SiteMap/sitemap.php");
        }
    }


}

/**
 * 文章自定义字段
 */

function themeFields(Typecho_Widget_Helper_Layout $layout)
{
     $Hot = new Typecho_Widget_Helper_Form_Element_Select('Hot', array('1' => '开启文章热度',  '2' => '关闭文章热度'), '2', '是否开启文章热度', '若选择开启,则文章页面将显示文章热度值。');
    $layout->addItem($Hot->multiMode());
    
    $copyright = new Typecho_Widget_Helper_Form_Element_Select('copyright', array('1' => '开启版权声明',  '2' => '关闭版权声明'), '2', '本文是否开启版权声明', '开启后在文章页面会显示版权声明。');
    $layout->addItem($copyright->multiMode());
    
    $excerpt = new Typecho_Widget_Helper_Form_Element_Textarea('excerpt', null, null, '文章摘要', '输入自定义摘要。留空自动从文章截取。');
    $layout->addItem($excerpt);
    $articleplo = new Typecho_Widget_Helper_Form_Element_Select('articleplo', array('1' => '关闭文章提示',  '2' => '在顶部展现文章提示',  '3' => '在左上角展现文章提示',  '4' => '在右上角展现文章提示'), '1', '文章提示展现形式', '开启后阅读本篇文章时会在所选择的位置展现文章提示');
    $layout->addItem($articleplo->multiMode());
    $articleplonr = new Typecho_Widget_Helper_Form_Element_Textarea('articleplonr', null, null, '文章提示内容', '文章提示功能非关闭状态时本栏有效，输入文章提示内容。留空则不显示');
    $layout->addItem($articleplonr);
    
}

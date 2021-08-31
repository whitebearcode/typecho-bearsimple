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
require_once('markdown.php');
require_once('checksec.php');
require_once('poster.php');
require_once('music.php');

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
Helper::options()->commentsMaxNestingLevels = 999;
         if (Helper::options()->SiteMap && Helper::options()->SiteMap !== 'close') {
        if (strpos($_SERVER['REQUEST_URI'], 'sitemap.xml') !== false) {
            //$self->response->setStatus(200);/**Typecho开发版新版本使用此方法会导致无法显示页面，似乎不需要再调了**/
            $self->setThemeFile("modules/SiteMap/sitemap.php");
        }
    }
 if (strpos($_SERVER['REQUEST_URI'], 'makepost') !== false) {
            //$self->response->setStatus(200);/**Typecho开发版新版本使用此方法会导致无法显示页面，似乎不需要再调了**/
            $self->setThemeFile("modules/MakePost/makepost.php");
        }
        
 if (strpos($_SERVER['REQUEST_URI'], 'usercenter') !== false) {
            //$self->response->setStatus(200);/**Typecho开发版新版本使用此方法会导致无法显示页面，似乎不需要再调了**/
            $self->setThemeFile("modules/UserCenter/user.php");
        }
}

/**
 * 文章自定义字段
 */

function themeFields(Typecho_Widget_Helper_Layout $layout)
{
    $cover = new Typecho_Widget_Helper_Form_Element_Text('cover', null, null, '文章封面', '输入文章封面图片直链');
    $layout->addItem($cover);
    
     $Hot = new Typecho_Widget_Helper_Form_Element_Select('Hot', array('1' => '开启文章热度',  '2' => '关闭文章热度'), '2', '是否开启文章热度', '若选择开启,则文章页面将显示文章热度值。');
    $layout->addItem($Hot->multiMode());
    
    $copyright = new Typecho_Widget_Helper_Form_Element_Select('copyright', array('1' => '开启版权声明',  '2' => '关闭版权声明'), '2', '本文是否开启版权声明', '开启后在文章页面会显示版权声明。');
    $layout->addItem($copyright->multiMode());
    
    $tags = new Typecho_Widget_Helper_Form_Element_Select('tags', array('1' => '开启文章标签',  '2' => '关闭文章标签'), '2', '本文是否开启标签', '开启后在文章末尾会显示文章标签，若文章不添加标签的情况下建议关闭。');
    $layout->addItem($tags->multiMode());
    
    $excerpt = new Typecho_Widget_Helper_Form_Element_Textarea('excerpt', null, null, '文章摘要', '输入自定义摘要。留空自动从文章截取。');
    $layout->addItem($excerpt);
    $articleplo = new Typecho_Widget_Helper_Form_Element_Select('articleplo', array('1' => '关闭文章提示',  '2' => '在顶部展现文章提示',  '3' => '在左上角展现文章提示',  '4' => '在右上角展现文章提示'), '1', '文章提示展现形式', '开启后阅读本篇文章时会在所选择的位置展现文章提示');
    $layout->addItem($articleplo->multiMode());
    $articleplonr = new Typecho_Widget_Helper_Form_Element_Textarea('articleplonr', null, null, '文章提示内容', '文章提示功能非关闭状态时本栏有效，输入文章提示内容。留空则不显示');
    $layout->addItem($articleplonr);
    
    $Overdue = new Typecho_Widget_Helper_Form_Element_Select(
        'Overdue',
        array(
            'close' => '关闭',
            '30' => '大于30天',
            '60' => '大于60天',
            '90' => '大于90天',
            '120' => '大于120天',
            '180' => '大于180天'
        ),
        'off',
        '是否开启文章时效性提示',
        '开启后如果文章在多少天内无任何修改，则显示文章时效性提示'
    );
    $layout->addItem($Overdue->multiMode());
    
    $Poster = new Typecho_Widget_Helper_Form_Element_Select('Poster', array('1' => '开启文章微海报',  '2' => '关闭文章微海报'), '2', '本文是否开启微海报', '开启后在文章页面会显示文章微海报生成按钮，请在服务器配置允许的情况下开启，配置较差的不建议开启。');
    $layout->addItem($Poster->multiMode());
    
}

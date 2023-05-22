<?php
namespace TypechoPlugin\BsCore;
error_reporting(0);
use Utils\Helper;
use Typecho\Plugin\PluginInterface;
use Typecho\Widget\Helper\Form;
use Typecho\{Plugin\Exception, Widget, Db, Widget\Request as WidgetRequest};
use \CSF as CSF;
use bsOptions;
use Widget\Options;
use Typecho\Common;
use Typecho\Router;
use Widget\Archive;
use Widget\Contents\Post\Admin;
use Widget\Contents\Post\Edit;
use Widget\Feedback;
use Widget\Service;
use ReflectionClass;
use Utils\PasswordHash;
use Typecho\Widget\Response as WidgetResponse;
require_once 'modules/DX_Captcha/CaptchaClient.php';
require_once 'modules/Markdown/ParsedownExtension.php';
use ParsedownExtension;
use CaptchaClient;
require_once dirname(__FILE__) . '/modules/Tinypng/Tinify/Exception.php';
require_once dirname(__FILE__) . '/modules/Tinypng/Tinify/ResultMeta.php';
require_once dirname(__FILE__) . '/modules/Tinypng/Tinify/Result.php';
require_once dirname(__FILE__) . '/modules/Tinypng/Tinify/Source.php';
require_once dirname(__FILE__) . '/modules/Tinypng/Tinify/Client.php';
require_once dirname(__FILE__) . '/modules/Tinypng/Tinify.php';

/**
 * BearSimple主题核心插件
 * <br>安装后无需进行其他设置
 * @package BsCore
 * @author WhiteBear
 * @version v2.2.8-release
 * @link https://www.bearnotion.ru/
 *
 */



if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (!defined('pluginName')) {
  define('pluginName', 'BsCore');
}
require_once 'bsoptions-framework.php';

class Plugin implements PluginInterface
{
    #邮件
    public static $action = 'bs-ajax';
    private static $_isMailLog  = false;
    private static $_adapter    = false;
    
    #上传文件目录
  const UPLOAD_DIR = 'usr/uploads';
public static $cache = null;
	public static $html = null;
	public static $path = null;
	public static $sys_config = null;
	public static $plugin_config = null;
	public static $request = null;
	public static $passed = false;
    
  
    
     public static function getNS(): string
    {
        return __NAMESPACE__;
    }
    
    public static function activate()
    {
        /* 
         *
         *  初始化路由和方法
         *
         */
        
        bsRouter::initRouter();
        if(get_option('bearsimple')['goLinkOpen'] == true){
        //外链转内链钩子
        Helper::addRoute('go', '/go/[key]/', 'TypechoPlugin\BsCore\Action', 'bsshortlink');
        \Typecho\Plugin::factory('Widget_Abstract_Contents')->contentEx_12 = [__CLASS__, 'replace'];
        \Typecho\Plugin::factory('Widget_Abstract_Contents')->excerptEx_12 = [__CLASS__, 'replace'];
        }
        \Typecho\Plugin::factory('index.php')->begin = [__CLASS__, 'initevent'];
        \Typecho\Plugin::factory('admin/header.php')->header_999 = [__CLASS__, 'enqueue_style'];
        \Typecho\Plugin::factory('admin/footer.php')->end_999 = [__CLASS__, 'enqueue_script'];
         if(get_option('bearsimple')['Cache'] == true && !empty(get_option('bearsimple')['Cache_choose']) && get_option('bearsimple')['Cache_choose'] !== '1'){
        //缓存功能钩子
        Helper::addRoute('clean-cache', '/clean-cache', 'TypechoPlugin\BsCore\Action', 'clean_cache');
		\Typecho\Plugin::factory('index.php')->begin = array(__CLASS__, 'C');
		\Typecho\Plugin::factory('index.php')->end = array(__CLASS__, 'S');
        \Typecho\Plugin::factory('Widget_Contents_Post_Edit')->finishPublish = [__CLASS__, 'post_update'];
        \Typecho\Plugin::factory('Widget_Contents_Page_Edit')->finishPublish = [__CLASS__, 'post_update'];
        \Typecho\Plugin::factory('Widget_Contents_Post_Edit')->delete = [__CLASS__, 'post_del_update'];
        \Typecho\Plugin::factory('Widget_Contents_Page_Edit')->delete = [__CLASS__, 'post_del_update'];
        \Typecho\Plugin::factory('Widget_Feedback')->finishComment_1 = [__CLASS__, 'comment_update'];
		\Typecho\Plugin::factory('Widget_Comments_Edit')->finishDelete = [__CLASS__, 'comment_update2'];
		\Typecho\Plugin::factory('Widget_Comments_Edit')->finishEdit = [__CLASS__, 'comment_update2'];
		\Typecho\Plugin::factory('Widget_Comments_Edit')->finishComment = [__CLASS__, 'comment_update2'];
        \Typecho\Plugin::factory('Widget_Abstract_Contents')->contentEx = [__CLASS__, 'cache_contentEx'];
        \Typecho\Plugin::factory('BsCache.Widget_Cache')->getCache = [__CLASS__, 'BsCache_getCache'];
        \Typecho\Plugin::factory('BsCache.Widget_Cache')->setCache = [__CLASS__, 'BsCache_setCache'];
         }
         if(get_option('bearsimple')['Cache'] == true && !empty(get_option('bearsimple')['Cache_choose']) && get_option('bearsimple')['Cache_choose'] == '1'){
         \Typecho\Plugin::factory('index.php')->begin = [__CLASS__, 'getCache_file'];
        \Typecho\Plugin::factory('index.php')->end = [__CLASS__, 'setCache_file'];
         }
        if(get_option('bearsimple')['Editors'] == '2'){
        \Typecho\Plugin::factory('admin/write-post.php')->bottom_1000 =  [__CLASS__,'btbutton'];
        \Typecho\Plugin::factory('admin/write-page.php')->bottom_1000 = [__CLASS__, 'btbutton'];
        }
        else{
        \Typecho\Plugin::factory('admin/write-post.php')->richEditor_1000 = [__CLASS__, 'Editor'];
        \Typecho\Plugin::factory('admin/write-page.php')->richEditor_1000 = [__CLASS__, 'Editor'];
        }
        \Typecho\Plugin::factory('Widget_Feedback')->comment = [__CLASS__, 'filter'];
          if(get_option('bearsimple')['Sticky'] == true){
        //文章置顶
        \Typecho\Plugin::factory('Widget_Archive')->indexHandle =  [__CLASS__, 'sticky'];
		\Typecho\Plugin::factory('Widget_Archive')->categoryHandle =[__CLASS__, 'stickyC'];
          }
          if(get_option('bearsimple')['seo_push'] == true){
          \Typecho\Plugin::factory('Widget_Contents_Post_Edit')->finishPublish = [__CLASS__, 'seo_publishpush'];
          }
        //腾讯云COS
        if(get_option('bearsimple')['bucket_choose'] == '2'){
\Typecho\Plugin::factory('Widget_Upload')->uploadHandle = [__CLASS__, 'uploadHandle'];
   \Typecho\Plugin::factory('Widget_Upload')->modifyHandle = [__CLASS__, 'modifyHandle'];
    \Typecho\Plugin::factory('Widget_Upload')->deleteHandle = [__CLASS__, 'deleteHandle'];
    \Typecho\Plugin::factory('Widget_Upload')->attachmentHandle = [__CLASS__, 'attachmentHandle'];
    \Typecho\Plugin::factory('Widget_Upload')->attachmentDataHandle = [__CLASS__, 'attachmentDataHandle'];
    \Typecho\Plugin::factory('Widget_Archive')->beforeRender = [__CLASS__, 'Widget_Archive_beforeRender'];
        }
        //代码高亮
        \Typecho\Plugin::factory('Widget_Archive')->header = [__CLASS__, 'headlink'];
       \Typecho\Plugin::factory('Widget_Archive')->footer = [__CLASS__, 'footlink'];
       //登陆验证逻辑
       //\Typecho\Plugin::factory('admin/header.php')->header_1081 = [__CLASS__, 'loginverify'];
         //邮件
         if(get_option('bearsimple')['CommentNotify__Open'] == true && get_option('bearsimple')['Smtp_open'] == true){
         \Typecho\Plugin::factory('Widget_Feedback')->finishComment = [__CLASS__,'parseComment'];
        \Typecho\Plugin::factory('Widget_Comments_Edit')->finishComment = [__CLASS__,'parseComment'];
         }
         if(get_option('bearsimple')['Smtp_open'] == true){
         Helper::addAction(self::$action, 'TypechoPlugin\BsCore\Action');
         }
         if(get_option('bearsimple')['Comment_private'] == true){
         \Typecho\Plugin::factory('Widget_Abstract_Comments')->contentEx = [__CLASS__,'secretComment'];
         }
         if(get_option('bearsimple')['Cate_Encrypt_open'] == true && get_option('bearsimple')['Cate_Encrypt_hide'] == false){
         \Typecho\Plugin::factory('Widget_Archive')->indexHandle = [__CLASS__,'CateFilter'];
         }
         //当腾讯云COS存储未开启时且Tinypng压缩开启
         if(get_option('bearsimple')['Tinypng_open'] == true && get_option('bearsimple')['bucket_choose'] !== '2'){
        \Typecho\Plugin::factory('Widget_Upload')->uploadHandle = [__CLASS__,'tinypng_uploadHandle'];
         }
         if(get_option('bearsimple')['Tinypng_open'] == true){
        \Typecho\Plugin::factory('admin/write-post.php')->bottom = [__CLASS__,'tinypng_bottom'];
         }
         \Typecho\Plugin::factory('admin/write-post.php')->bottom_99 = [__CLASS__,'tags_bottom'];
         //当开启用户中心功能
         if(get_option('bearsimple')['UserCenterOpen'] == true){
         \Typecho\Plugin::factory('Widget_Register')->register_99 = [__CLASS__,'bregister'];   
         \Typecho\Plugin::factory('Widget_Register')->finishRegister_99 = [__CLASS__,'bregister_finish'];   
         }
         \Typecho\Plugin::factory('Widget_Abstract_Contents')->markdown = [__CLASS__, 'markdownparse'];
        \CSF::activateEvent();
        
        /* 
         *
         *  检测数据库并插入数据库表
         *
         */
         
         $db = \Typecho\Db::get();
          $prefix = $db->getPrefix();
         
         $table = $db->getPrefix() . 'bscore_friendlinks';
         $table2 = $db->getPrefix() . 'bscore_sign_data';
         $table3 = $db->getPrefix() . 'bscore_notify_data';
         $table4 = $db->getPrefix() . 'bscore_says_data';
    $adapter = $db->getAdapterName();
        if ("Pdo_SQLite" === $adapter || "SQLite" === $adapter || "pgsql" === $adapter || "Pdo_Pgsql" === $adapter) {
            //友链表检测初始化
            $db->query(" CREATE TABLE IF NOT EXISTS " . $table . " (
			   id INTEGER PRIMARY KEY,
			   friendname TEXT,
			   friendurl TEXT,
			   friendpic TEXT,
			   frienddec TEXT,
			   contactmail TEXT,
			   status TEXT)");
			   //用户中心签到表检测初始化
			   $db->query(" CREATE TABLE IF NOT EXISTS " . $table2 . " (
			   id INTEGER PRIMARY KEY,
			   signuid TEXT,
			   signtime TEXT,
			   signcoin TEXT)");
			   //用户中心通知表检测初始化
			   $db->query(" CREATE TABLE IF NOT EXISTS " . $table3 . " (
			   id INTEGER PRIMARY KEY,
			   notifyuid TEXT,
			   notifytime TEXT,
			   notifytitle TEXT,
			   notifytext TEXT)");
			   //用户中心动态表检测初始化
			   $db->query(" CREATE TABLE IF NOT EXISTS " . $table4 . " (
			   id INTEGER PRIMARY KEY,
			   saysuid TEXT,
			   saystime TEXT,
			   saystext TEXT,
			   saysprivate TEXT,
			   sayslike TEXT DEFAULT 0)");
			   if (!array_key_exists('coins', $db->fetchRow($db->select()->from('table.users')))) {
$db->query('ALTER TABLE `' . $prefix . 'users` ADD `coins` TEXT NOT NULL  DEFAULT 0;');
}
if (!array_key_exists('submission', $db->fetchRow($db->select()->from('table.users')))) {
$db->query('ALTER TABLE `' . $prefix . 'users` ADD `submission` TEXT NOT NULL  DEFAULT true;');
}
if (!array_key_exists('person_Signature', $db->fetchRow($db->select()->from('table.users')))) {
$db->query('ALTER TABLE `' . $prefix . 'users` ADD `person_Signature` TEXT NOT NULL  DEFAULT 0;');
} 
if (strpos($db->fetchAll($db->query("select sql from sqlite_master where type = 'table' and name = 'typecho_bscore_friendlinks'"))[0]['sql'], 'checkurl') == false) {
            $db->query('ALTER TABLE `' . $prefix . 'bscore_friendlinks` ADD `checkurl` TEXT NOT NULL  DEFAULT 0;');
        }
        }
        if ("Pdo_Mysql" === $adapter || "Mysql" === $adapter || "Mysqli" === $adapter) {
            $dbConfig = null;
            if (class_exists('\Typecho\Db')) {
                $dbConfig = $db->getConfig($db::READ);
            } else {
                $dbConfig = $db->getConfig()[0];
            }
            $charset = $dbConfig->charset;
            $db->query("CREATE TABLE IF NOT EXISTS " . $table . " (
				  `id` int(8) NOT NULL AUTO_INCREMENT,
				  `friendname` varchar(1000) NOT NULL,
			      `friendurl` varchar(1000) NOT NULL,
			      `friendpic` varchar(1000) NOT NULL,
			      `frienddec` varchar(1000) NOT NULL,
			      `contactmail` varchar(1000) DEFAULT NULL,
			      `status` varchar(1000) NOT NULL,
				  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=$charset AUTO_INCREMENT=1");
				
			$db->query(" CREATE TABLE IF NOT EXISTS " . $table2 . " (
			   `id` int(8) NOT NULL AUTO_INCREMENT,
			   `signuid` varchar(1000) NOT NULL,
			   `signtime` varchar(1000) NOT NULL,
			   `signcoin` varchar(1000) NOT NULL,
			  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=$charset AUTO_INCREMENT=1");
				
			$db->query(" CREATE TABLE IF NOT EXISTS " . $table3 . " (
			   `id` int(8) NOT NULL AUTO_INCREMENT,
			   `notifyuid` varchar(1000) NOT NULL,
			   `notifytime` varchar(1000) NOT NULL,
			   `notifytitle` varchar(1000) NOT NULL,
			   `notifytext` varchar(1000) NOT NULL,
			  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=$charset AUTO_INCREMENT=1");
				
			   $db->query(" CREATE TABLE IF NOT EXISTS " . $table4 . " (
			   `id` int(8) NOT NULL AUTO_INCREMENT,
			   `saysuid` varchar(1000) NOT NULL,
			   `saystime`  varchar(1000) NOT NULL,
			   `saystext`  varchar(1000) NOT NULL,
			   `saysprivate`  varchar(1000) NOT NULL,
			   `sayslike`  varchar(1000) NOT NULL DEFAULT 0,
			  PRIMARY KEY (`id`)
				) DEFAULT CHARSET=$charset AUTO_INCREMENT=1");
				if(json_decode(json_encode($db->fetchAll($db->query("SHOW FULL COLUMNS FROM ".$table))),true)[6]['Field'] !=='contactmail' && json_decode(json_encode($db->fetchAll($db->query("SHOW FULL COLUMNS FROM ".$table))),true)[5]['Field'] !=='contactmail'){
            $db->query('ALTER TABLE '.$table.' ADD `contactmail` varchar(1000) DEFAULT null;');
        }
        if (!array_key_exists('coins', $db->fetchRow($db->select()->from('table.users')))) {
$db->query('ALTER TABLE `' . $prefix . 'users` ADD `coins` varchar(1000) NOT NULL  DEFAULT 0;');
}
if (!array_key_exists('submission', $db->fetchRow($db->select()->from('table.users')))) {
$db->query('ALTER TABLE `' . $prefix . 'users` ADD `submission` varchar(1000) NOT NULL  DEFAULT true;');
}
if (!array_key_exists('person_Signature', $db->fetchRow($db->select()->from('table.users')))) {
$db->query('ALTER TABLE `' . $prefix . 'users` ADD `person_Signature` varchar(1000) NOT NULL  DEFAULT 0;');
}
if(json_decode(json_encode($db->fetchAll($db->query("SHOW FULL COLUMNS FROM ".$table))),true)[8]['Field'] !=='checkurl'&&json_decode(json_encode($db->fetchAll($db->query("SHOW FULL COLUMNS FROM ".$table))),true)[7]['Field'] !=='checkurl'){
            $db->query('ALTER TABLE ' . $table . '  ADD `checkurl` varchar(1000) NOT NULL  DEFAULT 0;');
        }
        }
        
        
        
         return _t('BsCore核心同步完成');
    }

    public static function deactivate()
    {
        bsRouter::removeRouter();
        return _t('BsCore核心清除完成');
    }
    
    
   

    public static function initevent()
    {
        if (!class_exists('bsOptions')){
            require_once \Utils\Helper::options()->pluginDir('BsCore').'/bsOptions.php';
        }
    }
    public static function enqueue_style($header=null, $old=null)
    {
        \Typecho\Widget::widget('Widget_User')->to($user);
        $options = get_option('bearsimple');
        if($user->hasLogin() && !$user->pass('administrator', true) && $options['UserCenterRedirect'] == true){
        header('Location: '.Helper::options()->siteUrl.'/index.php/usercenter', true, 302);
        }
        if ($old!=null) $header = $old;
        return CSF::get_enqueue_style($header);
    }

    public static function enqueue_script($footer=null)
    {
        return CSF::get_enqueue_script($footer);
    }

    public static function config(Form $form)
    {

    }

    public static function personalConfig(Form $form)
    {
    }
    
    

 public static function configHandle($origin_config, $is_init)
    {
        return true;
    }
 public static function bCore_parseMultilineData($str, $columnCount)
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
 public static function bCore_seacharr_by_value($array, $index, $value){
    if(is_array($array) && count($array)>0) {
        foreach(array_keys($array) as $key){
            $temp[$key] = $array[$key][$index];
            if ($temp[$key] == $value){
                $newarray[$key] = $array[$key];
            }
        }
    }
    return $newarray;
}
public static function bCore_getDiyLinkToArray($data){
    $res = array();
foreach($data as $k=>$v){
    $res[]= array(
        'url' => $v[1],
        'key'=>$v[0]
        );
        
}
return $res;
 }
//获取自定义内链
public static function bCore_getDiyLink($key){
    $options = bsOptions::getInstance()::get_option('bearsimple');
    $data = self::bCore_parseMultilineData($options['goLinkList'],2);
    $result = self::bCore_seacharr_by_value(self::bCore_getDiyLinkToArray($data),'key',$key);
    $res = array();
foreach($result as $k=>$v){
   foreach ($v as $key=>$value) {
      $res[$key] = $value;
   }
}
    return $res;
}

public static function markdownparse($text)
    {
        $mdp = new ParsedownExtension;
        $markdownParser              = $mdp::instance();
        return $markdownParser->setBreaksEnabled(true)->text($text);
    }
 public static function bregister($v) {
  $hasher = new PasswordHash(8, true);
  if(\Typecho\Widget::widget('Widget_Register')->request->password !== ''){
    $generatedPassword = \Typecho\Widget::widget('Widget_Register')->request->password;
  }else{
    $generatedPassword = \Typecho\Common::randString(7);
  }
  define('getpassd', (string)$generatedPassword);
  $wPassword = $hasher->HashPassword((string)$generatedPassword);
  $v['password']=$wPassword;
  if(\Typecho\Widget::widget('Widget_Register')->request->regtype == 'nobackend'){
  $v['group']='contributor';
  $v['submission']=1;
  }
  else{
   $v['submission']=0;   
  }
  return $v;
}   

public static function bregister_finish($obj) {
 $wPassword=getpassd;
 \Typecho\Widget::widget('Widget_User')->to($user);
 $user->login($obj->request->name,$wPassword);
 \Typecho\Cookie::delete('__typecho_first_run');
 \Typecho\Cookie::delete('__typecho_remember_name');
 \Typecho\Cookie::delete('__typecho_remember_mail');
 $obj->widget('Widget_Notice')->set(_t('用户 <strong>%s</strong> 已经成功注册, 密码为 <strong>%s</strong>', $obj->screenName, $wPassword), 'success');
 if (NULL != $obj->request->referer) {
 $obj->response->redirect($obj->request->referer);
 }else if(NULL != $obj->request->tz){
   if (Helper::options()->rewrite==0){$authorurl=Helper::options()->rootUrl.'/index.php/usercenter/';}else{$authorurl=Helper::options()->rootUrl.'/usercenter/';}
  $obj->response->redirect($authorurl.$obj->user->uid);
 }else{
 $obj->response->redirect(Helper::options()->adminUrl);
 }
}
 //外链转内链
 public static function replace($text, $widget, $lastResult)
    {
        $text = empty($lastResult) ? $text : $lastResult;
        $options = get_option('bearsimple');
        
        $target = '';
        if($options['Pjax'] == 1){
            $target .= ' pjax="no"';
        }
        if($options['goLinkNewWindow'] == 1){
            $target .= ' target="_blank"';
        }
            $fields = unserialize($widget->fields);
            // 文章内容和评论内容处理
            @preg_match_all('/<a(.*?)href="(?!#)(.*?)"(.*?)>/', $text, $matches);
            if ($matches) {
                foreach ($matches[2] as $link) {
                    $text = str_replace("href=\"$link\"", "href=\"" . self::convertLinks($link) . "\"" . $target, $text);
                }
            }
        return $text;
    }
 public static function urlSafeB64Encodes($str)
    {
        $data = base64_encode($str);
        return str_replace(array('+', '/', '='), array('-', '_', ''), $data);
    }
public static function urlSafeB64Decodes($str)
    {
        $data = str_replace(array('-', '_'), array('+', '/'), $str);
        $mod = strlen($data) % 4;
        if ($mod) {
            $data .= substr('====', $mod);
        }
        return base64_decode($data);
    }
  public static function textareaToArrs($textarea)
    {
        $str = str_replace(array("\r\n", "\r", "\n"), "|", $textarea);
        if ($str == "") {
            return null;
        }

        return explode("|", $str);
    }
 public static function checkDomains($url, $arr)
    {
        if ($arr === null) {
            return false;
        }

        if (count($arr) === 0) {
            return false;
        }

        foreach ($arr as $a) {
            if (strpos($url, $a) !== false) {
                return true;
            }
        }
        return false;
    }
 public static function convertLinks($link, $check = true)
    {
        $options = get_option('bearsimple');
        $linkBase = ltrim(rtrim(\Typecho\Router::get('go')['url'], '/'), '/'); // 防止链接形式修改后不能用
        $siteUrl = Helper::options()->siteUrl;
        $nonConvertList = self::textareaToArrs($options['goLinkNonConvertList']); // 不转换列表
        if ($check) {
            if (strpos($link, '://') !== false && strpos($link, rtrim($siteUrl, '/')) !== false) {
                return $link;
            }
            // 本站链接不处理 不转换列表中的不处理
            if (self::checkDomains($link, $nonConvertList)) {
                return $link;
            }

            // 图片不处理
            if (preg_match('/\.(jpg|jepg|png|ico|bmp|gif|tiff)/i', $link)) {
                return $link;
            }
        }
        return \Typecho\Common::url(str_replace('[key]', self::urlSafeB64Encodes(htmlspecialchars_decode($link)), $linkBase), Helper::options()->index);
    }
    
  //取出所有加密分类mid并剔除重复值
public static function getCols($arr, $col)
    {
        $ret = array();
        foreach ($arr as $row)
        {
            if (isset($row[$col])) {
                $ret[] = $row[$col];
            }
        }
        
        return array_unique($ret);
    }
    
//加密的分类排列
public static function EncryptCategory(){
    $options = get_option('bearsimple');
    $data = $options['Cate_Encrypt'];
    $res = self::getCols($data, 'Cate_Encrypt_Id');
    return $res;
}

   public static function CateFilter($thisx, $select){
       \Typecho\Widget::widget('Widget_User')->to($user);
       $mid = self::EncryptCategory();
       $db = \Typecho\Db::get();
        $adapter = $db->getAdapterName();
       if ("Pdo_SQLite" === $adapter || "SQLite" === $adapter) {
            $db_query = 'left';
        }
        if ("Pdo_Mysql" === $adapter || "Mysql" === $adapter) {
            $db_query = 'right';
        }
        if(empty($mid) || $user->hasLogin()) return $select;       //没有加密分类或用户已登录，则直接返回
        $select = $select->join('table.relationships','table.relationships.cid = table.contents.cid',''.$db_query.'')->join('table.metas','table.relationships.mid = table.metas.mid',''.$db_query.'')->where('table.metas.type=?','category');
        foreach ($mid as $k => $v) {
            $select = $select->where('table.relationships.mid != '.intval($mid[$k]));//确保每个值都是数字
        }          
        return $select;
    }
   // 置顶
   public static function sticky($archive, $select)
    {
        $config  = get_option('bearsimple');
        if(!empty($config['Sticky_cids'])&&!empty($config['Sticky_cids_pages'])){
        $sticky_cids = array_merge($config['Sticky_cids'],$config['Sticky_cids_pages']);
        }
        if(!empty($config['Sticky_cids'])&&empty($config['Sticky_cids_pages'])){
        $sticky_cids = $config['Sticky_cids'];
        }
        if(empty($config['Sticky_cids'])&&!empty($config['Sticky_cids_pages'])){
        $sticky_cids = $config['Sticky_cids_pages'];
        }
        if (!$sticky_cids) return;

        $pagesize = Helper::options()->pageSize;
        $db = \Typecho\Db::get();
        $paded = $archive->request->get('page', 1);
$sticky_html = $config['Sticky_Mod'] ? $config['Sticky_Mod'] : "<span style='color:red'>[置顶] </span>";
        foreach($sticky_cids as $cid) {
          if ($cid && $sticky_post = $db->fetchRow($archive->select()->where('cid = ?', $cid))) {
              if ($paded == 1) {                
                $sticky_post['title'] = $sticky_post['title'];
                $sticky_post['sticky'] = $sticky_html;
                $archive->push($sticky_post); 
                //$pagesize = $pagesize - 1;
              }
              $select->where('table.contents.cid != ?', $cid);
              if ($pagesize > 0) { 
              $archive->parameter->pageSize = $pagesize;
              }
          }
        }
    }
    
	public static function stickyC($archive, $select)
	{
		$config  = get_option('bearsimple');
        $sticky_cid = $config['Sticky_cids_category'];
        if (!$sticky_cid) return;

        $pagesize = Helper::options()->pageSize;
        $db = \Typecho\Db::get();
        $paded = $archive->request->get('page', 1);
$sticky_html = $config['Sticky_Mod'] ? $config['Sticky_Mod'] : "<span style='color:red'>[置顶] </span>";
        foreach($sticky_cid as $cid) {
          $sticky_post = $db->fetchRow($archive->select()->where('cid = ?', $cid));
          if ($config['Sticky_Category']) {             
          	    $archive->widget('Widget_Archive@'.$cid, 'pageSize=1&type=post', 'cid='.$cid)->to($slug);
      	        $pattern = preg_match("/".$slug->category."/i", $_SERVER['PHP_SELF']);
          }else {
          	    $pattern = true;
          }
      	        
          if ($cid && $sticky_post && $pattern) {
              if ($paded == 1) {
                $sticky_post['title'] = $sticky_post['title'];
                $sticky_post['sticky'] = $sticky_html;
                $archive->push($sticky_post);
                //$pagesize = $pagesize - 1;
              }
              $select->where('table.contents.cid != ?', $cid);
              if ($pagesize > 0) {
              $archive->parameter->pageSize = $pagesize;
              }
          }

        }
	}
     public function setField(string $name, string $type, string $value, int $cid)
    {
        $db = \Typecho\Db::get();
        if (
            empty($name)
            || !in_array($type, ['str', 'int', 'float'])
        ) {
            return false;
        }

        $exist = $db->fetchRow($db->select('cid')->from('table.fields')
            ->where('cid = ? AND name = ?', $cid, $name));

        if (empty($exist)) {
            return $db->query($db->insert('table.fields')
                ->rows([
                    'cid'         => $cid,
                    'name'        => $name,
                    'type'        => $type,
                    'str_value'   => 'str' == $type ? $value : null,
                    'int_value'   => 'int' == $type ? intval($value) : 0,
                    'float_value' => 'float' == $type ? floatval($value) : 0
                ]));
        } else {
            return $db->query($db->update('table.fields')
                ->rows([
                    'type'        => $type,
                    'str_value'   => 'str' == $type ? $value : null,
                    'int_value'   => 'int' == $type ? intval($value) : 0,
                    'float_value' => 'float' == $type ? floatval($value) : 0
                ])
                ->where('cid = ? AND name = ?', $cid, $name));
        }
    }
    public static function C()
    {
        self::initEnv();
        $op = Helper::options();
        $scheme = parse_url($op->siteUrl)['scheme'];
        $host = parse_url($op->siteUrl)['host'];
        $ip = gethostbyname($_SERVER['HTTP_HOST']);
        if (self::$plugin_config->enable_gcache == '0')
            return ;
        if (self::$plugin_config->Cache_choose == '0')
            return;
        if (!self::preCheck()) return;

        if (!self::initPath()) return;
        try {
            $data = self::getCache();
            if (!empty($data)) {
                if ($data['time'] + self::$plugin_config->expire < time())
                    self::$passed = false;
               //处理可能存在开启缓存后域名被替换为IP地址的问题
               $html = $data['html'];
               $html = str_replace('https://'.$ip,$op->siteUrl,$html);
               $html = str_replace('http://'.$ip,$op->siteUrl,$html);
               $html = str_replace('http//','',$html);
               $html = str_replace('https//','',$html);
               $html = str_replace(':443/','',$html);
               $html = str_replace('http://'.$host.'/',$op->siteUrl,$html);
               $html = str_replace('https://'.$host.'/',$op->siteUrl,$html);
         echo $html;
                die;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        ob_flush();
    }

    public static function S($html = '')
    {
        if (self::$plugin_config->Cache_choose == '0')
            return;
        if (is_null(self::$path) || !self::$passed)
            return;
        if (empty($html))
            $html = ob_get_contents();
        $data = array();
        $data['time'] = time();
        $data['html'] = $html;
        self::setCache($data);
    }

    public static function getCache($name = null)
    {
        if ($name) return unserialize(self::$cache->get($name));
        return unserialize(self::$cache->get(self::$path));
    }

    public static function setCache($data, $name = null)
    {
        if ($name) return self::$cache->set($name, serialize($data));
        return self::$cache->set(self::$path, serialize($data));
    }

    public static function delCache($path, $rmHome = True)
    {
        self::$cache->delete($path);
        if ($rmHome)
            self::$cache->delete('/');
    }

    public static function preCheck($checkPost = True)
    {
        if ($checkPost && self::$request->isPost()) return false;

        if (self::$plugin_config->login && \Typecho\Widget::widget('Widget_User')->hasLogin())
            return false;
        if (self::$plugin_config->enable_ssl == '0' && self::$request->isSecure() == true)
            return false;
        if (self::$plugin_config->Cache_choose == '0')
            return false;
        self::$passed = true;
        return true;
    }

    public static function initEnv()
    {
        if (!class_exists('bsOptions')){
            require_once \Utils\Helper::options()->pluginDir('BsCore').'/bsOptions.php';
        }
        if (is_null(self::$sys_config))
            self::$sys_config = bsOptions::getInstance();
        if (is_null(self::$plugin_config))
            self::$plugin_config = (Object)self::$sys_config::get_option('bearsimple');
        if (is_null(self::$request))
            self::$request = new \Typecho\Request();
    }

    public static function initPath($pathInfo='')
    {

        if(empty($pathInfo))
            $pathInfo = self::$request->getPathInfo();
        if (!self::needCache($pathInfo)){
            return false;
        }

        self::$path = $pathInfo;
        return self::initBackend(self::$plugin_config->Cache_choose);
    }

    public static function initBackend($backend){
        if ($backend == '0') return false;
        $options = get_option('bearsimple');
        $class_name = "typecho_".$options['Cache_choose'];
        require_once 'modules/cache_driver/cache.interface.php';
        require_once "modules/cache_driver/$class_name.class.php";
        self::$cache = call_user_func(array($class_name, 'getInstance'), self::$plugin_config);
        if (is_null(self::$cache))
            return false;
        return true;
    }

    public static function needCache($path)
    {
        $pattern = '#^' . __TYPECHO_ADMIN_DIR__ . '#i';
        if (preg_match($pattern, $path)) return false;
        $pattern = '#^/action#i';
        if (preg_match($pattern, $path)) return false;
        $requestUrl = self::$request->getRequestUri();
        $pattern = '/.*?s=.*/i';
        if (preg_match($pattern, $requestUrl)) return false;
        $pattern = '#^/search#i';
        if (preg_match($pattern, $path) and in_array('search', self::$plugin_config->cache_page)) return true;
        $_routable = Helper::options()->routingTable;
        $post_regx = $_routable[0]['post']['regx'];
        if (array_key_exists('TePass', \Typecho\Plugin::export()['activated'])){
        if (preg_match($post_regx,$path,$arr)){
            if ($arr[1] and !empty($arr[1])){
                $db = \Typecho\Db::get();
                try {
		    $database = $db->getConfig($db::READ)['database'];
                    $tepass_exist = $db->fetchRow($db->select()->from('information_schema.TABLES')->where('TABLE_NAME = ?',$db->getPrefix().'tepass_posts')->where('TABLE_SCHEMA = ?',$database));
                    if (isset($tepass_exist) and count($tepass_exist) > 0){
                          $p_id = $db->fetchObject($db->select('id')->from('table.tepass_posts')->where('post_id = ?',$arr[1]))->id;
                          if ($p_id) return false;
                    }

                }catch (Typecho_Db_Query_Exception $e){
                    
                }

            }
        }
}


        foreach ($_routable as $page => $route) {
            if ($route['widget'] != '\Widget\Archive' and $route['widget'] != 'Widget_Archive') continue;
            $regx = Router::get($page);
            if (preg_match($regx['regx'], $path)) {
                $exclude = array('_year', '_month', '_day', '_page');
                $page = str_replace($exclude, '', $page);

                if (in_array($page, get_option('bearsimple')['cache_page']))
                    return true;
            }
        }
        return false;
    }

    public static function post_update($contents, $class)
    {
        if ('publish' != $contents['visibility'] || $contents['created'] > time())
            return;

        self::initEnv();
        if (self::$plugin_config->Cache_choose == '0')
            return;
        self::$passed = true;

        $type = $contents['type'];
        $routeExists = (NULL != \Typecho\Router::get($type));
        if (!$routeExists) {
            self::initPath('#');
            self::delCache(self::$path);
            return;
        }

        $db = \Typecho\Db::get();
        $contents['cid'] = $class->cid;
        $contents['categories'] = $db->fetchAll($db->select()->from('table.metas')
            ->join('table.relationships', 'table.relationships.mid = table.metas.mid')
            ->where('table.relationships.cid = ?', $contents['cid'])
            ->where('table.metas.type = ?', 'category')
            ->order('table.metas.order', \Typecho\Db::SORT_ASC));
        $contents['category'] = urlencode(current(\Typecho\Common::arrayFlatten($contents['categories'], 'slug')));
        $contents['slug'] = urlencode(empty($contents['slug'])?$class->slug:$contents['slug']);
        $contents['date'] = new \Typecho\Date($contents['created']);
        $contents['year'] = $contents['date']->year;
        $contents['month'] = $contents['date']->month;
        $contents['day'] = $contents['date']->day;

        if (!self::initPath(\Typecho\Router::url($type, $contents))){
            return;
        }
        self::delCache(self::$path);
        if ($class->cid)
            self::delCache(self::getPostMarkCacheName($class->cid));
    }

    public static function post_del_update($cid, $obj)
    {
        if (self::$plugin_config->Cache_choose == '0')
            return;
        $db = \Typecho\Db::get();
        $postObject = $db->fetchObject($db->select('cid','slug', 'type')
            ->from('table.contents')->where('cid = ?', $cid));
        if (!$postObject->cid){
            return;
        }
        $value = [];
        $value['cid'] = $cid;
        $value['type'] = $postObject->type;
        $value['slug'] = urlencode($postObject->slug);
        $pathInfo = \Typecho\Router::url($value['type'], $value);

        self::initEnv();

        self::initBackend(self::$plugin_config->Cache_choose);
        self::delCache($pathInfo);
        if ($cid){
            self::delCache(self::getPostMarkCacheName($cid));
        }
    }

    public static function comment_update($comment)
    {
        if (self::$plugin_config->Cache_choose == '0')
            return;
        self::initEnv();
        if (!self::preCheck(false)) return;
        if (!self::initBackend(self::$plugin_config->Cache_choose))
            return;
        $path_info = self::$request->getPathInfo();
        $article_url = preg_replace('/\/comment$/i','',$path_info);

        self::delCache($article_url);
        if ($comment->cid)
            self::delCache(self::getPostMarkCacheName($comment->cid));
    }

    public static function comment_update2($comment, $edit)
    {
        if (self::$plugin_config->Cache_choose == '0')
            return;
        self::initEnv();
        self::preCheck(false);
        self::initBackend(self::$plugin_config->Cache_choose);
        $perm = stripslashes($edit->parentContent['permalink']);
        $perm = preg_replace('/(https?):\/\//', '', $perm);
        $perm = preg_replace('/'.$_SERVER['HTTP_HOST'].'/', '', $perm);
        self::delCache($perm);
        if ($edit->cid)
            self::delCache(self::getPostMarkCacheName($edit->cid));
        if ($comment->cid)
            self::delCache(self::getPostMarkCacheName($comment->cid));
    }
    
    public static function getPostMarkCacheName($cid){
        if (!self::$path)
            self::$path = self::$request->getPathInfo();
        return self::$path.'_'.$cid.'_markdown';
    }

    public static function cache_contentEx($content, $obj, $lastResult){
        if (self::$plugin_config->Cache_choose == '0')
            return $content;
        $content = empty( $lastResult ) ? $content : $lastResult;
        if (self::$plugin_config->enable_markcache == '0'){
            return $content;
        }
        if (substr_count($content,'<!--no-cache-->'))
            return $content;
        self::initEnv();
        self::$path = self::$request->getPathInfo();
        $cacheName = self::getPostMarkCacheName($obj->cid);
        self::initEnv();
        if (!self::preCheck(false)) {
            return $content;
        }
        if (!self::initBackend(self::$plugin_config->Cache_choose)){
            return $content;
        }
        try {
            $data = self::getCache($cacheName);
            if (!empty($data)) {
                if ($data['time'] + self::$plugin_config->expire < time())
                    self::$passed = false;
                return $data['html'];
            }
        } catch (Exception $e) {
            return $content;
        }

        if (is_null(self::$path) || !self::$passed)
            return $content;
        $data = array();
        $data['time'] = time();
        $data['html'] = $content;
        self::setCache($data,$cacheName);
        return $content;
    }

    public static function BsCache_setCache($cacheKey,$val){
        self::initEnv();
        if (!self::preCheck(false)) {
            return false;
        }
        if (!self::initBackend(self::$plugin_config->Cache_choose)){
            return false;
        }
        $data = array();
        $data['time'] = time();
        $data['html'] = $val;
        self::setCache($data,$cacheKey);
        return true;
    }
    
    public static function BsCache_getCache($cacheKey){
        self::initEnv();
        if (!self::preCheck(false)) {
            return false;
        }
        if (!self::initBackend(self::$plugin_config->Cache_choose)){
            return false;
        }
        try{
            $data = self::getCache($cacheKey);
            if (!empty($data)) {
                if ($data['time'] + self::$plugin_config->expire < time())
                    self::$passed = false;
                return $data['html'];
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return false;
    }

public static function btbutton(){
     if(get_option('bearsimple')['Editors'] == '2'){
		if (strpos( $_SERVER['REQUEST_URI'],'write-post.php') !== false)
{
    $url = 'post';
\Typecho\Widget::widget('Widget_Contents_Post_Edit')->to($post);
}
if (strpos( $_SERVER['REQUEST_URI'],'write-page.php') !== false)
{
    $url = 'page';
\Typecho\Widget::widget('Widget_Contents_Page_Edit')->to($page);
}
if (isset($post) || isset($page)) {
    $cid = isset($post) ? $post->cid : $page->cid;
    
    if ($cid) {
        \Typecho\Widget::widget('Widget_Contents_Attachment_Related', 'parentId=' . $cid)->to($attachment);
    } else {
        \Typecho\Widget::widget('Widget_Contents_Attachment_Unattached')->to($attachment);
    }
}
		?><style>.wmd-button-row {
    height: auto;
}
</style>
<link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="//cdn.staticfile.org/limonte-sweetalert2/11.3.10/sweetalert2.min.css" />
<link href="https://jsd.typecho.co.uk/sweetalert2/bootstrap-4.css" rel="stylesheet">
<link rel="stylesheet" href="//cdn.staticfile.org/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css" />
<script src="//cdn.staticfile.org/limonte-sweetalert2/11.3.10/sweetalert2.min.js"></script>
        <script type="text/javascript" src="//cdn.staticfile.org/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js"></script>
        <link href="<?php echo Helper::options()->pluginUrl ?>/BsCore/modules/bs-emoji/bs-emoji.css?v=1" rel="stylesheet" type="text/css">
<script src="<?php echo Helper::options()->pluginUrl ?>/BsCore/modules/bs-emoji/bs-emoji.js?v=1"></script>
<?php if(get_option('bearsimple')['Cache'] == true && (get_option('bearsimple')['Cache_choose'] == 'memcached'||get_option('bearsimple')['Cache_choose'] == 'redis') &&  get_option('bearsimple')['enable_markcache'] == true): ?>
<script>
            $(document).ready(function(){
                $('#wmd-button-row').append('<li class="wmd-button" id="wmd-TePass-button" title="插入不缓存标签"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-times"></i></span></li>');
                if($('#wmd-button-row').length !== 0){
                    $('#wmd-TePass-button').click(function(){
                        var rs = "\r\n<!--no-cache-->\r\n";
                        var myField = $('#text')[0];
                        insertAtCursor(myField,rs);
                    })
                }
                function insertAtCursor(myField, myValue) {
                    if (document.selection) {
                        myField.focus();
                        sel = document.selection.createRange();
                        sel.text = myValue;
                        sel.select();
                    }
                    else if (myField.selectionStart || myField.selectionStart === '0') {
                        var startPos = myField.selectionStart;
                        var endPos = myField.selectionEnd;
                        var restoreTop = myField.scrollTop;
                        myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
                        if (restoreTop > 0) {myField.scrollTop = restoreTop;}
                        myField.selectionStart = startPos + myValue.length;
                        myField.selectionEnd = startPos + myValue.length;
                        myField.focus();
                    } else {
                        myField.value += myValue;
                        myField.focus();
                    }
                }
            });
        </script>
        <?php endif; ?>
        <script> 
         $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-firstline-button" title="首行缩进[ALT+Z]"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-mouse-pointer"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-firstline-button').click(function(){
						var rs = "  ";
						firstline(rs);
					})
				}


				function firstline(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}

				

			});
			$('body').on('keydown',function(a){
                    if( a.altKey && a.keyCode == "90"){
                        $('#wmd-firstline-button').click();
                    }
                });
</script>
<script>
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-loginkj-button" title="登录后可见"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-user-circle"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-loginkj-button').click(function(){
						var rs = "[bslogin]隐藏内容[/bslogin]";
						loginkj(rs);
					})
				}


				function loginkj(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}

				

			});
</script>
		<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-hfkj-button" title="回复或登录后可见"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-commenting"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-hfkj-button').click(function(){
						var rs = "[bshide]隐藏内容[/bshide]";
						hfkj(rs);
					})
				}


				function hfkj(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}

				

			});
</script>

<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-todocheck-button" title="打勾已完成"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-check-square"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-todocheck-button').click(function(){
						var rs = "[todo-t]Todolist已完成的内容[/todo-t]";
						todocheck(rs);
					})
				}


				function todocheck(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-todonotcheck-button" title="打叉未完成"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-square"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-todonotcheck-button').click(function(){
						var rs = "[todo-f]Todolist待完成的内容[/todo-f]";
						todonotcheck(rs);
					})
				}


				function todonotcheck(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-codes-button" title="代码高亮"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><svg t="1632126906909" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2425" width="16" height="16"><path d="M298.900577 778.338974c-7.070023 7.070023-17.974373 7.070023-25.043373 0L20.039405 524.521175c-7.070023-7.070023-7.070023-17.974373 0-25.043373l253.8178-253.8178c7.070023-7.070023 17.974373-7.070023 25.043373 0l27.242458 27.242458c7.070023 7.070023 7.070023 17.974373 0 25.043373L112.089891 512l214.053144 214.053144c7.070023 7.070023 7.070023 17.974373 0 25.043373L298.900577 778.338974zM444.87316 873.098151c-2.726088 9.269108-12.522198 14.702863-21.24486 11.995195l-33.767058-9.269108c-9.250688-2.726088-14.702863-12.522198-11.976776-21.790282l203.148793-703.132108c2.726088-9.269108 12.522198-14.702863 21.24486-11.995195l33.767058 9.269108c9.250688 2.726088 14.702863 12.522198 11.976776 21.790282L444.87316 873.098151zM752.049215 778.338974c-7.070023 7.070023-17.974373 7.070023-25.043373 0l-27.242458-27.242458c-7.070023-7.070023-7.070023-17.974373 0-25.043373l214.053144-214.053144L699.763384 297.946856c-7.070023-7.070023-7.070023-17.974373 0-25.043373l27.242458-27.242458c7.070023-7.070023 17.974373-7.070023 25.043373 0l253.8178 253.8178c7.070023 7.070023 7.070023 17.974373 0 25.043373L752.049215 778.338974z" p-id="2426" fill="#707070"></path></svg></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-codes-button').click(function(){
						var rs = "```编程语言\n这里是内容\n```";
						codes(rs);
					})
				}


				function codes(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-fontcolor-button" title="字体颜色"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-font"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-fontcolor-button').click(function(){
						Swal.fire({
  title: '字体颜色选择器面板',
  html: "<div id=\"color\"></div><br>选择完颜色后点击下面的直接插入按钮进行应用，本功能实现的效果仅在前台文章内页可见。",
  icon: 'info',
showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: "取消", 
  confirmButtonText: '直接插入'
}).then((result) => {
  if (result.isConfirmed) {
  var colorss = document.getElementById("colors").value;
  if(!colorss){
      alert('未选择颜色，不能直接插入!');
  }
  else{
    fontcolor('{bs-font color="'+ colorss + '"}内容{/bs-font}');
  }
  }
})
       $('#color').colorpicker({
        popover: false,
        inline: true,
        container: '#color',
template: '<div class="colorpicker">' +
          '<div class="colorpicker-saturation"><i class="colorpicker-guide"></i></div>' +
          '<div class="colorpicker-hue"><i class="colorpicker-guide"></i></div>' +
          '<div class="colorpicker-alpha">' +
          '   <div class="colorpicker-alpha-color"></div>' +
          '   <i class="colorpicker-guide"></i>' +
          '</div>' +
          '<div class="colorpicker-bar">' +
          '   <div class="input-group">' +
          '       <input id="colors" class="form-control input-block color-io" />' +
          '   </div>' +
          '</div>' +
          '</div>'
        })
        .on('colorpickerCreate', function (e) {
          var io = e.colorpicker.element.find('.color-io');
          io.val(e.color.string());
          io.on('change keyup', function () {
            e.colorpicker.setValue(io.val());
          });
        })
        .on('colorpickerChange', function (e) {
          var io = e.colorpicker.element.find('.color-io');
          if (e.value === io.val() || !e.color || !e.color.isValid()) {
            return;
          }
          io.val(e.color.string());
        });
						
					})
				}


				function fontcolor(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-iframe-button" title="插入iframe"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-window-maximize"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-iframe-button').click(function(){
						var rs = "{bs-iframe}iframe地址{/bs-iframe}";
						iframe(rs);
					})
				}


				function iframe(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-bframe-button" title="插入Bframe"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-external-link-square"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-bframe-button').click(function(){
						var rs = '[bsfra image="占位封面图直链" url="页面地址"]';
						bframe(rs);
					})
				}


				function bframe(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-audio-button" title="插入音频"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-file-audio-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-audio-button').click(function(){
						var rs = "[bsaudio]音频地址[/bsaudio]";
						audio(rs);
					})
				}


				function audio(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-musiclist-button" title="插入音乐歌单"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-music"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-musiclist-button').click(function(){
						var rs = "[bsmusic]网易云音乐歌单ID[/bsmusic]";
						musiclist(rs);
					})
				}


				function musiclist(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-star-button" title="插入评星"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-star-half-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-star-button').click(function(){
						Swal.fire({
  title: '第一步 选择评星样式',
  input: 'select',
  inputOptions: {
      'star': '星星',
      'heart': '红心',
  },
  inputPlaceholder: '选择一款样式',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 输入评星数目',
  input: 'number',
inputLabel: '输入评星数目，最高五颗星',
inputAttributes:{
  min:1,
  max:5,
  
},
  inputPlaceholder: '输入评星数目',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
var text = '[bseva type="'+valueone+'"]'+valuetwo+'[/bseva]';
      star(text);
        
        resolve() 
      } 
      else{
         resolve('您必须输入评星数目~~') 
      }
    })
  }
})

        
    
        resolve() 
      } 
      else{
         resolve('您必须选择一款评星样式~~') 
      }
    })
  }
})
					})
				}


				function star(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-accord1-button" title="插入线性手风琴"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-plus-square"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-accord1-button').click(function(){
						var rs = "{bs-accord style=line title=线性手风琴标题}线性手风琴内容{/bs-accord}";
						accord1(rs);
					})
				}


				function accord1(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-accord2-button" title="插入普通手风琴"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-plus-square-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-accord2-button').click(function(){
						var rs = "{bs-accord style=common title=普通手风琴标题}普通手风琴内容{/bs-accord}";
						accord2(rs);
					})
				}


				function accord2(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-message-button" title="插入提示框"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-sticky-note-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-message-button').click(function(){
						Swal.fire({
  title: '第一步 选择提示框样式',
  input: 'select',
  inputOptions: {
      'common': '普通提示框',
      'basic': '阴影提示框',
      'commonclose': '普通可关闭提示框',
      'basicclose':'阴影可关闭提示框',
  },
  inputPlaceholder: '选择一款提示框',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 选择提示框颜色',
  input: 'select',
  inputOptions: {
      'standard': '淡色',
      'info':'淡青色',
      'primary': '蓝色',
      'secondary': '黑色',
      'red': '红色',
      'orange': '橙色',
      'yellow': '黄色',
      'olive': '淡绿色',
      'green': '深绿色',
      'teal': '青色',
      'violet': '紫罗兰色',
      'purple': '基佬紫色',
      'pink': '粉色',
      'brown': '土黄色',
      'grey': '灰色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
        
        

  Swal.fire({
      title: '第三步 填写提示框标题',
  input: 'text',
  inputLabel: '提示框标题',
  inputPlaceholder: '填写提示框标题',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
        
        
        Swal.fire({
  title: '第四步 填写提示框内容',
  input: 'textarea',
  inputLabel: '提示框内容',
  inputPlaceholder: '请填写提示框内容',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuefour) => {
    if (!valuefour) {
      return '您必须填写提示框内容'
    }
    else{
        
        
        
        Swal.fire({
  title: '第五步 填写提示框图标名',
  input: 'text',
  inputLabel: '提示框图标名(若不需要图标可留空)',
  'html':'<a href="https://bs-icon.typecho.ru/" target="_blank">图标获取请戳这里</a>',
  inputPlaceholder: '请填写提示框图标名',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuefive) => {
      if(!valuefive){
          var icon = '';
      }
      else{
          var icon = ' icon="'+valuefive+'"';
      }
      var text = '[bsmessage type="'+valueone+'" color="'+valuetwo+'" title="'+valuethree+'"'+icon+']'+valuefour+'[/bsmessage]';
      message(text);
    resolve()
  }
})
        
        
        
        resolve()
    }
  }
})
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须填写提示框标题~~') 
      }
    })
  }
})

        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款颜色~~') 
      }
    })
  }
})

        
        
        
        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款提示框~~') 
      }
    })
  }
})
					})
				}


				function message(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-button-button" title="插入按钮"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-circle-o-notch"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-button-button').click(function(){
						Swal.fire({
  title: '第一步 选择按钮样式',
  input: 'select',
  inputOptions: {
      'common': '普通按钮',
      'basic': '光圈按钮',
      'animated': '动画按钮',
  },
  inputPlaceholder: '选择一款按钮',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 选择按钮颜色',
  input: 'select',
  inputOptions: {
      'standard': '淡色',
      'primary': '蓝色',
      'secondary': '黑色',
      'red': '红色',
      'orange': '橙色',
      'yellow': '黄色',
      'olive': '淡绿色',
      'green': '深绿色',
      'teal': '青色',
      'violet': '紫罗兰色',
      'purple': '基佬紫色',
      'pink': '粉色',
      'brown': '土黄色',
      'grey': '灰色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
        
        

  Swal.fire({
      title: '第三步 填写按钮点击链接',
  input: 'url',
  inputLabel: '按钮点击跳转链接',
  inputPlaceholder: '填写按钮点击跳转链接，需带http(s)://',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
        
        
        Swal.fire({
  title: '第四步 填写按钮名称',
  input: 'text',
  inputLabel: '按钮名称(若为动画按钮，两个名称请使用|隔开)',
  inputPlaceholder: '请填写按钮名称',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuefour) => {
    if (!valuefour) {
      return '您必须填写按钮名称'
    }
    else{
        
        
        
        Swal.fire({
  title: '第五步 填写按钮图标名',
  input: 'text',
  inputLabel: '按钮图标名(若不需要图标可留空)',
  'html':'<a href="https://bs-icon.typecho.ru/" target="_blank">图标获取请戳这里</a>',
  inputPlaceholder: '请填写按钮图标名',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuefive) => {
      if(!valuefive){
          var icon = '';
      }
      else{
          var icon = ' icon="'+valuefive+'"';
      }
      var text = '[bsbtn type="'+valueone+'" color="'+valuetwo+'" url="'+valuethree+'"'+icon+']'+valuefour+'[/bsbtn]';
      button(text);
    resolve()
  }
})
        
        
        
        resolve()
    }
  }
})
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须填写跳转链接~~') 
      }
    })
  }
})

        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款颜色~~') 
      }
    })
  }
})

        
        
        
        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款按钮~~') 
      }
    })
  }
})
					})
				}


				function button(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
 <script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-progress-button" title="插入进度条"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-product-hunt"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
				    $('#wmd-progress-button').click(function(){
				    Swal.fire({
  title: '选择进度条颜色',
  input: 'select',
  inputOptions: {
      'normal':'蓝色',
      'secondary': '黑色',
      'default': '灰色',
      'warning': '黄色',
      'success': '绿色',
      'info': '天蓝色',
      'warning': '黄色',
      'danger': '红色'
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {
      
      Swal.fire({
      title: '第二步 填写进度条标题',
  input: 'text',
  inputLabel: '进度条标题[将显示在进度条上方]',
  inputPlaceholder: '填写进度条标题',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
             Swal.fire({
      title: '第三步 填写进度条数值',
  input: 'text',
  inputLabel: '进度条数值[如40%就填写40]',
  inputPlaceholder: '填写进度条数值',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
                var text = '[bsprog color="'+valueone+'" number="'+valuethree+'"]'+valuetwo+'[/bsprog]';
      progress(text);
    resolve()
      }
      else{
       resolve('您必须填写进度条数值~')    
      }
    })
  }
})
    resolve()
      }
      else{
       resolve('您必须填写进度条标题~')    
      }
    })
  }
})
      
      
      
      
      } 
      else{
         resolve('您必须选择一款颜色~') 
      }
    })
  }
})

				})
				}


				function progress(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-fujian-button" title="插入所有附件"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-paperclip"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-fujian-button').click(function(){
                 function getData() {
                    $.ajax({
                        type: "GET",
                        url: "<?php getAttachFile(); ?>",
                        data: {
                            "cid": "<?php echo $cid; ?>",
                             "url": "<?php echo $url; ?>",
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            content(json.list);
                        },
                        complete: function() {
                        },
                        error: function() {
                            alert("数据获取错误");
                        }
                    });
                }
                getData();
                function content(list) {
                    var filename = " ";
                    var fileurl = " ";
                    for(var i in list) {
                        if(list[i]['type'] == 'img'){
                        filename += '![' + list[i]['title'] + '][' + list[i]['cid'] + ']\n'
fileurl += '\n  [' + list[i]['cid'] + ']:' + list[i]['url']
}
                        if(list[i]['type'] == 'other'){
                        filename += '[' + list[i]['title'] + '][' + list[i]['cid'] + ']\n'
fileurl += '\n  [' + list[i]['cid'] + ']:' + list[i]['url']
}
}
fujian(filename + fileurl);
}
					})
				}


				function fujian(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>

<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-bscardgithub-button" title="Github仓库"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-github"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-bscardgithub-button').click(function(){
						var rs = '[bsgit user="Github仓库拥有者，如whitebearcode"]Github项目名，如typecho-bearsimple[/bsgit]';
						githubcard(rs);
					})
				}


				function githubcard(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-gallery-button" title="相册"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-file-image-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-gallery-button').click(function(){
						var rs = '[bsgallery title="相册名"]\n[bsimg title="图片标题1"]图片地址1[/bsimg]\n[bsimg title="图片标题2"]图片地址2[/bsimg]\n[bsimg title="图片标题3"]图片地址3[/bsimg]\n[/bsgallery]';
						gallery(rs);
					})
				}


				function gallery(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-time-button" title="时间计划"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-microchip"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-time-button').click(function(){
						var rs = '[bstimes title="时间计划名，必填!"]\n[bstime time="时间"]计划内容[/bstime]\n[bstime time="时间2"]计划内容2[/bstime]\n[bstime time="时间3"]计划内容3[/bstime]\n[/bstimes]';
						time(rs);
					})
				}


				function time(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-quotepost-button" title="引用文章"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-newspaper-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-quotepost-button').click(function(){
						var rs = '[bspost cid="文章CID"]';
						quotepost(rs);
					})
				}


				function quotepost(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-postmark-button" title="标注文字"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-bookmark-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-postmark-button').click(function(){
						var rs = '[bsmark]要标注的内容[/bsmark]';
						postmark(rs);
					})
				}


				function postmark(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-postruby-button" title="文字带拼音"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-file-word-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-postruby-button').click(function(){
						var rs = '[bsruby]要带拼音的汉字[/bsruby]';
						postruby(rs);
					})
				}


				function postruby(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-everydaypaper-button" title="每日60s早报"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-calendar-o"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-everydaypaper-button').click(function(){
						var rs = '[bspaper image="true"]';
						everydaypaper(rs);
					})
				}


				function everydaypaper(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-emoji-button" title="表情"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-paw"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-emoji-button').click(function(){
					    Swal.fire({
  title: '表情面板',
  html: '<button id=\"emoji\" class="swal2-confirm swal2-styled">点击显示表情面板</button><br><div id="emoemo"></div><br>Tips:点击表情后将直接插入到文章中',
  icon: 'info',
showCancelButton: false,
showConfirmButton: false,

});
		$('#emoji').BearsimpleEmoji($('#text'));
		$.fn.insertText = function(text){
		    Swal.close();
			var rs = text+' ';
						emoji(rs);     
			return this;
		}
		
						
					})
				}


				function emoji(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-mermaid-button" title="流程图"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-random"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-mermaid-button').click(function(){
						var rs = '```mermaid\nMermaid内容\n```';
						mermaid(rs);
					})
				}


				function mermaid(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-mindmap-button" title="思维导图"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-map-signs"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-mindmap-button').click(function(){
						var rs = '```mermaid\nmindmap\n思维导图内容\n```';
						mindmap(rs);
					})
				}


				function mindmap(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-dateprogress-button" title="插入倒计时进度条"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-calendar"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
				    $('#wmd-dateprogress-button').click(function(){
				    Swal.fire({
  title: '选择倒计时进度条颜色',
  input: 'select',
  inputOptions: {
      'blue':'蓝色',
      'green': '绿色',
      'cyan': '青色',
      'yellow': '黄色',
      'red': '红色',
      'orange': '橙色',
      'black': '黑色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {
      
      Swal.fire({
      title: '第二步 填写倒计时进度条标题',
  input: 'text',
  inputLabel: '倒计时进度条标题[将显示在倒计时进度条上方]',
  inputPlaceholder: '填写倒计时进度条标题',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
             Swal.fire({
      title: '第三步 填写倒计时结束日期',
  input: 'text',
  inputLabel: '按照年-月-日 时:分:秒来填写，如2022-12-12 22:12:12',
  inputPlaceholder: '填写倒计时结束日期',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {

                var text = '[bsdate color="'+valueone+'" end="'+valuethree+'"]'+valuetwo+'[/bsdate]';
      dateprogress(text);
    resolve()
     
      }
      else{
       resolve('您必须填写结束日期~')    
      }
    })
  }
})
    resolve()
      }
      else{
       resolve('您必须填写倒计时进度条标题~')    
      }
    })
  }
})
      
      
      
      
      } 
      else{
         resolve('您必须选择一款颜色~') 
      }
    })
  }
})

				})
				}


				function dateprogress(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-copytext-button" title="点击复制内容"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-copy"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-copytext-button').click(function(){
						var rs = '[bscopy text="点击所复制的内容文字"]显示的内容文字[/bscopy]';
						copytext(rs);
					})
				}


				function copytext(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<script> 
          $(document).ready(function(){
          	$('#wmd-button-row').append('<li class="wmd-button" id="wmd-tag-button" title="文章标签"><span style="background: none;margin-top:5px;font-size: large;text-align: center;color: #999999;font-family: serif;"><i class="fa fa-tag"></i></span></li>');
				if($('#wmd-button-row').length !== 0){
					$('#wmd-tag-button').click(function(){
						var rs = '[tag]要调用的标签名[/tag]';
						tag(rs);
					})
				}


				function tag(tag) {
					var myField;
					if (document.getElementById('text') && document.getElementById('text').type == 'textarea') {
						myField = document.getElementById('text');
					} else {
						return false;
					}
					if (document.selection) {
						myField.focus();
						sel = document.selection.createRange();
						sel.text = tag;
						myField.focus();
					}
					else if (myField.selectionStart || myField.selectionStart == '0') {
						var startPos = myField.selectionStart;
						var endPos = myField.selectionEnd;
						var cursorPos = startPos;
						myField.value = myField.value.substring(0, startPos)
						+ tag
						+ myField.value.substring(endPos, myField.value.length);
						cursorPos += tag.length;
						myField.focus();
						myField.selectionStart = cursorPos;
						myField.selectionEnd = cursorPos;
					} else {
						myField.value += tag;
						myField.focus();
					}
				}
			});
</script>
<?php
}
}

/**
     * 插入编辑器
     */
     public static function Editor()
    {
        $cssUrl = 'https://jsd.typecho.co.uk/easymde/easymde.min.css';
        $jsUrl = 'https://jsd.typecho.co.uk/easymde/easymde.min.js';
        
        
	if (strpos( $_SERVER['REQUEST_URI'],'write-post.php') !== false)
{
    $url = 'post';
\Typecho\Widget::widget('Widget_Contents_Post_Edit')->to($post);
}
if (strpos( $_SERVER['REQUEST_URI'],'write-page.php') !== false)
{
    $url = 'page';
\Typecho\Widget::widget('Widget_Contents_Page_Edit')->to($page);
}

if (isset($post) || isset($page)) {
    $cid = isset($post) ? $post->cid : $page->cid;
    
    if ($cid) {
        \Typecho\Widget::widget('Widget_Contents_Attachment_Related', 'parentId=' . $cid)->to($attachment);
    } else {
        \Typecho\Widget::widget('Widget_Contents_Attachment_Unattached')->to($attachment);
    }
}

        ?>
<link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo $cssUrl; ?>" />
<link rel="stylesheet" href="//cdn.staticfile.org/limonte-sweetalert2/11.3.10/sweetalert2.min.css" />
        <script type="text/javascript" src="<?php echo $jsUrl; ?>"></script>
<link href="https://jsd.typecho.co.uk/sweetalert2/bootstrap-4.css" rel="stylesheet">

        <script src="//cdn.staticfile.org/limonte-sweetalert2/11.3.10/sweetalert2.min.js"></script>
<link rel="stylesheet" href="//cdn.staticfile.org/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css" />
<script type="text/javascript" src="//cdn.staticfile.org/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js"></script>
	<link href="//cdn.staticfile.org/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">
	<script src="//cdn.staticfile.org/toastr.js/2.1.4/toastr.min.js"></script>


<style>
    .editor-statusbar .lines:before{content:'行数: '}
    .editor-statusbar .words:before{content:'字数: '}
    .editor-statusbar .lines:after{content:' 行'}
    .editor-statusbar .words:after{content:' 个字'}
</style>


<link href="<?php echo Helper::options()->pluginUrl ?>/BsCore/modules/bs-emoji/bs-emoji.css?v=1" rel="stylesheet" type="text/css">
<script src="<?php echo Helper::options()->pluginUrl ?>/BsCore/modules/bs-emoji/bs-emoji.js?v=1"></script>
        <script>
        

            $(document).ready(function() {
                     
                $.fn.autoHeight = function () {
        function autoHeight(elem) {
            elem.style.height = 'auto';
            elem.scrollTop = 0;
            elem.style.height = elem.scrollHeight + 'px';
        }

        this.each(function () {
            autoHeight(this);
            $(this).on('keyup', function () {
                autoHeight(this);
            });
        });
    }

  $("#excerpt-0-18").autoHeight();
                $('#excerpt-0-18').css({'width':'100%'});
                new EasyMDE({
        autoDownloadFontAwesome: false,
        spellChecker:false,
        nativeSpellcheck:false,
        maxHeight:"400px",
        showIcons: ['strikethrough', 'code', 'table', 'redo', 'heading', 'undo', 'heading-bigger', 'heading-smaller', 'heading-1', 'heading-2', 'heading-3', 'clean-block', 'horizontal-rule','side-by-side'],
        <?php if(bsOptions::getInstance()::get_option( 'bearsimple' )->EditorsAutosave[0] == '1'):?>
        autosave: {
            enabled: true,
            delay: 1000,
            uniqueId: 'text',
            timeFormat:{locale:'zh-CN'},
            text:'自动保存时间：'
        },
        <?php endif; ?>
        toolbar: [ <?php if(get_option('bearsimple')['Cache'] == true && (get_option('bearsimple')['Cache_choose'] == 'memcached'||get_option('bearsimple')['Cache_choose'] == 'redis') &&  get_option('bearsimple')['enable_markcache'] == true): ?>{ name: "nocache", className: "fa fa-times", action:nocache,title: "插入不缓存标签"},<?php endif; ?>{ name: "firstline", className: "fa fa-mouse-pointer", action:firstline,title: "首行缩进[ALT+Q]"},{ name: "bold", action:EasyMDE.toggleBold, className: "fa fa-bold",title: "加粗"}, { name: "italic", action:EasyMDE.toggleItalic, className: "fa fa-italic",title: "字体倾斜"}, { name: "strikethrough", action:EasyMDE.toggleStrikethrough, className: "fa fa-strikethrough",title: "删除线"},{ name: "heading-smaller", action:EasyMDE.toggleHeadingSmaller, className: "fa fa-header",title: "字体缩小"}, { name: "heading-bigger", action:EasyMDE.toggleHeadingBigger, className: "fa fa-header",title: "字体放大"},{ name: "heading-1", action:EasyMDE.toggleHeading1, className: "fa fa-header header-1",title: "H1字号"},{ name: "heading-2", action:EasyMDE.toggleHeading2, className: "fa fa-header header-2",title: "H2字号"},{ name: "heading-3", action:EasyMDE.toggleHeading3, className: "fa fa-header header-3",title: "H3字号"}, { name: "code", action:EasyMDE.toggleCodeBlock, className: "fa fa-code",title: "代码"}, { name: "quote", action:EasyMDE.toggleBlockquote, className: "fa fa-quote-left",title: "引用"}, { name: "unordered-list", action:EasyMDE.toggleUnorderedList, className: "fa fa-list-ul",title: "无序列表"}, { name: "ordered-list", action:EasyMDE.toggleOrderedList, className: "fa fa-list-ol",title: "有序列表"}, { name: "clean-block", action:EasyMDE.cleanBlock, className: "fa fa-eraser",title: "擦除代码块"}, { name: "link", action:EasyMDE.drawLink, className: "fa fa-link",title: "插入链接"}, { name: "image", action:EasyMDE.drawImage, className: "fa fa-picture-o",title: "插入图片"}, '|', { name: "table", action:EasyMDE.drawTable, className: "fa fa-table",title: "插入表格"}, { name: "color", className: "fa fa-font", action:colorpc,title: "字体颜色选择器"},{ name: "button", className: "fa fa-circle-o-notch", action:button,title: "按钮"},{ name: "message", className: "fa fa-sticky-note-o", action:message,title: "提示框"},{ name: "iframe", className: "fa fa-window-maximize", action:iframe,title: "插入iframe"},{ name: "bframe", className: "fa fa-external-link-square", action:bframe,title: "插入bframe"},{ name: "audio", className: "fa fa-file-audio-o", action:audio,title: "插入音频"},{ name: "musiclist", className: "fa fa-music", action:musiclist,title: "插入音乐歌单"},{ name: "hide", className: "fa fa-commenting", action:hide,title: "回复或登录后可见"},{ name: "login", className: "fa fa-user-circle", action:login,title: "登录后可见"},{ name: "inserts", className: "fa fa-paperclip", action:attachInsertEvent,title: "插入所有附件"},{ name: "insertper", className: "fa fa-paperclip", action:insertper,title: "插入单个附件"},{ name: "copyupload", className: "fa fa-paperclip", action:copyupload,title: "复制粘贴上传"},{ name: "todolist1", className: "fa fa-check-square", action:todolist1,title: "已完成列表"},{ name: "todolist2", className: "fa fa-square", action:todolist2,title: "未完成列表"},{ name: "star", className: "fa fa-star-half-o", action:star,title: "评星"},{ name: "accord1", className: "fa fa-plus-square", action:accord1,title: "线性手风琴"},{ name: "accord2", className: "fa fa-plus-square-o", action:accord2,title: "普通手风琴"},{ name: "quotepost", className: "fa fa-newspaper-o", action:quotepost,title: "引用文章"},{ name: "postmark", className: "fa fa-bookmark-o", action:postmark,title: "标注文字"},{ name: "postruby", className: "fa fa-file-word-o", action:postruby,title: "文字带拼音"},{ name: "everydaypaper", className: "fa fa-calendar-o", action:everydaypaper,title: "每日60s早报"},{ name: "emoji", className: "fa fa-paw", action:emoji,title: "表情"},{ name: "hr", className: "fa fa-minus", action:hr,title: "分割线"},{ name: "mermaid", className: "fa fa-compass", action:mermaid,title: "流程图"},{ name: "mindmap", className: "fa fa-map-signs", action:mindmap,title: "思维导图"},{ name: "gallery", className: "fa fa-file-image-o", action:gallery,title: "相册"},{ name: "time", className: "fa fa-microchip", action:time,title: "时间计划"},{ name: "githubcard", className: "fa fa-github", action:githubcard,title: "Github仓库"},{ name: "autosaves", className: "fa fa-grav", action:autosave,title: "自动保存"},{ name: "progress", className: "fa fa-product-hunt", action:progress,title: "进度条"},{ name: "dateprogress", className: "fa fa-calendar", action:dateprogress,title: "倒计时进度条"},{ name: "copytext", className: "fa fa-copy", action:copytext,title: "点击复制内容"},{ name: "tag", className: "fa fa-tag", action:tag,title: "文章标签"},{ name: "preview", action:EasyMDE.togglePreview, className: "fa fa-eye no-disable",title: "预览"}, { name: "side-by-side", action:EasyMDE.toggleSideBySide, className: "fa fa-columns no-disable no-mobile",title: "所见即所得"}, { name: "fullscreen", action:EasyMDE.toggleFullScreen, className: "fa fa-arrows-alt no-disable no-mobile",title: "全屏"}, '|', ],
        promptURLs:true,
        promptTexts:{
            image:"请填写图片直链",
            link:"请填写网址链接",
        },
        element: document.getElementById('text'),
    });
            });
       function dateprogress(editor){
           Swal.fire({
  title: '选择倒计时进度条颜色',
  input: 'select',
  inputOptions: {
      'blue':'蓝色',
      'green': '绿色',
      'cyan': '青色',
      'yellow': '黄色',
      'red': '红色',
      'orange': '橙色',
      'black': '黑色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {
      
      Swal.fire({
      title: '第二步 填写倒计时进度条标题',
  input: 'text',
  inputLabel: '倒计时进度条标题[将显示在倒计时进度条上方]',
  inputPlaceholder: '填写倒计时进度条标题',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
             Swal.fire({
      title: '第三步 填写倒计时结束日期',
  input: 'text',
  inputLabel: '按照年-月-日 时:分:秒来填写，如2022-12-12 22:12:12',
  inputPlaceholder: '填写倒计时结束日期',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {

                var text = '[bsdate color="'+valueone+'" end="'+valuethree+'"]'+valuetwo+'[/bsdate]';
   editor.codemirror.doc.replaceSelection(text); 
    resolve()
     
      }
      else{
       resolve('您必须填写结束日期~')    
      }
    })
  }
})
    resolve()
      }
      else{
       resolve('您必须填写倒计时进度条标题~')    
      }
    })
  }
})
      
      
      
      
      } 
      else{
         resolve('您必须选择一款颜色~') 
      }
    })
  }
})



    
       }
       function copyupload(editor){
                    $(document).on('paste', function(event) {
                        event = event.originalEvent;
                        var cbd = event.clipboardData;
                        var ua = window.navigator.userAgent;
                        var uploadURL = '<?php Helper::security()->index('/action/upload?cid=CID'); ?>';
                        if (!(event.clipboardData && event.clipboardData.items)) {
                            return;
                        }

                        if (cbd.items && cbd.items.length === 2 && cbd.items[0].kind === "string" && cbd.items[1].kind === "file" &&
                            cbd.types && cbd.types.length === 2 && cbd.types[0] === "text/plain" && cbd.types[1] === "Files" &&
                            ua.match(/Macintosh/i) && Number(ua.match(/Chrome\/(\d{2})/i)[1]) < 49){
                            return;
                        }

                        var itemLength = cbd.items.length;

                        if (itemLength == 0) {
                            return;
                        }

                        if (itemLength == 1 && cbd.items[0].kind == 'string') {
                            return;
                        }

                        if ((itemLength == 1 && cbd.items[0].kind == 'file')
                                || itemLength > 1
                            ) {
                            for (var i = 0; i < cbd.items.length; i++) {
                                var item = cbd.items[i];

                                if(item.kind == "file") {
                                    var blob = item.getAsFile();
                                    if (blob.size === 0) {
                                        return;
                                    }
                                    var ext = blob.name.substring(blob.name.lastIndexOf(".")+1);
                                    var formData = new FormData();
                                    formData.append('blob', blob, Math.floor(new Date().getTime() / 1000) + '.' + ext);
                                    var uploadingText = '![文件上传中(' + i + ')...]';
                                    var uploadFailText = '![文件上传失败(' + i + ')]'
                                    $.ajax({
                                        method: 'post',
                                        url: uploadURL.replace('CID', $('input[name="cid"]').val()),
                                        data: formData,
                                        contentType: false,
                                        processData: false,
                                        success: function(data) {
                                            if (data[0]) {
                                                var filehz = data[0].substring(data[0].lastIndexOf(".")+1);
                                                switch(filehz){
                                                 case 'gif':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'jpg':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'jpeg':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'gif':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'png':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'tiff':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'bmp':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'svg':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 case 'ico':
                                                 editor.codemirror.doc.replaceSelection('![](' + data[0] + ')\n');
                                                 break;
                                                 default:
                                                 editor.codemirror.doc.replaceSelection('['+data[1]['cid']+']['+data[1]['cid']+']\n['+data[1]['cid']+']: ' + data[0]+'\n');
                                                }
                                                
                                            } else {
                                               editor.codemirror.doc.replaceSelection(uploadFailText);
                                            }
                                        },
                                        error: function() {
                                            editor.codemirror.doc.replaceSelection(uploadFailText);
                                        }
                                    });
                                }
                            }

                        }

			});
       }
       
              setTimeout(function() {
                var button = $(".copyupload");
                button.click();
            }, 2000);
       
       
       
            
            function star(editor){
               Swal.fire({
  title: '第一步 选择评星样式',
  input: 'select',
  inputOptions: {
      'star': '星星',
      'heart': '红心',
  },
  inputPlaceholder: '选择一款样式',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 输入评星数目',
  input: 'number',
inputLabel: '输入评星数目，最高五颗星',
inputAttributes:{
  min:1,
  max:5,
  
},
  inputPlaceholder: '输入评星数目',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
var text = '[bseva type="'+valueone+'"]'+valuetwo+'[/bseva]';
      editor.codemirror.doc.replaceSelection(text);
        
        resolve() 
      } 
      else{
         resolve('您必须输入评星数目~~') 
      }
    })
  }
})

        
    
        resolve() 
      } 
      else{
         resolve('您必须选择一款评星样式~~') 
      }
    })
  }
}) 
            }
            function autosave(editor){
          <?php if(bsOptions::getInstance()::get_option( 'bearsimple' )->EditorsAutosave[0] == '11'||bsOptions::getInstance()::get_option( 'bearsimple' )->EditorsAutosave[1] == '11'):?>
            //$("textarea:eq(1)").bind("input propertychange", autosaves); //废弃方法
        setInterval(function(){
         var submitted = false, form = $('form[name=write_post],form[name=write_page]').submit(function () {
        submitted = true;
    }), formAction = form.attr('action'),
        idInput = $('input[name=cid]'),
        cid = idInput.val(),
        draft = $('input[name=draft]'),
        draftId = draft.length > 0 ? draft.val() : 0,
        btnSave = $('#btn-save').removeAttr('name').removeAttr('value'),
        btnSubmit = $('#btn-submit').removeAttr('name').removeAttr('value'),
        btnPreview = $('#btn-preview'),
        doAction = $('<input type="hidden" name="do" value="publish" />').appendTo(form),
        locked = false,
        changed = false,
        autoSave = $('<span id="auto-save-message" class="left"></span>').prependTo('.submit'),
        lastSaveTime = null;
        var data = new FormData(form.get(0));
        data.set("text",editor.value());
        var localcid = "<?php echo $cid;?>";
if(localcid == '' && localStorage.getItem('autosavecid') && localStorage.getItem('autosavecid') !== ''){
data.set("cid",localStorage.getItem('autosavecid'));
}
else{
    data.set("cid",localcid);
}
     
        function callback(o) {
toastr.success('已自动保存<br>保存时间:'+o.time);   
localStorage.setItem('autosavecid',o.cid);

        }
                
            data.append('do', 'save');
            
  $.ajax({
                url: formAction,
                processData: false,
                contentType: false,
                type: 'POST',
                data: data,
                success: callback
            });    
   },15000); 
   <?php endif; ?>
}
            
                setTimeout(function() {
                var buttons = $(".autosaves");
                buttons.click();
            }, 2000);
            
           function confirmEnding(str, target) {
  var start = str.length-target.length;
  var arr = str.substr(start,target.length);
  if(arr == ".jpg" || arr == ".jpeg" || arr == ".png" || arr == ".gif"){
    return '1';
  }
 return '2';
}

            setTimeout(function() {
                var button = $(".insertper");
                button.click();
            }, 2000);
        function insertper (editor) {
  $('#file-list').on('mousedown', '.insert', function(){
      var s=$(this).parents("li").data('url');
var name = '.'+ s.substring(s.lastIndexOf(".")+1);
   var end = confirmEnding(s, name);
   if(end == '1'){
        var filenames="!["+$(this).parents("li").data('cid')+"]["+$(this).parents("li").data('cid')+"]";
   }
   else{
       var filenames="["+$(this).parents("li").data('cid')+"]["+$(this).parents("li").data('cid')+"]\n";
   }
	    var fileurls="\n  ["+$(this).parents("li").data('cid')+"]: "+$(this).parents("li").data('url');
                 editor.codemirror.doc.replaceSelection(filenames + fileurls+'\n'); 
});
    }

             function attachInsertEvent (editor) {
                 function getData() {
                    $.ajax({
                        type: "GET",
                        url: "<?php getAttachFile(); ?>",
                        data: {
                            "cid": "<?php echo $cid; ?>",
                             "url": "<?php echo $url; ?>",
                        },
                        dateType: "json",
                        success: function(json) {
                            json = JSON.parse(json);
                            content(json.list);
                        },
                        complete: function() {
                        },
                        error: function() {
                            alert("数据获取错误");
                        }
                    });
                }
                getData();
                function content(list) {
                    var filename = " ";
                    var fileurl = " ";
                    for(var i in list) {
                        if(list[i]['type'] == 'img'){
                        filename += '![' + list[i]['title'] + '][' + list[i]['cid'] + ']'
fileurl += '\n  [' + list[i]['cid'] + ']:' + list[i]['url']
}
                        if(list[i]['type'] == 'other'){
                        filename += '[' + list[i]['title'] + '][' + list[i]['cid'] + ']'
fileurl += '\n  [' + list[i]['cid'] + ']:' + list[i]['url']
}
}
editor.codemirror.doc.replaceSelection(filename + fileurl+'\n');
}
    }
    function iframe(editor){
    editor.codemirror.doc.replaceSelection('{bs-iframe}iframe地址，可为video等{/bs-iframe}'); 
            }
            function tag(editor){
    editor.codemirror.doc.replaceSelection('[tag]要调用的标签名[/tag]'); 
            }
            function everydaypaper(editor){
    editor.codemirror.doc.replaceSelection('[bspaper image="true"]'); 
            }
            function mermaid(editor){
    editor.codemirror.doc.replaceSelection('```mermaid\nMermaid内容\n```'); 
            }
            function mindmap(editor){
    editor.codemirror.doc.replaceSelection('```mermaid\nmindmap\n思维导图内容\n```'); 
            }
            function githubcard(editor){
    editor.codemirror.doc.replaceSelection('[bsgit user="Github仓库拥有者，如whitebearcode"]Github项目名，如typecho-bearsimple[/bsgit]'); 
            }
            $('body').on('keydown',function(a){
                    if( a.altKey && a.keyCode == "90"){
                        $('.firstline').click();
                    }
                });
                function hr(editor){
    editor.codemirror.doc.replaceSelection('----------'); 
            }
            function copytext(editor){
    editor.codemirror.doc.replaceSelection('[bscopy text="点击所复制的内容文字"]显示的内容文字[/bscopy]'); 
            }
            function musiclist(editor){
    editor.codemirror.doc.replaceSelection('[bsmusic]网易云音乐歌单ID[/bsmusic]'); 
            }
            function firstline(editor){
    editor.codemirror.doc.replaceSelection('  '); 
            }
            function hide(editor){
    editor.codemirror.doc.replaceSelection('[bshide]隐藏内容[/bshide]'); 
            }
            function gallery(editor){
    editor.codemirror.doc.replaceSelection('[bsgallery title="相册名"]\n[bsimg title="图片标题1"]图片地址1[/bsimg]\n[bsimg title="图片标题2"]图片地址2[/bsimg]\n[bsimg title="图片标题3"]图片地址3[/bsimg]\n[/bsgallery]'); 
            }
            function time(editor){
    editor.codemirror.doc.replaceSelection('[bstimes title="时间计划名，必填!"]\n[bstime time="时间"]计划内容[/bstime]\n[bstime time="时间2"]计划内容2[/bstime]\n[bstime time="时间3"]计划内容3[/bstime]\n[/bstimes]'); 
            }
            function login(editor){
    editor.codemirror.doc.replaceSelection('[bslogin]隐藏内容[/bslogin]'); 
            }
            function nocache(editor){
    editor.codemirror.doc.replaceSelection("\r\n<!--no-cache-->\r\n"); 
            }
            function audio(editor){
    editor.codemirror.doc.replaceSelection('[bsaudio]音频地址[/bsaudio]'); 
            }
            function accord1(editor){
    editor.codemirror.doc.replaceSelection('{bs-accord style=line title=线性手风琴标题}线性手风琴内容{/bs-accord}'); 
            }
            function accord2(editor){
    editor.codemirror.doc.replaceSelection('{bs-accord style=common title=普通手风琴标题}普通手风琴内容{/bs-accord}'); 
            }
            function quotepost(editor){
    editor.codemirror.doc.replaceSelection('[bspost cid="文章CID"]'); 
            }
            function postmark(editor){
    editor.codemirror.doc.replaceSelection('[bsmark]要标注的内容[/bsmark]'); 
            }
            function postruby(editor){
    editor.codemirror.doc.replaceSelection('[bsruby]要带拼音的汉字[/bsruby]'); 
            }
             function todolist1(editor){
    editor.codemirror.doc.replaceSelection('[todo-t]Todolist已完成的内容[/todo-t]'); 
            }
             function todolist2(editor){
    editor.codemirror.doc.replaceSelection('[todo-f]Todolist待完成的内容[/todo-f]'); 
            }
             function bframe(editor){
    editor.codemirror.doc.replaceSelection('[bsfra image="占位封面图直链" url="页面地址"]'); 
            }


function button(editor){
         Swal.fire({
  title: '第一步 选择按钮样式',
  input: 'select',
  inputOptions: {
      'common': '普通按钮',
      'basic': '光圈按钮',
      'animated': '动画按钮',
  },
  inputPlaceholder: '选择一款按钮',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 选择按钮颜色',
  input: 'select',
  inputOptions: {
      'standard': '淡色',
      'primary': '蓝色',
      'secondary': '黑色',
      'red': '红色',
      'orange': '橙色',
      'yellow': '黄色',
      'olive': '淡绿色',
      'green': '深绿色',
      'teal': '青色',
      'violet': '紫罗兰色',
      'purple': '基佬紫色',
      'pink': '粉色',
      'brown': '土黄色',
      'grey': '灰色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
        
        

  Swal.fire({
      title: '第三步 填写按钮点击链接',
  input: 'url',
  inputLabel: '按钮点击跳转链接',
  inputPlaceholder: '填写按钮点击跳转链接，需带http(s)://',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
        
        
        Swal.fire({
  title: '第四步 填写按钮名称',
  input: 'text',
  inputLabel: '按钮名称(若为动画按钮，两个名称请使用|隔开)',
  inputPlaceholder: '请填写按钮名称',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuefour) => {
    if (!valuefour) {
      return '您必须填写按钮名称'
    }
    else{
        
        
        
        Swal.fire({
  title: '第五步 填写按钮图标名',
  input: 'text',
  inputLabel: '按钮图标名(若不需要图标可留空)',
  'html':'<a href="https://bs-icon.typecho.ru/" target="_blank">图标获取请戳这里</a>',
  inputPlaceholder: '请填写按钮图标名',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuefive) => {
      if(!valuefive){
          var icon = '';
      }
      else{
          var icon = ' icon="'+valuefive+'"';
      }
      var text = '[bsbtn type="'+valueone+'" color="'+valuetwo+'" url="'+valuethree+'"'+icon+']'+valuefour+'[/bsbtn]';
      editor.codemirror.doc.replaceSelection(text);
    resolve()
  }
})
        
        
        
        resolve()
    }
  }
})
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须填写跳转链接~~') 
      }
    })
  }
})

        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款颜色~~') 
      }
    })
  }
})

        
        
        
        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款按钮~~') 
      }
    })
  }
})

      }
      
      function progress(editor){
         Swal.fire({
  title: '选择进度条颜色',
  input: 'select',
  inputOptions: {
       'normal':'蓝色',
      'secondary': '黑色',
      'default': '灰色',
      'warning': '黄色',
      'success': '绿色',
      'info': '天蓝色',
      'warning': '黄色',
      'danger': '红色'
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {
      
      Swal.fire({
      title: '第二步 填写进度条标题',
  input: 'text',
  inputLabel: '进度条标题[将显示在进度条上方]',
  inputPlaceholder: '填写进度条标题',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
             Swal.fire({
      title: '第三步 填写进度条数值',
  input: 'text',
  inputLabel: '进度条数值[如40%就填写40]',
  inputPlaceholder: '填写进度条数值',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
                var text = '[bsprog color="'+valueone+'" number="'+valuethree+'"]'+valuetwo+'[/bsprog]';
      editor.codemirror.doc.replaceSelection(text);
    resolve()
      }
      else{
       resolve('您必须填写进度条数值~')    
      }
    })
  }
})
    resolve()
      }
      else{
       resolve('您必须填写进度条标题~')    
      }
    })
  }
})
      
      
      
      
      } 
      else{
         resolve('您必须选择一款颜色~') 
      }
    })
  }
})

      }
      
      function message(editor){
         Swal.fire({
  title: '第一步 选择提示框样式',
  input: 'select',
  inputOptions: {
      'common': '普通提示框',
      'basic': '阴影提示框',
      'commonclose': '普通可关闭提示框',
      'basicclose':'阴影可关闭提示框',
  },
  inputPlaceholder: '选择一款提示框',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valueone) => {
    return new Promise((resolve) => {
      if (valueone !== '') {

                Swal.fire({
  title: '第二步 选择提示框颜色',
  input: 'select',
  inputOptions: {
      'standard': '淡色',
      'info':'淡青色',
      'primary': '蓝色',
      'secondary': '黑色',
      'red': '红色',
      'orange': '橙色',
      'yellow': '黄色',
      'olive': '淡绿色',
      'green': '深绿色',
      'teal': '青色',
      'violet': '紫罗兰色',
      'purple': '基佬紫色',
      'pink': '粉色',
      'brown': '土黄色',
      'grey': '灰色',
  },
  inputPlaceholder: '选择一款颜色',
  showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuetwo) => {
    return new Promise((resolve) => {
      if (valuetwo !== '') {
        
        

  Swal.fire({
      title: '第三步 填写提示框标题',
  input: 'text',
  inputLabel: '提示框标题',
  inputPlaceholder: '填写提示框标题',
    showCancelButton: true,
cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuethree) => {
    return new Promise((resolve) => {
      if (valuethree !== '') {
        
        
        Swal.fire({
  title: '第四步 填写提示框内容',
  input: 'textarea',
  inputLabel: '提示框内容',
  inputPlaceholder: '请填写提示框内容',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '下一步',
  inputValidator: (valuefour) => {
    if (!valuefour) {
      return '您必须填写提示框内容'
    }
    else{
        
        
        
        Swal.fire({
  title: '第五步 填写提示框图标名',
  input: 'text',
  inputLabel: '提示框图标名(若不需要图标可留空)',
  'html':'<a href="https://bs-icon.typecho.ru/" target="_blank">图标获取请戳这里</a>',
  inputPlaceholder: '请填写提示框图标名',
  showCancelButton: true,
  cancelButtonText: "取消", 
  confirmButtonText: '插入',
  inputValidator: (valuefive) => {
      if(!valuefive){
          var icon = '';
      }
      else{
          var icon = ' icon="'+valuefive+'"';
      }
      var text = '[bsmessage type="'+valueone+'" color="'+valuetwo+'" title="'+valuethree+'"'+icon+']'+valuefour+'[/bsmessage]';
      editor.codemirror.doc.replaceSelection(text);
    resolve()
  }
})
        
        
        
        resolve()
    }
  }
})
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须填写提示框标题~~') 
      }
    })
  }
})

        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款颜色~~') 
      }
    })
  }
})

        
        
        
        
        
        
        
        
        resolve() 
      } 
      else{
         resolve('您必须选择一款提示框~~') 
      }
    })
  }
})

      }
      function emoji(editor){
       Swal.fire({
  title: '表情面板',
  html: '<button id=\"emoji\" class="swal2-confirm swal2-styled">点击显示表情面板</button><br><div id="emoemo"></div><br>Tips:点击表情后将直接插入到文章中',
  icon: 'info',
showCancelButton: false,
showConfirmButton: false,

});
		$('#emoji').BearsimpleEmoji($('#text'));
		$.fn.insertText = function(text){
		    editor.codemirror.doc.replaceSelection(text+' ');
		    Swal.close();
			this.each(function() {
				if(this.tagName !== 'INPUT' && this.tagName !== 'TEXTAREA') {return;}
				if (document.selection) {
					this.focus();
					var cr = document.selection.createRange();
					cr.text = text;
					cr.collapse();
					cr.select();
				}else if (this.selectionStart || this.selectionStart == '0') {
					var 
					start = this.selectionStart,
					end = this.selectionEnd;
					this.value = this.value.substring(0, start)+ text+ this.value.substring(end, this.value.length);
					this.selectionStart = this.selectionEnd = start+text.length;
				}else {
					this.value += text;
				}
			});        
			return this;
		}
		

}

       function colorpc(editor){
       Swal.fire({
  title: '字体颜色选择器面板',
  html: "<div id=\"color\"></div><br>选择完颜色后点击下面的直接插入按钮进行应用，本功能实现的效果仅在前台文章内页可见。",
  icon: 'info',
showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  cancelButtonText: "取消", 
  confirmButtonText: '直接插入'
}).then((result) => {
  if (result.isConfirmed) {
  var colorss = document.getElementById("colors").value;
  if(!colorss){
      alert('未选择颜色，不能直接插入!');
  }
  else{
    editor.codemirror.doc.replaceSelection('{bs-font color="'+ colorss + '"}内容{/bs-font}');
  }
  }
})
       $('#color').colorpicker({
        popover: false,
        inline: true,
        container: '#color',
template: '<div class="colorpicker">' +
          '<div class="colorpicker-saturation"><i class="colorpicker-guide"></i></div>' +
          '<div class="colorpicker-hue"><i class="colorpicker-guide"></i></div>' +
          '<div class="colorpicker-alpha">' +
          '   <div class="colorpicker-alpha-color"></div>' +
          '   <i class="colorpicker-guide"></i>' +
          '</div>' +
          '<div class="colorpicker-bar">' +
          '   <div class="input-group">' +
          '       <input id="colors" class="form-control input-block color-io" />' +
          '   </div>' +
          '</div>' +
          '</div>'
        })
        .on('colorpickerCreate', function (e) {
          var io = e.colorpicker.element.find('.color-io');
          io.val(e.color.string());
          io.on('change keyup', function () {
            e.colorpicker.setValue(io.val());
          });
        })
        .on('colorpickerChange', function (e) {
          var io = e.colorpicker.element.find('.color-io');
          if (e.value === io.val() || !e.color || !e.color.isValid()) {
            return;
          }
          io.val(e.color.string());
        });
       }
       $(document).ready(function() {
     
           $(".copyupload").attr("style","display:none;");
               $(".insertper").attr("style","display:none;");
               $(".autosaves").attr("style","display:none;");
               localStorage.setItem('autosavecid','');
               $("#wmd-button-bar").attr("style","display:none;");
        
       });
     

      
        </script>
   
      
        <?php
    }
    
    
    
    //腾讯云COS
    
    /**
   * @description: 上传文件处理函数
   * @param {array} $file
   * @return {*}
   */
  public static function uploadHandle(array $file)
  {
    if(bsOptions::getInstance()::get_option( 'bearsimple' )['Tinypng_open'] == true){
        //文件名是否空
        if (empty($file['name'])) {
            return false;
        }
        //文件名安全性检测
        $ext = self::getTypechoMethod("getSafeName", $file['name']);
        if (!self::getTypechoMethod("checkFileType", $ext) || \Typecho\Common::isAppEngine()) {
            return false;
        }
        //判断格式
        $ext = strtolower($ext);
        $isimage = in_array($ext, array("jpg", "png", "jpeg"));

        $options = Helper::options();
        if (empty($date)) {
            $date = new \Typecho\Date($options->gmtTime);
        }
        $path = \Typecho\Common::url(defined('__TYPECHO_UPLOAD_DIR__') ? __TYPECHO_UPLOAD_DIR__ : \Widget\Upload::UPLOAD_DIR,

                defined('__TYPECHO_UPLOAD_ROOT_DIR__') ? __TYPECHO_UPLOAD_ROOT_DIR__ : __TYPECHO_ROOT_DIR__)

            . '/' . $date->year . '/' . $date->month;

        if (!isset($file['tmp_name'])) {
            return false;
        }
        if ($isimage) {
            $apikey = trim(bsOptions::getInstance()::get_option( 'bearsimple' )['Tinypng_apikey']);
            \Tinify\setKey($apikey);
            $source = \Tinify\fromFile($file['tmp_name']);
        }
        //创建上传目录
        if (!is_dir($path)) {

            if (!self::getTypechoMethod("makeUploadDir", $path)) {

                return false;
            }
        }

        $fileName = sprintf('%u', crc32(uniqid())) . '.' . $ext;
        $path = $path . '/' . $fileName;
        if (!$isimage) {
            if (isset($file['tmp_name'])) {
                if (!@move_uploaded_file($file['tmp_name'], $path)) {
                    return false;
                }
            } else if (isset($file['bytes'])) {
                if (!file_put_contents($path, $file['bytes'])) {
                    return false;
                }
            } else {
                return false;
            }
        }
        if ($isimage) {
            $source->toFile($path);
            $file['size'] = filesize($path);
        } else if (!isset($file['size'])) {
            $file['size'] = filesize($path);
    }         
    $file['tmp_name'] = $path;
    }
    
    if (empty($file['name'])) {
      return false;
    }
    #获取扩展名
    $ext = self::getSafeName($file['name']);
    #判定是否是允许的文件类型
    if (!\Widget\Upload::checkFileType($ext) || \Typecho\Common::isAppEngine()) {
      return false;
    }
    #获取设置参数
    $opt = Helper::options();
    $opts = get_option('bearsimple');
    #获取文件名
    $date = new \Typecho\Date($opt->gmtTime);
    $fileDir = self::getUploadDir() . '/' . $date->year . '/' . $date->month;
    $fileName = sprintf('%u', crc32(uniqid())) . '.' . $ext;
    $path = $fileDir . '/' . $fileName;
    #获得上传文件
    $uploadfile = self::getUploadFile($file);
    #如果没有临时文件，则退出
    if (!isset($uploadfile)) {
      return false;
    }

    /* 上传到COS */
    #初始化COS
    $cosClient = self::CosInit();
    try {
      #判断是否存在重名文件，重名则重新生成
      $times = 10;
      while ($times > 0 && self::doesObjectExist($path)) {
        $fileName = sprintf('%u', crc32(uniqid($times--))) . '.' . $ext;
        $path = $fileDir . '/' . $fileName;
      }

      $cosClient->upload(
        $bucket = $opts['bucket_name'],
        $key = $path,
        $body = fopen($uploadfile, 'rb'),
        $options = array(
          "ACL" => 'public-read',
          'CacheControl' => 'private'
        )
      );
    } catch (Exception $e) {
      echo "$e\n";
      return false;
    }

    if (!isset($file['size'])) {
      $fileInfo = $cosClient->headObject(array('Bucket' => $opts['bucket_name'], 'Key' => $path))->toArray();
      $file['size'] = $fileInfo['ContentLength'];
    }
if ($opts['bucket_other'] !== '') {
      $bucket_other = $opts['bucket_other'];
    }
    if ($opts['bucket_localsave'] == true && self::makeUploadDir($fileDir)) {
      #本地存储一份
      @move_uploaded_file($uploadfile, $path);
    }

    #返回相对存储路径
    return array(
      'name' => $file['name'],
      'path' => $path,
      'size' => $file['size'],
      'type' => $ext,
      'mime' => @\Typecho\Common::mimeContentType($path)
    );
  }

  /**
   * @description: 修改文件处理函数
   * @param {array} $content 旧文件
   * @param {array} $file 新文件
   * @return {*}
   */
  public static function modifyHandle(array $content, array $file)
  {
    if (empty($file['name'])) {
      return false;
    }
if ($opts['bucket_other'] !== '') {
      $bucket_other = $opts['bucket_other'];
    }
    #获取扩展名
    $ext = self::getSafeName($file['name']);
    #判定是否是允许的文件类型
    if ($content['attachment']->type != $ext || \Typecho\Common::isAppEngine()) {
      return false;
    }
    #获取设置参数
    $opt = get_option('bearsimple');
    #获取文件路径
    $path = $content['attachment']->path;
    #获得上传文件
    $uploadfile = self::getUploadFile($file);
    #如果没有临时文件，则退出
    if (!isset($uploadfile)) {
      return false;
    }

    /* 上传到COS */
    $cosClient = self::CosInit();
    try {
      $cosClient->upload(
        $bucket = $opt['bucket'],
        $key = $path,
        $body = fopen($uploadfile, 'rb'),
        $options = array(
          "ACL" => 'public-read',
          'CacheControl' => 'private'
        )
      );
    } catch (Exception $e) {
      echo "$e\n";
      return false;
    }

    if (!isset($file['size'])) {
      $fileInfo = $cosClient->headObject(array('Bucket' => $opt['bucket_name'], 'Key' => $path))->toArray();
      $file['size'] = $fileInfo['ContentLength'];
    }

    if ($opt['bucket_localsave'] == true) {
      #本地存储一份
      @move_uploaded_file($uploadfile, $path);
    }


    #返回相对存储路径
    return array(
      'name' => $content['attachment']->name,
      'path' => $content['attachment']->path,
      'size' => $file['size'],
      'type' => $content['attachment']->type,
      'mime' => $content['attachment']->mime
    );
  }

  /**
   * @description: 删除文件
   * @param {array} $content
   * @return {*}
   */
  public static function deleteHandle(array $content)
  {
    #获取设置参数
    $opt = get_option('bearsimple');

    #删除本地文件
    if ($opt['bucket_localsave'] == true && $opt['bucket_localdelete']== true) {
      @unlink($content['attachment']->path);
    }
    # 开启同步删除COS文件则执行
    if ($opt['bucket_sync']==true) {
      #初始化COS
      $cosClient = self::CosInit();
      try {
        $result = $cosClient->deleteObject(array(
          #bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
          'Bucket' => $opt['bucket_name'],
          'Key' => $content['attachment']->path
        ));
      } catch (Exception $e) {
        echo "$e\n";
        return false;
      }
    }
    return true;
  }

  /**
   * @description: 获取对象访问Url
   * @param {array} $content
   * @return {*}
   */
  public static function attachmentHandle(array $content)
  {
    #获取设置参数
    $opt = get_option('bearsimple');
    $cosClient = self::CosInit();
    if ($opt['bucket_other'] !== '') {
      $bucket_other = $opt['bucket_other'];
    }
    if ($opt['bucket_sign'] == true) {
      $url = $cosClient->getObjectUrl($opt['bucket_name'], $content['attachment']->path, '+60 minutes');
      $reg = '/(https):\/\/([^\/]+)/i';
      $domain = $opt['bucket_domain'];
    if (empty($domain)){
      return $url.$bucket_other;
    }
    else{
       return preg_replace($reg, $domain, $url).$bucket_other; 
    }
    }
    $url = $cosClient->getObjectUrlWithoutSign($opt['bucket_name'], $content['attachment']->path);
    $reg = '/(https):\/\/([^\/]+)/i';
      $domain = $opt['bucket_domain'];
    if (empty($domain)){
      return $url.$bucket_other;
    }
    else{
       return preg_replace($reg, $domain, $url).$bucket_other; 
    }
  }

  /**
   * @description: 获取对象访问Url
   * @param array $content
   * @return {*}
   */
  public static function attachmentDataHandle($content)
  {
    #获取设置参数
    $opt = get_option('bearsimple');
    $cosClient = self::CosInit();
    if ($opt['bucket_other'] !== '') {
      $bucket_other = $opt['bucket_other'];
    }
    if ($opt['bucket_sign'] == 1) {
      $url = $cosClient->getObjectUrl($opt['bucket_name'], $content['attachment']->path, '+60 minutes');
      $reg = '/(https):\/\/([^\/]+)/i';
      $domain = $opt['bucket_domain'];
    if (empty($domain)){
      return $url.$bucket_other;
    }
    else{
       return preg_replace($reg, $domain, $url).$bucket_other; 
    }
    }
    $url = $cosClient->getObjectUrlWithoutSign($opt['bucket_name'], $content['attachment']->path);
    $reg = '/(https):\/\/([^\/]+)/i';
      $domain = $opt['bucket_domain'];
    if (empty($domain)){
      return $url.$bucket_other;
    }
    else{
       return preg_replace($reg, $domain, $url).$bucket_other; 
    }
  }

  /**
   * @description: 更新正文中的对象网址钩子
   * @return {*}
   */
  public static function Widget_Archive_beforeRender()
  {
    ob_start();
    $html = ob_get_contents();
    ob_clean();
    echo self::beforeRender($html);
    ob_end_flush();
  }

  /**
   * @description: 更新正文中的对象网址（获得新的sign）
   * @param string $text 页面html
   * @return string
   */
  public static function beforeRender($text)
  {
    $opt = get_option('bearsimple');
    $cosClient = self::CosInit();
    if ($opt['bucket_sign'] == 1) {
      return preg_replace_callback(
        '/https?:\/\/[-A-Za-z0-9+&@#\/\%?=~_|!:,.;]+[-A-Za-z0-9+&@#\/\%=~_|]/i',
        function ($matches) use ($opt, $cosClient) {
          $url = $matches[0];
          if (strpos($url, self::getDomain()) !== false) {
            $expTime = explode('q-key-time%3D', $url);
            if (sizeof($expTime) > 1) {
              @$expTime = explode('%26q', $expTime[1])[0];
              @$expTime = explode('%3B', $expTime)[1];
              #未过期，不更新
              if ($expTime > time()) {
                return $url;
              }
            }
            $path = str_replace(self::getDomain(), '', $url);
            $url = $cosClient->getObjectUrl($opt['bucket_name'], explode('?', $path)[0], '+10 minutes');
          }
          return $url;
        },
        $text
      );
    }
    return $text;
  }

  /**
   * @description: COS初始化
   * @param object $options 设置信息
   * @return {*}
   */
  public static function CosInit($options = '')
  {
    try {
      if (!$options) {
        $options = get_option('bearsimple');
      }
    } catch (Exception $e) {
    }
    if (self::compareVersion('7.2.5') < 0) {
      require_once 'phar://' . __DIR__ . '/modules/tencent_cos/phar/cos-sdk-v5-6.phar/vendor/autoload.php';;
    } else {
      require_once 'phar://' . __DIR__ . '/modules/tencent_cos/phar/cos-sdk-v5-7.phar/vendor/autoload.php';;
    }
   if(empty($options['bucket_secret_id'])||empty($options['bucket_secret_key'])){
       return new \Qcloud\Cos\Client(array(
      'region' => 'ap-beijing',
      'schema' => 'https', #协议头部，默认为http
      'credentials' => array(
        'secretId' => 'fix',
        'secretKey' => 'fix'
      )
    ));
   }
   else{
    return new \Qcloud\Cos\Client(array(
      'region' => $options['bucket_region'],
      'schema' => 'https', #协议头部，默认为http
      'credentials' => array(
        'secretId' => $options['bucket_secret_id'],
        'secretKey' => $options['bucket_secret_key']
      )
    ));
   }
  }

  /**
   * @description: 判断存储桶是否存在
   * @param {*} $opt
   * @return {*}
   */
  public static function doesBucketExist($opt)
  {
    #初始化COS
    $cosClient = self::CosInit($opt);
    try {
      $result = $cosClient->doesBucketExist(
        $opt['bucket_name']
      );
      if (!$result) {
        return false;
      }
    } catch (Exception $e) {
      return false;
    }
    return true;
  }

  /**
   * @description: 判断对象是否已存在
   * @param {*} $key
   * @return {*}
   */
  public static function doesObjectExist($key)
  {
    #获取设置参数
    $opt = get_option('bearsimple');
    #初始化COS
    $cosClient = self::CosInit();
    try {
      $result = $cosClient->doesObjectExist(
        $opt['bucket_name'],
        $key
      );
      if ($result) {
        return true;
      }
    } catch (Exception $e) {
      return true;
    }
    return false;
  }

  /**
   * @description: 创建上传路径
   * @param {string} $path
   * @return {*}
   */
  private static function makeUploadDir(string $path)
  {
    $path = preg_replace("/\\\+/", '/', $path);
    $current = rtrim($path, '/');
    $last = $current;

    while (!is_dir($current) && false !== strpos($path, '/')) {
      $last = $current;
      $current = dirname($current);
    }

    if ($last == $current) {
      return true;
    }

    if (!@mkdir($last, 0755)) {
      return false;
    }

    return self::makeUploadDir($path);
  }

  /**
   * @description: 获取文件上传目录
   * @return {*}
   */
  private static function getUploadDir()
  {
    $opt = get_option('bearsimple');
    if ($opt['bucket_path']) {
      return $opt['bucket_path'];
    } else if (defined('__TYPECHO_UPLOAD_DIR__')) {
      return __TYPECHO_UPLOAD_DIR__;
    } else {
      return self::UPLOAD_DIR;
    }
  }

  /**
   * @description: 获取上传文件信息
   * @param array $file 上传的文件
   * @return {*}
   */
  private static function getUploadFile($file)
  {
    return isset($file['tmp_name']) ? $file['tmp_name'] : (isset($file['bytes']) ? $file['bytes'] : (isset($file['bits']) ? $file['bits'] : ''));
  }

  /**
   * @description: 获取访问域名
   * @return string
   */
  private static function getDomain()
  {
    $opt = get_option('bearsimple');
    $domain = $opt['bucket_domain'];
    if (empty($domain))  $domain = 'https://' . $opt['bucket_name'] . '.cos.' . $opt['bucket_region'] . '.myqcloud.com';
    return $domain;
  }

  /**
   * @description: 获取安全的文件名
   * @param string $file 
   * @return string
   */
  private static function getSafeName(&$file)
  {
    $file = str_replace(array('"', '<', '>'), '', $file);
    $file = str_replace('\\', '/', $file);
    $file = false === strpos($file, '/') ? ('a' . $file) : str_replace('/', '/a', $file);
    $info = pathinfo($file);
    $file = substr($info['basename'], 1);
    return isset($info['extension']) ? strtolower($info['extension']) : '';
  }

  /**
   * @description: 比较php版本
   * @param string $test 要比较的版本号，如7.2.5
   * @return int 当前版本大于比较版本:1 当前版本小于比较版本:-1 当前版本等于比较版本:0
   */
  private static function compareVersion($test)
  {
    $currentVersion = explode('.', PHP_VERSION);
    $testVersion = explode('.', $test);
    $ret = 0;
    for ($i = 0; $i < sizeof($currentVersion); $i++) {
      if ($currentVersion[$i] == $testVersion[$i]) {
        continue;
      }
      if ($currentVersion[$i] > $testVersion[$i]) {
        $ret = 1;
        break;
      } else {
        $ret = -1;
        break;
      }
    }
    return $ret;
  }
  
  
  //文章内容分页
  public static function parseContent($obj,$u,$r,$con){
		$options = \Typecho\Widget::widget('Widget_Options');
		$db = \Typecho\Db::get();
		$query= $db->select()->from('table.contents')->where('cid = ?', $obj->cid); 
		$row = $db->fetchRow($query);
		$log_content=$row['text'];
		if(get_option('Scroll') == 1){
		    $menutree = 'window.tocManager.displayDisableTocTips = false;window.tocManager.generateToc();';		}
		$Page_Mark = "----------";
		if(strpos($log_content, $Page_Mark)) $ob = "Y";
		if(isset($ob)){
			$content_list = explode($Page_Mark, $log_content);
			$page_count = count($content_list);
			$page_now = !empty($_GET['page_now']) ? intval($_GET['page_now']) : 1;
			$page_now = ($page_now > $page_count && $page_count>0) ? $page_count : $page_now;
			$log_content = stripslashes($content_list[$page_now -1]);
			
				$log_content = '
					<div id="pagearea"></div>
					<div id="pageBar"></div>
					<script>
					var curPage;
					var totalItem;
					var pageSize;
					var totalPage;
					 
					//获取分页数据
					function turnPage(page){
					  $.ajax({
						type: "POST",
						url: "'.$options->siteUrl.'/index.php/bs-pagecontent",
						data: {"page_now":page,"cid":"'.$obj->cid.'","title":"'.$obj->title.'","remember":"'.$r.'","haslogin":"'.$u.'","ArticleType":"'.$obj->fields->ArticleType.'"},
						dataType: "json",
						beforeSend: function() {
						  $("#pagearea").append("<div class=\"ui medium active secondary inline text loader\">加载中......</div>");
						},
						success: function(json) {
						  $("#pagearea").empty();/*移除原来的分页数据*/
						  totalItem = json.totalItem;
						  pageSize = json.pageSize;
						  curPage = page;
						  totalPage = json.totalPage;
						  var data_content = json.log_content;
						  $("#pagearea").append(data_content);

			'.$menutree.'
						},
						complete: function() {    /*添加分页按钮栏*/
						  getPageBar();
						},
						error: function() {
						  alert("数据加载失败");
						}
					  });
					}
					/*获取分页条（分页按钮栏的规则和样式根据自己的需要来设置）*/
					function getPageBar(){
					  if(curPage > totalPage) {
						curPage = totalPage;
					  }
					  if(curPage < 1) {
						curPage = 1;
					  }
					 
					  pageBar = "<div class=\"ui circular labels\"><div style=\"text-align:center\">";
					 
					  /*如果不是第一页*/
					  if(curPage != 1){
						pageBar += "<a class=\"ui large label\" href=\"javascript:turnPage(1)\">首页</a>&nbsp;";
						pageBar += "<a class=\"ui large label\" href=\"javascript:turnPage("+(curPage-1)+")\">上一页</a>&nbsp;";
					  }
					 
					  /*显示的页码按钮(5个)*/
					  var start,end;
					  if(totalPage <= 5) {
						start = 1;
						end = totalPage;
					  } else {
						if(curPage-2 <= 0) {
							start = 1;
							end = 5;
						} else {
							if(totalPage-curPage < 2) {
								start = totalPage - 4;
								end = totalPage;
							} else {
								start = curPage - 2;
								end = curPage + 2;
							}
						}
					  }
					  
					  for(var i=start;i<=end;i++) {
						if(i == curPage) {
							pageBar += "<a class=\"ui large grey  label\" href=\"javascript:turnPage("+i+")\">"+i+"</a>&nbsp;";
						} else {
							pageBar += "<a class=\"ui large label\" href=\"javascript:turnPage("+i+")\">"+i+"</a>&nbsp;";
						}
					  }
					  
					  /*如果不是最后页*/
					  if(curPage != totalPage){
						pageBar += "<a class=\"ui large label\" href=\"javascript:turnPage("+(parseInt(curPage)+1)+")\">下一页</a>&nbsp;";
						pageBar += "<a class=\"ui large label\" href=\"javascript:turnPage("+totalPage+")\">尾页</a>";
					  }
						pageBar += "</div></div>"; 
					  $("#pageBar").html(pageBar);
					}
					 
					/*页面加载时初始化分页*/
					$(function() {
					  turnPage(1);
					});
					     $(window).bind(\'popstate\',function(event) {  
					     turnPage(1);
					     });
					</script>
				';
				return $log_content;
			?>
				<?php
		}else{
			return $con;
		}
  }
  
  
  
  
  public static function xsscheck($text)
{
    $xsscheck = false;
    $list = array(
        '/onabort/is',
        '/onblur/is',
        '/onchange/is',
        '/onclick/is',
        '/ondblclick/is',
        '/onerror/is',
        '/onfocus/is',
        '/onkeydown/is',
        '/onkeypress/is',
        '/onkeyup/is',
        '/onload/is',
        '/onmousedown/is',
        '/onmousemove/is',
        '/onmouseout/is',
        '/onmouseover/is',
        '/onmouseup/is',
        '/onreset/is',
        '/onresize/is',
        '/onselect/is',
        '/onsubmit/is',
        '/onunload/is',
        '/eval/is',
        '/ascript:/is',
        '/style=/is',
        '/width=/is',
        '/width:/is',
        '/height=/is',
        '/height:/is',
        '/src=/is',
    );
    if (strip_tags($text)) {
        for ($i = 0; $i < count($list); $i++) {
            if (preg_match($list[$i], $text) > 0) {
                $xsscheck = true;
                break;
            }
        }
    } else {
        $xsscheck = true;
    };
    return $xsscheck;
}

/**
    * PHP获取字符串中英文混合长度 
    */
    public static function strLength($str){        
        preg_match_all('/./us', $str, $match);
        return count($match[0]);  // 输出9
    }
        

    /**
     * 检查$str中是否含有$words_str中的词汇
     * 
     */
	public static function check_in($words_str, $str)
	{
		$words = explode("\n", $words_str);
		if (empty($words)) {
			return false;
		}
		foreach ($words as $word) {
            if (false !== strpos($str, trim($word))) {
                return true;
            }
		}
		return false;
	}

    /**
     * 检查$ip中是否在$words_ip的IP段中
     * 
     */
	public static function check_ip($words_ip, $ip)
	{
		$words = explode("\n", $words_ip);
		if (empty($words)) {
			return false;
		}
		foreach ($words as $word) {
			$word = trim($word);
			if (false !== strpos($word, '*')) {
				$word = "/^".str_replace('*', '\d{1,3}', $word)."$/";
				if (preg_match($word, $ip)) {
					return true;
				}
			} else {
				if (false !== strpos($ip, $word)) {
					return true;
				}
			}
		}
		return false;
	}
	
 public static function GetRandStr($length){
 $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
 $len = strlen($str)-1;
 $randstr = '';
 for ($i=0;$i<$length;$i++) {
  $num=mt_rand(0,$len);
  $randstr .= $str[$num];
 }
 return $randstr;
}
 public static function secretComment($data, $obj,$last){
     $text = empty($last)?$data:$last;                                                                                                        
     $parentid=array();$parentmail=array();//定义初始父级信息数组
     if($obj->parent>0){//如果拥有父级，则循环将所有父级信息加入数组
       $db = \Typecho\Db::get();
       $parent = $obj->parent;            
            while ($parent > 0) {
                $parentRows = $db->fetchRow($db->select()->from('table.comments')
                ->where('coid = ? AND status = ?', $parent, 'approved')->limit(1));
                
                if (!empty($parentRows)) {
                    $coid = $parent;
                    $parent = $parentRows['parent'];
                  array_push($parentid,$parentRows['authorId']);
                  array_push($parentmail,$parentRows['mail']);
                } else {
                    break;
                }
            }   
     }
     
     \Typecho\Widget::widget('Widget_User')->to($user);//获取当前用户信息
     $stext =$text; 
      if(strpos($text,'@私密@') !== false){
          if(get_option('bearsimple')['avatar__choose'] !== 'closeavatar'){
     $stext = '<div class="comment-excerpta break bshideContent">该评论为私密评论，仅已登录者与评论双方可见</div>';
     $text = '<div class="comment-excerpta break">'.str_replace("@私密@","",$text).'</div>';
          }
          else{
      $stext = '<div class="comment-excerptb break bshideContent">该评论为私密评论，仅已登录者与评论双方可见</div>';
     $text = '<div class="comment-excerptb break">'.str_replace("@私密@","",$text).'</div>';        
          }
      
      
      
     
 if (\Typecho\Widget::widget('Widget_User')->hasLogin()){
   if($user->group=="administrator"||$user->group=="editor"||$user->uid==$obj->authorId||$user->uid==$obj->ownerId||in_array($user->uid,$parentid)){
       if(get_option('bearsimple')['avatar__choose'] !== 'closeavatar'){
       Helper::options()->commentsHTMLTagAllowed='<div class="comment-excerpta break">'.Helper::options()->commentsHTMLTagAllowed;
       }
       else{
        Helper::options()->commentsHTMLTagAllowed='<div class="comment-excerptb break">'.Helper::options()->commentsHTMLTagAllowed;   
       }
     return $text;
   }else{
     if(get_option('bearsimple')['avatar__choose'] !== 'closeavatar'){
       Helper::options()->commentsHTMLTagAllowed='<div class="comment-excerpta break bshideContent">'.Helper::options()->commentsHTMLTagAllowed;
       }
       else{
        Helper::options()->commentsHTMLTagAllowed='<div class="comment-excerptb break bshideContent">'.Helper::options()->commentsHTMLTagAllowed;   
       }
     return $stext;
   }
}else{
$commentsMail = \Typecho\Cookie::get('__typecho_remember_mail');
if(($obj->mail==$commentsMail && $obj->authorId==0)||(!empty($parentmail) && in_array($commentsMail,$parentmail))){
    if(get_option('bearsimple')['avatar__choose'] !== 'closeavatar'){
       Helper::options()->commentsHTMLTagAllowed='<div class="comment-excerpta break">'.Helper::options()->commentsHTMLTagAllowed;
       }
       else{
        Helper::options()->commentsHTMLTagAllowed='<div class="comment-excerptb break">'.Helper::options()->commentsHTMLTagAllowed;   
       }
    return $text;
}else{
    if(get_option('bearsimple')['avatar__choose'] !== 'closeavatar'){
       Helper::options()->commentsHTMLTagAllowed='<div class="comment-excerpta break bshideContent">'.Helper::options()->commentsHTMLTagAllowed;
       }
       else{
        Helper::options()->commentsHTMLTagAllowed='<div class="comment-excerptb break bshideContent">'.Helper::options()->commentsHTMLTagAllowed;   
       }
  return $stext;
} 
 }  
      }
      
      
      else{
          if(get_option('bearsimple')['avatar__choose'] !== 'closeavatar'){
        $text = '<div class="comment-excerpta break">'.str_replace("@私密@","",$text).'</div>';
        Helper::options()->commentsHTMLTagAllowed='<div class="comment-excerpta break">'.Helper::options()->commentsHTMLTagAllowed;
          }
          else{
           $text = '<div class="comment-excerptb break">'.str_replace("@私密@","",$text).'</div>';
        Helper::options()->commentsHTMLTagAllowed='<div class="comment-excerptb break">'.Helper::options()->commentsHTMLTagAllowed;   
          }
  return $text;
      }
     
   
   }
 public static function post_request($url, $postdata) {
    $data = http_build_query($postdata);
    $options    = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => "Content-type: application/x-www-form-urlencoded",
            'content' => $data,
            'timeout' => 5
        )
    );
    $context = stream_context_create($options);
    $result    = file_get_contents($url, false, $context);
    if($http_response_header[0] != 'HTTP/1.1 200 OK'){
        $result = array(
            "result" => "success",
            "reason" => "request geetest api fail"
        );
        return json_encode($result);
    }else{
        return $result;
    }
}
 
 public static function spam_protection_mathjia(){
   
    $num1=rand(1,49);
    $num2=rand(1,49);

    echo "<div class=\"field\">
    <label class=\"required\">验证码</label>
  <input type=\"text\" name=\"sum\" class=\"text\" value=\"\" size=\"10\" tabindex=\"4\" style=\"width:180px\" placeholder=\"$num1 + $num2 = ?\">
</div>\n";
    echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
    echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\">\n";
    echo "<input type=\"hidden\" name=\"spam_protection_mathstyle\" value=\"addition\">";
}

public static function spam_protection_mathjian(){
   
    $num1=rand(1,49);
    $num2=rand(1,49);

    echo "<div class=\"field\">
    <label class=\"required\">验证码</label>
  <input type=\"text\" name=\"sum\" class=\"text\" value=\"\" size=\"10\" tabindex=\"4\" style=\"width:180px\" placeholder=\"$num1 - $num2 = ?\">
</div>\n";
    echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
    echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\">\n";
    echo "<input type=\"hidden\" name=\"spam_protection_mathstyle\" value=\"subtraction\">";
}

public static function spam_protection_question(){
   $opt = get_option('bearsimple');
   $rand = mt_rand(0,count($opt['VerifyQuestion'])-1);
   $rand_key = $opt['VerifyQuestion'][$rand]['VerifyQuestion_key'];
   $rand_answer = $opt['VerifyQuestion'][$rand]['VerifyQuestion_answer'];
   $rand_answer_tipshow = $opt['VerifyQuestion'][$rand]['VerifyQuestion_showtip'];
   $rand_answer_tipshow_text = $opt['VerifyQuestion'][$rand]['VerifyQuestion_showtiptext'];
   if($rand_answer_tipshow == true){
     echo "<div class=\"field\">
    <label class=\"required\">验证问答</label>
    <div class=\"ui input\">
  <input type=\"text\" placeholder=\"$rand_key\" name=\"answer\">
 
</div><br>
<div style=\"margin-top:5px;margin-bottom:5px;font-weight:bold;\"><a id=\"answerhide\">显示答案提示</a>
  <a id=\"answershow\" style=\"display:none;\">隐藏答案提示</a>
  <span class=\"answer\" style=\"display:none;\">
    「答案提示:$rand_answer_tipshow_text 」</span></div>
</div>";  
   }
   else{
    echo "<div class=\"field\">
    <label class=\"required\">验证问答</label>
    <div class=\"ui input\">
  <input type=\"text\" placeholder=\"$rand_key\" name=\"answer\">
 
</div><br>
<div style=\"margin-top:5px;margin-bottom:5px;font-weight:bold;\"><a id=\"answerhide\">显示答案</a>
  <a id=\"answershow\" style=\"display:none;\">隐藏答案</a>
  <span class=\"answer\" style=\"display:none;\">
    「答案:$rand_answer 」</span></div>
</div>";
}
 self::getSecurity('set','__typecho_comment_question_answer',$rand_answer);
}
 
public static  function authToken($string, $operation = 'DECODE', $key = '', $expiry = 0) { 
    $opurl = Helper::options()->siteUrl; 
  $ckey_length = 4;  
  $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);  
  $keya = md5(substr($key, 0, 16));  
  $keyb = md5(substr($key, 16, 16));  
  $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): 
substr(md5(microtime()), -$ckey_length)) : '';  
  $cryptkey = $keya.md5($keya.$keyc);  
  $key_length = strlen($cryptkey);  
  $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : 
sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;  
  $string_length = strlen($string);  
  $result = '';  
  $box = range(0, 255);  
  $rndkey = array();  
  for($i = 0; $i <= 255; $i++) {  
    $rndkey[$i] = ord($cryptkey[$i % $key_length]);  
  }  
  for($j = $i = 0; $i < 256; $i++) {  
    $j = ($j + $box[$i] + $rndkey[$i]) % 256;  
    $tmp = $box[$i];  
    $box[$i] = $box[$j];  
    $box[$j] = $tmp;  
  }  
  for($a = $j = $i = 0; $i < $string_length; $i++) {  
    $a = ($a + 1) % 256;  
    $j = ($j + $box[$a]) % 256;  
    $tmp = $box[$a];  
    $box[$a] = $box[$j];  
    $box[$j] = $tmp;  
    $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));  
  }  
  if($operation == 'DECODE') { 
    if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && 
substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {  
      return substr($result, 26);  
    } else {  
      return '';  
    }  
  } else {  
    return $keyc.str_replace('=', '', base64_encode($result));  
  }  
}

 public static function getSecurityToken($type = NULL){
     $str = mt_rand(100001,999999); 
     $key = Helper::options()->siteUrl; 
     $securityToken = self::authToken($str,'ENCODE',$key,0);
     if($type == 'html'){
     echo "<input type=\"hidden\" name=\"SecurityToken\"  id=\"SecurityToken\" value='".$securityToken."'>\n";
     }
     self::getSecurity('set','__typecho_security_token',$securityToken);
 }
 
 public static function filter($comment,$post){
 $options = bsOptions::getInstance()::get_option( 'bearsimple' );
 $removeChar = ["https://", "http://", "/"]; 
if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", Helper::options()->siteUrl)) == false ) { 
    throw new \Typecho\Widget\Exception("Currently not authorized, please return to the correct page.",200);
}
if($_POST['SecurityToken'] !== self::getSecurity('get','__typecho_security_token')){
    throw new \Typecho\Widget\Exception("Currently not authorized, please return to the correct page.",200);
}
 if(Plugin::xsscheck($comment['text'])) {
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论包含危险内容，请返回修改后再试。",200);
        }
$comment['url'] =htmlspecialchars($comment['url'],ENT_QUOTES,'UTF-8');
        if(preg_match("/^[A-Za-z0-9]+([_\.][A-Za-z0-9]+)*@([A-Za-z0-9\-]+\.)+[A-Za-z]{2,6}$/",$comment['mail']) !== 1){
         throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论包含危险内容，请返回修改后再试。",200);                      
        }
 if(!$_POST['vtype'] || $_POST['vtype'] !== 'cross'){ //判断POST过来的vtype字段是否为微语或为空
 

         if (strlen(trim(preg_replace('/\xc2\xa0/',' ',$comment['text']))) == 0) {
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容只有空格，请返回修改后再试。",200);
            }
            
        
        if($options['BearSpam_Pro'] == true){
        if (!empty($options['BearSpam_IP'])) {
			if (Plugin::check_ip($options['BearSpam_IP'], $comment['ip'])) {
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的IP处于屏蔽范围内，已拦截本条评论。",200);
			  \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}

            
        }
		if (!empty($options['BearSpam_EMAIL'])) {
			if (Plugin::check_in($options['BearSpam_EMAIL'], $comment['mail'])) {
				throw new \Typecho\Widget\Exception("抱歉，系统检测到您的邮箱处于屏蔽范围内，已拦截本条评论。",200);
				  \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
		}
		
			if (!empty($options['BearSpam_NAME'])) {
			if (Plugin::check_in($options['BearSpam_NAME'], $comment['author'])) {
			    
				throw new \Typecho\Widget\Exception("抱歉，系统检测到您的昵称存在敏感禁止词汇，已拦截本条评论。",200);
				  \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
		}
		
		if (!empty($options['BearSpam_URL'])) {
			if (Plugin::check_in($options['BearSpam_URL'], $comment['url'])) {
			    			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的网址处于屏蔽范围内，已拦截本条评论。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
			}
			
			if (!empty($options['BearSpam_ArticleTitle'])&& $options['BearSpam_ArticleTitle'] == "1") {
			$db = \Typecho\Db::get();
            // 获取评论所在文章
            $pot = $db->fetchRow($db->select('title')->from('table.contents')->where('cid = ?', $comment['cid']));        
            if(strstr($comment['text'], $pot['title'])){
                		throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容疑似存在灌水内容，已自动拦截。",200);
\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
			}
			
			if (!empty($options['BearSpam_NAMEMIN'])) {    
            if(Plugin::strLength($comment['author']) < $options['BearSpam_NAMEMIN']){

			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论昵称过短，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
			}
			
			if (!empty($options['BearSpam_NAMEMAX'])) {    
            if (Plugin::strLength($comment['author']) > $options['BearSpam_NAMEMAX']) {
                throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论昵称过长，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options['BearSpam_NAMEURL'])&& $options['BearSpam_NAMEURL'] == "1") {    
            if (preg_match(" /^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*[\.。])+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&]*)?)?(#[a-z][a-z0-9_]*)?$/ ", $comment['author']) > 0) {
			                throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论昵称异常，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options['BearSpam_Chinese'])&& $options['BearSpam_Chinese'] == "1") {    
            if (preg_match("/[\x{4e00}-\x{9fa5}]/u", $comment['text']) == 0) {
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容不包含中文，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options['BearSpam_MIN'])) {    
            if(Plugin::strLength($comment['text']) < $options['BearSpam_MIN']){         
				throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容字数过少，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options['BearSpam_MAX'])) {    
            if(Plugin::strLength($comment['text']) > $options['BearSpam_MAX']){         
				throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容字数过多，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options['BearSpam_Words'])) {    
            if (Plugin::check_in($options['BearSpam_Words'], $comment['text'])) { 
	throw new \Typecho\Widget\Exception("抱歉，系统检测到您的评论内容包含敏感禁止词汇，已自动拦截。",200);
			\Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			}
					    
			}
        }
         if ($options['VerifyChoose'] == '22-2'){
            $answer = $_POST['answer'];
            $ganswer = self::getSecurity('get','__typecho_comment_question_answer');
             switch($answer){
        case $ganswer:
        break;
        case null:
        throw new \Typecho\Widget\Exception('对不起，请输入验证码。',200);
        break;
        default:
        throw new \Typecho\Widget\Exception('对不起，验证码错误，请重试。',200);
           
         }
         }
       if ($options['VerifyChoose'] == '1' || $options['VerifyChoose'] == '11'){
           $sum = $_POST['sum'];
           switch($_POST['spam_protection_mathstyle']){
               case 'addition':
                   switch($sum){
        case $_POST['num1'] + $_POST['num2']:
        break;
        case null:
        throw new \Typecho\Widget\Exception('对不起，请输入验证码。',200);
        break;
        default:
        throw new \Typecho\Widget\Exception('对不起，验证码错误，请重试。',200);
    }
                   break;
               case 'subtraction':
                    switch($sum){
        case $_POST['num1'] - $_POST['num2']:
        break;
        case null:
        throw new \Typecho\Widget\Exception('对不起，请输入验证码。',200);
        break;
        default:
        throw new \Typecho\Widget\Exception('对不起，验证码错误，请重试。',200);
    }
                   break;
           }
       } 
      if ($options['VerifyChoose']== '2-2' && !empty($options['turnstile_key']) && !empty($options['turnstile_secretkey']) && $options['backendVerify_Turnstile'] == true) {
     if(empty($_POST['cf-turnstile-response'])){
         \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的验证密钥已失效，需重新验证！",200); 
     }
     elseif (isset($_POST['cf-turnstile-response'])) {
$response_data = self::getTurnstileResult($_POST['cf-turnstile-response'], $options['turnstile_secretkey']);
if ($response_data['success']) {
                if ($response_data['action'] == 'comment') {
                    return $comment;
                } else {
                    \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
                    throw new Typecho_Widget_Exception(_t(self::getTurnstileResultMsg('场景验证失败')),200);
                }
            } else {
                \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
                throw new Typecho_Widget_Exception(_t(self::getTurnstileResultMsg($response_data)),200);
            }
        } else {
            \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
            throw new Typecho_Widget_Exception(_t('加载验证码失败, 请检查你的网络'),200);
        }

 }
 
 
        if ($options['VerifyChoose']== '2' && !empty($options['vid']) && !empty($options['vkey']) && $options['backendVerify_Vaptcha'] == true) {
     if(empty($_POST['vaptcha_server']) || empty($_POST['vaptcha_token'])){
         \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的验证密钥已失效，需重新验证！",200); 
     }
 $url = $_POST['vaptcha_server'];
 $data = array(
     'id'=> $options['vid'],
     'secretkey' => $options['vkey'],
     'scene'=> '1',
     'token'=> $_POST['vaptcha_token'],
     'ip'=> $comment['ip']
     );
    $ch = curl_init();  
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,3);  
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $handles = curl_exec($ch);  
    curl_close($ch);  
    $result = json_decode($handles,true);
    if($result['success'] == 0){
        \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，您未通过人机验证，原因:".$result['msg'],200);
    }
 }
  if ($options['VerifyChoose']== '2-3' && !empty($options['geeid']) && !empty($options['geekey']) && $options['backendVerify_Geetest'] == true) {
      $captcha_id = $options['geeid'];
$captcha_key = $options['geekey'];
$api_server = "https://gcaptcha4.geetest.com";
$lot_number = $_POST['lot_number'];
$captcha_output = $_POST['captcha_output'];
$pass_token = $_POST['pass_token'];
$gen_time = $_POST['gen_time'];
$sign_token = hash_hmac('sha256', $lot_number, $captcha_key);
$query = array(
    "lot_number" => $lot_number,
    "captcha_output" => $captcha_output,
    "pass_token" => $pass_token,
    "gen_time" => $gen_time,
    "sign_token" => $sign_token
);
$url = sprintf($api_server . "/validate" . "?captcha_id=%s", $captcha_id);
$res = self::post_request($url,$query);
$obj = json_decode($res,true);

if($obj['status'] == 'success' && $obj['result'] == 'fail'){
    \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，您未通过人机验证，原因:".$obj['reason'],200);
}
if($obj['status'] == 'error' && $obj['code']){
    \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，您未通过人机验证，错误码:".$obj['code']."，原因:".$obj['msg'],200);
}

  }
 if ($options['VerifyChoose']== '2-1' && !empty($options['dx_domain']) && !empty($options['dx_appId']) && !empty($options['dx_appSecret']) && $options['backendVerify_Dingxiang'] == true) {
     
     if(empty($_POST['dx_token'])){
         \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，系统检测到您的验证密钥已失效，需重新验证！",200); 
     }
   $appId = $options['dx_appId'];
$appSecret = $options['dx_appSecret'];
$client = new CaptchaClient($appId,$appSecret);
$client->setTimeOut(2);
$client->setCaptchaUrl("https://".$options['dx_domain']."/api/tokenVerify");
$response = $client->verifyToken($_POST['dx_token']);
if(!$response->result){
    \Typecho\Cookie::set('__typecho_remember_text', $comment['text']);
			throw new \Typecho\Widget\Exception("抱歉，您未通过人机验证，请返回重试。",200);
}
 }
 
            \Typecho\Cookie::delete('__typecho_remember_text');
            if(empty($comment['mail'])){
                $comment['mail'] = self::GetRandStr(17).'@privatemail.com';
                \Typecho\Cookie::set('__typecho_remember_mail', $comment['mail']);
            }
            if($_POST['privatecomment'] == 'on'){
                $comment['text'] = '@私密@'.$comment['text'];
            }
            
 }
 
        return $comment;
 }

    private static function getTurnstileResult($turnstile_response, $secretKey)
    {
        $beforeload = array('secret' => $secretKey, 'response' => $turnstile_response);
        $beforeload['remoteip'] = $_SERVER['REMOTE_ADDR'];
        $stream = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($beforeload)
            )
        ));
        $response = file_get_contents("https://challenges.cloudflare.com/turnstile/v0/siteverify", false, $stream);
        $response = json_decode($response, true);
        return $response;
    }

    private static function getTurnstileResultMsg($resp)
    {
        if ($resp['success'] == true) {
            return '验证通过';
        } else {
            switch (strtolower($resp['error-codes'][0])) {
                case 'missing-input-response':
                    return '请先完成验证';

                case 'invalid-input-response':
                    return '验证无效或已过期';

                case 'timeout-or-duplicate':
                    return '验证密钥已被使用, 请重新验证';

                case 'bad-request':
                    return '呜呜呜验证失败了,要不 再试一次?';

                case 'internal-error':
                    return '验证服务器寄了, 再试一次吧';

                case 'missing-input-secret':
                case 'invalid-input-secret':
                    return '未设置或设置了无效的 secretKey';

                default:
                    return '还请再试一次！';
            }
        }
    }
    
 //文件缓存
 
public static function getCache_file(){
        $req = \Typecho\Request::getInstance();
        $url = $req->getRequestUri();


        if(!$req->isGet()){
            return;
        }
        if(strstr($url,'/action/') !== false || strstr($url,'/admin/') !== false){
            
            return;
        }

        $hash = md5($url);

        @$settings = bsOptions::getInstance()::get_option( 'bearsimple' );
        if(!$settings) return;


        $cache_timeout = intval($settings['cache_timeout']);

        $cache_root = $settings['cache_dir'];
        if(strstr($cache_root, '/') !== 0 ){
            $cache_root = __TYPECHO_ROOT_DIR__.'/usr/'.$cache_root;
        }

        if($cache_timeout <= 0){
            $cache_timeout = 60; //1min
        }

        $file = self::hash2dir($hash,$cache_root).$hash.".gz";
        if(file_exists($file)){
            $filetime = filemtime($file);
            if($filetime !== false && time() - $filetime < $cache_timeout){
                $fh = fopen($file, "rb");
                $content = fread($fh,filesize ($file));
                fclose($fh);
                $html = gzuncompress($content);
                echo $html;
                exit(0);
            }
        }else{
        
        }
    }

    public static function setCache_file(){
        $req = \Typecho\Request::getInstance();
        $url = $req->getRequestUri();
        
        if(!$req->isGet()){
            return;
        }
        if(strstr($url,'/action/') !== false || strstr($url,'/admin/') !== false){
            return;
        }
       $_routingTable = Helper::options()->routingTable;
        $post_regx = $_routingTable[0]['post']['regx'];
        if (array_key_exists('TePass', \Typecho\Plugin::export()['activated'])){
        if (preg_match($post_regx,$path,$arr)){
            if ($arr[1] and !empty($arr[1])){
                $db = \Typecho\Db::get();
                try {
		    $database = $db->getConfig($db::READ)['database'];
                    $tepass_exist = $db->fetchRow($db->select()->from('information_schema.TABLES')->where('TABLE_NAME = ?',$db->getPrefix().'tepass_posts')->where('TABLE_SCHEMA = ?',$database));
                    if (isset($tepass_exist) and count($tepass_exist) > 0){
                          $p_id = $db->fetchObject($db->select('id')->from('table.tepass_posts')->where('post_id = ?',$arr[1]))->id;
                          if ($p_id) return;
                    }

                }catch (Typecho_Db_Query_Exception $e){
                  
                }

            }
        }
        }
        
        @$settings = bsOptions::getInstance()::get_option( 'bearsimple' );
        if(!$settings) return;
        $cache_root = $settings['cache_dir'];
        if(strstr($cache_root, '/') !== 0 ){
            $cache_root = __TYPECHO_ROOT_DIR__.'/usr/'.$cache_root;
        }

        $hash = md5($url);
        $file = self::hash2dir($hash,$cache_root).$hash.".gz";
        $dir = dirname($file);

        if(!file_exists($dir)){
            $ret = mkdir($dir,0777,true);
            if(!$ret){
                return;
            }
        }

        $html = ob_get_contents();
        $html_gz = gzcompress($html);
        $fp = fopen($file, 'w');
        fwrite($fp, $html_gz);
        fclose($fp);
    }

    private static function hash2dir($hash,$base_dir=""){
        $dir="";
        for($i = 0; $i < strlen($hash) ; $i+=2){
            $dir = $dir."/".substr($hash, $i, 2);
        }
        return rtrim($base_dir,'/').$dir.'/';
    }
 
 
 //代码高亮
     public static function headlink($cssUrl) {
        
        $options = Helper::options();
    
        $dir = $options->themeUrl.'/';
   
    if(bsOptions::getInstance()::get_option('bearsimple' )['Codehightlight'] == true){
        $style = bsOptions::getInstance()::get_option('bearsimple' )['code_style'];
        if(empty($style)){
            $style = 'coy.css';
        }
        else{
       $style = bsOptions::getInstance()::get_option( 'bearsimple' )['code_style'];
        }
        $cssUrl = $dir.'modules/codehightlight/static/styles/' . $style.'?v=2.2.4';
    
    
        echo '<link rel="stylesheet" type="text/css" href="' . $cssUrl . '" />';
    }
    
    }

    /**
     * 底部脚本
     *
     * @access public
     * @param unknown $footlink
     * @return unknown
     */
    public static function footlink() {
      $options = Helper::options();
        $dir = $options->themeUrl.'/';
        //全局引入alpinejs来实现某些组件动作类
  echo <<<HTML
  <script src="//cdn.staticfile.org/alpinejs/3.10.5/cdn.min.js"></script>
    <script src="//cdn.staticfile.org/instant.page/5.1.1/instantpage.min.js" type="application/javascript"></script>
HTML;
    if(bsOptions::getInstance()::get_option('bearsimple' )['Codehightlight'] == 1){
         $jsUrl = $dir.'modules/codehightlight/static/prism.js?v=1';
        $showLineNumber = bsOptions::getInstance()::get_option('bearsimple')['showLineNumber'];
        if ($showLineNumber == 1) {
            echo <<<HTML
<script type="text/javascript">
	(function(){
		var pres = document.querySelectorAll('pre');
		var lineNumberClassName = 'line-numbers';
		pres.forEach(function (item, index) {
			item.className = item.className == '' ? lineNumberClassName : item.className + ' ' + lineNumberClassName;
		});
	})();
</script>
<script type="text/javascript">
$(document).on('pjax:complete', function() {
if (typeof Prism !== 'undefined') {
var pres = document.getElementsByTagName('pre');
                for (var i = 0; i < pres.length; i++){
                    if (pres[i].getElementsByTagName('code').length > 0)
                        pres[i].className  = 'line-numbers';}
Prism.highlightAll(true,null);}
});
</script>


HTML;
        }
        echo <<<HTML
<script type="text/javascript" src="{$jsUrl}"></script>
HTML;
}
if(bsOptions::getInstance()::get_option('bearsimple')['seo_push'] == true && bsOptions::getInstance()::get_option('bearsimple')['seotabs']['baidu_token'] !== ''){
        echo PHP_EOL.'<script>
(function(){
  var bp = document.createElement("script");
  var curProtocol = window.location.protocol.split(":")[0];
  if (curProtocol === "https"){
    bp.src = "https://zz.bdstatic.com/linksubmit/push.js";
  }else{
    bp.src = "http://push.zhanzhang.baidu.com/push.js";
  }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>'.PHP_EOL;
}
if(bsOptions::getInstance()::get_option('bearsimple')['AdControl'] == true && bsOptions::getInstance()::get_option('bearsimple')['AdControl_Google'] == true){
echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
}
    }
    
    
    
    //邮件
    /**
     * 获取邮件内容
     *
     * @access public
     * @param $comment 调用参数
     * @return void
     */
    public static function parseComment($comment)
    {
        $options = \Typecho\Widget::widget('Widget_Options');
        $Temoptions = get_option('bearsimple');
        $cfg = array(
            'siteTitle' => $options->title,
            'timezone'  => $options->timezone,
            'cid'       => $comment->cid,
            'coid'      => $comment->coid,
            'created'   => $comment->created,
            'author'    => $comment->author,
            'authorId'  => $comment->authorId,
            'ownerId'   => $comment->ownerId,
            'mail'      => $comment->mail,
            'ip'        => $comment->ip,
            'title'     => $comment->title,
            'text'      => $comment->text,
            'permalink' => $comment->permalink,
            'status'    => $comment->status,
            'parent'    => $comment->parent,
            'manage'    => $options->adminUrl . "/manage-comments.php"
        );

      
 self::$_isMailLog = in_array('4', $Temoptions['CommentNotify__OtherSetting']) ? true : false;
        if($_POST['accept'] == 'on'){
            $cfg['banMail'] = 1;
        }
        else{
            $cfg['banMail'] = 0;
        }

        $fileName = \Typecho\Common::randString(12);
        $cfg      = (object)$cfg;
        file_put_contents(dirname(__FILE__) . '/cache/' . $fileName, serialize($cfg));
        $url = ($options->rewrite) ? $options->siteUrl : $options->siteUrl . 'index.php';
        $url = rtrim($url, '/') . '/action/' . self::$action . '?send=' . $fileName;

        $date = new \Typecho\Date(\Typecho\Date::gmtTime());
        $time = $date->format('Y-m-d H:i:s');

        self::saveLog("{$time} 开始发送请求：{$url}\n");
        self::asyncRequest($url);
    }



    /**
     * 发送异步请求
     * @param $url
     */
    public static function asyncRequest($url)
    {
        self::isAvailable();
        self::$_adapter == 'Socket' ? self::socket($url) : self::curl($url);
    }

    /**
     * Socket 请求
     * @param $url
     * @return bool
     */
    public static function socket($url)
    {
        $params = parse_url($url);
        $path = $params['path'] . '?' . $params['query'];
        $host = $params['host'];
        $port = 80;
        $scheme = '';

        if ('https' == $params['scheme']) {
            $port = 443;
            $scheme = 'ssl://';
        }

        if (function_exists('fsockopen')) {
            $fp = @fsockopen($scheme . $host, $port, $errno, $errstr, 30);
        } elseif (function_exists('pfsockopen')) {
            $fp = @pfsockopen($scheme . $host, $port, $errno, $errstr, 30);
        } else {
            $fp = stream_socket_client($scheme . $host . ":$port", $errno, $errstr, 30);
        }

        if ($fp === false) {
            self::saveLog("SOCKET错误," . $errno . ':' . $errstr);
            return false;
        }

        $out = "GET " . $path . " HTTP/1.1\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Connection: Close\r\n\r\n";

        self::saveLog("Socket 方式发送\r\n");

        fwrite($fp, $out);
        sleep(1);
        fclose($fp);
        self::saveLog("请求结束\r\n");
    }

    /**
     * Curl 请求
     * @param $url
     */
    public static function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // 将curl_exec()获取的信息以文件流的形式返回,不直接输出。  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);  // 连接等待时间  
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);         // curl允许执行时间

        self::saveLog("Curl 方式发送\r\n");

        curl_exec($ch);
        curl_close($ch);
        self::saveLog("请求结束\r\n");
    }

    /**
     * 检测 适配器
     * @return string
     */
    public static function isAvailable()
    {
        function_exists('ini_get') && ini_get('allow_url_fopen') && (self::$_adapter = 'Socket');
        false == self::$_adapter && function_exists('curl_version') && (self::$_adapter = 'Curl');

        return self::$_adapter;
    }

    /**
     * 检测 是否可写
     * @param $file
     * @return bool
     */
    public static function isWritable($file)
    {
        if (is_dir($file)) {
            $dir = $file;
            if ($fp = @fopen("$dir/check_writable", 'w')) {
                @fclose($fp);
                @unlink("$dir/check_writable");
                $writeable = true;
            } else {
                $writeable = false;
            }
        } else {
            if ($fp = @fopen($file, 'a+')) {
                @fclose($fp);
                $writeable = true;
            } else {
                $writeable = false;
            }
        }

        return $writeable;
    }
    /**
     * 写入记录
     * @param $content
     * @return bool
     */
    public static function saveLog($content)
    {
        if (!self::$_isMailLog) {
            return false;
        }

        file_put_contents(dirname(__FILE__) . '/log/mailer_log.txt', $content, FILE_APPEND);
    }
    
    public function sign($msg, $key)
    {
        $signature = '';
        $success = openssl_sign($msg, $signature, $key, 'SHA256');
        if(!$success){
            return false;
        }
        return $signature;
    }


    public function urlEncode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }
    public function encode($payload, $key, $alg = 'RS256')
    {
        $header = array('typ' => 'JWT', 'alg' => $alg);
        $segments = array();
        $segments[] = $this->urlEncode(json_encode($header));
        $segments[] = $this->urlEncode(json_encode($payload));
        $signing_input = implode('.', $segments);
        $signature = $this->sign($signing_input, $key);
        $segments[] = $this->urlEncode($signature);
        return implode('.', $segments);
    }
    
    //百度推送
    public static function seo_publishpush($content, $edit)
    {
        $bd_api = get_option('bearsimple')['seotabs']['baidu_token'];
        $sm_api = get_option('bearsimple')['seotabs']['shenma_token'];
        $bing_api = get_option('bearsimple')['seotabs']['bing_token'];
        $toutiao_api = get_option('bearsimple')['seotabs']['toutiao_token'];
        $indexnow_api = get_option('bearsimple')['seotabs']['indexnow_token'];
        $siteUrl = Helper::options()->siteUrl;
         $adminUrl = Helper::options()->adminUrl;
         $db = \Typecho\Db::get();
        $content['cid'] = $edit->cid;
        $content['slug'] = $edit->slug;
        
        //获取分类缩略名
        $content['category'] = urlencode(current(\Typecho\Common::arrayFlatten($db->fetchAll($db->select()->from('table.metas')
            ->join('table.relationships', 'table.relationships.mid = table.metas.mid')
            ->where('table.relationships.cid = ?', $content['cid'])
            ->where('table.metas.type = ?', 'category')
            ->order('table.metas.order', \Typecho\Db::SORT_ASC)), 'slug')));

        //获取并格式化文章创建时间
        $content['created'] = $edit->created;
        $created = new \Typecho\Date($content['created']);
        $content['year'] = $created->year; $content['month'] = $created->month; $content['day'] = $created->day;

        //生成URL
        $url = \Typecho\Common::url(\Typecho\Router::url($content['type'], $content), $siteUrl);
         $urls = array(0=>$url);
        if($content['created'] >  Helper::options()->time) exit('<script>location.href="'.$adminUrl.'/manage-posts.php";</script>');
        
        if($bd_api !== ''){
        if(strpos($bd_api, 'data.zz.baidu.com') !== 7) exit('<script>alert("请配置正确的百度收录推送接口调用地址");location.href="'.$adminUrl.'/manage-posts.php";</script>');
        //发送请求
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $bd_api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        
        $res = json_decode($result, true);
        if(isset($res['error'])) exit('<script>alert("链接提交百度过程中出现错误，错误代码：'.$res['error'].'，错误信息：'.$res['message'].'。");location.href="'.$adminUrl.'/manage-posts.php";</script>');
        
        }
        
        if($sm_api !== ''){
           //发送请求
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $sm_api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        
        $res = json_decode($result, true);
        if($res['returnCode'] !== 200) exit('<script>alert("链接提交神马过程中出现错误，错误代码：'.$res['returnCode'].'，错误信息：'.$res['errorMsg'].'。");location.href="'.$adminUrl.'/manage-posts.php";</script>');  
        }
        
        if($bing_api !== ''){
        $submit_url = array();
        $home_url = Helper::options()->siteUrl;
        $len = strlen($home_url);
        foreach($urls as $url){
            $url = trim($url);
            if(empty($url)){
                continue;
            }
            if(substr($url,0,$len)!=$home_url){
                continue;
            }
            $submit_url[] = $url;
        }
           //发送请求
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => 'https://ssl.bing.com/webmaster/api.svc/json/SubmitUrlbatch?apikey='.$bing_api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode(array('siteUrl'=>$home_url,'urlList'=>$submit_url)),
            CURLOPT_HTTPHEADER => array('Content-Type: text/json; charset=utf-8'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        
        $res = json_decode($result, true);
        if(!$res)
            exit('<script>alert("链接提交Bing过程中响应解析出错");location.href="'.$adminUrl.'/manage-posts.php";</script>'); 
        
        if(isset($res['ErrorCode']))
           exit('<script>alert("链接提交Bing过程中出现错误，错误代码：'.$res['ErrorCode'].'，错误信息：'.$res['Message'].'。");location.href="'.$adminUrl.'/manage-posts.php";</script>'); 
        
        }
        
        if($toutiao_api !== ''){
            $url = urlencode($url);
           //发送请求
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => 'https://zhanzhang.toutiao.com/s.gif?url='.$url.'&token='.$toutiao_api,
            CURLOPT_POST => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: text/json; charset=utf-8'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        
        $res = json_decode($result, true);
        if($res['code'] == 8) exit('<script>alert("链接提交头条过程中出现错误，错误代码：'.$res['code'].'，错误信息：'.$res['msg'].'。");location.href="'.$adminUrl.'/manage-posts.php";</script>');  
        }
        
          if($indexnow_api !== ''){
           //发送请求
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => 'https://api.indexnow.org/indexnow?key='.$indexnow_api.'&url='.$url,
            CURLOPT_POST => FALSE,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json; charset=utf-8'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
         curl_close($ch);
        $res = json_decode($result, true);
        $resCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
         if($resCode !== 200){
            $msg  = [
                202=>'URL校验正常，IndexNow密钥已激活，该通知或许仅会显示这一次:).',
                400=>'非法格式',
                403=>'在密钥无效的情况下出现错误（例如，没有找到密钥，找到文件但密钥内容不在文件中）。',
                422=>'如果URL不属于主机，或者密钥与协议中的模式不匹配，就会出现这种情况',
                429=>'请求过多(被限制了)',
            ];
            $err = $msg[$httpCode] ? $msg[$httpCode] : 'api error,response code['.$httpCode.']';
            exit('<script>alert("链接提交IndexNow过程中出现错误，原因：'.$err.'。");location.href="'.$adminUrl.'/manage-posts.php";</script>');
        }
        
        
        
        }
        
    }
    
      public static function seo_autopush()
    {
        echo PHP_EOL.'<script>
(function(){
  var bp = document.createElement("script");
  var curProtocol = window.location.protocol.split(":")[0];
  if (curProtocol === "https"){
    bp.src = "https://zz.bdstatic.com/linksubmit/push.js";
  }else{
    bp.src = "http://push.zhanzhang.baidu.com/push.js";
  }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>'.PHP_EOL;
    }
   
    
    public static function tags_bottom(){
        ?><style>.autotags a{cursor: pointer; padding: 0px 6px; margin: 2px 0;display: inline-block;border-radius: 2px;text-decoration: none;}
.autotags a:hover{background: #ccc;color: #fff;}
</style>
<script> $(document).ready(function(){
    $('#tags').after('<div style="margin-top: 20px;" class="autotags"><label for="token-input-tags" class="typecho-label">点击标签自动插入</label><ul style="list-style: none;border: 1px solid #D9D9D6;padding: 6px 12px; max-height: 240px;overflow: auto;background-color: #FFF;border-radius: 2px;"><?php
$i=0;
\Typecho\Widget::widget('Widget_Metas_Tag_Cloud', 'sort=count&desc=1&limit=200')->to($tags);
while ($tags->next()) {
    if (strpos($tags->name, "'") == false) {
echo "<a id=".$i." onclick=\"$(\'#tags\').tokenInput(\'add\', {id: \'".$tags->name."\', tags: \'".$tags->name."\'});\">".$tags->name."</a>";
$i++;
}
}
?></ul></div>');
  });</script>
<?php
    }
    
     /*

     * 文件上传

     * @param $file

     *

     */

    public static function tinypng_uploadHandle($file)
    {
        //文件名是否空
        if (empty($file['name'])) {
            return false;
        }
        //文件名安全性检测
        $ext = self::getTypechoMethod("getSafeName", $file['name']);
        if (!self::getTypechoMethod("checkFileType", $ext) || \Typecho\Common::isAppEngine()) {
            return false;
        }
        //判断格式
        $ext = strtolower($ext);
        $isimage = in_array($ext, array("jpg", "png", "jpeg"));

        $options = Helper::options();
        if (empty($date)) {
            $date = new \Typecho\Date($options->gmtTime);
        }
        $path = \Typecho\Common::url(defined('__TYPECHO_UPLOAD_DIR__') ? __TYPECHO_UPLOAD_DIR__ : \Widget\Upload::UPLOAD_DIR,

                defined('__TYPECHO_UPLOAD_ROOT_DIR__') ? __TYPECHO_UPLOAD_ROOT_DIR__ : __TYPECHO_ROOT_DIR__)

            . '/' . $date->year . '/' . $date->month;

        if (!isset($file['tmp_name'])) {
            return false;
        }
        if ($isimage) {
            $apikey = trim(bsOptions::getInstance()::get_option( 'bearsimple' )['Tinypng_apikey']);
            \Tinify\setKey($apikey);
            $source = \Tinify\fromFile($file['tmp_name']);
        }
        //创建上传目录
        if (!is_dir($path)) {

            if (!self::getTypechoMethod("makeUploadDir", $path)) {

                return false;
            }
        }

        $fileName = sprintf('%u', crc32(uniqid())) . '.' . $ext;
        $path = $path . '/' . $fileName;
        if (!$isimage) {
            if (isset($file['tmp_name'])) {
                if (!@move_uploaded_file($file['tmp_name'], $path)) {
                    return false;
                }
            } else if (isset($file['bytes'])) {
                if (!file_put_contents($path, $file['bytes'])) {
                    return false;
                }
            } else {
                return false;
            }
        }
        if ($isimage) {
            $source->toFile($path);
            $file['size'] = filesize($path);
        } else if (!isset($file['size'])) {
            $file['size'] = filesize($path);
        }

        return array(
            'name' => $file['name'],
            'path' => (defined('__TYPECHO_UPLOAD_DIR__') ? __TYPECHO_UPLOAD_DIR__ : \Widget\Upload::UPLOAD_DIR)
                . '/' . $date->year . '/' . $date->month . '/' . $fileName,
            'size' => $file['size'],
            'type' => $ext,
            'mime' => \Typecho\Common::mimeContentType($path)
        );
    }


    public static function getTypechoMethod($methodName, $inParams)

    {

        if (empty($objReflectClass)) {

            $objReflectClass = new ReflectionClass("Widget_Upload");

        }

        $method = $objReflectClass->getMethod($methodName);

        $method->setAccessible(true);

        if ("getSafeName" == $methodName) {

            $result = $method->invokeArgs(null, array(&$inParams));

        } else {

            $result = $method->invokeArgs(null, array($inParams));

        }

        return $result;

    }



    /**

     * 异步更新可用压缩数

     * @param $post

     */

    public static function tinypng_bottom($post)

    {

        $options = Helper::options();

        $statusPath = \Typecho\Common::url("/action/bs-ajax?do=tinypng", $options->index);



        echo <<<EOT

        <script>

$("#tab-files").append("<div id=\"upload-panel\" class=\"p\">     <div class=\"upload-area tinypngstatus\" draggable=\"true\" title=\"点击更新\" style=\"position: relative;cursor: pointer;\">图片压缩可用数正在查询中...</div> </div>");

function statusfind() {

	$.ajax({

		url: "{$statusPath}",

		async: true,

		dataType: "text",

		global: true,

		success: function(result) {

		    //如果正常返回数字

		    if(!isNaN(result)){

		        $(".tinypngstatus").text("图片压缩可用："+result+"张");

		    }else{

		          var sear=new RegExp('Provide an API key');

		          var unknownerror = true;

　　              if(sear.test(result)){

                      unknownerror = false;

    　　             $(".tinypngstatus").html("<span style=\"color:#df4068;\">TinyPNG APIKEY需要设置</span>");

　　              }

                  //未知错误

                  if(unknownerror){

                    $(".tinypngstatus").html("<span style=\"color:#df4068;\">TinyPNG出现错误</span>");

                  }

		    }	    

		},

		error:function(result) {

			$(".tinypngstatus").html("<span style=\"color:#df4068;\">TinyPNG状态获取失败，网络故障或者配置错误</span>");

		}

	});

}

$("#tab-files-btn").click(statusfind);

function statusfindsession(){

     $(".tinypngstatus").text("图片压缩可用数查询中...");

    statusfind();

}

$(".tinypngstatus").click(statusfindsession);

</script>\n

EOT;

    }
public static function getSecurity($typeName,$name,$value = null){
    if($typeName == 'get'){
        $value = \Typecho\Cookie::get($name);
        return $value;
    }
    elseif($typeName == 'set'){
        \Typecho\Cookie::set($name, $value);
    }
    else{
        \Typecho\Cookie::delete($name, $value);
    }
}


}
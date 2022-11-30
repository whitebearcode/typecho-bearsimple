<?php
namespace TypechoPlugin\BsCore;
use BsCore;
use bsOptions;
use \Utils\Helper;
use Typecho\{Exception, Widget, Db};
use Typecho\Cookie;
use Widget\Options;
require_once dirname(__FILE__) . '/lib/class.phpmailer.php';
use PHPMailer;

if(!class_exists('CSF')){
    require_once Helper::options()->pluginDir('BsCore').'/bsoptions-framework.php';
}

if (!class_exists('bsOptions')){
    require_once \Utils\Helper::options()->pluginDir('BsCore').'/bsOptions.php';
}

class Action extends Widget implements \Widget\ActionInterface
{

   

    public function clean_cache()
    {
        $options = get_option('bearsimple');
        if ($options['Cache_choose'] == 'memcached' || $options['Cache_choose'] == 'redis') {
            Plugin::initBackend($config['Cache_choose']);
            try {
                Plugin::$cache->flush();
                $data['code']  = '1';
	            $data['message']  = '缓存清理成功!';
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                print $e->getMessage();
            }
        } else{
            // 关闭其他插件选项
            if ($options['enable_gcache'] == '1'){
                $options['enable_gcache'] = 0;
            }
            if ($options['enable_markcache'] == '1'){
                $options['enable_markcache'] = 0;
            }
            $data['code']  = '0';
	            $data['message']  = '缓存清理失败，请检查缓存方式选项是否为Memcached或Redis!';
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        bsOptions::update_option('bearsimple', $options);

    }
    
    //邮件功能
    private $_db;
    private $_dir;
    private $_options;
    private $_isMailLog = false;
    private $_user;
    private  $_email;

    /**
     * 读取缓存文件内容
     */
    public function process($fileName)
    { 
        $this->init();
        $options = get_option('bearsimple');
        //获取评论内容
        $file = $this->_dir . '/cache/' . $fileName;
        if (file_exists($file)) {
            $this->_email = unserialize(file_get_contents($file));
            @unlink($file);

            if (!$this->_user->simpleLogin($this->_email->ownerId)) {
                $this->widget('Widget_Archive@404', 'type=404')->render();
                exit;
            }
        } else {
            $this->widget('Widget_Archive@404', 'type=404')->render();
            exit;
        }

        //发件人邮箱
        $this->_email->from = $options['CommentNotify__Username'];

        //发件人名称
        $this->_email->fromName = $options['CommentNotify__SenderName'] ? $options['CommentNotify__SenderName'] : $this->_email->siteTitle;

        //向博主发邮件的标题格式
        $this->_email->titleForOwner = $options['CommentNotify__Author'];

        //向访客发邮件的标题格式
        $this->_email->titleForGuest = $options['CommentNotify__Reader'];

        //验证博主是否接收自己的邮件
        $toMe = (in_array('3', $options['CommentNotify__OtherSetting']) && $this->_email->ownerId == $this->_email->authorId) ? true : false;

        //向博主发信
        if (
            in_array($this->_email->status, $options['CommentNotify__NotifySetting']) && in_array('1', $options['CommentNotify__OtherSetting'])
            && ($toMe || $this->_email->ownerId != $this->_email->authorId) && 0 == $this->_email->parent
        ) {
            if (empty($options['CommentNotify__AcceptMailAddress'])) {
                \Typecho\Widget::widget('Widget_Users_Author@temp' . $this->_email->cid, array('uid' => $this->_email->ownerId))->to($user);
                $this->_email->to = $user->mail;
            } else {
                $this->_email->to = $options['CommentNotify__AcceptMailAddress'];
            }

            $this->authorMail()->sendMail();
        }

        //向访客发信
        if (
            0 != $this->_email->parent
            && 'approved' == $this->_email->status
            && in_array('2', $options['CommentNotify__OtherSetting'])
            && !$this->ban($this->_email->parent)
        ) {
            //如果联系我的邮件地址为空，则使用文章作者的邮件地址
            if (empty($this->_email->contactme)) {
                if (!isset($user) || !$user) {
                    \Typecho\Widget::widget('Widget_Users_Author@temp' . $this->_email->cid, array('uid' => $this->_email->ownerId))->to($user);
                }
                $this->_email->contactme = $user->mail;
            } else {
                $this->_email->contactme = $options['CommentNotify__TemplateContact'];
            }

            $original = $this->_db->fetchRow($this->_db->select('author', 'mail', 'text')
                ->from('table.comments')
                ->where('coid = ?', $this->_email->parent));

            if (
                in_array('3', $options['CommentNotify__OtherSetting'])
                || $this->_email->mail != $original['mail']
            ) {
                $this->_email->to             = $original['mail'];
                $this->_email->originalText   = $original['text'];
                $this->_email->originalAuthor = $original['author'];
                $this->guestMail()->sendMail();
            }
        }

        $date = new \Typecho\Date(\Typecho\Date::gmtTime());
        $time = $date->format('Y-m-d H:i:s');
        $this->mailLog(false, $time . " 邮件发送完毕!\r\n");
    }

    /**
     * 作者邮件信息
     * @return $this
     */
    public function authorMail()
    {
        $options = get_option('bearsimple');
        $this->_email->toName = $this->_email->siteTitle;
        $date = new \Typecho\Date($this->_email->created);
        $time = $date->format('Y-m-d H:i:s');
        $status = array(
            "approved" => '通过',
            "waiting"  => '待审',
            "spam"     => '垃圾'
        );
        $search  = array(
            '{siteTitle}',
            '{title}',
            '{author}',
            '{ip}',
            '{mail}',
            '{permalink}',
            '{manage}',
            '{text}',
            '{time}',
            '{status}',
            '{siteurl}'
        );
        $replace = array(
            $this->_email->siteTitle,
            $this->_email->title,
            $this->_email->author,
            $this->_email->ip,
            $this->_email->mail,
            $this->_email->permalink,
            $this->_email->manage,
            $this->_email->text,
            $time,
            $status[$this->_email->status],
            $this->_options->siteUrl
            
        );

        $this->_email->msgHtml = str_replace($search, $replace, file_get_contents(dirname(__FILE__)."/modules/MailServices/owner.html"));
        $this->_email->subject = str_replace($search, $replace, $this->_email->titleForOwner);
        $this->_email->altBody = "作者：" . $this->_email->author . "\r\n链接：" . $this->_email->permalink . "\r\n评论：\r\n" . $this->_email->text;

        return $this;
    }

    /**
     * 访问邮件信息
     * @return $this
     */
    public function guestMail()
    {
        $options = get_option('bearsimple');
        $sysoptions = \Typecho\Widget::widget('Widget_Options');
        $this->_email->toName = $this->_email->originalAuthor ? $this->_email->originalAuthor : $this->_email->siteTitle;
        $date    = new \Typecho\Date($this->_email->created);
        $time    = $date->format('Y-m-d H:i:s');
        $search  = array(
            '{siteTitle}',
            '{title}',
            '{author_p}',
            '{author}',
            '{permalink}',
            '{text}',
            '{contactme}',
            '{text_p}',
            '{time}',
            '{siteurl}'
        );
        $replace = array(
            $this->_email->siteTitle,
            $this->_email->title,
            $this->_email->originalAuthor,
            $this->_email->author,
            $this->_email->permalink,
            $this->_email->text,
            $this->_email->contactme,
            $this->_email->originalText,
            $time,
            $this->_options->siteUrl
        );

        $this->_email->msgHtml = str_replace($search, $replace, file_get_contents(dirname(__FILE__)."/modules/MailServices/guest.html"));
        $this->_email->subject = str_replace($search, $replace, $this->_email->titleForGuest);
        $this->_email->altBody = "作者：" . $this->_email->author . "\r\n链接：" . $this->_email->permalink . "\r\n评论：\r\n" . $this->_email->text;

        return $this;
    }

    /*
     * 发送邮件
     */
    public function sendMail()
    {
        /** 载入邮件组件 */
        require_once $this->_dir . '/lib/class.phpmailer.php';
        $mailer = new PHPMailer();
        $mailer->CharSet = 'UTF-8';
        $mailer->Encoding = 'base64';
$options = get_option('bearsimple');
        //选择发信模式
        switch ($options['CommentNotify__Sendway']) {
            case 'sendmail':
                $mailer->IsSendmail();
                break;
            case 'smtp':
                $mailer->IsSMTP();

                if (in_array('true', $options['CommentNotify__Verify'])) {
                    $mailer->SMTPAuth = true;
                }

                switch ($options['CommentNotify__VerifyWay']) {
                    case 'ssl':
                        $mailer->SMTPSecure = "ssl";
                        break;
                    case 'tls':
                        $mailer->SMTPSecure = "tls";
                        break;
                    case 'none':
                        $mailer->SMTPSecure = "";
                        break;
                }

                $mailer->Host     = $options['CommentNotify__Address'];
                $mailer->Port     = $options['CommentNotify__Port'];
                $mailer->Username = $options['CommentNotify__Username'];
                $mailer->Password = $options['CommentNotify__Password'];

                break;
        }

        $mailer->SetFrom($this->_email->from, $this->_email->fromName);
        $mailer->AddReplyTo($this->_email->to, $this->_email->toName);
        $mailer->Subject = $this->_email->subject;
        $mailer->AltBody = $this->_email->altBody;
        $mailer->MsgHTML($this->_email->msgHtml);
        $mailer->AddAddress($this->_email->to, $this->_email->toName);

        if ($result = $mailer->Send()) {
            $this->mailLog();
        } else {
            $this->mailLog(false, $mailer->ErrorInfo . "\r\n");
            $result = $mailer->ErrorInfo;
        }

        $mailer->ClearAddresses();
        $mailer->ClearReplyTos();

        return $result;
    }

    /*
     * 记录邮件发送日志和错误信息
     */
    public function mailLog($type = true, $content = null)
    {
        if (!$this->_isMailLog) {
            return false;
        }

        $fileName = $this->_dir . '/log/mailer_log.txt';
        if ($type) {
            $guest = explode('@', $this->_email->to);
            $guest = substr($this->_email->to, 0, 1) . '***' . $guest[1];
            $content  = $content ? $content : "向 " . $guest . " 发送邮件成功！\r\n";
        }

        file_put_contents($fileName, $content, FILE_APPEND);
    }

   
    /*
     * 验证原评论者是否接收评论
     */
    public function ban($parent, $isWrite = false)
    {
        if ($parent) {
            $index    = ceil($parent / 500);
            $filename = $this->_dir . '/log/ban_' . $index . '.list';

            if (!file_exists($filename)) {
                $list = array();
                file_put_contents($filename, serialize($list));
            } else {
                $list = unserialize(file_get_contents($filename));
            }

            //写入记录
            if ($isWrite) {
                $list[$parent] = 1;
                file_put_contents($filename, serialize($list));

                return true;
            } else if (isset($list[$parent]) && $list[$parent]) {
                return true;
            }
        }

        return false;
    }

    /**
     * 邮件发送测试
     */
    public function testMail()
    {
        error_reporting(0);
$options = get_option('bearsimple');
        $this->init();
        $this->_isMailLog = true;
        $this->_email->from = $options['CommentNotify__Username'] ? $options['CommentNotify__Username'] : 'system@system.com';
        $this->_email->fromName = $options['CommentNotify__SenderName'] ? $options['CommentNotify__SenderName'] : $this->_options->title;
        $this->_email->to = $this->_user->mail;
        $this->_email->toName = $this->_user->screenName;
        $this->_email->subject = '测试邮件';
        $this->_email->altBody = '这是一封由BearSimple发出的测试邮件';
        $this->_email->msgHtml = '这是一封由BearSimple发出的测试邮件';

        $result = $this->sendMail();
$data['code']  =  true === $result ? '1' : '0';
	            $data['message']  = true === $result ? _t('测试邮件发送成功，已发送至'.$this->_user->mail) : _t('测试邮件发送失败：' . $result);
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
       

    }
    
    /*
     * 获取管理员信息
     */
    public function userInfo($value,$uid)
    {
    $db   = \Typecho\Db::get();
    $prow = $db->fetchRow($db->select($value)->from('table.users')->where('uid = ?', $uid));
    $text = $prow[$value];
    return $text;
     }
     
    /*
     * 邮件发送[友链]
     */
    public function linkMail()
    {
        error_reporting(0);
$options = get_option('bearsimple');
        $this->init();
        $this->_isMailLog = true;
        $this->_email->from = $options['CommentNotify__Username'];
        $this->_email->fromName = $options['CommentNotify__SenderName'] ? $options['CommentNotify__SenderName'] : $this->_options->title;
        switch($_GET['type']){
            case 'notifyaccept':
        $this->_email->to = self::userInfo('mail','1');
        $this->_email->toName = $this->_user->screenName;
        $this->_email->subject = '友链审核提醒';
        $this->_email->altBody = '这是一封友链审核提醒邮件';
        $this->_email->msgHtml = '主人，有人提交了友链申请啦，快去审核下叭～';
        break;
        case 'notifysuccess':
        $this->_email->to = $_GET['mail'];
        $this->_email->toName = $_GET['mail'];
        $this->_email->subject = '友链审核通过提醒';
        $this->_email->msgHtml = '您好，您在'.$this->_options->title.'提交的友链申请已经审核通过，后续还请您遵守本站关于互换友链的相关说明哦。';
        break;
        case 'notifyfail':
        $this->_email->to = $_GET['mail'];
        $this->_email->toName = $_GET['mail'];
        $this->_email->subject = '友链审核不通过提醒';
        $this->_email->msgHtml = '您好，您在'.$this->_options->title.'提交的友链申请审核不通过，还请您参照本站关于互换友链的标准并检查是否符合哦。';
        break;
}
        $result = $this->sendMail();
$data['code']  =  true === $result ? '1' : '0';
	            $data['message']  = true === $result ? _t('测试邮件发送成功，已发送至'.$this->_user->mail) : _t('测试邮件发送失败：' . $result);
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
       

    }

    /**
     * 初始化
     * @return $this
     */
    public function init()
    {
        $this->_dir = dirname(__FILE__);
        $this->_db = \Typecho\Db::get();
        $this->_user = $this->widget('Widget_User');
        $this->_options = $this->widget('Widget_Options');
        $this->mailLog(false, "开始发送邮件Action：" . $this->request->send . "\r\n");
    }
    public function action()
    {
        $this->on($this->request->is('do=testMail'))->testMail();
        $this->on($this->request->is('do=linkMail'))->linkMail();
        $this->on($this->request->is('send'))->process($this->request->send);
    }
}
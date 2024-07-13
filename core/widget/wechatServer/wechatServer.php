<?php
ob_clean();
error_reporting(0);
require __DIR__ . '/vendor/autoload.php';
include 'Config.php';
require('bearWechatHandler.php');
use EasyWeChat\OfficialAccount\Application;
$options = Helper::options();

// 获取MD5加密后的内容
function getEncryptToken(){
    $db = Typecho_Db::get();
    return md5(md5("bearsimple!@#$%^&*()-=+@#$%$" . Helper::options()->openId . "bearsimple!@#$%^&*()-=+@#$%$@#$%^&*"));

}
switch($_POST['action']){
    case 'saysTalk':
		if (!empty($_POST['content']) && !empty($_POST['postEncryptToken']) && !empty($_POST['cid']) && !empty($_POST['agent'])) {
			$cid = $_POST['cid'];
			$thisText = $_POST['content'];
			$postEncryptToken = $_POST['postEncryptToken'];
			$agent = $_POST['agent'];
			$msg_type = $_POST['msg_type'];
            $encryptToken = getEncryptToken();

            if (md5($postEncryptToken) == $encryptToken) {
					$db = Typecho_Db::get();
					$getAdminSql = $db->select()->from('table.users')->limit(1);
					$user = $db->fetchRow($getAdminSql);
					$insert = $db->insert('table.comments')->rows(array('cid' => $cid, 'created' => time(), 'author' => $user['screenName'], 'authorId' => $user['uid'], 'ownerId' => $user['uid'], 'text' => $thisText, 'url' => $user['url'], 'mail' => $user['mail'], 'agent' => $agent, 'ip' => '1.1.1.1'));
					$insertId = $db->query($insert);
					$row = $db->fetchRow($db->select('commentsNum')->from('table.contents')->where('cid = ?', $cid));
					$db->query($db->update('table.contents')->rows(array('commentsNum' => (int) $row['commentsNum'] + 1))->where('cid = ?', $cid));
					echo '1';
				
			} else {
				echo '-2';
			}
		} else {
			echo '-3';
		}
	
        break;
        default:
$app = new Application($config);
$app->server->push(BearWechatHandler::class);
$response = $app->server->serve();
$response->send();
}
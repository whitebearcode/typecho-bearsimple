<?php
ob_clean();
error_reporting(0);
date_default_timezone_set('Asia/Shanghai');
require __DIR__ . '/vendor/autoload.php';
use EasyWeChat\OfficialAccount\Application;
use Typecho\Cookie;
include 'Config.php';
require('bearWechatHandler.php');
require_once 'WechatUtils.php';
$options = Helper::options();

function typeImageContent($url, $b,$openid)
{
	$c = WechatUtils::uploadPic($b, uniqid(), $url, 'web', '.jpg',$openid);
	$url = $c.',';
	return $url;
}
function typeTextContent($a,$c = true)
{
	if ($c) {
		$a = $a .'
';
	}
	return $a;
}

function parseCircleContent($data, $options,$openid,$type)
{
	$arr = json_decode($data, true);
	$arr = $arr['results'];
	$data = array();
	$data['text'] = '';
	$images = '';
	foreach ($arr as $con2) {
	if($type == 'image'){
		if ($con2['type'] == 'image') {
			$images .= typeImageContent($con2['content'], $options->rootUrl,$openid);
			$filtered_arr = array_filter(explode(',', $images), function($value) {
    return $value !== '' && $value !== null;
});
			$data['images'] = json_encode($filtered_arr);
			
		}
	}

	elseif($type == 'text'){
	 if ($con2['type'] == 'text') {
			$data['text'] .= typeTextContent($con2['content'], true);
		}    
	}
	}
	return $data;
}

// 获取MD5加密后的内容
function getEncryptToken(){
    $db = Typecho_Db::get();
    return md5(md5("bearsimple!@#$%^&*()-=+@#$%$" . Helper::options()->openId . "bearsimple!@#$%^&*()-=+@#$%$@#$%^&*"));

}
switch($_POST['action']){
    case 'sendCircle':
    $options = Helper::options();
    if (!empty($_POST['content']) && !empty($_POST['postEncryptToken']) && !empty($_POST['cid']) && !empty($_POST['agent'])) {
        $cid = $_POST['cid'];
        $postEncryptToken = $_POST['postEncryptToken'];
        $agent = $_POST['agent'];
        $msg_type = $_POST['msg_type'];
        $encryptToken = getEncryptToken();
        if (md5($postEncryptToken) == $encryptToken) {
            $msgid = $_POST['msgid'];
                $db = Typecho_Db::get();
$checkMsgidSql = $db->select()->from('table.bscore_wechat_msgids')->where('msgid = ?', $msgid);
$exists = $db->fetchRow($checkMsgidSql);

if ($exists) {
    echo "1";
    exit;
} else {
    $db->query($db->insert('table.bscore_wechat_msgids')->rows(array('msgid' => $msgid)));

                $getAdminSql = $db->select()->from('table.users')->limit(1);
                $user = $db->fetchRow($getAdminSql);
                
                $time = time();

                $thisText = parseCircleContent($_POST['content'], $options,$_POST['openid'],'text')['text'];
                $insert = $db->insert('table.comments')->rows(array('cid' => $cid, 'created' => $time, 'author' => $user['screenName'], 'authorId' => $user['uid'], 'ownerId' => $user['uid'], 'text' => $thisText, 'url' => $user['url'], 'mail' => $user['mail'], 'agent' => $agent, 'ip' => '1.1.1.1'));

                $insertId = $db->query($insert);
                $row = $db->fetchRow($db->select('commentsNum')->from('table.contents')->where('cid = ?', $cid));
                $db->query($db->update('table.contents')->rows(array('commentsNum' => (int) $row['commentsNum'] + 1))->where('cid = ?', $cid));
                $queryTable = $db->fetchRow($db->select()->from('table.comments')->where('cid = ?', $cid)->where('created = ?', $time));
                $circle_data = array(
                    'coid' => $queryTable['coid'],
                    'location' => '',
                    'private' => false,
                    'resources' => parseCircleContent($_POST['content'], $options,$_POST['openid'],'image')['images'],
                );
                $db->query($db->insert('table.bscore_friendcircle_data')->rows($circle_data));
                echo '1';
            }
        } else {
            echo '-2';
        }
    } else {
        echo '-3';
    }  
    break;
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
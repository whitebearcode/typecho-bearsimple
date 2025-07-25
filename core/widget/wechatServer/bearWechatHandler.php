<?php
$db = \Typecho\Db::get();
use \EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use \EasyWeChat\OfficialAccount\Application;

function queryFileExist($type,$content){
    $pattern = "/($type->.*?@)/";
if (preg_match($pattern, $content)) {
    return true;
} else {
    return false;
}
}


function requestPost($url = '', $post_data = array())
{
    if (empty($url) || empty($post_data)) {
        return false;
    }

    $o = "";
    foreach ($post_data as $k => $v) {
        $o .= "$k=" . urlencode($v) . "&";
    }
    $post_data = substr($o, 0, -1);

    $postUrl = $url;
    $curlPost = $post_data;
    $ch = curl_init();
    //初始化curl
    curl_setopt($ch, CURLOPT_URL, $postUrl);
    //抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);
    //设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);
    //post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '0');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);  // 连接等待时间  
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);         // curl允许执行时间
    $data = curl_exec($ch);
    //运行curl
    curl_close($ch);

    return $data;
}

function push($content, $msg_type, $url, $postEncryptToken, $cid, $action,$msgid,$openid)
{
    $desp = array('cid' => $cid,  'content' => $content, 'action' => $action, 'msgid'=> $msgid, 'openid'=> $openid,'postEncryptToken' => md5("bearsimple!@#$%^&*()-=+@#$%$" . $postEncryptToken . "bearsimple!@#$%^&*()-=+@#$%$@#$%^&*"), 'msg_type' => $msg_type, 'agent' => 'weixin');
    $res = requestPost($url, $desp);
    return $res;
}

class BearWechatHandler implements EventHandlerInterface
{
    public function handle($message = null)
    {
        $openid = $message['FromUserName'];
       $db = \Typecho\Db::get();
       $prefix = $db->getPrefix();
       $options = Helper::options();
       $bsoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
        $arr = $db->fetchRow($db->query("SELECT * FROM `{$prefix}bscore_wechat_data` WHERE openid='{$openid}'"));
        $url = Helper::options()->siteUrl.'index.php/wechatServer';
        $postEncryptToken = Helper::options()->openId;
        
        $content = $arr['content'];
        if($bsoptions['wechat_circleSendText'] == '' || $bsoptions['wechat_circleSendText'] == 'openid' || $bsoptions['wechat_circleSendText'] == '绑定' || $bsoptions['wechat_circleSendText'] == '解除绑定' || $bsoptions['wechat_circleSendText'] == '解绑' || $bsoptions['wechat_circleSendText'] == '帮助' || $bsoptions['wechat_circleSendText'] == '取消' || $bsoptions['wechat_circleSendText'] == '发表'){
         $wechat_circleSendText = '发朋友圈';   
        }
        else{
         $wechat_circleSendText = $bsoptions['wechat_circleSendText'];
        }
        if($bsoptions['wechat_service'] == false){
           return "您未开启微信公众号服务，无法通过公众号发送微语，请前往 [Bearsimple主题配置中心 - 实验室 - 微信公众号服务] 进行开启~~~";
           die;
        }
        switch ($message['Content']) {
            case 'openid':
                return $message['FromUserName'];
                break;
           case "绑定":
                if (isset($options->openId)) {
                    return "您已完成绑定，无法重复绑定";
                } else {
                    
               if($db->query($db->update('table.options')->rows(array(
                'value' => $message['FromUserName']))
                        ->where('name = ?', 'openId')) &&  $db->query($db->insert('table.bscore_wechat_data')->rows(array('openid'=>$message['FromUserName'])))){
                            
                    return "绑定成功！";
                        }
                        else{
                      return "绑定失败，请稍后重试或前往BearTalk社区或QQ群寻求帮助！";      
                        }
                
                }
                break;
            case "解除绑定":
            case "解绑":
                if ($db->query($db->update('table.options')->rows(array(
                'value' => null))
                        ->where('name = ?', 'openId')) && $db->query($db->delete('table.bscore_wechat_data')->where('openid = ?', $message['FromUserName']))) {
                    return "解除绑定完成！";
                } else {
                    return "操作失败，未知错误";
                }
                break;
            case "帮助":
                return '帮助中心暂未构建完成~~~';
                break;
            default:
                if (isset($openid)) {
                    switch ($message['Content']) {
                       
                        default:
                            switch ($message['Content']) {
                     case $wechat_circleSendText:
                              $ifCircle = $db->fetchRow($db->select()->from('table.contents')->where('cid = ?', $bsoptions['wechat_choose'])->where('template = ?', 'friendcircle.php'));
                              if(!$ifCircle){
                                  return '当前所选择的页面非朋友圈模板，请前往 [Bearsimple主题配置中心 - 实验室 - 微信公众号服务] 重新选择';
                              }
                              else{
                                    $msg_type = 'mixed_circle';
                                    $db->query("update `{$prefix}bscore_wechat_data` set msg_type='$msg_type',content='' where openid='$openid'");
                                    return "当前处于朋友圈模式，可混合发送图片、文字、语音或视频(图片、语音和视频仅限发送其中一项)，发送『发表』进行发表朋友圈，发送『取消』取消本次发送~";
                              }
                                    break;
                    case "取消":
                        $db->query("update `{$prefix}bscore_wechat_data` set msg_type='',content='' where openid='$openid'");
                        return '操作已取消';
                                   break;
                    case "发表":
                                    $arr = $db->fetchRow($db->query("SELECT * FROM `{$prefix}bscore_wechat_data` WHERE openid='{$openid}'"));
                                    $str = $arr['content'];
                                    if ($str == null) {
                                        $db->query("update `{$prefix}bscore_wechat_data` set msg_type='',content='' where openid='$openid'");
                                        return "发表内容为空，取消操作";//这里因为微信服务器逻辑，超过5s会重试
                                        exit();
                                    }
                                    $msg_type = $arr['msg_type'];
                                    $arr = mb_split('@', $str);
                                    $m = count($arr);
                                    for ($i = 0; $i < $m - 1; $i++) {
                                        $con[$i] = mb_split('->', $arr[$i]);
                                    }
                                    $m1 = count($con);
                                    for ($m = 0; $m < $m1; $m++) {
                                        $result[$m] = array('type' => $con[$m][0], 'content' => $con[$m][1]);
                                    }
                                    $content = array('results' => $result);
                                     $status = push(json_encode($content), $msg_type, $url, $postEncryptToken, $bsoptions['wechat_choose'], 'sendCircle',$message['MsgId'],$openid);
                                    $db->query("update `{$prefix}bscore_wechat_data` set msg_type='',content='' where openid='$openid'");
                                    switch ($status) {
                                        case "1":
                                            return "朋友圈发表成功~";
                                           break;
                                                case "-1":
                                                    return "参数错误，请稍后重试！";
                                                    break;
                                                case "-2":
                                                    return "系统核验身份信息错误，请稍后重试！";
                                                    break;
                                                case "-3":
                                                    return "必要性数据缺失，请检查是否已填写好配置信息或可以发送“解绑”并发送“绑定”后再试！";
                                                    break;
                                                default:
                                                    return $status;
                                    }
                                    break;
                                default:
                                    $arr = $db->fetchRow($db->query("SELECT * FROM `{$prefix}bscore_wechat_data` WHERE openid='{$openid}'"));
                                    $buffer = $arr['content'];
                                    $type = $arr['msg_type'];
                                    switch ($message['MsgType']) {
                                        case "image":
                                    if(queryFileExist('voice',$buffer) == true){
                                        return '检测到本次发送内容中已包含音频文件，无法继续发送图片~';
                                    }
                                    if(queryFileExist('video',$buffer) == true){
                                        return '检测到本次发送内容中已包含视频文件，无法继续发送图片~';
                                    }
                                            $content = $message['PicUrl'];
                                            $msg_type = "image";
                                            if ($type == 'mixed_circle') {
                                                $content = $buffer . $msg_type . "->" . $content . "@";
                                            }
                                            if($buffer){
                                        $pattern = '/(image->.*?@)/';
preg_match_all($pattern, $buffer, $matches);
$count = count($matches[1]);
if($count == 9){
    return '图片数量已达最大数量九张~~';
}
else{
                                            $db->query("update `{$prefix}bscore_wechat_data` set content='$content' where openid='$openid'");
}
                                            }
                                            else{
                                            $db->query("update `{$prefix}bscore_wechat_data` set content='$content' where openid='$openid'");    
                                            }
                                            break;
                                        case "text":
                                                $content = $message['Content'];
                                                if($content == '[收到不支持的消息类型，暂无法显示]'){
                                                    return '检测到您发送的是当前不支持的表情包，请重新发送';
                                                }
                                            $msg_type = "text";
                                          if ($type == 'mixed_circle') {
                                                $content = $buffer . $msg_type . "->" . $content . "@";
                                            }
                                            $db->query("update `{$prefix}bscore_wechat_data` set content='$content' where openid='$openid'");
                                            break;
                                            
                                        case "voice":
                                            if(!in_array($message['Format'], $options->allowedAttachmentTypes)){
                                            return '检测到您未将'.$message['Format'].'格式添加到允许上传的文件类型中，请前往Typecho后台-设置-基本设置中添加！';    
                                            }
                                            if(queryFileExist('image',$buffer) == true){
                                        return '检测到本次发送内容中已包含图片文件，无法继续发送语音~';
                                    }
                                    if(queryFileExist('video',$buffer) == true){
                                        return '检测到本次发送内容中已包含视频文件，无法继续发送语音~';
                                    }
                                            $content = $message['MediaId'].'!'.$message['Format'];
                                            $msg_type = "voice";
                                            if ($type == 'mixed_circle') {
                                                $content = $buffer . $msg_type . "->" . $content . "@";
                                            }
                                            if($buffer){
                                        $pattern = '/(voice->.*?@)/';
preg_match_all($pattern, $buffer, $matches);
$count = count($matches[1]);
if($count == 1){
    return '当前仅能发送一条语音哦~';
}
else{
                                            $db->query("update `{$prefix}bscore_wechat_data` set content='$content' where openid='$openid'");
}
                                            }
                                            else{
                                            $db->query("update `{$prefix}bscore_wechat_data` set content='$content' where openid='$openid'");    
                                            }
                                            break;
                                            case "video":
                                                if(!in_array('mp4', $options->allowedAttachmentTypes)){
                                            return '检测到您未将mp4格式添加到允许上传的文件类型中，请前往Typecho后台-设置-基本设置中添加！';    
                                            }
                                            if(queryFileExist('image',$buffer) == true){
                                        return '检测到本次发送内容中已包含图片文件，无法继续发送视频~';
                                    }
                                    if(queryFileExist('voice',$buffer) == true){
                                        return '检测到本次发送内容中已包含音频文件，无法继续发送视频~';
                                    }
                                            $content = $message['MediaId'].'!'.'mp4';
                                            $msg_type = "video";
                                            if ($type == 'mixed_circle') {
                                                $content = $buffer . $msg_type . "->" . $content . "@";
                                            }
                                            if($buffer){
                                        $pattern = '/(video->.*?@)/';
preg_match_all($pattern, $buffer, $matches);
$count = count($matches[1]);
if($count == 1){
    return '当前仅能发送一条视频哦~';
}
else{
                                            $db->query("update `{$prefix}bscore_wechat_data` set content='$content' where openid='$openid'");
}
                                            }
                                            else{
                                            $db->query("update `{$prefix}bscore_wechat_data` set content='$content' where openid='$openid'");    
                                            }
                                            break;
                                        default:
                                            return "不支持的消息类型";
                                            exit();
                                    }
                                    $arr = $db->fetchRow($db->query("SELECT * FROM `{$prefix}bscore_wechat_data` WHERE openid='{$openid}'"));
                                    $content = $arr['content'];
                                    $type = $arr['msg_type'];
                                    switch ($type) {
                                       case 'mixed_circle':
                                            return "请继续，发送『发表』进行发表朋友圈，发送『取消』取消本次发送~";
                                            break;
                                        default:
                                            $status = push($content, $msg_type, $url, $postEncryptToken, $bsoptions['wechat_choose'],'saysTalk',$message['MsgId'],$openid);
                                            $db->query("update `{$prefix}bscore_wechat_data` set msg_type='',content='' where openid='$openid'");
                                            switch ($status) {
                                                case "1":
                                                    return "信息发送成功~~~";
                                                    break;
                                                case "-1":
                                                    return "参数错误，请稍后重试！";
                                                    break;
                                                case "-2":
                                                    return "系统核验身份信息错误，请稍后重试！";
                                                    break;
                                                case "-3":
                                                    return "必要性数据缺失，请检查是否已填写好配置信息！";
                                                    break;
                                                default:
                                                    return $status;
                                            }
                                    }
                            }
                    }
                } else {
                    return "操作错误";
                }
        }
    }
}

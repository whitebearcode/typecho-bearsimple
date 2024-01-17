<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    use Typecho\Db;
use Typecho\Common;
use Widget\Options;
    $options = Helper::options();
    $temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
    $removeChar = ["https://", "http://", "/"]; 
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
        if(!$_POST['SecurityToken']){
 $this->response->throwJson([
            'code'=> 0,
            'msg' => '鉴权失败',
    ]);         
        }
        if($_POST['SecurityToken'] !== \BsCore\Plugin::getSecurity('get','__typecho_security_token')){
    $this->response->throwJson([
            'code'=> 0,
            'msg' => '鉴权失败',
    ]);
}

if ($temoptions['VerifyChoose']== '2-3' && !empty($temoptions['geeid']) && !empty($temoptions['geekey']) && $temoptions['backendVerify_Geetest'] == true) {
      $captcha_id = $temoptions['geeid'];
$captcha_key = $temoptions['geekey'];
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
$res = \BsCore\Plugin::post_request($url,$query);
$obj = json_decode($res,true);

if($obj['status'] == 'success' && $obj['result'] == 'fail'){
   $this->response->throwJson([
            'code'=> 0,
            'msg' => "抱歉，您未通过人机验证，原因:".$obj['reason'],
    ]);
}
if($obj['status'] == 'error' && $obj['code']){
    $this->response->throwJson([
            'code'=> 0,
            'msg' => "抱歉，您未通过人机验证，错误码:".$obj['code']."，原因:".$obj['msg'],
    ]);
}

  }
if ($temoptions['VerifyChoose'] == '22-2'){
            $answer = $_POST['answer'];
            $ganswer = \BsCore\Plugin::getSecurity('get','__typecho_comment_question_answer');
             switch($answer){
        case $ganswer:
        break;
        case null:
            $this->response->throwJson([
            'code'=> 0,
            'msg' => "对不起，请输入验证码。",
    ]);
        break;
        default:
           $this->response->throwJson([
            'code'=> 0,
            'msg' => "对不起，验证码错误，请重试。",
    ]);
         }
         }
       if ($temoptions['VerifyChoose'] == '1' || $temoptions['VerifyChoose'] == '11'){
    
           $sum = $_POST['sum'];

           switch($_POST['spam_protection_mathstyle']){
               case 'addition':
                   switch($sum){
        case $_POST['num1'] + $_POST['num2']:
                  
        break;
        case null:
        $this->response->throwJson([
            'code'=> 0,
            'msg' => "对不起，请输入验证码。",
    ]);
        break;
        default:
       $this->response->throwJson([
            'code'=> 0,
            'msg' => "对不起，验证码错误，请重试。",
    ]);
    }
                   break;
               case 'subtraction':
                    switch($sum){
        case $_POST['num1'] - $_POST['num2']:
        break;
        case null:
        $this->response->throwJson([
            'code'=> 0,
            'msg' => "对不起，请输入验证码。",
    ]);
        break;
        default:
        $this->response->throwJson([
            'code'=> 0,
            'msg' => "对不起，验证码错误，请重试。",
    ]);
    }
                   break;
           }
       } 
      if ($temoptions['VerifyChoose']== '2-2' && !empty($temoptions['turnstile_key']) && !empty($temoptions['turnstile_secretkey']) && $temoptions['backendVerify_Turnstile'] == true) {
     if(empty($_POST['cf-turnstile-response'])){
			$this->response->throwJson([
            'code'=> 0,
            'msg' => "抱歉，系统检测到您的验证密钥已失效，需重新验证！",
    ]);
     }
     elseif (isset($_POST['cf-turnstile-response'])) {
$response_data =  \BsCore\Plugin::getTurnstileResult($_POST['cf-turnstile-response'], $temoptions['turnstile_secretkey']);
if (!$response_data['success']){
                //throw new Typecho_Widget_Exception(_t(self::getTurnstileResultMsg($response_data)),200);
                $this->response->throwJson([
            'code'=> 0,
            'msg' =>  \BsCore\Plugin::getTurnstileResultMsg($response_data),
    ]);
            }
        } else {
            //throw new Typecho_Widget_Exception(_t('加载验证码失败, 请检查你的网络'),200);
            $this->response->throwJson([
            'code'=> 0,
            'msg' => "加载验证码失败, 请检查你的网络",
    ]);
        }

 }
 
 
        if ($temoptions['VerifyChoose']== '2' && !empty($temoptions['vid']) && !empty($temoptions['vkey']) && $temoptions['backendVerify_Vaptcha'] == true) {
     if(empty($_POST['vaptcha_server']) || empty($_POST['vaptcha_token'])){
			//throw new \Typecho\Widget\Exception("抱歉，系统检测到您的验证密钥已失效，需重新验证！",200); 
			$this->response->throwJson([
            'code'=> 0,
            'msg' => "抱歉，系统检测到您的验证密钥已失效，需重新验证！",
    ]);
     }
 $url = $_POST['vaptcha_server'];
 $data = array(
     'id'=> $temoptions['vid'],
     'secretkey' => $temoptions['vkey'],
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
			//throw new \Typecho\Widget\Exception("抱歉，您未通过人机验证，原因:".$result['msg'],200);
			$this->response->throwJson([
            'code'=> 0,
            'msg' => "抱歉，您未通过人机验证，原因:".$result['msg'],
    ]);
    }
 }

 if ($temoptions['VerifyChoose']== '2-1' && !empty($temoptions['dx_domain']) && !empty($temoptions['dx_appId']) && !empty($temoptions['dx_appSecret']) && $temoptions['backendVerify_Dingxiang'] == true) {
     
     if(empty($_POST['dx_token'])){
			//throw new \Typecho\Widget\Exception("抱歉，系统检测到您的验证密钥已失效，需重新验证！",200); 
			$this->response->throwJson([
            'code'=> 0,
            'msg' => "抱歉，系统检测到您的验证密钥已失效，需重新验证！",
    ]);
     }
   $appId = $temoptions['dx_appId'];
$appSecret = $temoptions['dx_appSecret'];
$client = new CaptchaClient($appId,$appSecret);
$client->setTimeOut(2);
$client->setCaptchaUrl("https://".$temoptions['dx_domain']."/api/tokenVerify");
$response = $client->verifyToken($_POST['dx_token']);
if(!$response->result){
			$this->response->throwJson([
            'code'=> 0,
            'msg' => "抱歉，您未通过人机验证，请返回重试。",
    ]);
}
 }  
  
    if(empty($_POST['contactmail'])){
        $_POST['contactmail'] = '无';
    }
    $db= \Typecho\Db::get();
        $link = array(
                'friendname' => htmlspecialchars($_POST['friendname'],ENT_QUOTES,'UTF-8'),
                'friendurl' => htmlspecialchars($_POST['friendurl'],ENT_QUOTES,'UTF-8'),
                'friendpic' => htmlspecialchars($_POST['friendpic'],ENT_QUOTES,'UTF-8'),
                'frienddec' => htmlspecialchars($_POST['frienddec'],ENT_QUOTES,'UTF-8'),
                'contactmail' => htmlspecialchars($_POST['contactmail'],ENT_QUOTES,'UTF-8'),
                'checkurl' => htmlspecialchars($_POST['checkurl'],ENT_QUOTES,'UTF-8'),
                'status' => 'waiting'
            );
            $db->query($db->insert('table.bscore_friendlinks')->rows($link));
            if($temoptions['FriendLinkSubmitSendMail'] == true && $temoptions['Smtp_open'] == true){
             file_get_contents(Common::url('/action/' . BsCore_Plugin::$action, Options::alloc()->index).'?do=linkMail&type=notifyaccept'.'&friendname='.$_POST['friendname']);   
            }
            $this->response->throwJson([
            'code'=> 1,
            'msg' => 'success',
    ]);
    }
    else{
        $this->response->throwJson([
            'code'=> 0,
            'msg' => '鉴权失败',
    ]);
}
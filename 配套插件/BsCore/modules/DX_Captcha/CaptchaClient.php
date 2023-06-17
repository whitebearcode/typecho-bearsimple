<?php

/**
 * Created by PhpStorm.
 * User: dingxiang-inc
 * Date: 2017/8/24
 * Time: 21:05
 */
include ("model/CaptchaResponse.php");

class CaptchaClient
{
    private $captchaUrl = "https://cap.dingxiang-inc.com/api/tokenVerify";     // 顶象验证码服务后台token验证URL
    private $appId;
    private $appSecret;
    private $captchaResponse;
    private $timeout = 2;

    function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function setTimeOut($timeout) {
        if ($timeout < 0) {
            # code...
            return;
        }
        $this->timeout = $timeout;
    }
    public function setCaptchaUrl($captchaUrl) {
        $this->captchaUrl = $captchaUrl;
    }

    public function verifyToken($token)
    {
        $captchaResponse = new CaptchaResponse(false, "");

        if (is_null($this->appId) || is_null($this->appSecret) || is_null($token)) {
            $captchaResponse->setServerStatus("参数错误");
            return $captchaResponse;
        }

        $params = explode(":", $token);
        $constId = null;
        if (count($params) == 2) {
            $constId = $params[1];
        }
        $sign = md5($this->appSecret.$params[0].$this->appSecret);

        $requestUrl = $this->captchaUrl . "?appKey=" . $this->appId . "&constId=" . $constId . "&token=" . $params[0]."&sign=".$sign;

        $httpResponse = $this->do_request($requestUrl, $this->timeout, $captchaResponse);
    
        return $captchaResponse;
    }


    private function do_request($requestUrl, $timeout, $captchaResponse)
    {
        $params = array('http' => array(
            'method' => 'GET',
            'header' => 'Content-type:text/html',
            'timeout' => $timeout
        ));
        $ctx = stream_context_create($params);

        $fp = @fopen($requestUrl, 'r', false, $ctx);

        if (!$fp) {
            $this->setResponse($captchaResponse, "server connect failed!", $fp);
            return;
        }
  
        $response = @stream_get_contents($fp);
        if ($response === false) {
            $this->setResponse($captchaResponse, "get response failed!", $fp);
            $this->close($fp);
            return;
        }
    
        $obj = json_decode($response);
        
        if ($obj == null) {
            $this->setResponse($captchaResponse, "get response failed!", $fp);
            $this->close($fp);
            return;
        }
        $captchaResponse->setServerStatus("SERVER_SUCCESS");
        $captchaResponse->setResult($obj->success);

        $this->close($fp);
    }

    public function __set($property_name, $value)
    {
        $this->$property_name = $value;
    }

    public function setResponse($captchaResponse, $msg, $fp) {
        $captchaResponse->setResult(true);
        $captchaResponse->setServerStatus($msg);
        $this->close($fp);
    }

    public function close($fp){
        try {
            if ($fp != null) {
                fclose($fp);
            }
        } catch (Exception $e) {
            echo "close error:" . $e->getMessage();
        }
    }
}
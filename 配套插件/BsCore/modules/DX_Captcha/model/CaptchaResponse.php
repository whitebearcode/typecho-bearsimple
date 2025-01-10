<?php
class CaptchaResponse
{
    public $result;             // 调用结果
    public $serverStatus;       // 标记调用服务状态 "" 表示调用正常 不为空，表明调用服务异常

    public function __construct($result, $serverStatus){
    	$this->result = $result;
    	$this->serverStatus = $serverStatus;
    }

    public function setResult($result){
    	$this->result = $result;
    }

    public function setServerStatus($serverStatus){
    	$this->serverStatus = $serverStatus;
    }
}
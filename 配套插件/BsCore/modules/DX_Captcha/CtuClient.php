<?php
/**
 * Created by PhpStorm.
 * User: dingxiang-inc
 * Date: 2017/8/19
 * Time: 下午1:29
 */


include ("./model/CtuRequest.php");
include ("./model/CtuResponse.php");
include ("./util/SignUtil.php");

class CtuClient
{
    public $url;           // 风险防控服务URL
    public $appId;         // 颁发的公钥,可公开
    public $appSecret;     // 颁发的秘钥,严禁公开,请保管好,千万不要泄露!
    public $connectTimeout = 3000;
    public $connectionRequestTimeout = 2000;
    public $socketTimeout = 5000;
    const UTF8_ENCODE = "UTF-8";
    const VERSION = 1;     //client版本号  从1开始

    /**
     * CtuClient constructor.
     * @param $url
     * @param $appId
     * @param $appSecret
     */
    public function __construct($url, $appId, $appSecret)
    {
        $this->url = $url;
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    /**
     * @param $ctuRequest
     */
    public function checkRisk($ctuRequest, $timeout) {
        // 计算签名
        $sign = SignUtil::sign($this->appSecret, $ctuRequest);
        // 拼接请求URL
        $requestUrl = $this->url ."?appKey=". $this->appId ."&sign=". $sign. "&version=". CtuClient::VERSION;
        $reqJsonString = json_encode($ctuRequest, JSON_UNESCAPED_UNICODE);
        $data = base64_encode($reqJsonString);

        return $this -> do_post_request($requestUrl, $data, $timeout);
    }

    public function do_post_request($url, $data, $timeout = 2)
    {
        $ctuResponse = new CtuResponse("");
        $params = array('http' => array(
            'method' => 'POST',
            'content' => $data,
            'header' => 'Content-type:text/html',
            'timeout' => $timeout
        ));

        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            $ctuResponse->result = array('riskLevel' => 'ACCEPT', 'msg' => 'server connect failed!');
            $this->close($fp);
            return json_encode($ctuResponse, JSON_FORCE_OBJECT);
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            $ctuResponse->result = array('riskLevel' => 'ACCEPT', 'msg' => 'get response failed!');
            $this->close($fp);
            return json_encode($ctuResponse, JSON_FORCE_OBJECT);
        }
        $this->close($fp);
        return $response;
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




























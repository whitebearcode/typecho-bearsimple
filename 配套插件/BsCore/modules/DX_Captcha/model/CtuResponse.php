<?php
/**
 * Created by PhpStorm.
 * User: dingxiang-inc
 * Date: 2017/8/19
 * Time: 下午12:45
 */

class CtuResponse
{
    public $uuid;              // 服务端返回的请求标识码，供服务端排查问题
    public $status;            // 状态码
    public $result;            // 防控结果

    /**
     * CtuResponse constructor.
     * @param $uuid
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
    }

}
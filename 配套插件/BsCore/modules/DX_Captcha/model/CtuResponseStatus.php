<?php
/**
 * Created by PhpStorm.
 * User: dingxiang-inc
 * Date: 2017/8/19
 * Time: 下午12:50
 */

class CtuResponseStatus
{
    const SUCCESS = "成功";
    const INVALID_REQUEST_PARAMS = "请求不合法,缺少必须参数";
    const INVALID_REQUEST_BODY = "请求不合法,请求body为空";
    const INVALID_REQUEST_NO_EVENT_DATA = "请求不合法,请求事件的数据为空";
    const INVALID_REQUEST_SIGN = "请求签名错误";
    const INVALID_APP_ID = "不合法的appId";
    const INVALID_EVENT_CODE = "不合法的事件";
    const INVALID_APP_EVENT_RELATION = "应用和事件的绑定关系错误";
    const EVENT_GRAY_SCALE = "事件有灰度控制,非灰度请求";
    const NO_POLICY_FOUND = "没有找到防控策略";
    const POLICY_HAS_ERROR = "防控策略配置有错误";
    const NOT_SUPPORTED_POLICY_OPERATOR = "不支持防控策略里的操作符";
    const QPS_EXCEEDING_MAXIMUM_THRESHOLD = "QPS超过最大阀值";
    const SERVICE_INTERNAL_ERROR = "服务器内部错误";


}


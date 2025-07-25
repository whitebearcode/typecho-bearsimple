<?php
/**
 * Created by PhpStorm.
 * User: dingxiang-inc
 * Date: 2017/8/19
 * Time: 下午1:01
 */

class CtuResult
{
    public $riskLevel;           // 请求的风险级别
    public $riskType;            // 风险类型
    public $hitPolicyCode;       // 命中策略code
    public $hitPolicyName;       // 命中策略标题
    public $hitRules;            // 命中规则
    public $suggestPolicies;     // 建议防控策略
    public $suggestion;          // 命中策略处置建议
    public $flag;                // 客户端请求带上来的标记
    public $extraInfo;           // 附加信息

    /**
     * CtuResult constructor.
     * @param $riskLevel
     */
    public function __construct($riskLevel)
    {
        $this->riskLevel = $riskLevel;
    }

    public function hasRisk() {
        return $this->riskLevel == RiskLevel::REJECT || $this->riskLevel == RiskLevel::REVIEW;
    }

}
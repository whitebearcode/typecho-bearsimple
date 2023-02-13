<?php
/**
 * Created by PhpStorm.
 * User: dingxiang-inc
 * Date: 2017/8/19
 * Time: 下午1:05
 */

class HitRule
{
    public $id;
    public $leftValue;

    /**
     * HitRule constructor.
     * @param $id
     * @param $leftValue
     */
    public function __construct($id, $leftValue)
    {
        $this->id = $id;
        $this->leftValue = $leftValue;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: dingxiang-inc
 * Date: 2017/8/19
 * Time: 下午1:09
 */

class SuggestPolicy
{
    public $code;
    public $name;

    /**
     * SuggestPolicy constructor.
     * @param $code
     * @param $name
     */
    public function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

}
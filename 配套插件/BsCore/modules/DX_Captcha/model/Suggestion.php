<?php
/**
 * Created by PhpStorm.
 * User: dingxiang-inc
 * Date: 2017/11/30
 * Time: 下午8:30
 */

class Suggestion
{
    public $code;
    public $message;

    /**
     * Suggestion constructor.
     * @param $code
     * @param $message
     */
    public function __construct($code, $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

}
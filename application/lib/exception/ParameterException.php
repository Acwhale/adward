<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/14
 * Time: 14:51
 */

namespace app\lib\exception;


class ParameterException extends BaseException {
    public $code = 400;
    public $msg = '参数错误';
    public $errcode = 10000;

}
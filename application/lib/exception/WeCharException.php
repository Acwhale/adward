<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/20
 * Time: 17:45
 */

namespace app\lib\exception;


class WeCharException extends BaseException {
    public $code = 400;
    public $msg = '微信接口调用失败';
    public $errcode = 999;
}
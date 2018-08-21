<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/21
 * Time: 14:28
 */

namespace app\lib\exception;


class TokenException extends BaseException {
    public $code = 401;
    public $msg = '无效token或者token失效';
    public $errcode = 10001;
}
<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/9/1
 * Time: 11:04
 */

namespace app\lib\exception;


class PrepareOrderCException extends BaseException {
    public $code =404;
    public $msg  = '请做好相关微信支付的配置';
    public $errcode = 10001;
}
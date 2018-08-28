<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/28
 * Time: 14:07
 */

namespace app\lib\exception;


class OrderException extends BaseException {
    public $code = 404;
    public $msg = '订单不存在，请检查ID';
    public $errcode = 80000;
}
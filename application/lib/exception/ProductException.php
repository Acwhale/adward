<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 11:01
 */

namespace app\lib\exception;


class ProductException extends BaseException {
    public $code= 404;
    public $msg = '指定参数不存在，请检查参数';
    public $errcode = 20000;
}
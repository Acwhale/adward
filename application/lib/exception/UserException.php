<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/22
 * Time: 15:28
 */

namespace app\lib\exception;


class UserException extends BaseException {
    public $code = 404;
    public $msg = '用户不不存在';
    public $errcode = 60000;
}
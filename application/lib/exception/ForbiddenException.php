<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/27
 * Time: 14:33
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException {
    public $code = 403;
    public $msg ='权限不够';
    public $errcode = '10001';
}
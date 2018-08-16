<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/16
 * Time: 16:39
 */

namespace app\lib\exception;


class ThemeException extends BaseException {
    public $code = 404;
    public $msg = '请求的主题不存在，请检查主题ID';
    public $errcode = 30000;
}
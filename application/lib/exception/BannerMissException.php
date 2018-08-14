<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/14
 * Time: 10:23
 */

namespace app\lib\exception;


class BannerMissException extends BaseException {
    public $code = 404;
    public $msg = '请求的banner不存在';
    public $errcode = 40000;
}
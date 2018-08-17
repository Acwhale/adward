<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 14:04
 */

namespace app\lib\exception;


class CategoryException extends BaseException {
    public $code = 404;
    public $msg = '指定的类目不存在,请检查';
    public $errcode = 50000;
}
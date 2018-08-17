<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 18:51
 */

namespace app\api\validate;


class TokenGet extends BaseValidate {
    protected $rule = [
        'code'=>'require|isNotEmpty'
    ];
    protected $message =[
        'code'=>'没有code，还想获取，抓梦jio'
    ];
}
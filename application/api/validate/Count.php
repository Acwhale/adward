<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 10:48
 */

namespace app\api\validate;


class Count extends BaseValidate {
    protected $rule = [
        'count'=>'isPositiveInteger|between:1,15'
    ];
}
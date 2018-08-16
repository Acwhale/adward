<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/13
 * Time: 19:00
 */

namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate {
    protected $rule = [
        'id'=>'require|isPositiveInteger',
    ];
    protected $message =[
      'id'=>'id必须是正整数'
    ];
}
<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/9
 * Time: 18:58
 */

namespace app\api\validate;


use think\Validate;

class TestValidate extends Validate {

    protected $rule =[
        'name'=>'require|max:10',
        'email'=>'email'
    ];
}
<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/22
 * Time: 14:02
 */

namespace app\api\validate;


class AddressNew extends BaseValidate {
    protected $rule =[
        'name'=>'require|isNotEmpty',
        'mobile'=>'require|isMobile',
        'province'=>'require|isNotEmpty',
        'city'=>'require|isNotEmpty',
        'country'=>'require|isNotEmpty',
        'detail'=>'require|isNotEmpty'
    ];
}
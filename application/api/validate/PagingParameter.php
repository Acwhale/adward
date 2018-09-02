<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/9/2
 * Time: 13:57
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate {
    protected $rule = [
        'page'=>'isPositiveInteger',
        'pageSize'=>'isPositiveInteger'
    ];
    protected $message =[
      'page'=>'分页参数必须是正整数',
      'pageSize'=>'分页参数必须是正整数',
    ];
}
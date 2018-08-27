<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/27
 * Time: 17:21
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderValidate extends BaseValidate {
//    参数形式如下
//    protected $products = [
//        [
//            'product_id'=>1,
//            'count'=>3
//        ],
//        [
//            'product_id'=>2,
//            'count'=>3
//        ],
//
//    ];
    protected $rule =[
        'products'=>'checkProducts'
    ];
    //子元素的验证
    protected $singleRule =[
        'product_id'=>'require|isPositiveInteger',
        'count'=>'require|isPositiveInteger'
    ];
    protected function checkProducts($values,$data='',$rule='',$filed=''){
        if(!is_array($values)){
            throw new ParameterException([
                'msg'=>'商品参数不正确'
            ]);
        }
        if(empty($values)){
            throw new ParameterException([
                'msg'=>'商品列表不能为空'
            ]);
        }
        foreach ($values as $value){
            $this->checkProduct($value);
        }
        return true;

    }
    protected function checkProduct($value){
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->batch()->check($value);
        if(!$result){
            throw new ParameterException([
                'msg'=>'商品列表参数错误'
            ]);
        }
    }
}
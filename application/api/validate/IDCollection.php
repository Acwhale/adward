<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/16
 * Time: 15:39
 */

namespace app\api\validate;


class IDCollection extends BaseValidate {
    protected $rule =[
      'ids'=>'require|checkIDs'
    ];
    protected $message = [
        'ids'=>'ids必须是已逗号分隔的正整数'
    ];
    protected function checkIDs($value,$rule='',$data='',$filed=''){
        $values = explode(',',$value);

        if(empty($values)){
            return false;
        }
        foreach ($values as $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}
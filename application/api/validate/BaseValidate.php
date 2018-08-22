<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/13
 * Time: 19:40
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate {
    public function goCheck(){
        $requset = Request::instance();
        $params = $requset->param();
        $result = $this->batch()->check($params);
        if(!$result){
            $e = new ParameterException([
                'msg'=>$this->error,
//                'code'=>400,
//                'errcode'=>10002
            ]);
//            $e->msg = $this->error;
            throw $e;
//            $error = $this->error;
//            throw new BaseException($error);
        }else{
            return true;
        }

    }

    protected function isPositiveInteger($value,$rule='',$data='',$filed=''){
        if(is_numeric($value) && is_int($value+0) &&($value+0)>0){
            return true;
        }else{
            return false;
        }
    }
    protected function isNotEmpty($value,$rule='',$data='',$filed=''){
        if(empty($value)){
            return false;
        }
        return true;
    }
    protected function isMobile($value,$rule='',$data='',$filed=''){
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule,$value);
        if(!$result){
            return false;
        }
        return true;
    }
    public function getDataByRule($arrays){
        if(array_key_exists('user_id',$arrays) | array_key_exists('uid',$arrays)){
            throw  new ParameterException([
                'msg'=>'参数中包含非法的user_id或者'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key =>$value){
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}
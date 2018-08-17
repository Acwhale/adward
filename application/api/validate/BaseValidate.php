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
}
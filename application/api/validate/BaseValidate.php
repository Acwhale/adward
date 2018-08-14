<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/13
 * Time: 19:40
 */

namespace app\api\validate;


use app\lib\exception\BaseException;
use app\lib\exception\ParameterException;
use think\Exception;
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
}
<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/14
 * Time: 10:21
 */

namespace app\lib\exception;


use think\Exception;
use Throwable;

class BaseException extends Exception {
    public $code = 400;
    public $msg ='参数错误';
    public $errcode = 10000;
    public function __construct($params=[]) {
        if(!is_array($params)){
            return ;
//            throw  new Exception('参数必须是数组');
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errcode',$params)){
            $this->errcode = $params['errcode'];
        }
    }
}
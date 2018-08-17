<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 18:56
 */

namespace app\api\service;


use think\Exception;

class UserToken {
    protected $code;
    protected $vxAppID;
    protected $vxAppSecret;
    protected $vxloginUrl;

    public function __construct($code) {
        $this->code=$code;
        $this->vxAppID = config('wx.appid');
        $this->vxAppSecret = config('wx.app_secret');
        $this->vxloginUrl = sprintf(config('wx.loginUrl'),$this->vxAppID,$this->vxAppSecret,$this->code);
    }

    public function get(){
       $result =  curl_get($this->vxloginUrl);
       $vxResult = json_decode($result,true);
       if(empty($vxResult)){
           throw  new Exception('获取session_key以及openID时异常，微信内部错误');
       }else{
           $loginFail = array_key_exists('errcode',$vxResult);
           if($loginFail){

           }else{

           }
       }
    }
}
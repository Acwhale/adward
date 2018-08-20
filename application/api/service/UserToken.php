<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 18:56
 */

namespace app\api\service;


use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\WeCharException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken {
    protected $code;
    protected $vxAppID;
    protected $vxAppSecret;
    protected $vxloginUrl;

    public function __construct($code) {
        $this->code=$code;
        $this->vxAppID = config('wx.appid');
        $this->vxAppSecret = config('wx.app_secret');
        $this->vxloginUrl = sprintf(config('wx.login_url'),$this->vxAppID,$this->vxAppSecret,$this->code);
    }

    /**
     * @throws Exception
     * 获取openid
     */
    public function get(){
       $result =  curl_get($this->vxloginUrl);
       $vxResult = json_decode($result,true);
       if(empty($vxResult)){
           throw  new Exception('获取session_key以及openID时异常，微信内部错误');
       }else{
           $loginFail = array_key_exists('errcode',$vxResult);
           if($loginFail){
                $this->processLoginError($vxResult);
           }else{
                $this->grantToken($vxResult);
           }
       }
    }

    /**
     * @param $vxResult
     * 颁发令牌：核对数据库是否去在openid，如果存在不处理，不存在则新增，生成令牌，存入缓存，令牌返回客户端
     * key:令牌
     * value：vxReslut,uid,scope
     */
    private function grantToken($vxResult){
        $openid = $vxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }
        $cachedVale = $this->prepareCacheValue($vxResult,$uid);
    }

    /**
     * 写入缓存
     * @param $cachedVale
     */
    private function saveToCache($cachedVale){
    }
    /**
     * 准备缓存数据
     * @param $vxResult
     * @param $uid
     */
    private function prepareCacheValue($vxResult,$uid){
        $cachedValue = $vxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = 16;//代表用户
        return $cachedValue;
    }

    /**
     * 插入一个用户，返回主键id
     * @param $openid
     * @return id
     */
    private function newUser($openid){
        $user = UserModel::create([
            'openid'=>$openid
        ]);
        return $user->id;
    }
    /**
     * @param $vxResult
     * @throws WeCharException
     * @des 微信异常处理
     */
    private function processLoginError($vxResult){
        throw new WeCharException([
            'msg' =>$vxResult['errmsg'],
            'errorCode'=>$vxResult['errcode']
        ]);
    }
}
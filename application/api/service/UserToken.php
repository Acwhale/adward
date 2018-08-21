<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 18:56
 */

namespace app\api\service;


use app\api\model\User as UserModel;
use app\lib\exception\TokenException;
use app\lib\exception\WeCharException;
use think\Exception;

class UserToken extends Token {
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
               return $this->grantToken($vxResult);
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
        $token = $this->saveToCache($cachedVale);
        return $token;
    }

    /**
     * 写入缓存
     * @param $cachedVale
     */
    private function saveToCache($cachedVale){
        $key = self::generateToken();
        $value = json_encode($cachedVale);
        $expire_in = config('setting.token_exprie_in');
        $result = cache($key,$value,$expire_in);
        if(!$result){
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errcode'=>10005
            ]);
        }
        return $key;
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
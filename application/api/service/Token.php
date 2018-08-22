<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/21
 * Time: 13:58
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token {
    /**
     * @return string
     * 生成token
     */
    public static function generateToken(){
        $randchars = getRandChar(32);
        $timetapme = $_SERVER['REQUEST_TIME'];
        $salt = config('secure.token_salt');
        return md5($randchars.$timetapme.$salt);
    }
    public static function getCurrentTokenVar($key){
        $token = Request::instance()->header('token');
        $vars  = Cache::get($token);
        if(!$vars){
            throw new TokenException();
        }else{
            if(!is_array($vars)){
                $vars = json_decode($vars,true);
                if(array_key_exists($key,$vars)){
                    return $vars[$key];
                }else{
                    throw new Exception('尝试获取的Token并不存在');
                }
            }
        }
    }
    /**
     * 获取当前用户的uid
     */
    public static function getCurrentUID(){
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }
}
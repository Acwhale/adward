<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/21
 * Time: 13:58
 */

namespace app\api\service;


use app\lib\enums\ScopeEnum;
use app\lib\exception\ForbiddenException;
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

    /**
     * 检查用户和cms都可以访问的权限
     * @return bool
     * @throws Exception
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function needPrimaryScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope>= ScopeEnum::USER){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw  new TokenException();
        }
    }

    /**
     * 只有用户可以访问的权限
     * @return bool
     * @throws Exception
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function needExclusiveScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope == ScopeEnum::USER){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    public static function isValidateOperate($checkedUID){
        if(!$checkedUID){
            throw  new  Exception('检查UID必须传入一个UID');
        }
        $currentOperateUID = self::getCurrentUID();
        if($currentOperateUID == $checkedUID){
            return true;
        }
        return false;
    }

    public static function verifyToken($token){
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        return false;
    }
}
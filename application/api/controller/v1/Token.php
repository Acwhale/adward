<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 18:48
 */

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;
use app\lib\exception\ParameterException;
use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token {
    public function getToken($code=''){
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token'=>$token
        ];
    }

    public function verifyToken($token =''){
    	if(!$token){
    		throw new ParameterException([
    			'token不能为空'
    		]);
    	}
    	$valiad = TokenService::verifyToken($token);
    	return [
    		'isValid'=>$valiad
    	];
    }
}

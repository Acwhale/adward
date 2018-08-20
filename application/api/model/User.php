<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 18:55
 */

namespace app\api\model;


class User extends BaseModel {
    public static function getByOpenID($openid){
        $user = self::where('openid','=',$openid)->find();
        return $user;
    }
}
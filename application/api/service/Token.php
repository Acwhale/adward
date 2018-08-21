<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/21
 * Time: 13:58
 */

namespace app\api\service;


class Token {
    public static function generateToken(){
        $randchars = getRandChar(32);
        $timetapme = $_SERVER['REQUEST_TIME'];
        $salt = config('secure.token_salt');
        return md5($randchars,$timetapme,$salt);
    }
}
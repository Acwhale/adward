<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/14
 * Time: 9:42
 */

namespace app\api\model;


use think\Db;
use think\Exception;

class Banner {
    public static function getBannerById($id){
        //todo:根据banner id获取banner信息
        $result  = Db::query('select * from banner_item where banner_id=?',[$id]);
        return $result;
    }
}
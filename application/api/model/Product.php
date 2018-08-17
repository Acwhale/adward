<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/16
 * Time: 15:23
 */

namespace app\api\model;


class Product extends BaseModel {
    protected $hidden =['delete_time','update_time','create_time','main_img_id','pivot','from','category_id'];
    public static function getMostRecent($count){
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }

    public static function getProductsByCategoryId($id){
        $products = self::where('category_id','=',$id)->select();
        return $products;
    }
}
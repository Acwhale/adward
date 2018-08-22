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

    public function getMainImgUrlAttr($value,$data){
        return $this->prefixUrl($value,$data);
    }
    //定义关联关系product product_img
    public function imgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }
    //定义关联关系
    public function properties(){
        return $this->hasMany('ProductProperty','product_id','id');
    }
    public static function getMostRecent($count){
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }

    public static function getProductsByCategoryId($id){
        $products = self::where('category_id','=',$id)->select();
        return $products;
    }

    /**
     * 获取商品详情
     * @param $id
     */
    public static function getProductDetail($id){
//        $product = self::with(['imgs.imgUrl'])->with(['properties'])
//            ->find($id);
        //闭包的方式对关联模型的字段进行排序
        $product = self::with([
            'imgs'=>function($query){
                $query->with(['imgUrl'])->order('order',' asc');
            }
        ])->with('properties')->find($id);
        return $product;
    }
}
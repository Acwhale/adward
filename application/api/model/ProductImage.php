<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/21
 * Time: 17:37
 */

namespace app\api\model;


class ProductImage extends BaseModel {
    protected $hidden = ['img_id','delete_id','product_id'];
    public function imgUrl(){
        return $this->belongsTo('Image','img_id','id');
    }
}
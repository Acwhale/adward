<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/16
 * Time: 15:24
 */

namespace app\api\model;


class Theme extends BaseModel {
    protected $hidden = ['update_time','delete_time','topic_img_id','head_img_id'];
    //一对一模型关联
    //belongsto使用的时候是在A表中有外键，需要和B表关联的时候使用belongsto
    //hasone是B表中没有外键，而外键是是在需要关联的A表中的时候需要用hasone
    public function topicImg(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public function headImg(){
        return $this->belongsTo('Image','head_img_id','id');
    }
    //定义多对多关系
    public function products(){
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    public static function getThemeWithProducts($id){
        $theme= self::with(['products','topicImg','headImg'])->find($id);
        return $theme;
    }
}
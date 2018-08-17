<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 13:56
 */

namespace app\api\model;


class Category extends BaseModel {
    protected $hidden=['delete_time','update_time','create_time'];
    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }
}
<?php

namespace app\api\model;

use think\Model;

class BannerItem extends Model {
    //隐藏不必要属性
    protected $hidden = ['id','banner_id','update_time','img_id','delete_time'];
    //
    public function img(){
        return $this->belongsTo('Image','img_id','id');
    }
}

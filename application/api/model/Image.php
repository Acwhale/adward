<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/15
 * Time: 19:09
 */

namespace app\api\model;



use app\lib\enums\ImageFrom;
use think\Model;


class Image extends Model {
    //隐藏不必要属性
    protected $hidden =['id','from','update_time','delete_time'];
    //读取器
    public function getUrlAttr($value,$data){
        $finalUrl = $value;
        if($data['from'] == ImageFrom::FROM_LOCAL){
            $prefix = config('setting.img_prefix')?config('setting.img_prefix'):'http://z.cn/images';
            return $prefix.$finalUrl;
        }
        return $finalUrl;
    }

}
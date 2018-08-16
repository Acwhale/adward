<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/16
 * Time: 14:45
 */

namespace app\api\model;


use app\lib\enums\ImageFrom;
use think\Model;

class BaseModel extends Model {
    //获取完整图片URl
    protected function prefixUrl($value,$data){
        $finalUrl = $value;
        if($data['from'] == ImageFrom::FROM_LOCAL){
            $prefix = config('setting.img_prefix')?config('setting.img_prefix'):'http://z.cn/images';
            return $prefix.$finalUrl;
        }
        return $finalUrl;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/15
 * Time: 19:09
 */

namespace app\api\model;



class Image extends  BaseModel {
    //隐藏不必要属性
    protected $hidden =['id','from','update_time','delete_time'];
    //读取器
    public function getUrlAttr($value,$data){
        return $this->prefixUrl($value,$data);
    }

}
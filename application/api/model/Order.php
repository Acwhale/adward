<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/28
 * Time: 17:28
 */

namespace app\api\model;


class Order extends BaseModel {
    protected $hidden = ['user_id','delete_time','update_time'];
    //自动写入时间戳
    protected $autoWriteTimestamp = true;
    //修改时间戳的字段名与数据库保持一致。
//    protected $createTime = 'create_times';
//    protected $updateTime = 'update_times';
    public static function getSummaryByUser($uid,$page,$pageSize){
        return self::where('user_id','=',$uid)->
        order('create_time desc')->paginate($pageSize,true,['page'=>$page]);
    }
    public function getSnapItemsAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }
    public function getSnapAddressAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }
}
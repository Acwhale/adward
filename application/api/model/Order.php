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

}
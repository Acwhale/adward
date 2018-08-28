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
}
<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/22
 * Time: 17:56
 */

namespace app\api\model;


class UserAddress extends BaseModel {
    protected $hidden = ['user_id','id','delete_time'];
}
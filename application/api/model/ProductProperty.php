<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/21
 * Time: 17:40
 */

namespace app\api\model;


class ProductProperty extends BaseModel {
    protected $hidden = ['product_id','delete_time','id'];
}
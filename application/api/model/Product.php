<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/16
 * Time: 15:23
 */

namespace app\api\model;


class Product extends BaseModel {
    protected $hidden =['delete_time','update_time','create_time','main_img_id','pivot','from','category_id'];
}
<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/30
 * Time: 15:58
 */

namespace app\api\service;


use think\Exception;

class Pay {
    private $orderID;
    private $orderNO;
    public function __construct($orderID) {
        if(!$orderID){
            throw new Exception('订单号不能为空');
        }
        $this->orderID = $orderID;
    }

    public function pay(){

    }
}
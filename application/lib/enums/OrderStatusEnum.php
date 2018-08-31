<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/31
 * Time: 11:37
 */
namespace  app\lib\enums;

class OrderStatusEnum {
    //1:未支付， 2：已支付，3：已发货 , 4: 已支付，但库存不足
    const UNPAID = 1;
    const PAID = 2;
    const DELIVERED = 3;
    const PAID_OUT_OF = 4;
}
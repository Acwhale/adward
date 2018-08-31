<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/30
 * Time: 15:23
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;
class Pay extends BaseController {
    //权限控制
    protected $beforeActionList =[
        'checkExclusiveScope' =>[
            'only'=>'getPreOrder'
        ]
    ];
    /**
     * 获取预订单信息
     */
    public function getPreOrder($id = ''){
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }
}
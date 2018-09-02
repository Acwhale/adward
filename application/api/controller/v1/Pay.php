<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/30
 * Time: 15:23
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
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

    /**
     * 微信回调函数
     */
    public function receiveNotify(){
        //1检测库存量
        //2更新订单状态
        //3减库存
        //如果成功处理，返回微信成功处理的信息。否则，返回没有成功处理的信息
        // post请求，xml格式。
        $notify = new WxNotify();
        $config = new \WxPayConfig();
        $notify->Handle($config);
    }
}
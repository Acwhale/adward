<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/30
 * Time: 15:58
 */

namespace app\api\service;


use app\lib\enums\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use think\Loader;
use think\Log;

//loader引入微信支付  extend/WxPay/WxPay.Api.php
Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');
//Loader::import('WxPay.WxPay',EXTEND_PATH,'.Config.php');

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
        $this->checkOrderValidate();
        //进行库存量检测
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if(!$status['pass']){
            return $status;
        }
        return  $this->makeVxPerOrder($status['orderPrice']);
    }

    /**
     * 生成微信预订单
     * @param $totalPrice
     * @throws Exception
     * @throws TokenException
     */
    private function makeVxPerOrder($totalPrice){
        //openid
        $openid  = Token::getCurrentTokenVar('openid');
        if(!$openid){
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        //传入自己的订单号
        $wxOrderData->SetOut_trade_no($this->orderNO);
        //设置交易类型
        $wxOrderData->SetTrade_type('JSAPI');
        //设置总金额 单位：分
        $wxOrderData->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        //微信回调通知设置
        $wxOrderData->SetNotify_url('https://qq.com');

        return $this->getPaySignature($wxOrderData);

    }

    /**
     * 请求微信预订单
     * @param $wxOrderData
     * @throws \WxPayException
     */
    private function getPaySignature($wxOrderData){
        $config = new \WxPayConfig();
        $wxOrder = \WxPayApi::unifiedOrder($config,$wxOrderData);
        if($wxOrder['return_code']!='SUCCESS' || $wxOrder['result_code'] !='SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
        }
        //prepay_id  推送模板消息时使用
        $this->recoredPreOrder($wxOrder);

        return null;
    }
    private function recoredPreOrder($wxOrder){
        OrderModel::where('id','=',$this->orderID)->update(['prepay_id'=>$wxOrder['prepay_id']]);
    }
    /**
     * 更进一步检查订单
     * @return bool
     * @throws Exception
     * @throws OrderException
     * @throws TokenException
     */
    private function checkOrderValidate(){
        //检查订单号是否存在
        $order = OrderModel::where('id','=',$this->orderID)->find();
        if(!$order){
            throw  new OrderException();
        }
        //检查当前订单与用户是否一致
        if(!Token::isValidateOperate($order->user_id)){
            throw new TokenException([
                'msg'=>'订单与用户不匹配',
                'errcode'=>10003
            ]);
        }
        //订单是否已经支付过
        if($order->status != OrderStatusEnum::UNPAID){
            throw new OrderException([
                'msg'=>'订单已经支付过',
                'errcode'=>80003,
                'code'=>400
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
 }
}
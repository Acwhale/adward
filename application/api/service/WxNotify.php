<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/9/1
 * Time: 11:38
 */

namespace app\api\service;

use app\api\model\Product;
use app\lib\enums\OrderStatusEnum;
use think\Db;
use think\Exception;
use think\Loader;

use app\api\model\User as UserModel;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Log;
Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');

class WxNotify extends \WxPayNotify {
    public function NotifyProcess($objData, $config, &$msg) {
        $config = new \WxPayConfig();
        /**
         * <xml>
        <return_code><![CDATA[SUCCESS]]></return_code>
        <return_msg><![CDATA[OK]]></return_msg>
        <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
        <mch_id><![CDATA[10000100]]></mch_id>
        <openid><![CDATA[oUpF8uMuAJO_M2pxb1Q9zNjWeS6o]]></openid        <nonce_str><![CDATA[IITRi8Iabbblz1Jc]]></nonce_str>
        >
        <sign><![CDATA[7921E432F65EB8ED0CE9755F0E86D72F]]></sign>
        <result_code><![CDATA[SUCCESS]]></result_code>
        <prepay_id><![CDATA[wx201411101639507cbf6ffd8b0779950874]]></prepay_id>
        <trade_type><![CDATA[JSAPI]]></trade_type>
        </xml>
         */
        if($objData['result_code'] == 'SUCCESS'){
            $openid = $objData['openid'];
            $user = UserModel::getByOpenID($openid);
            Db::startTrans();
            try{
                $order = OrderModel::where('user_id','=',$user->user_id)->select();
                if($order->status == OrderStatusEnum::UNPAID){
                    $service = new OrderService();
                    $status = $service->checkOrderStock($order->id);
                    if($status['pass']){
                        //更新订单状态
                        $this->updateOrderStatus($order->id,true);
                        //消减库存量
                        $this->reduceStock($status);
                    }else{
                        $this->updateOrderStatus($order->id,false);
                    }
                }
                Db::commit();
                return true;
            }catch (Exception $exception){
                Db::rollback();
                Log::error($exception);
                return false;
            }
        }else{
            return true;
        }
    }
    private function updateOrderStatus($orderID,$success){
        $status = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_OUT_OF;
        OrderModel::where('id','=',$orderID)->update(['status'=>$status]);
    }
    private function reduceStock($stockStatus){
         foreach ($stockStatus['pStatusArray'] as $singlePStatus){
//             $singlePStatus['count']
             Product::where('id','=',$singlePStatus['id'])->setDec('stock',$singlePStatus['count']);
         }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/27
 * Time: 15:11
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderValidate;
use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;
use app\api\validate\PagingParameter;
use app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;
use think\Route;

class Order extends BaseController {
    //用户在选择商品之后，向API提交包含它所选择的商品的相关信息
    //API在接收到信息之后，需要检查订单商品的库存量
    //有库存，把订单数据存入数据库，=下单成功，返回客户端信息，告诉客户端可以支付
    //调用支付接口，进行支付，在支付之前，还需要库存检查，调用微信支付接口
    //小程序根据服务器返回的结果拉起微信支付
    //微信会异步返回一个支付结果
    //根据微信返回的结果，来判断库存量是否进行扣除，成功，扣除库存，失败，返回一个支付结果。
    protected $beforeActionList=[
        'checkExclusiveScope'=>[
            'only'=>'placeOrder'
        ],
        'checkPrimaryScope'=>[
            'only'=>'getSummaryByUser,getDetail'
        ]
    ];
    public function getDetail($id){
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail){
            throw new OrderException();
        }
        $orderDetail = collection($orderDetail);
        return $orderDetail->hidden('prepay_id');
    }
    /**
     * 根据用户信息获取简要订单信息
     * @param int $page
     * @param int $pageSize
     */
    public function getSummaryByUser($page=1,$pageSize=15){
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUID();
        $pageOrder = OrderModel::getSummaryByUser($uid,$page,$pageSize);
        if(empty($pageOrder)){
            return [
                'data'=>[],
                'current_page'=>$pageOrder->getCurrentPage()
            ];
        }
        $data = $pageOrder->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return [
            'data'=>$data,
            'current_page'=>$pageOrder->getCurrentPage()
        ];
    }
    public function placeOrder(){
        (new OrderValidate())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUID();
        $order = new OrderService();
        $status = $order->place($uid,$products);
        return $status;
    }
}
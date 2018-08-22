<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/22
 * Time: 13:55
 */

namespace app\api\controller\v1;


use app\api\model\User;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address {
    /**
     * 新增或者修改地址
     */
    public function createOrUpdateAddress(){
        $validate = new AddressNew();
        $validate->goCheck();
        #todo:根据token获取uid，根据uid查询用户，用户不存在，抛出异常。用户存在，获取从客户端提交来的信息，根据用户地址是否存在来判断是新增还是更新
        $uid = TokenService::getCurrentUID();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }
        //获取提交数据以及过滤数据
        $dataArray =$validate->getDataByRule(input('post.')) ;
        $userAddress = $user->address;
        if(!$userAddress){
            //新增地址
            $user->address()->save($dataArray);
        }else{
            //更新地址
            $user->address->save($dataArray);
        }
//        return $user;
        return json(new SuccessMessage(),201);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/27
 * Time: 16:51
 */

namespace app\api\controller;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller {
    /**
     * 权限：用户和cms都可以访问
     * @throws \app\lib\exception\ForbiddenException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     */
    protected function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }

    /**
     * 权限：只有用户可以访问
     * @throws \app\lib\exception\ForbiddenException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     */
    protected function checkExclusiveScope(){
        TokenService::needExclusiveScope();
    }
}
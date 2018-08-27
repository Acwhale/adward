<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];
Route::get('api/:version/banner/:id','api/:version.banner/getBanner');
Route::get('api/:version/theme','api/:version.theme/getSimpleList');
Route::get('api/:version/theme/:id','api/:version.theme/getComplexOne');
Route::get('api/:version/product/by_category','api/:version.product/getAllInProduct');
//路由限制
Route::get('api/:version/product/:id','api/:version.product/getOne',[],['id'=>'\d+']);
Route::get('api/:version/product/recent','api/:version.product/getRecent');



Route::get('api/:version/category/all','api/:version.category/getAllCategories');

Route::post('api/:version/token/user','api/:version.token/getToken');
Route::post('api/:version/address','api/:version.address/createOrUpdateAddress');
Route::post('api/:version/order','api/:version.order/placeOrder');
//Route::get('api/:version/before','api/:version.address/second');

#路由分组
//Route::group('api/:version/group',function (){
//    Route::get('','');
//});
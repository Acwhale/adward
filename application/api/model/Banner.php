<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/14
 * Time: 9:42
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends Model {
    public static function getBannerById($id){
//        //todo:根据banner id获取banner信息
////        $result  = Db::query('select * from banner_item where banner_id=?',[$id]);
////        $result = Db::table('banner_item')->where('banner_id','=',$id)
////            ->select();
//        $result = Db::table('banner_item')->where(
//            function ($query) use ($id){
//                $query->where('banner_id','=',$id);
//            }
//        )->select();
        $banner = self::with(['items','items.img'])->find($id);
        return $banner;
    }
    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }
}
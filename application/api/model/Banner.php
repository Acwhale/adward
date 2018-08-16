<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/14
 * Time: 9:42
 */

namespace app\api\model;


class Banner extends BaseModel {
    //隐藏不必要属性
    protected $hidden = ['delete_time','update_time'];

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
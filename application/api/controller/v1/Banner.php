<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/9
 * Time: 17:35
 */

namespace app\api\controller\v1;
use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;

class Banner {

    /**
     * @param $id
     * @url: banner/:id
     * @method:get
     */
    public function getBanner($id) {
        (new IDMustBePositiveInt())->goCheck();
        $banner = BannerModel::getBannerById($id);
        if (!$banner) {
            throw new BannerMissException();
        }
        return json($banner,200);
    }
}
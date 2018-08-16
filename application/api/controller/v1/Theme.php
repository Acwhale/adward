<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/16
 * Time: 15:21
 */

namespace app\api\controller\v1;


use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;

class Theme {
    /**
     * @url: theme?ids=id1,id2,id3
     * $return:一组Theme模型
     */
    public function getSimpleList($ids=''){
        (new IDCollection())->goCheck();
        $ids = explode(',',$ids);
        $result = ThemeModel::with(['topicImg','headImg'])->select($ids);
        if(!$result){
            throw new ThemeException();
        }
        return $result;
    }
    //使用完全匹配路由config.php下的route_complete_match改为true

    /**
     * @param $id
     * @url:theme/:id
     */
    public function getComplexOne($id){
        (new IDMustBePositiveInt())->goCheck($id);
        $theme = ThemeModel::getThemeWithProducts($id);
        if(!$theme){
            throw  new ThemeException();
        }
        return $theme;
    }
}
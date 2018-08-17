<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 13:56
 */

namespace app\api\controller\v1;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category {
    public function getAllCategories(){
//        $categories = CategoryModel::with(['Image'])->select();
        $categories = CategoryModel::all([],['img']);
        if(!$categories){
            throw new CategoryException();
        }
        return $categories;

    }
}
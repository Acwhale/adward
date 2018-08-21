<?php
/**
 * Created by PhpStorm.
 * User: hello
 * Date: 2018/8/17
 * Time: 10:44
 */

namespace app\api\controller\v1;


use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

class Product {
    /**
     * @param $count
     * @url:/product
     */
    public function getRecent($count=15){
        (new Count())->goCheck($count);
        $products = ProductModel::getMostRecent($count);
        if(!$products){
            throw  new ProductException();
        }
        //通过数据集的方式临时隐藏一些字段
        //也可以修改database.php下的resultset_type 设置为collection,就不需要转换，返回就是collection
        //使用数据集判空是需要isEmpty()
        $collection = collection($products);
        $products = $collection->hidden(['summary']);
        return $products;
    }

    /**
     * @url: /product/by_category
     */
    public function getAllInProduct($id){
        (new IDMustBePositiveInt())->goCheck($id);
        $product = ProductModel::getProductsByCategoryId($id);
        if(!$product){
            throw new ProductException();
        }
        //转换数据集，隐藏summary属性
        $collection = collection($product);
        $product = $collection->hidden(['summary']);
        return $product;
    }

    /**
     * 获取商品详情
     * @param $id
     * url
     */
    public function getOne($id){
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if(!$product){
            throw  new ProductException();
        }
        return $product;
    }
}
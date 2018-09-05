import {Base} from '../../utils/base.js';

class Category extends Base{
    constructor(){
        super();
    }

    /**
     * 获取所有分类
     *
     */
    getCategoryType(callback){
        let parmas ={
            url:'category/all',
            sCallback:(res=>{
                callback && callback(res);
            }),
        };
        this.request(parmas);
    }
    /**
     * 获取某个标签下的数据
     */
    getProductByCategory(id,callback){
        let params ={
            url:'product/by_category?id='+id,
            sCallback:(res=>{
                callback && callback(res)
            })
        };
        this.request(params);
    }
}
export {Category};
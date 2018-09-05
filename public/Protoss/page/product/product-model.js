import {Base} from '../../utils/base.js';

class Product extends Base{
    constructor(){
        super();
    }
    /**
     * 根据ID获取商品详情
    */
    getDetailInfo(id,callback){
        let params ={
            url:'product/'+id,
            sCallback:(res)=>{
                callback && callback(res)
            }
        };
        this.request(params);
    }
}
export {Product}
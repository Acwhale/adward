import {Base} from '../../utils/base.js';

class Cart extends Base{

    constructor(){
        super();
        this._storageKeyName = 'cart';
    }

    /**
     * 添加商品
     */
    add(item,counts){
        let cartData = this.getCartDataFromLocal();
        let isHasInfo = this._isHasThatOne(item.id,cartData);
        //新增属性
        if(isHasInfo.index ==-1){
            item.counts = counts;
            item.selectStatus = true;
            cartData.push(item);
        }else{
            cartData[isHasInfo.index].counts+=counts;
        }
        wx.setStorageSync(this._storageKeyName, cartData);
    }
    /**
     * 从缓存中读取数据
     */
    getCartDataFromLocal(){
        let res = wx.getStorageSync(this._storageKeyName);
        if(!res){
            res = [];
        }
        return res;
    }
    /**
     * 判断是否购物车中有该数据
     */
    _isHasThatOne(id,arr){
        var item,result = {index:-1};
        for(let i=0;i<arr.length;i++){
            item = arr[i];
            if(item.id == id){
                result ={
                    index:i,
                    data:item
                };
                break;
            }
        }
        return result;
    }
}

export {Cart}
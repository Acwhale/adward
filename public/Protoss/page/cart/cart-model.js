import { Base } from '../../utils/base.js';

class Cart extends Base {

    constructor() {
        super();
        this._storageKeyName = 'cart';
    }
    /**
     * 获取购物车商品数量
     * flag:true 商品的选择状态
     */
    getCartTotalCounts(flag) {
        let data = this.getCartDataFromLocal();
        var counts = 0;
        for (let i = 0; i < data.length; i++) {
            if(flag){
                if(data[i].selectStatus){
                    counts += data[i].counts
                }
            }else{
                counts += data[i].counts
            }
          
        }
        return counts;
    }

    /**
     * 添加商品
     */
    add(item, counts) {
        let cartData = this.getCartDataFromLocal();
        let isHasInfo = this._isHasThatOne(item.id, cartData);
        //新增属性
        if (isHasInfo.index == -1) {
            item.counts = counts;
            item.selectStatus = true;
            cartData.push(item);
        } else {
            cartData[isHasInfo.index].counts += counts;
        }
        wx.setStorageSync(this._storageKeyName, cartData);
    }
    /**
     * 从缓存中读取数据
     */
    getCartDataFromLocal(flag) {
        let res = wx.getStorageSync(this._storageKeyName);
        if (!res) {
            res = [];
        }
        //在下单的时候过滤
        if(flag){
            var newRes =[];
            for(let i=0;i<res.length;i++){
                if(res[i].selectStatus){
                    newRes.push(res[i])
                }
            }
            res = newRes;
        }
        return res;
    }
    /**
     * 判断是否购物车中有该数据
     */
    _isHasThatOne(id, arr) {
        var item, result = { index: -1 };
        for (let i = 0; i < arr.length; i++) {
            item = arr[i];
            if (item.id == id) {
                result = {
                    index: i,
                    data: item
                };
                break;
            }
        }
        return result;
    }
    /*
   * 修改商品数目
   * params:
   * id - {int} 商品id
   * counts -{int} 数目
   * */
    _changeCounts(id, counts) {
        var cartData = this.getCartDataFromLocal(),
            hasInfo = this._isHasThatOne(id, cartData);
        if (hasInfo.index != -1) {
            if (hasInfo.data.counts > 0) {
                cartData[hasInfo.index].counts += counts;
            }
        }
        wx.setStorageSync(this._storageKeyName ,cartData)  //更新本地缓存
    }
    /*
   * 增加商品数目
   * */
    addCounts(id) {
        this._changeCounts(id, 1);
    };

    /*
    * 购物车减
    * */
    cutCounts(id) {
        this._changeCounts(id, -1);
    };
    /**
     * 删除
     */
    /*
    * 删除某些商品
    */
    delete(ids) {
        if (!(ids instanceof Array)) {
            ids = [ids];
        }
        var cartData = this.getCartDataFromLocal();
        for (let i = 0; i < ids.length; i++) {
            var hasInfo = this._isHasThatOne(ids[i], cartData);
            if (hasInfo.index != -1) {
                cartData.splice(hasInfo.index, 1);  //删除数组某一项
            }
        }
        wx.setStorageSync(this._storageKeyName, cartData)
    }
    execsetStorageSync(data){
        wx.setStorageSync(this._storageKeyName, data)
    }
}

export { Cart }
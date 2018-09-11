// page/cart/cart.js
import { Cart } from 'cart-model.js';
var cart = new Cart();
Page({

    /**
     * 页面的初始数据
     */
    data: {

    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {

    },
    onHide:function(){
        // wx.setStorageSync('cart', this.data.cartData);
        cart.execsetStorageSync(this.data.cartData)
    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function () {
        var cartData = cart.getCartDataFromLocal();
        // var countsInfo = cart.getCartTotalCounts(true);
        var cal = this._calcTotalAccountAndCounts(cartData);
        this.setData({
            selectedCounts: cal.selectedCounts,
            cartData: cartData,
            selectedTypeCounts:cal.selectedTypeCounts,
            account: cal.account
        });
    },
    /*
   * 计算总金额和选择的商品总数
   * */
    _calcTotalAccountAndCounts: function (data) {
        var len = data.length,
            account = 0,
            selectedCounts = 0,
            selectedTypeCounts = 0;
        let multiple = 100;
        for (let i = 0; i < len; i++) {
            //避免 0.05 + 0.01 = 0.060 000 000 000 000 005 的问题，乘以 100 *100
            if (data[i].selectStatus) {
                account += data[i].counts * multiple * Number(data[i].price) * multiple;
                selectedCounts += data[i].counts;
                selectedTypeCounts++;
            }
        }
        return {
            selectedCounts: selectedCounts,
            selectedTypeCounts: selectedTypeCounts,
            account: account / (multiple * multiple)
        }
    },
    /**
     * 选项切换
     */
    toggleSelect:function(e){
        console.log(e)
        var id = e.currentTarget.dataset.id;
        var selectStatus = e.currentTarget.dataset.status;
        var index = this._getProductIndexById(id);
        this.data.cartData[index].selectStatus = !selectStatus;
        this._resetCartData();
    },
    /*全选*/
    toggleSelectAll:function (event) {
        console.log(event)
        var status = event.currentTarget.dataset.status == 'true';
        var data = this.data.cartData,
            len = data.length;
        for (let i = 0; i < len; i++) {
            data[i].selectStatus = !status;
        }
        this._resetCartData();
    },

    /**
     * 全选的操作
     */
    _resetCartData:function(){
        var newData = this._calcTotalAccountAndCounts(this.data.cartData);
        // console.log(this.data.cartData)

        this.setData({
            account: newData.account,
            selectedCounts: newData.selectedCounts,
            selectedTypeCounts: newData.selectedTypeCounts,
            cartData: this.data.cartData
        });
        
    },
    
    /**
     * 根据商品的id得到商品的下标
     */
    _getProductIndexById:function(id){
        var data = this.data.cartData,len = data.length;
        for(let i =0;i<len;i++){
            if(data[i].id == id){
                return i;
            }
        }
    },
    /**
     * +-
     */
    changeCounts:function(e){
        var id = e.currentTarget.dataset.id,
        type = e.currentTarget.dataset.type,
        index = this._getProductIndexById(id),
        counts = 1; 
        switch(type){
            case 'add':cart.addCounts(id);break;
            case 'cut': counts =-1;cart.cutCounts(id);break;
        }
        // if(type =='add'){
        //     cart.addCounts(id);
        // }else{
        //     counts = -1; cart.cutCounts(id);
        // }
        this.data.cartData[index].counts += counts;
        this._resetCartData();

    },
    delete:function(e){
        let id = e.currentTarget.dataset.id;
        let index = this._getProductIndexById(id);
        this.data.cartData.splice(index,1);
        this._resetCartData();
        cart.delete(id);
    }
})
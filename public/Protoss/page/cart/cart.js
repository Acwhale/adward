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
    _calcTotalAccountAndCounts: function (data) {
        var len = data.length, account = 0, selectedCounts = 0, selectedTypeCounts = 0;
        let multiple = 100;
        for (let i = 0; i < len; i++) {
            if (data[i].selectedStatus) {
                account += data[i].counts * multiple * Number(data[i].price) * multiple;
                selectedCounts += data[i].counts;
                selectedTypeCounts++;
            }
        }

        return {
            selectedCounts: selectedCounts,
            selectedTypeCounts: selectedTypeCounts,
            account: account / (multiple * multiple)
        };

    }

})
// page/category/category.js
import {Category} from 'category-model.js';
var category = new Category();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    currentMenuIndex:0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this._loadData();
  },
  _loadData:function(){
      /**
       * 获取标签
       */
      category.getCategoryType(categoryData=>{
        // console.log(res);
        this.setData({
            'categoryData':categoryData
        });
        /**
       * 获取某个标签下的商品
       */
        category.getProductByCategory(categoryData[0].id, (data) => {
            var dataObj ={
                products:data,
                topImgUrl:categoryData[0].img.url,
                title:categoryData[0].name
            };
           this.setData({
               categoryProducts: dataObj
           });
        });
      });
      
  },
  /**
   * 标签切换
   */
  changeCategory:function(e){
    //   console.log(e)
    let id = e.currentTarget.dataset.id;
    let index = e.currentTarget.dataset.index;
    /**
       * 获取某个标签下的商品
       */
    category.getProductByCategory(id, (data) => {
        var dataObj = {
            products: data,
            topImgUrl: this.data.categoryData[index].img.url,
            title: this.data.categoryData[index].name
        };
        this.setData({
            categoryProducts: dataObj,
            currentMenuIndex:index
        });
    });
    
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})
// page/theme/theme.js
import {Theme} from 'theme-model.js';
var theme = new Theme();
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
    var [id,name] = [options.id,options.name];
    this.data.id = id;
    this.data.name = name;
   
    this._loadData();
  },
  onReady:function(){
      //动态设置标题
      wx.setNavigationBarTitle({
          title: this.data.name,
      })
  },
  _loadData:function(){
      /**
    * 获取主题下的商品列表
    */
      theme.getProductsData(this.data.id, (res) => {
        //   console.log(res);
        this.setData({
            "themeInfo":res
        });
      });
  }
})
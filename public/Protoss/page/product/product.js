// page/product/product.js
import {Product} from 'product-model.js'
var product = new Product();
Page({

  /**
   * 页面的初始数据
   */
  data: {
      countsArr: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 
      productCount:1
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    // console.log(options)
    let id = options.id;
    this.data.id = id;
    this._loadData();
    
  },
  _loadData:function(){
      product.getDetailInfo(this.data.id,(res)=>{
        console.log(res)
        this.setData({
            'product':res
        });
      });
  },
  /**
   * 数量选择器
   */
  bindPickerChange:function(e){
    //   console.log(e)
    this.setData({
        'productCount': yhis.data.countsArr[e.detail.value],
    });
  },
  /**
   * 选项卡切换
   */
  onTabsItemTap:function(e){
    //   console.log(e);
    let index = e.currentTarget.dataset.index;
    this.setData({
        'currentTabsIndex':index
    });
  }
  
})
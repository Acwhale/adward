// page/home/home.js
import {Home} from 'home-model.js';
var home = new Home();

Page({

  /**
   * 页面的初始数据
   */
  data: {
  
  },
  
  onLoad:function(){
    this._loadData();
  },

  _loadData:function(){
    var id = 1;
    home.getBannerData(id,(res)=>{
      // console.log(res);
      this.setData({
        'bannerArray':res
      });
    });
    
    home.getThemeData((res)=>{
    //   console.log(res);
      this.setData({
        'theme':res
      });
    });
    
    home.getProductsData((res)=>{
      // console.log(res)
      this.setData({
        'productsArr':res
      })
    });
  },
  /**
   *轮播页面事件绑定 
   */
  onProductsItemTap:function(event){
    // console.log(event);
    let id = event.currentTarget.dataset.id;
    wx.navigateTo({
      url: '../product/product?id='+id,
    })
  },
  /**
   * 精选主题时间绑定
   */
  onThemeItemTap:function(event){
    let id = event.currentTarget.dataset.id;
    let name = event.currentTarget.dataset.name;
    wx.navigateTo({
      url: '../theme/theme?id='+id+'&name='+name,
    })
  }

})
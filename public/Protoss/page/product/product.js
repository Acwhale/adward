// page/product/product.js
import {Product} from 'product-model.js';
import {Cart} from '../cart/cart-model.js';
var cart = new Cart();
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
        //   console.log(cart.getCartTotalCounts())
        this.setData({
            'product':res,
            'cartTotalCounts': cart.getCartTotalCounts()
        });
      });
  },
  /**
   * 数量选择器
   */
  bindPickerChange:function(e){
    //   console.log(e)
    this.setData({
        'productCount': this.data.countsArr[e.detail.value],
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
  },
  /**
   * 加入到购物车
   */
  onAddToCartTap:function(e){
      this.addTocart();
      var counts = this.data.cartTotalCount+this.data.productCount;
      this.setData({
          'cartTotalCounts': cart.getCartTotalCounts()
      });
  },
  addTocart:function(){
    let tmpObj={};
    let keys =['id','name','main_img_url','price'];

    for(let key in this.data.product){
        if(keys.indexOf(key) >=0){
            tmpObj[key] = this.data.product[key];
        }
    }
    cart.add(tmpObj,this.data.productCount)
  },
  onCartTap:function(event){
      wx.switchTab({
          url: '/page/cart/cart',
      });
  }

})
import {Base} from '../../utils/base.js'

class Home extends Base{
  constructor(){
    super();
  }
  /**
   * 获取Banner数据
   * @parameter：id
   */
  getBannerData(id,callback){
    let params ={
      url:'banner/'+id,
      sCallback:(res)=>{
        callback && callback(res.items);
      }
    };
    this.request(params)
    // wx.request({
    //   url: 'http://z.cn/api/v1/banner/'+id,
    //   method:'GET',
    //   success:function(res){
    //     // console.log(res)
    //     callBack(res)
    //   }
    // })
  }
  /**
   * 获取theme
   */
  getThemeData(callback){
    let params={
      url:'theme?ids=1,2,3',
      sCallback:(res)=>{
        callback && callback(res);
      }
    };
    this.request(params);
  }

  /**
   * 获取最近新品
   */
  getProductsData(callback){
    let params ={
      url:'product/recent',
      sCallback:(res)=>{
        callback && callback(res)
      }
    };
    this.request(params);
  }
}

export {Home}
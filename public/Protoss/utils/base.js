import {Config} from '../utils/config.js';

class Base{

  constructor(){
    this.baseRequestUrl = Config.restUrl;
  }

  request(params){
    let url = this.baseRequestUrl + params.url;
    wx.request({
      url: url,
      data:params.data,
      method:params.typ?params.type:'GET',
      header:{
        'content-type':'application/json',
        'token':wx.getStorageSync('token')
      },
      success:function(res){
        // if(params.sCallBack){
        //   params.sCallBack(res)
        // }
        params.sCallback&&params.sCallback(res.data);
      },
      fail:function(err){
        console.log(err);
      }
    })
  }
}
export {Base}
import {Config} from '../utils/config.js';
import {Token} from '../utils/token.js';
class Base{

  constructor(){
    this.baseRequestUrl = Config.restUrl;
  }
  _refetch(params){
      var token = new Token();
      token.getTokenFromService((token)=>{
          this.request(params,true);
      })
  }
  request(params,noReftch){
      var that =this;
    let url = this.baseRequestUrl + params.url;
    wx.request({
      url: url,
      data:params.data,
      method:params.type?params.type:'GET',
      header:{
        'content-type':'application/json',
        'token':wx.getStorageSync('token')
      },
      success:function(res){
        // if(params.sCallBack){
        //   params.sCallBack(res)
        // }
        var code = res.statusCode.toString();
        var startChar = code.charAt(0);
        if(startChar =='2'){
            params.sCallback && params.sCallback(res.data);
        }else{
            if(code == '401'){
               if(!noReftch){
                   that.request(params);
               }
            }
            if(noReftch){
                params.eCallback && params.eCallback(res.data); 
            }  
        }
       
      },
      fail:function(err){
        console.log(err);
      }
    })
  }
}
export {Base}
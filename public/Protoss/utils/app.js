
import { Token } from ''
App({

    onLaunch:function(){
        var token =new Token();
        token.verify();
    }
});
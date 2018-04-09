define(function (require, exports) {
    var $ = require("/Wechat/Public/Home/product/common/zepto"),
    util = require("/Wechat/Public/Home/product/util/util"),
    keyConfig = require("/Wechat/Public/Home/product/common/keyConfig");

    var passTicket = util.getQuery("pass_ticket");

    var obj = {
        ajaxReq: function(config, toOauth){
            var option = {
                url: "",
                data: {},
                type: "GET",
                dataType: "json",
                onSuccess: function () {},      // 回调函数
                onError: function (json) {}
            };
            if (!config) {
                return;
            }
            $.extend(option, config);

            if(passTicket){
                option.data.pass_ticket = passTicket;
            }
            if(option.type.toUpperCase() == "GET"){
                option.data.t = new Date().getTime();
            } else {
                option.url += (((option.url.indexOf("?")==-1)? "?" : "&") + "t="+new Date().getTime());
            }
            $.ajax({
                url: option.url,
                type: option.type,
                data: option.data,
                dataType: option.dataType,
                beforeSend: function(request){
                    request.setRequestHeader( 'X-Gizwits-Application-Id',keyConfig.JZY_APPID);
                    request.setRequestHeader( 'X-Gizwits-User-token','97b35b56ad5a44e1bff89d4943dbc43a' );
                },//这里设置header
                success: function (json) {
                    if( json ){
                        option.onSuccess(json);
                    }else{
                        option.onError(json);
                    }
                },
                error: option.onError
            });
        },
    };

    return obj;
});
/*  |xGv00|680f78671c060a0f6684dd408b138ba0 */
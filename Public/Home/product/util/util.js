define(function (require, exports, module) {

    var $ = require("/Wechat/Public/Home/product/common/zepto");
    
    return{
        getQuery: function (name, url) {
            //参数：变量名，url为空则表从当前页面的url中取
            var u = arguments[1] || window.location.search.replace("&amp;", "&"),
                reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"),
                r = u.substr(u.indexOf("\?") + 1).match(reg);
            return r != null ? r[2] : "";
        },
        getCookie: function (name) {
            //读取COOKIE
            var reg = new RegExp("(^| )" + name + "(?:=([^;]*))?(;|$)"), val = document.cookie.match(reg);
            return val ? (val[2] ? unescape(val[2]) : "") : null;
        },
        myGetCookie: function (name) {
            try{
                var arr = document.cookie.split(";"),
                    obj = {};
                for(var i=0; i<arr.length; ++i){
                    var item = arr[i].trim(), key = item.split("=")[0], val = item.split("=")[1];
                    obj[key]=val;
                }
                return obj[name];
            } catch (e){
                return "";
            }
        },
        delCookie: function (name, path, domain, secure) {
            //删除cookie
            var value = this.getCookie(name);
            if (value != null) {
                var exp = new Date();
                exp.setMinutes(exp.getMinutes() - 1000);
                path = path || "/";
                document.cookie = name + '=;expires=' + exp.toGMTString() + ( path ? ';path=' + path : '') + ( domain ? ';domain=' + domain : '') + ( secure ? ';secure' : '');
            }
        },
        setCookie: function (name, value, expires, path, domain, secure) {
            //写入COOKIES
            var exp = new Date(), expires = arguments[2] || null, path = arguments[3] || "/", domain = arguments[4] || null, secure = arguments[5] || false;
            expires ? exp.setTime(exp.getTime() + expires * 24 * 3600 * 1000) : "";
            document.cookie = name + '=' + escape(value) + ( expires ? ';expires=' + exp.toGMTString() : '') + ( path ? ';path=' + path : '') + ( domain ? ';domain=' + domain : '') + ( secure ? ';secure' : '');
        },
        strReplace:function(template, json) {
            var s = template;
            for(var d in json) {
                var reg = new RegExp("{#"+d+"#}","g");
                s = s.replace(reg, json[d]);
            }
            return s;
        },
        /**
         * 把时间戳转化成指定格式
         * date : 秒为单位
         */
        formatDate: function(date,format){
            if(!date){
                return "";
            }
            if("object" != typeof(date)){
                var d = new Date();
                d.setTime(date+"000");
                date = d;
            }
            var paddNum = function(num){
                num += "";
                return num.replace(/^(\d)$/,"0$1");
            }
            //指定格式字符
            var cfg = {
                yyyy : date.getFullYear() //年 : 4位
                ,yy : date.getFullYear().toString().substring(2)//年 : 2位
                ,M  : date.getMonth() + 1  //月 : 如果1位的时候不补0
                ,MM : paddNum(date.getMonth() + 1) //月 : 如果1位的时候补0
                ,d  : date.getDate()   //日 : 如果1位的时候不补0
                ,dd : paddNum(date.getDate())//日 : 如果1位的时候补0
                ,hh : date.getHours()  //时
                ,mm : paddNum(date.getMinutes()) //分
                ,ss : paddNum(date.getSeconds()) //秒
            }
            format || (format = "yyyy-MM-dd hh:mm:ss");
            return format.replace(/([a-z])(\1)*/ig,function(m){return cfg[m];});
        },
        closePage: function () {
            var userAgent = navigator.userAgent;
            window.close();
            if (userAgent.indexOf("Firefox") != -1 || userAgent.indexOf("Chrome") !=-1) {
                window.location.href="about:blank";
            } else {
                window.opener = null;
                window.open("", "_self");
                window.close();
            }
        }
    };
});/*  |xGv00|d181c47e0f846db77a5facef0ca36af1 */
define(function (require) {
    var $ = require("/Wechat/Public/Home/product/common/zepto");
    var keyConfig = require("/Wechat/Public/Home/product/common/keyConfig");
    var reqData = require("/Wechat/Public/Home/product/common/reqData");
    var util = require("/Wechat/Public/Home/product/util/util");
    var ProcessBar = require("/Wechat/Public/Home/product/ui/process-bar");

    var pageParam = {
        device_id: util.getQuery("device_id"),
        device_type: util.getQuery("device_type"),
        appid: keyConfig.WX_MYDEVICE_APPID
    };

    var jzyDate = {
        did: keyConfig.JZY_DID,
        appid: keyConfig.JZY_APPID,
    }

    var lastModTime = 0;

    var powerBtn = $("#powerBtn"), // 开关按钮
        lightBar;
    var device_status= {
        attr: {
            onOFF: 0,
            speed: 0,
        }
    }; // 数据对象

    var newDataPoint = [];	
    newDataPoint['onOFF'] = 0;
    newDataPoint['speed'] = 0;
    var dataPoint = [];
    dataPoint['attrs'] = newDataPoint;

    console.log( dataPoint );

    (function () {
        if(!pageParam.device_id || !pageParam.device_type){
            alert("页面缺少参数");
            return;
        }
        powerBtn.on("tap", togglePower); // 开关按钮事件
        initBar();
        initInterval();
    })();

    /**
     * 初始化进度条
     */
    function initBar() { 
        lightBar = new ProcessBar({
            $id: "lightBar",
            min: 0,
            stepCount: 100,
            step: 1,
            touchEnd: function (val) {
                console.log("亮度值为："+val);
                dataPoint.attrs.speed = val
                setData();
            }
        });
    }
    /**
     * 请求数据
     */
    function getData() {
        reqData.ajaxReq({
            url:'https://api.gizwits.com/app/devdata/'+keyConfig.JZY_DID+'/latest',
            type:'get',
            dataType:'json',
            onSuccess: renderPage,
            onError:function(msg) {
                console.log("获取数据失败:" + JSON.stringify(msg));
            },
        });
    }
    /**
     * 设置数据
     */
    function setData() {
    	var datas = '{"attrs":{"onOFF": '+dataPoint.attrs.onOFF+' ,"speed":'+dataPoint.attrs.speed+'} }';		
        console.log(datas);
        reqData.ajaxReq({
            url:'https://api.gizwits.com/app/control/'+keyConfig.JZY_DID,
            type:'post',
            data: datas,
            dataType:'json',
            onSuccess: function(msg){
            	alert('修改数据点成功！');
            	getData();
            },
            onError:function(msg) {
                console.log("获取数据失败:" + JSON.stringify(msg));
            },
        });
    }

    /**
     * 开关按钮事件
     */
    function togglePower() {
        $("#switchBtn").toggleClass("on").toggleClass("off");
        if(device_status.attr.onOFF == 0 ){
            dataPoint.attrs.onOFF = 0;
            device_status.attr.onOFF = 0;
        } else {
            dataPoint.attrs.onOFF = 1;
            device_status.attr.onOFF = 1;
        }
        setData();
    }

    /**
     * 轮询
     */
    function initInterval() {
        getData();
        setInterval(function () {
            if((new Date().getTime() - lastModTime) > 100000){ // 当有设置操作时，停止1s轮询，2秒后继续轮询
                getData();
            }
        }, 100000);
    }

    /**
     * 渲染页面
     */
    function renderPage(json) {
        if(!json.attr){
            return;
        }
        device_status = json;
        if(device_status.attr.onOFF == 1 ){
            $("#switchBtn").addClass("on").removeClass("off");
        } else {
            $("#switchBtn").addClass("off").removeClass("on");
        }
        lightBar.setVal(device_status.attr.speed);
    }
});
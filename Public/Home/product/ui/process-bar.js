/**
 * 进度条组件
 */
define(function (require) {
    var $ = require("/Wechat/Public/Home/product/common/zepto");
    
    function Bar(opt) {
        var defaults = {
            $id: "", // 进度条dom节点id
            min: 1, // 刻度最小值
            stepCount: 5, // 刻度步数
            step: 1, // 刻度步长
            touchEnd: function () {} // 拖动完成回调
        };
        this.option = $.extend(defaults, opt);
        this.barNode = $("#"+this.option.$id);
        this.parentNode = this.barNode.parents(".J_slider_box");
        this.sliderNode = this.barNode.find(".J_slider");
        this.fillNode = this.barNode.find(".J_fill");
        this.valNode = this.barNode.find(".J_value");
        this.val = this.option.min;
        this.valNode.text(this.val);
        this._init();
        return this;
    }

    Bar.prototype = {
        /**
         * 根据比例值来重新渲染进度条的位置
         * @param ratio 取值：0~1
         */
        refreshPos: function (ratio) {
            if(ratio >= 1 || ratio < 0){ // 等于1时，js的%取值有问题，故排除
                return;
            }
            // 根据触点位置更新进度条
            var percentage = ratio*100;
            this.sliderNode.css("left", percentage+"%");
            this.fillNode.css("width", percentage+"%");

            var unit = 1 / this.option.stepCount,
                halfUnit = unit / 2,
                a = Math.floor(ratio / unit),
                b = ratio % unit,
                index = a + (b<halfUnit ? 0 : 1);
            this.val = this.option.min + index*this.option.step;
            this.valNode.text(this.val);
        },
        /**
         * 设置指定的进度值
         */
        setVal: function (val) {
            var ratio = (val-this.option.min) / (this.option.step * this.option.stepCount);
            this.refreshPos(ratio);
        },
        _init: function () {
            var bar = this;
            if(!(bar.barNode.width() > 0)){
                setTimeout(function () {
                    bar._init();
                }, 100); // 直到vm渲染完成之后才能取得正确的dom高宽
                return;
            }
            bar.leftDis = bar.barNode.offset().left;
            bar.sliderWidth = bar.barNode.width();

            bar.barNode.on("touchmove", function (e) {
                e.preventDefault();
//                bar.parentNode.addClass("on");
                var touch = e.changedTouches ? e.changedTouches[0] : e;
                var ratio = (touch.pageX - bar.leftDis) / bar.sliderWidth;
                bar.refreshPos(ratio);
            });

            bar.barNode.on("touchend", function (e) {
                e.preventDefault();
//                bar.parentNode.removeClass("on");
                var touch = e.changedTouches ? e.changedTouches[0] : e;
                var ratio = (touch.pageX - bar.leftDis) / bar.sliderWidth;
                bar.refreshPos(ratio);
                bar.option.touchEnd(bar.val);
            });
        }
    };

    return Bar;
});/*  |xGv00|7e721ba88fbeb79b77ebb5a93ec89a5e */
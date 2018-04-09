<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0051)https://hw.weixin.qq.com/devicectrl/panel/lamp.html -->
<html>  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>控制面板</title>
    <link rel="stylesheet" type="text/css" href="/Public/Home/product/css/common.css">
    <link rel="stylesheet" type="text/css" href="/Public/Home/product/css/light_switch.css">
</head>
<body>
    <div class="body">
        <div class="inner">
            <div id="switchBtn" class="status_button off">
                <div class="button_wrp">
                    <div class="button_mask">
                        <div class="alerter_button" id="powerBtn">
                            <i class="status_pot"></i>
                            <span class="on">ON</span>
                            <span class="off">OFF</span>
                        </div>
                    </div>
                </div>
                <div class="on">
                    <h2>电源已开启</h2>
                </div>
                <div class="off">
                    <h2>电源已关闭</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="foot">
        <div class="slider_box J_slider_box" style="height:15px;">
            <i class="slider_box_icon icon dark">风速</i>
            <div id="lightBar" class="slider_box_bar">
                <div class="slider_box_slider J_slider" style="left:0%">
                    <p class="slider_box_slider_label J_value"></p>
                    <i class="slider_box_slider_touch"></i>
                </div>
                <div class="slider_box_line">
                    <span class="slider_box_line_fill J_fill" style="width:0%"></span>
                </div>
            </div>
            <i class="slider_box_icon icon light"></i>
        </div>
    </div>
  </div>
  <div class="no_device dn">
      <h3>无法连接设备</h3>
      <p class="tips">请检查是否有电以及网络是否正常连接</p>
  </div>

  <script type="text/javascript" src="/Public/Home/product/sea.js"></script>
  <script type="text/javascript" src="/Public/Home/product/jquery-3.2.1.min.js"></script>
  <script type="text/javascript">
        seajs.use("/Public/Home/product/lamp");
  </script>

</body>

</html>
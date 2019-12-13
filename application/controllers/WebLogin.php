<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Weixin Web Menu
 */
class WebLogin extends CI_Controller {

    /**
     * [login description]
     * @author   Ding Jingfei  <794783766@qq.com>
     * @datetime 2019-10-17T22:04:38+0800
     * @return   [type]                   [description]
     */
	public function login()
    {      
        var_dump('aaa');die;

        $redirect_uri = "http://weixin.kevinfei.com/weixinlogin/weblogin";
        $redirect_uri = urlencode($redirect_uri);//该回调需要url编码
        $appID  = "wxf424cee783ba41b8";
        $scope  = "snsapi_login";//写死，微信暂时只支持这个值
        //准备向微信发请求
        $url = "https://open.weixin.qq.com/connect/qrconnect?appid=".$appID."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=STATE#wechat_redirect";
        //请求返回的结果(实际上是个html的字符串)
        $result = file_get_contents($url);
        var_dump($result);die;

        //替换图片的src才能显示二维码
        $result = str_replace("/connect/qrcode/", "https://open.weixin.qq.com/connect/qrcode/", $result);
        return $result; //返回页面
    }

    public function weblogin()
    {
        if(isset($_GET['code']) && $_GET['code'])
        {
            var_dump($_GET['code'] );die;
        }
    }
}

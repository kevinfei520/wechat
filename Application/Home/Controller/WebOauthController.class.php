<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 微信网页授权业务控制器 Oauth2 
*/

class WebOauthController extends BaseController
{      
    /**
     * 描述    业务逻辑页面
     * @Author   Cabbage.
     * @DateTime 2018-04-01
     * @return   [type]     [description]
     */
    public function index()
    {   
        //拉取用户信息
        $code = I('get.code');
        $access_token = D('WechatOauth')->getAccessToken($code);
        $arropenid = D('WechatOauth')->getInfo('openid');
        $openid = $arropenid['openid'];
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $result = curlGet($url);
        var_dump($result);
    }

}
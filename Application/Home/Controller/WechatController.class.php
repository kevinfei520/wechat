<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 公众号菜单操作类
 */
class WechatController extends BaseController
{	
    public function customMenu(){
        $access_token = D('Wechat')->GetAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
        $centent = 
        '{
              "button": [
                    {
                        "name": "菜单",
                        "sub_button": [{
                            "type": "click",
                            "name": "BiaoPizza",
                            "key": "news",
                            "sub_button": []
                        }, {
                            "type": "view",
                            "name": "获取设备二维码地址",
                            "url": "http://58djf.com/Wechat/Home/product/getOpenid",
                            "sub_button": []
                        }, {
                            "type": "view",
                            "name": "其他通知",
                            "url": "http:\/\/mp.weixin.qq.com\/s?__biz=MzI2MDI4NzQ4NA==&mid=2247483654&idx=1&sn=571ff09b182d25b03851fbb4c6456094&scene=18#rd",
                            "sub_button": []
                        }]
                    }, 

                    {
                        "name": "备忘",
                        "sub_button": [{
                            "type": "view",
                            "name": "H5",
                            "url": "http:\/\/h5.eqxiu.com\/s\/pwIOcdKA",
                            "sub_button": []
                        }, {
                            "type": "click",
                            "name": "图文",
                            "key": "news",
                            "sub_button": []
                        }]
                    },

                    {
                        "name": "关于",
                        "sub_button": 
                        [
                            {
                                "type": "view",
                                "name": "Blog",
                                "url": "http:\/\/www.58djf.com\/",
                                "sub_button": []
                            },
                            {
                                "type": "click",
                                "name": "联系我们",
                                "key": "About",
                                "sub_button": []
                            }
                        ]
                    }
                ]
         }' ;
        $result = curl_post_url($url,$centent,60);
        var_dump($result);

    }
    
    public function getMenu(){
        $access_token = D('Wechat')->GetAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$access_token;
        $result = curlGet($url);
        var_dump($result);
    }
    
    public function deleteMenu()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.D('Wechat')->GetAccessToken();
        $result = curlGet($url);
        var_dump($result);
    }

}

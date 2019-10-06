<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Weixin Menu
 */
class Menu extends CI_Controller {

	public function setMenu()
	{
		$this->load->library('Wechat/wechat_menu', self::getWconfig());
		var_dump($this->wechat_menu->tryCondMenu());
	}	

	/**
	 * [create description]
	 * @author   jingfeiMac  794783766@qq.com
	 * @datetime 2019-09-12T20:04:47+0800
	 * @return   [type]                   [description]
	 */
	public function create()
	{	
		$data = '{
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
                            "name": "网页授权",
                            "url": "http:\/\/weixin.kevinfei.com\/welcome\/webAuth",
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
                                "url": "http:\/\/blog.kevinfei.com\/",
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
        }';
		$this->load->library('Wechat/wechat_menu', self::getWconfig());
        var_dump( $this->wechat_menu->createMenu($data) );
	}

	/**
	 * [get description]
	 * @author   jingfeiMac  794783766@qq.com
	 * @datetime 2019-09-12T20:05:31+0800
	 * @return   [type]                   [description]
	 */
	public function get()
	{
		$this->load->library('Wechat/wechat_menu', self::getWconfig());
        var_dump( $this->wechat_menu->getMenu() );
	}

	/**
	 * [delete description]
	 * @author   jingfeiMac  794783766@qq.com
	 * @datetime 2019-09-12T20:05:36+0800
	 * @return   [type]                   [description]
	 */
	public function delete()
	{
        $this->load->library('Wechat/wechat_menu', self::getWconfig());
        var_dump( $this->wechat_menu->deleteMenu() );
    }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Weixin Authentication
 */
class WeixinVaild extends CI_Controller {

	/**
	 * 微信服务器认证
	 * @author   jingfeiMac
	 * @datetime 2019-09-04T12:52:55+0800
	 * @return   [type]                   [description]
	 */
	public function valid()
	{	
		# 加载对应操作接口
		// $this->load->library('Wechat/lib/Wechat_common', self::getWconfig());
		// $this->wechat_common->valid();
		$this->load->library('Wechat/Wechat_receive', self::getWconfig());
		echo $this->wechat_receive->text('hello')->reply();
	}
	


}
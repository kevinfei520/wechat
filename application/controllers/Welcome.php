<?php

/**
 * Weixin Authentication
 */
class Welcome extends CI_Controller {

	public function index()
	{	
		$this->load->library('Wechat/Wechat_oauth', self::getWconfig());
		$url = $this->wechat_oauth->getOauthRedirect('http://weixin.kevinfei.com/welcome/getuserinfo','STATE');
		echo file_get_contents($url);
	}

	public function getUserInfo()
	{
		var_dump($_GET['code']);
	}

}

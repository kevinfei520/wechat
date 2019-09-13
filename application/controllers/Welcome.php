<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Weixin Authentication
 */
class Welcome extends CI_Controller {

	
	public function index()
	{
		$this->load->library('Wechat/Wechat_oauth', self::getWconfig());
		$url = $this->wechat_oauth->getOauthRedirect('http://weixin.kevinfei.com/welcome/getuserinfo','STATE');
		header("Location: ".$url); 
	}

	public function getUserInfo()
	{	
		if(isset($_GET['code']) && $_GET['code'])
		{
			//拉取用户信息
			$this->load->library('Wechat/Wechat_oauth', self::getWconfig());
			$access = $this->wechat_oauth->getOauthAccessToken();
			$userinfo = $this->wechat_oauth->getOauthUserinfo($access['access_token'],$access['openid']);
			var_dump($userinfo);die;
		}
	}

	
}

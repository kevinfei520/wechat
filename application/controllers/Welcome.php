<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Weixin Authentication
 */
class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function webAuth()
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

	// public function 
}
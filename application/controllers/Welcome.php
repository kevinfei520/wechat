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
			$result = $this->addUserInfo($userinfo);
			var_dump($result);die;
		}
	}

	//添加用户信息
	public function addUserInfo($userinfo)
	{
		if(!empty($userinfo))
		{	
			$data['unionid']     =  isset($userinfo['unionid']) ? $userinfo['unionid']:0;
			$data['sex']         =  isset($userinfo['sex']) ? $userinfo['sex']:0;   
			$data['language']    =  isset($userinfo['language']) ? $userinfo['language']:0;   
			$data['city']   	 =  isset($userinfo['city']) ? $userinfo['city']:0;   
			$data['province']    =  isset($userinfo['province']) ? $userinfo['province']:0;   
			$data['country']     =  isset($userinfo['country']) ? $userinfo['country']:0;    
	        $data['openid']      =  $userinfo['openid'] ;
	        $data['username']    =  $userinfo['nickname'];
	        $data['nickname']    =  $userinfo['nickname'];
	        $data['headimgurl']  =  $userinfo['headimgurl'];
	        $data['status']      =  1;
	        $data['created_at']  =  date('Y-m-d H:i:s',time()); 
	        $data['updated_at']  =  date('Y-m-d H:i:s',time());

	        var_dump($userinfo);
	        var_dump($data);die;

			$this->load->model('user', '' ,true);
			$result = $this->user->insert_user_entry($data);
			var_dump($result);die;

		}

	}

}
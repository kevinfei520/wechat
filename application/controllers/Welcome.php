<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
	// public function index()
	// {
	// 	$this->load->view('welcome_message');
	// }

	public function __construct() {

		parent::__construct();
		
		# 配置参数
		$config = array(
			'token'          => 'WechatToken',
			'appid'          => 'wxf424cee783ba41b8',
			'appsecret'      => '9a3b805dd87ab76c53edd79f5fb937ad',
			'encodingaeskey' => '',
			'type'			 => 'user',
		);
		
		# 加载对应操作接口
		//文件夹名注意大写
		$this->load->library('Wechat/wechat_user', $config);
		
		var_dump($this->wechat_user->getUserList());
	}
	
	public function index(){
		/*
		# 配置参数
		$config = array(
			'token'          => 'openant',
			'appid'          => 'wxfc790e2eb9601add',
			'appsecret'      => '39ea2b90c55ec14462b1967909316895',
			'encodingaeskey' => '',
		);

		# 加载对应操作接口
		$this->wechat->get('User', $config);
		//$userlist = $wechat->getUserList();
		*/
		//var_dump($userlist);
		//var_dump($wechat->errMsg);
		//var_dump($wechat->errCode);
	}

}

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
		$this->load->library('Wechat/Wechat_oauth', self::getWconfig());
		$url = $this->wechat_oauth->getOauthRedirect('http://weixin.kevinfei.com//welcome/getuserinfo','STATE');
		var_dump( $url );die;

		// $this->load->library('Wechat/lib/Wechat_basic');
		// echo $this->wechat_oauth->http_get($url);
		// $this->getOauthRedirect()
	}

	public function getUserInfo()
	{
		var_dump('aa');
	}


}

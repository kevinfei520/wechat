<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Weixin Authentication
 */
class Welcome extends CI_Controller {

	
	public function index()
	{
		$this->load->library('Wechat/Wechat_oauth', self::getWconfig());
		$url = $this->wechat_oauth->getOauthRedirect('http://weixin.kevinfei.com/welcome/getuserinfo','STATE');
		$result = $this->curlGet($url);
		var_dump( $result );
	}

	public function getUserInfo()
	{	
		if(isset($_GET['code']) && $_GET['code'])
		{
			var_dump( $_GET['code'] );
		}
	}
	
	public function curlGet($url,$method='get',$headers='',$data=''){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		if ( !empty($data) ){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Weixin Authentication
 */
class Welcome extends CI_Controller {

	public function getUserInfo()
	{	
		if(isset($_GET['code']) && $_GET['code'])
		{
			var_dump( $_GET['code'] );
		}
		else
		{
			$this->load->library('Wechat/Wechat_oauth', self::getWconfig());
			$url = $this->wechat_oauth->getOauthRedirect('http://weixin.kevinfei.com/welcome/getuserinfo','STATE');
			self::http_get($url);
		}
	}

	/**
     * GET 请求
     * @param string $url
     */
    public static function http_get($url) {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Weixin Authentication
 */
class Menu extends CI_Controller {

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
	
	public function setMenu()
	{
		$this->load->library('Wechat/wechat_menu', self::getWconfig());
		var_dump($this->wechat_menu->getUserList());
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
				     "button":[
				     {    
				          "type":"click",
				          "name":"今日歌曲",
				          "key":"V1001_TODAY_MUSIC"
				      },
				      {
				           "name":"菜单",
				           "sub_button":[
				           {    
				               "type":"view",
				               "name":"搜索",
				               "url":"http://www.soso.com/"
				            },
				            {
				                 "type":"miniprogram",
				                 "name":"wxa",
				                 "url":"http://mp.weixin.qq.com",
				                 "appid":"wx286b93c14bbf93aa",
				                 "pagepath":"pages/lunar/index"
				             },
				            {
				               "type":"click",
				               "name":"赞一下我们",
				               "key":"V1001_GOOD"
				            }]
				       }]
				 }';
		$this->load->library('Wechat/wechat_menu', self::getWconfig());
		var_dump($this->wechat_menu->createMenu($data));
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
		var_dump($this->wechat_menu->getMenu());

	}

	/**
	 * [delete description]
	 * @author   jingfeiMac  794783766@qq.com
	 * @datetime 2019-09-12T20:05:36+0800
	 * @return   [type]                   [description]
	 */
	public function delete()
	{}

}

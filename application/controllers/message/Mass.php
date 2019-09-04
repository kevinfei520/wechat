<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Wechat Message Reply
 */
class Mass extends CI_Controller {

	/**
	 * [index description]
	 * @author   jingfeiMac  794783766@qq.com
	 * @datetime 2019-09-04T13:57:21+0800
	 * @return   [type]                   [description]
	 */
	public function index()
	{
		echo 'hello wechat';
	}

	public function send()
	{
		$this->load->library('Wechat/Wechat_receive', self::getWconfig());
		echo $this->wechat_receive->text('msg tips')->reply();
	}

	public function preview()
	{}

	public function get()
	{

	}

	public function sendall()
	{
		$this->load->library('Wechat/Wechat_receive', self::getWconfig());
		echo $this->wechat_receive->text('msg tips')->reply();
	}

	public function delete()
	{
		
	}
}

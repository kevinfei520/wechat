<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Wechat Message Reply
 */
class Custom extends CI_Controller {

	public function send()
	{
		$this->load->library('Wechat/Wechat_receive', self::getWconfig());
		echo $this->wechat_receive->text('msg tips')->reply();
	}
	
	
}

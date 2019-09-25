<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 微信硬件接入类 - 对接机智云openid接口
*/
const JZYAPPID = "";   // 机智云 appid
const product_key = "";   // 机智云 product_key
const product_secret = "";   // 机智云 product_secret

class ProductController extends Controller
{   
    public function index()
    {	
    	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
    	$postArr = json_decode($postStr,true);
    	if ( empty($postStr) ) {
    		$this->checkSignature();
    	}
    	if ($postArr['msg_type'] === 'bind') {
			// 和微信正常通信后的操作 目前由于没有真正的airkiss ，无法就近搜索设备，和微信配网
			// header("Location: ".'http://www.58djf.com/Wechat/index.php/Home/Product/panel');
			// $myfile = fopen("msg_bind.txt", "w" , $postStr) or die("Unable to open file!");
			// fwrite($myfile, $postStr);
			// fclose($myfile);
    	}else{
    		$openid = $postArr['open_id'];
	    	$deviceid = $postArr['device_id']; //记得存数据库
	    	$token = $this->JzyRegister($openid,$deviceid);
	    	if (!empty($token)) {
	    		$this->Jzybind($token);
	    	}
    	}
	}

	/**
	 * 描述      用于验证服务器配置
	 * @Author   Cabbage.
	 * @DateTime 2018-04-03
	 * @return   [type]     [description]
	 */
	public function checkSignature(){
	    $signature = I('get.signature');
            $timestamp = I('get.timestamp');
            $nonce = I('get.nonce');	
	    $token = "WechatProduct";
            $tmpArr = array($token, $timestamp, $nonce);
	    sort($tmpArr, SORT_STRING);
	    $tmpStr = implode( $tmpArr );
	    $tmpStr = sha1( $tmpStr );

	    if( $tmpStr == $signature ){
	 	$echostr = I('get.echostr');
        	echo  $echostr;
	     }else{
		return false;
	     }    
	}

	/**
	 * 获取设备绑定openID的二维码地址
	 * @Author   Cabbage.
	 * @DateTime 2018-03-30
	 * @return   [type]     [description]
	 */
	public function getOpenid(){
		$access = D('Wechat')->GetAccessToken();
		$url = "https://api.weixin.qq.com/device/getqrcode?access_token=".$access."&product_id=46129";
		$jsondata = curl_post_url( $url );
		$result = json_decode($jsondata);
		$deviceid = $result->deviceid;
		$qrticket = $result->qrticket;
		echo $qrticket;
	}

	/**
	 * 描述      微信设备授权
	 * @Author   Cabbage.
	 * @DateTime 2018-04-03
	 * @return   [type]     [description]
	 */
	public function authorizationDevice(){
		$access_token = D('Wechat')->GetAccessToken();
		$url = "https://api.weixin.qq.com/device/authorize_device?access_token=".$access_token;
		$content = '{
					    "device_num": "1", 
					    "device_list": [
					        {
					            "id": "CzXXFU94ToX8jFibj7PLox", 
					            "mac": "virtual:site", 
					            "connect_protocol": "4", 
					            "auth_key": "", 
					            "close_strategy": "1", 
					            "conn_strategy": "1", 
					            "crypt_method": "0", 
					            "auth_ver": "0", 
					            "manu_mac_pos": "-2", 
					            "ser_mac_pos": "-2"
					        }
					    ], 
					    "op_type": "0", 
					    "product_id": "46129"
					}';
        $result = curl_post_url($url,$content);
        var_dump($result);
	}

	/**
	 * 描述      使用open_id注册机智云新用户
	 * @Author   Cabbage.
	 * @DateTime 2018-04-05
	 * @return   token     用户token
	 */
	public function JzyRegister($openid,$deviceid){
		$url = "http://api.gizwits.com/app/users";
		$content = array(
			'phone_id' => 'normal', 
			'src' => 'wechat',
			'uid' => $openid
		);
		$headers = array(
        	'X-Gizwits-Application-Id:'.JZYAPPID,
        	'Content-Type:application/json',
        );
		$postJson = curl_post_url($url,$content,$headers,$timeout = 60 ,$type=1);
		$postArr = json_decode($postJson,true);
		$data = array(
			'openid' => $openid,
			'deviceid' => $deviceid,
			'appid' => JZYAPPID,
			'token' => $postArr['token'], //token,
			'uid' => $postArr['uid'],
			'expire_at' => $postArr['expire_at'],
			'status' => 0,
			'did' => '',
		);
		$reply = D('JzyInfo')->getFind(['status'=>0,'openid'=>$openid]);
		if ($reply) {
			$date = array(
				'token' => $postArr['token'], //token,
				'uid' => $postArr['uid'],
				'expire_at' => $postArr['expire_at'],
			);
			$result = D('JzyInfo')->saveJzyInfo($reply['id'],$date);
		}else{
			$result = D('JzyInfo')->createJzyInfo($data);
		}
		return empty($result) ? false : $postArr['token'];
	}

	/**
	 * 描述      用户token过期，重新获取用户token
	 * @Author   Cabbage.
	 * @DateTime 2018-04-05
	 * @return   token     用户token
	 */
	public function refreshToken($id,$openid){   //post
		$url = "http://api.gizwits.com/app/users";
		$content = array(
			'phone_id' => 'normal', 
			'src' => 'wechat',
			'uid' => $openid
		);
		$headers = array(
        	'X-Gizwits-Application-Id:'.JZYAPPID,
        	'Content-Type:application/json',
        );
		$postJson = curl_post_url($url,$content,$headers,$timeout = 60 ,$type=1);
		$tokenArr = json_decode($postJson,true);
		$data = array(
			'token' => $tokenArr['token'], //->token,
			'uid' => $tokenArr['uid'], //->uid,
			'expire_at' => $tokenArr['expire_at'],
		);
		$result = D('JzyInfo')->saveJzyInfo($id,$data);
		return empty($result) ? false : $tokenArr['token'];
	}

	/**
	 * 描述      绑定机智云设备
	 * @Author   Cabbage.
	 * @DateTime 2018-04-05
	 * @return   [type]     [description]
	 */
	public function Jzybind($token){
		$result = D('JzyInfo')->getInfo($token);
		if ( intval($result['expire_at']) < time() ) {
			$token = $this->refreshToken($result['id'],$result['openid']);
		}
    	$url = "http://api.gizwits.com/app/bind_mac"; 
    	$headers = array(
    		'X-Gizwits-Application-Id:'.JZYAPPID,
    		'X-Gizwits-User-token:'.$token,
    		'X-Gizwits-Timestamp:'.time(),
    		'X-Gizwits-Signature:'.strtolower( md5(product_secret.time()) ), 
    		'Content-Type:application/json', 
    	);
    	$content = array(
			'product_key' => product_key, 
			'mac' => 'virtual:site',
		);
		$postJson = curl_post_url($url,$content,$headers,$timeout = 60 ,$type=1);
		$postArr = json_decode($postJson,true);
		$data = ['did'=>$postArr['did']];
		$result = D('JzyInfo')->saveJzyInfo($result['id'],$data);
		if (!empty($result)) {
			$this->success('设备绑定成功','/Product/panel/id/'.$result['id'],1);
		}
	}
	
	/**
	 * 描述      硬件面板
	 * @Author   Cabbage.
	 * @DateTime 2018-04-05
	 * @return   [type]     [description]
	 */
	public function panel(){
		$this->display();
	}
    
}

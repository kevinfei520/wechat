<?php 
namespace Home\Model;
use Think\Model;

const APPID ='wx014a9e03aff14def';

/**
 * 网页授权的相关信息存储 --- 目前业务逻辑暂时写模型里，以后再写入service
 */
class WechatOauthModel extends Model
{	

	/**
	 * 描述      获取某个字段  
	 * @Author   Cabbage.
	 * @DateTime 2018-04-03
	 * @param    [string]  $field [字段名]
	 * @return   [获取某个字段]
	 */
	public function getInfo($field){
		return $this->where(['status'=>0])->field($field)->find(); 
	}

	/**
	 * 描述  存储授权后得到信息
	 * @Author   Cabbage.
	 * @DateTime 2018-04-01
	 * @param    $info [description]
	 */
	public function addAccessTokenInfo($info){
		$data = array(
			'access_token' => $info->access_token,
			'refresh_token' => $info->refresh_token,
			'scope' => $info->scope,
			'openid' => $info->openid,
			'createtime' => time()+7200,
			'refresh_time' => time(),
			'status' => 0
		);
		$reslut = $this->add($data);
		return $reslut ? $reslut : false; 
	}

	/**
	 * 描述  	 修改刷新后得到信息
	 * @Author   Cabbage.
	 * @DateTime 2018-04-01
	 * @param    $info [description]
	 */
	public function saveAccessTokenInfo($id,$info){
		$data = array(
			'access_token' => $info->access_token,
			'refresh_token' => $info->refresh_token,
			'scope' => $info->scope,
			'openid' => $info->openid,
			'createtime' => time()+7200,
			'refresh_time' => time(),
			'status' => 0
		);
		$reslut = $this->where(['id'=>$id])->save($data);
		return $reslut ? $reslut : false; 
	}

   /**
     * 用户授权登录
     * @Author   Cabbage.
     * @DateTime 2018-03-30
     * @return   [type]     [description]
     */
    public function login()
    {	
    	$redirect_uri  = urlEncode('http://www.58djf.com/Wechat/index.php/Home/WebOauth/index'); //回调地址
    	$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=0#wechat_redirec";
    	header("Location: ".$url); 
    }
	
	/**
	 * 获取网页access_token
	 * @Author   Cabbage.
	 * @DateTime 2018-04-01
	 * @return   [type]     [description]
	 */
	public function getAccessToken($code)
	{	
		if ( empty($code) ) {
			$where = [ 'status'=>0 ];
			$info = $this->where($where)->find();
			if (intval($info['createtime']) > time()) {
				return empty($info) ? false : $info['access_token'];
			}else{
				if (intval($info['refresh_time']+30*24*3600 < time() )) { //超时 重新获取
					$this->login();
				}else{
					$refresh_token = $info['refresh_token'];
					return $this->refreshAccessToken($refresh_token); //刷新access_token
				}
			}
		}else{
			return $this->getRefreshAccessToken($code);
		}
	}

	/**
	 * 描述      重新获取新的access和refrsh_token
	 * @Author   Cabbage.
	 * @DateTime 2018-04-03
	 * @param    [type]     $code [description]
	 * @return   [type]           [description]
	 */
	public function getRefreshAccessToken($code)
	{
		if (!empty($code)) {
	    	$secret = '954a9770df68c0d3f0abbc1be1eb6cf5';
	    	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".$secret."&code=".$code."&grant_type=authorization_code";
	        $result = curlGet($url);
	        $info = json_decode($result);
	        $reply = $this->addAccessTokenInfo($info);
			return empty($reply) ? false : $info->access_token;
		}
	}

	/**
	 * 描述      刷新access_token
	 * @Author   Cabbage.
	 * @DateTime 2018-04-03
	 * @param    [type]     $refresh_token [description]
	 * @return   [type]                    [description]
	 */
	public function refreshAccessToken($refresh_token)
	{	
		$url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".APPID."&grant_type=refresh_token&refresh_token=".$refresh_token;
		$result = curlGet($url);
		$info = json_decode($result);
		$id = $this->where(['status'=>0])->field('id')->find();
	    $reply = $this->saveAccessTokenInfo($id['id'],$info);
		return empty($reply) ? false : $info->access_token;
	}
	
}
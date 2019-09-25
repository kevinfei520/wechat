<?php 
namespace Home\Model;
use Think\Model;

/**
 * 机智云info模型
 */
class JzyInfoModel extends Model
{	

	/**
	 * 描述      获取机智云信息
	 * @Author   Cabbage.
	 * @DateTime 2018-04-05
	 * @param    integer    $field [description]
	 * @return   [type]            [description]
	 */
	public function getInfo($token){
		$where = array(
			'status' => 0,
			'token' => $token
		);
		return $this->where($where)->find();
	}

	/**
	 * 描述      获取某一条
	 * @Author   Cabbage.
	 * @DateTime 2018-04-05
	 * @return   [type]     [description]
	 */
	public function getFind($where){
		return $this->where($where)->find();
	}

	/**
	 * 描述      新建机智云数据
	 * @Author   Cabbage.
	 * @DateTime 2018-04-05
	 * @param    [type]     $data [description]
	 * @return   [type]           [description]
	 */
	public function createJzyInfo($data){
		return  $this->add($data);
	}

	/**
	 * 描述      修改机智云数据
	 * @Author   Cabbage.
	 * @DateTime 2018-04-05
	 * @param    [type]     $data [description]
	 * @return   [type]           [description]
	 */
	public function saveJzyInfo($id,$data){
		$where = array(
			'id' => $id,
			'status' => 0
		);
		return $this->where($where)->save($data);
	}

	/**
     * 给设备发送开指令
     */
    public function openDevice(){
    	$arropenid = D('WechatOauth')->getInfo('openid');
    	$openid = $arropenid['openid'];
    	$where = array(
    		'openid' => $openid,
    		'status' => 0
    	);
    	$info = $this->getFind($where);
    	$url = "https://api.gizwits.com/app/control/".$info['did'];
		$content = array(
			'attrs' => array( 'onOFF' => 1 )
		);
		$headers = array(
        	'X-Gizwits-Application-Id:'.$info['appid'],
    		'X-Gizwits-User-token:'.$info['token'],
        );
    	$postJson = curl_post_url($url,$content,$headers,$timeout = 60 ,$type=1);
    	return $postJson;
    }

    /**
     * 给设备发送关闭指令
     */
    public function colseDevice(){
    	$arropenid = D('WechatOauth')->getInfo('openid');
    	$openid = $arropenid['openid'];
    	$where = array(
    		'openid' => $openid,
    		'status' => 0
    	);
    	$info = $this->getFind($where);
    	$url = "https://api.gizwits.com/app/control/".$info['did'];
		$content = array(
			'attrs' => array( 'onOFF' => 0 )
		);
		$headers = array(
        	'X-Gizwits-Application-Id:'.$info['appid'],
    		'X-Gizwits-User-token:'.$info['token'],
        );
    	$postJson = curl_post_url($url,$content,$headers,$timeout = 60 ,$type=1);
    	return $postJson;
    }

}
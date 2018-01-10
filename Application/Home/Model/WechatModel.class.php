<?php 
namespace Home\Model;
use Think\Model;

// class WechatModel extends Model 
class WechatModel
{	

	


	/**
	 * 描述      使用curl模拟get请求
	 * @Author   Cabbage.
	 * @DateTime 2018-01-06
	 * @param    $url       请求地址
	 * @param    $method    请求方式
	 * @param    $data     	请求数据
	 * @return   string 请求结果     
	 */		
	public function curlGet($url,$method='get',$data=''){
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
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
        
    public function curl_post_url($url, $content, $timeout = 10) {
        $post = '';
        if (is_array ( $content )) {
            foreach ( $content as $k => $v ) {
                $post .= $k . '=' . $v . '&';
            }
        } else {
            $post = $content;
        }
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
        curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        // curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        // curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        // curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
        $ret = curl_exec ( $ch );
        curl_close ( $ch );
        return $ret;
    }

}
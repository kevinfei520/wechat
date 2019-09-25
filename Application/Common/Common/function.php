<?php 
/**
 * 系统公共库文件
 * 主要定义系统公共函数库
 */


/**
 * 描述      使用curl模拟get请求
 * @Author   Cabbage.
 * @DateTime 2018-01-06
 * @param    $url       请求地址
 * @param    $method    请求方式
 * @param    $data     	请求数据
 * @return   string 请求结果     
 */		
function curlGet($url,$method='get',$headers='',$data=''){
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

/**
* 描述      使用curl模拟post请求
* @Author   Cabbage.
* @DateTime 2018-01-06
* @param    $url       请求地址
* @param    $content   请求内容
* @param    $timeout   超时设置
* @return   string     请求结果      
*/   
function curl_post_url($url, $content='', $headers = 0 ,$timeout = 60 , $type = 0) {
	
	if ($type != 0) {
		$post = json_encode($content);
	}else{
		if (is_array ( $content )) {
		    foreach ( $content as $k => $v ) {
				$post .= $k . '=' . $v . '&';
		    }
		} else {
		    $post = $content;
		}
	}
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
	curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
	curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post );
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	// curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	// curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
	$ret = curl_exec ( $ch );
	curl_close ( $ch );
	return $ret;
}

/**
 * 对数据列表中的某些字段进行加密
 * @param unknown $lists
 * @param unknown $fields，多个字段以逗号隔开
 */
function dataListEncrypt(&$lists, $fields="id"){
	$fieldArray = explode(',', $fields);
	foreach ($lists as &$entry){
		foreach ($fieldArray as $key){
			if(isset($entry[$key]) && $entry[$key] != ''){
				$entry[$key] = en($entry[$key]);
			}
		}
	}
	return $lists;
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key 加密密钥
 * @param int $expire 过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_encrypt($data, $key = '', $expire = 0) {
	$key = md5 ( empty ( $key ) ? C ( 'AUTH_KEY' ) : $key );
	$data = base64_encode ( $data );
	$x = 0;
	$len = strlen ( $data );
	$l = strlen ( $key );
	$char = '';
	
	for($i = 0; $i < $len; $i ++) {
		if ($x == $l)
			$x = 0;
		$char .= substr ( $key, $x, 1 );
		$x ++;
	}
	
	$str = sprintf ( '%010d', $expire ? $expire + time () : 0 );
	
	for($i = 0; $i < $len; $i ++) {
		$str .= chr ( ord ( substr ( $data, $i, 1 ) ) + (ord ( substr ( $char, $i, 1 ) )) % 256 );
	}
	return str_replace ( array (
			'+',
			'/',
			'=' 
	), array (
			'-',
			'_',
			'' 
	), base64_encode ( $str ) );
}

/**
 * 简写加密函数
 */
function en($data, $key = '', $expire = 0) {
	return think_encrypt($data,$key,$expire);
}

/**
 * 系统解密方法
 * 
 * @param string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param string $key 加密密钥
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_decrypt($data, $key = '') {
	$key = md5 ( empty ( $key ) ? C ( 'AUTH_KEY' ) : $key );
	$data = str_replace ( array (
			'-',
			'_' 
	), array (
			'+',
			'/' 
	), $data );
	$mod4 = strlen ( $data ) % 4;
	if ($mod4) {
		$data .= substr ( '====', $mod4 );
	}
	$data = base64_decode ( $data );
	$expire = substr ( $data, 0, 10 );
	$data = substr ( $data, 10 );
	
	if ($expire > 0 && $expire < time ()) {
		return '';
	}
	$x = 0;
	$len = strlen ( $data );
	$l = strlen ( $key );
	$char = $str = '';
	
	for($i = 0; $i < $len; $i ++) {
		if ($x == $l)
			$x = 0;
		$char .= substr ( $key, $x, 1 );
		$x ++;
	}
	
	for($i = 0; $i < $len; $i ++) {
		if (ord ( substr ( $data, $i, 1 ) ) < ord ( substr ( $char, $i, 1 ) )) {
			$str .= chr ( (ord ( substr ( $data, $i, 1 ) ) + 256) - ord ( substr ( $char, $i, 1 ) ) );
		} else {
			$str .= chr ( ord ( substr ( $data, $i, 1 ) ) - ord ( substr ( $char, $i, 1 ) ) );
		}
	}
	return base64_decode ( $str );
}
/**
 * 简写的解密函数
 * @param unknown $data
 * @param string $key
 * @return string
 */
function de($data, $key = '') {
	return think_decrypt($data, $key);
}

?>
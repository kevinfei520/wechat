<?php 
namespace Home\Model;
use Think\Model;

// class WechatModel extends Model 
class WechatModel extends Model
{	

    /**
     * 描述      获取$access_token
     * @Author   Cabbage.
     * @DateTime 2018-01-06
     * @return   access_token   string
     */
    public function GetAccessToken()
    {
        $info = $this->where(['type'=>1,'status'=>0])->find();  //目前是测试环境 0正式 1测试
        if ( !empty($info) ) {
                if (!empty($info["early_time"]) ) {
                    if ( intval($info["early_time"]) > time() ) {   //判断access_token是否过期
                        return $access_token = $info['access_token'];
                    }else{
                        $access_token = $this->CurlGetAccessToken( $info['appid'] , $info['secret'] );
                        $access_token = json_decode($access_token,true);
                        $data['access_token'] = $access_token['access_token'];
                        $data['early_time'] = time()+7200;
                        $res = M('Wechat')->where( ['id'=>$info['id']] )->save( $data );
                        $access_token = $data['access_token'];
                        return  ($access_token ? $access_token :'sorry add error' );
                    }
                }else{  echo "no early_time!"; }
        }else{  echo " no info";  }
    }
     /*
     * 描述         使用curl获取access_token
     * @Author      Cabbage.
     * @DateTime    2018-01-06
     * @param       $appid    微信appid
     * @param       $secret   微信验证的密匙
     * @return      access_token   json
     */
    public function CurlGetAccessToken( $appid , $secret )
    {   
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
        return curlGet($url);
    }



	


}

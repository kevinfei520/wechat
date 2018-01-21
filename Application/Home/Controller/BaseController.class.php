<?php
namespace Home\Controller;
use Think\Controller;
define("TOKEN", "WechatToken");
class BaseController extends Controller {

    public function valid() 
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $myfile = fopen("newfile.txt", "w" , $postStr) or die("Unable to open file!");
        fwrite($myfile, $postStr);
        fclose($myfile);

        //extract post data
        if (!empty($postStr)){
            
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>"; 

            if(!empty( $keyword ))
            {   
                $msgType = "text";
                $contentStr = "Welcome to wechat world!";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }else{
                echo "Input something...";
            }


        }else {
            echo "没收到您发的信息，请重试！"; exit;
        }
    }

    /**
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
        return D('Wechat')->curlGet($url);
    }

    /**
     * 描述      获取$access_token
     * @Author   Cabbage.
     * @DateTime 2018-01-06
     * @return   access_token   string
     */
    public function GetAccessToken()
    {
        $info = M('Wechat')->where(['type'=>1,'status'=>0])->select();  //目前是测试环境
        if ( !empty($info) ) {
                if (!empty( $info[0]["early_time"] ) ) {
                    if (  $info[0]["early_time"] > time() ) {   //判断access_token是否过期
                        return $access_token = $info[0]['access_token'];
                    }else{
                        $access_token = $this->CurlGetAccessToken( $info['0']['appid'] , $info['0']['secret'] );
                        $access_token = json_decode($access_token,true);
                        $data['access_token'] = $access_token['access_token'];
                        $data['early_time'] = time()+7200;
                        $res = M('Wechat')->where( ['id'=>$info['0']['id']] )->save( $data );
                        $access_token = $data['access_token'];
                        return ( $access_token ? $access_token :'sorry add error' );
                    }
                }else{  echo "no early_time!"; }
        }else{  echo " no info";  }
    }







}

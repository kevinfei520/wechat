<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 微信业务类
 */
class WechatController extends BaseController
{	
	public function index(){
		$access_token = $this->GetAccessToken();
		
	}

	public function AutoReply( $postObj ){   //自动回复 

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
		    $talking = new autoreply;
			    
            }else{
                $msgType = "text";
                $contentStr = "Sorry ! I don't know what you're talking about！";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
	}




}

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
            $msgType = $postObj->MsgType;
            switch ( $msgType ) {
                case 'text':
                    if ($keyword === '开启') {
                        $result = D('JzyInfo')->openDevice();
                        if (!empty($result)) {
                             echo $this->autoReplyText($fromUsername,$toUsername,'设备已开启！'); 
                        }else{
                             echo $this->autoReplyText($fromUsername,$toUsername,'设备已开启失败！') ;
                        }
                    } else if( $keyword === '关闭'){
                        $result = D('JzyInfo')->colseDevice();
                        if (!empty($result)) {
                             echo $this->autoReplyText($fromUsername,$toUsername,'设备已关闭！'); 
                        }else{
                             echo $this->autoReplyText($fromUsername,$toUsername,'设备已关闭失败！') ;
                        }
                    }
                break;
                case 'image':
                    echo $this->autoReplyText($fromUsername,$toUsername,'i m is image');
                break;
                case 'location':
                    echo $this->autoReplyText($fromUsername,$toUsername,'i m is gps');
                break;
                case 'event':
                    $this->autoReplyEvent($fromUsername,$toUsername,$postObj);
                break;
                default:
                    echo  $this->autoReplyText($fromUsername,$toUsername,$msgType);
                break;
            }
        }else {
            echo "没收到您发的信息，请重试！"; exit;
        }
    }
    
    /**
     * 描述  自动回复文本  
     * @Author   Cabbage.
     * @DateTime 2018-03-12
     * @return   [type]     [description]
     */
    public function autoReplyText($fromUsername,$toUsername,$text){
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                </xml>";
        $time = time();
        $msgType = 'text';
        $contentStr = $text;
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        return $resultStr;
    }

    /**
     * 描述  事件的自动推送  
     * @Author   Cabbage.
     * @DateTime 2018-03-12
     * @return   [type]     [description]
     */
    public function autoReplyEvent($fromUsername,$toUsername,$postObj){
        $event = $postObj->Event;
        switch ($event) {
            case 'subscribe':
                echo $this->autoReplyText($fromUsername,$toUsername,'终于等到您，谢谢您的关注！');
            break;
            case 'unsubscribe':
                echo $this->autoReplyText($fromUsername,$toUsername,'您已取消关注');
            break;
            // case 'SCAN':
            //     echo $this->autoReplyText($fromUsername,$toUsername,'I’m Sorry ，you is scan');
            // break;
            // case 'LOCATION':
            //     echo $this->autoReplyText($fromUsername,$toUsername,'I’m Sorry ，i`m location');
            // break;
            default:
                echo $this->autoReplyText($fromUsername,$toUsername,'I’m Sorry ' );
            break;
        }
    }


}
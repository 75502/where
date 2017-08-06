<?php
/**
  * wechat php test
  */
require 'common.php';
require 'Wechat.class.php';
//define your token

define("TOKEN", "jiuye");

class wechatCallbackapiTest extends Wechat
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = file_get_contents("php://input");

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                global $tmp_arr;
	            switch($postObj->MsgType){
case 'text';
if($keyword=='图片'){
$msgType = "image";
$mediaid='YTJtwEC4WeuTdEWqxVMc3Ol728llHmsS2_ulhhdmCw1-5QRYPC8sT6u_v3j3oLPT';
$resultStr = sprintf($tmp_arr['image'], $fromUsername, $toUsername, $time, $msgType, $mediaid);

                        echo $resultStr;
}elseif($keyword=='音乐'){
$msgType = "music";
$title='十年';
$url='http://www.itshop.top/music.mp3';
$description='陈奕迅成名曲';
$hqurl='http://www.itshop.top/music.mp3';
// $mediaid='RqdshK-j8mvhJtRMEyI3gsCUvOvvalTmMNr1uRbV55s3A34jkOf29y7zPt3uYzqu';
$resultStr = sprintf($tmp_arr['music'], $fromUsername,$toUsername, $time, $msgType, $title,$description,$url,$hqurl);
file_put_contents('wx.log', $resultStr, FILE_APPEND);
echo $resultStr;
}elseif($keyword=='单图文'){
    $msgType='news';
    $count=1;
    $str = '<item>
<Title><![CDATA[美女]]></Title>
<Description><![CDATA[流鼻血的美女]]></Description>
<PicUrl><![CDATA[http://www.itshop.top/images/timg1.jpg]]></PicUrl>
<Url><![CDATA[http://www.itshop.top/]]></Url>
</item>';
//使用sprintf函数对XML模板进行格式化
$resultStr = sprintf($tmp_arr['news'], $fromUsername, $toUsername, $time, $msgType, $count, $str);
//使用file_put_contents把格式化后的XML代码写入到日志中
file_put_contents('wx.log', $resultStr, FILE_APPEND);
//返回格式化后的XML数据到客户端
echo $resultStr;
}elseif($keyword == '多图文') {
//定义相关变量
$msgType = "news";
//定义图文数量
$count = 2;
//定制$str(item选项）
$str = '<item>
<Title><![CDATA[美女]]></Title>
<Description><![CDATA[美女...]]></Description>
<PicUrl><![CDATA[http://www.itshop.top/images/timg1.jpg]]></PicUrl>
<Url><![CDATA[http://www.itshop.top/]]></Url>
</item>
<item>
<Title><![CDATA[美女？]]></Title>
<Description><![CDATA[美女...]]></Description>
<PicUrl><![CDATA[http://www.itshop.top/images/timg2.jpg]]></PicUrl>
<Url><![CDATA[http://www.itshop.top/]]></Url>
</item>
<item>
<Title><![CDATA[美女？]]></Title>
<Description><![CDATA[美女...]]></Description>
<PicUrl><![CDATA[http://www.itshop.top/images/timg3.jpg]]></PicUrl>
<Url><![CDATA[http://www.itshop.top/]]></Url>
</item>
';
//使用sprintf函数对XML模板进行格式化
$resultStr = sprintf($tmp_arr['news'], $fromUsername, $toUsername, $time, $msgType, $count, $str);
//返回格式化后的XML数据到客户端
echo $resultStr;
                        }elseif($keyword=='文本'){
$access_token=$this->get_token();
$url="https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
$contentStr='客服消息接口';
$contentStr=urlencode($contentStr);
$content_arr=array('content'=>$contentStr);
$reply_arr=array('touser'=>"{$fromUsername}",'msgtype'=>'text','text'=>$content_arr);
$data=json_encode($reply_arr);
$data=urldecode($data);
$this->http_request($url,$data);
                        }
                    break;
                    case 'image':
                    $msgType = "text";
                    $contentStr = "你发送的是图片消息";
                    $resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    break;
                     case 'voice':
                    $msgType = "text";
                    $contentStr = "你发送的是语音消息";
                    $resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                    break;
                      case 'event':
                      if($postObj->Event=='CLICK' && $postObj->EventKey=='V1001_TODAY_MUSIC'){
$msgType = "music";
$title='十年';
$url='http://www.itshop.top/music.mp3';
$description='陈奕迅成名曲';
$hqurl='http://www.itshop.top/music.mp3';
// $mediaid='RqdshK-j8mvhJtRMEyI3gsCUvOvvalTmMNr1uRbV55s3A34jkOf29y7zPt3uYzqu';
$resultStr = sprintf($tmp_arr['music'], $fromUsername,$toUsername, $time, $msgType, $title,$description,$url,$hqurl);
file_put_contents('wx.log', $resultStr, FILE_APPEND);
echo $resultStr;
}
                      if($postObj->Event=='subscribe'){
$msgType = "text";
$contentStr = "感谢你的关注";
$resultStr = sprintf($tmp_arr['text'], $fromUsername, $toUsername, $time, $msgType, $contentStr);
echo $resultStr;
}

                    break;
                }

        }else {
        	echo "";
        	exit;
        }
    }

	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();
?>
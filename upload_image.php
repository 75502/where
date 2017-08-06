<?php
//header("content-type:text/html;charset=utf-8");
require 'get_token.php';
$url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type=image";
$data['media']='@'.dirname(__FILE__).'/1998.jpg';
$str=http_request($url,$data);
$json=json_decode($str);
$media_id=$json->media_id;
echo $media_id;
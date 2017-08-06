<?php
$url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxebfabddb9b2c7400&secret=ca61da3a60d92cbd8623bc6790002e12';
$str=http_request($url);
$json=json_decode($str);
$access_token=$json->access_token;
//var_dump($access_token);die;
  function http_request($url,$data=null){
  	$ch=curl_init();
  	curl_setopt($ch,CURLOPT_URL,$url);
  	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
  	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
  	if(!empty($data)){
  		curl_setopt($ch,CURLOPT_POST,1);
  		curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
  	}
  	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  	$output=curl_exec($ch);
  	curl_close($ch);
  	return $output;
  }
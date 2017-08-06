<?php
header("content-type:text/html;charset=utf-8");
require 'get_token.php';
$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";
$data = ' {
     "button":[
     {
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {
               "type":"view",
               "name":"搜索",
               "url":"http://www.soso.com/"
            },
            {
                 "type":"view",
                 "name":"视频",
                 "url":"http://v.qq.com"
             },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';

 $str=http_request($url,$data);
 $json=json_decode($str);
 if($json->errmsg=='ok'){
 	echo '自定义菜单ok';
 }
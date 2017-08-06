<?php
class Wechat{

    //定义get_token 获取 anness_token
    protected function get_token(){
        $appid = 'wxebfabddb9b2c7400';
        $appsecret = 'ca61da3a60d92cbd8623bc6790002e12';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

        $output = curl_exec($ch);

        curl_close($ch);

        $json = json_decode($output);

        $access_token = $json->access_token;

        return $access_token;

    }

    //定义http_request  获取httpq请求
    protected function http_request($url,$data=null){
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);

        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

        if(!empty($data)){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        }

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/10
 * Time: 19:44
 */

namespace app\common\lib;


class Curl
{
    public static function http_get($url){
        //开启curl
        $ch = curl_init();
        //设置传输选项
        //设置传输地址
        curl_setopt($ch,CURLOPT_URL,$url);
        //以文件流的形式返回
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //发送curl
        $arr = curl_exec($ch);
        $arrs = json_decode($arr,TRUE);
        var_dump($arrs) ;
        //关闭资源
        curl_close($ch);


    }

    public  static  function http_curl($url, $type = 'get', $res = 'json', $arr = '')
    {
        //初始化curl
        $ch = curl_init();
        //设置超时
        //curl_setopt($ch, CURLOP_TIMEOUT, $this->curl_timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($type == 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }
        //运行curl，结果以jason形式返回
        $output = curl_exec($ch);
        curl_close($ch);
        if ($res == 'json') {
            return json_decode($output, true);
        }
        //取出
        //dump($output);
        return $output;
    }

}
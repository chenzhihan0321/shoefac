<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/11
 * Time: 10:05
 */

namespace app\common\lib;

use app\common\lib\Curl;
class Token
{
    public $appid = "wx3e623fd877e89cf1";
    public $appsecret = "7be828e68383855bc9c70708cbf038e5";
    public function getWxAccessToken($appid= "wx3e623fd877e89cf1",$appsecret="7be828e68383855bc9c70708cbf038e5")
    {
        $url = " https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        Curl::http_curl($url);
    }

    public function createMenu(){

        $url =  'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $this->getWxAccessToken();
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
                         "type":"miniprogram",
                         "name":"wxa",
                         "url":"http://mp.weixin.qq.com",
                         "appid":"wx286b93c14bbf93aa",
                         "pagepath":"pages/lunar/index"
                     },
                    {
                       "type":"click",
                       "name":"赞一下我们",
                       "key":"V1001_GOOD"
                    }]
               }]
         }';
        Curl::http_curl($url,'post','json',$data);
    }
}
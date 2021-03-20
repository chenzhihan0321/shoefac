<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/2
 * Time: 16:43
 */

namespace app\api\controller;


class Logout extends AuthBase
{
    public  function  index(){
        //删除 redis  token 缓存
        $res = cache(config("redis.token_pre").$this->accessToken,NULL);
        if($res){
            return show(config("status.success"),"退出登录成功");
        }
        return show(config("status.error"),"退出登录失败");
    }

}
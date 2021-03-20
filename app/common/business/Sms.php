<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/28
 * Time: 10:52
 */

declare(strict_types=1);
namespace app\common\business;

use app\common\lib\sms\AliSms;
use app\common\lib\Num;
use app\common\lib\ClassArr;


class Sms
{
    public static  function  sendCode(string  $phoneNumber ,int $len,string $type = "ali") :bool {
        //我们需要生成验证码 4位 6位
        $code = Num::getCode($len);
       //$sms =AliSms::sendCode($phoneNumber,$code);
        //工厂模式
//        $type = ucfirst($type);
//        $class = "app\common\lib\sms\\".$type."Sms";
//        $sms = $class::sendCode($phoneNumber,$code);
        $classStats =  ClassArr::smsClassStat();
        $classObj = ClassArr::initClass($type,$classStats);
        $sms = $classObj::sendCode($phoneNumber,$code);
       if($sms){
           //需要把我们的短信验证码记录到redis 并且需要给出一个失效时间 1分钟有效
          //1. 我们的php环境是否有redis拓展 redis.dll linux unix:redis.so
           //2.redis服务
           cache(config("redis.code_pre").$phoneNumber,$code,config("redis.code_expire"));


       }
        return $sms;

    }
}
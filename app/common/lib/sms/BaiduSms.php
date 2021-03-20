<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/29
 * Time: 8:59
 */

declare(strict_types=1);
namespace app\common\lib\sms;


class BaiduSms implements  SmsBase
{
   public static  function  sendCode(string $phone, int $code){
       return true;
   }
}
<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/29
 * Time: 9:15
 */
declare(strict_types =1);
namespace app\common\lib\sms;


interface SmsBase
{
    public  static  function  sendCode(string  $phone ,int $code);

}
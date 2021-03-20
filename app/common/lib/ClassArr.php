<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/29
 * Time: 9:30
 */

namespace app\common\lib;


class ClassArr
{
    public  static  function smsClassStat(){
        return [
            "ali" =>"app\common\lib\sms\Alisms",
            "baidu" => "app\common\lib\sms\Baidu",
            "jd" =>"app\common\lib\sms\JdSms"
        ];
    }
    public  static  function  uploadClassStat(){
        return [
            'text' => 'xxx',
            'image' => 'xxx',
        ];
    }
    public static  function  initClass($type,$classs,$param = [],$needInstance = false){
        //如果我们工厂模式调用的方法是静态的，那么我们这个地方返回类库 AliSms
        //如果不是静态的，我们就需要返回 对象
          if(!array_key_exists($type,$classs)){
                   return false;
          }
          $className = $classs[$type];
         // new ReflecttionClass('A') =>建立A反射类
        //->newInstanceArgs($args) =>相当于实例化A对象
          return $needInstance == true ? (new \ReflectionClass($className))->newInstanceArgs($param):$className;
    }

}
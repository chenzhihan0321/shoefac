<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/6/29
 * Time: 22:32
 */

namespace app\common\lib;


class Time
{
    public static  function  userLoginExpiresTime($type = 2){
        $type  = !in_array($type,[1,2]) ? 2: $type;
        if($type == 1){
            $day = $type * 7;
        }elseif ($type == 2){
            $day = $type * 15 ;
        }
        return $day * 24 * 3600;
    }
}
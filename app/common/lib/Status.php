<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/4
 * Time: 20:37
 */

namespace app\common\lib;


class Status
{
    public  static  function  getTableStatus(){
        $mysqlStatus = config("status.mysql");
        return array_values($mysqlStatus);
    }

}
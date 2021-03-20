<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/14
 * Time: 13:06
 */

namespace app\common\lib;


class Key
{
    /**
     * userCart 记录用户的购物车的redis key
     * @param $userId
     * @return string
     */
    public static  function  userCart($userId){
        return config("redis.cart_pre").$userId;
    }

}
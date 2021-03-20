<?php
/**
 * Num 记录和数据相关的类库
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/28
 * Time: 16:38
 */
declare(strict_types =1);
namespace  app\common\lib;

class  Num {
    /**
     *
     * @param int $len
     * @return int
     */
   public  static  function getCode( int $len = 4) :int{
       $code = rand(1000,9999);
       if($len ==6) {
           $code = rand(100000,999999);
       }
       return $code;
   }

}
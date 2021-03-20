<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/23
 * Time: 15:03
 */

namespace app\demo\controller;


use app\BaseController;
use app\common\business\Demo;
use app\common\lib\Snowflake;
class Index   extends  BaseController
{
    public function  index(){
        $categoryId = $this-> request->param("category_id",0,"intval");
        if(empty($categoryId)){
            return show(config("status.error"),"参数错误");
        }
        $demo = new Demo();
        $res = $demo->getDemoDataByCategoryId($categoryId);
        return  show(config("status.success"),"ok",$res);
    }
    public function hello(){
        echo microtime();
        $time = explode(' ', microtime());
        echo '--------------';
        dump($time);
        $time2 = substr($time[0], 2, 3);
        return $time[1] . $time2;
    }
    public  function  abc(){
        phpinfo();
    }
    public function test(){
        $workId = rand(1,1023);
        $orderId = Snowflake::getInstance()->setWorkId($workId)->id();
        dump($orderId);exit;
    }
     public function FindIndexFromArray(){
        $num = [1,5,8,10,15,18,22,33,88,102,166,235,456,PHP_INT_MAX,PHP_INT_MAX,PHP_INT_MAX,PHP_INT_MAX,PHP_INT_MAX,PHP_INT_MAX];
       // $this->solution($num,33);
        return    $this->solution($num,33);

     }
     public function  solution($num ,$target){
        //首先找到右边临界点
         $result = -1;
         //处理临界值
         if( $num == null || count($num) == 0){
             return $result;
         }
         if($num[0] == PHP_INT_MAX){
             return $result;
         }elseif($num[0] == $target){
             return 1;
         }

         $i = 1;

         while($num[$i] != PHP_INT_MAX){// 遇到MAX就停止
             if($num[$i] == $target){
                 return $i;
             }

             $i *= 2;

         }
         $res = $this->binarySearch($num,$target,0,$i);

         return $res;
     }

     public  function  binarySearch($num,$target,$low,$high){
        $left = $low ;
        $right = $high;

        while($left <= $right){
             $mid = $left +(($right-$left) >> 1);

             if($num[$mid] > $target ){
                 $right = $mid -1;

             }elseif ($num[$mid] < $target){
                 $left = $mid +1;
             }else{
                 return $mid;
             }

        }

        return -1;

     }


}
<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/23
 * Time: 9:36
 */

namespace app\controller;


use app\BaseController;

class Index extends  BaseController
{
    /**
     * @return string
     */
    public  function index()
    {
        //phpinfo();
        $arrs = [1,2,8,4];
        $s = 12;
        $ab = 'asdsa';
        $cd = 'sdas';
        $ab = 'asdsa';
        $cd = 'sdas';

        $ab = 'asdsa';
        $cd = 'sdas';
        $ab = 'asdsa';
        $cd = 'sdas';
        //$ab = 'asdsa';
        $cd = 'sdas';
        $ab = 'asdsa';
        $cd = 'sdas';
        if($s >10){
            $arr1 = array_push($arrs,$s);
            //var_dump($arr1);
            echo $ab;
        }else{
            $arr2 = array_push($arrs,1);
           // var_dump($arr2);
           echo  $cd;
        }
        return  '1111';
    }
    public  function  abc()
    {
        return  '22';
    }
}
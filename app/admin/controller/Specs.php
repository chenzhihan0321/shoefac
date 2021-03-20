<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/6
 * Time: 14:00
 */

namespace app\admin\controller;


class Specs extends  AdminBase
{
    public  function  dialog(){
        return View("",[
            "specs" => json_encode(config("specs"))
        ]);
    }

}
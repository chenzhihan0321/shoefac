<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/6
 * Time: 16:32
 */

namespace app\admin\controller;

use app\common\business\SpecsValue as SpecsValuseBis;
class SpecsValue extends  AdminBase
{
    public function save(){
        $specsId = input("param.specs_id",0,"intval");
        $name = input("param.name","","trim");
        //需要validate验证机制自行验证参数

        $data = [
            "specs_id" => $specsId,
            "name" => $name,
        ];
        $id = (new SpecsValuseBis())->add($data);
        if(!$id){
            return show(config("status.error"),"新增失败");
        }
        return show(config("status.success"),"OK",["id" => $id]);
    }
    public  function  getBySpecsId(){
        $specsId = input("param.specs_id",0,"intval");
        if(!$specsId){
            return show(config('status.success'),"没有数据");
        }
        $result = (new SpecsValuseBis())->getBySpecsId($specsId);
        return show(config('status.success'),"OK",$result);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/6
 * Time: 16:56
 */

namespace app\common\model\mysql;


use think\Model;

class SpecsValue extends  BaseModel
{

    public  function  getNormalBySpecsId($specsId,$field="*"){
        $where = [
            "specs_id" => $specsId,
            "status" => config("status.mysql.table_normal")
        ];
        $res = $this->where($where)
            ->field($field)
            ->select();
        return $res;
    }


}
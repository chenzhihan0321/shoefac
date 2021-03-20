<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/24
 * Time: 14:21
 */

namespace app\common\model\mysql;



class Category extends  BaseModel
{

    public  function  getCategoryNameByName($name){
        if(empty($name)){
            return false;
        }
        $where =[
            "name" => $name,
        ];
        $result = $this->where($where)->find();
        if($result){
            return true;
        }
        return false;
    }

    /**
     *
     * @param string $field
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public  function  getNormalCategorys($field = "*"){
        $where = [
            "status" => config("status.mysql.table_normal"),
        ];
        $order = [
            "listorder" =>"desc",
            "id" => "desc"
        ];
        $result = $this->where($where)
            ->field($field)
            ->order($order)
            ->select();
        return $result;
    }
    public function getLists($where,$num = 10){
        $order = [
            "listorder" =>"desc",
            "id" => "desc"
        ];
        $result = $this->where("status","<>",config("status.mysql.table_delete"))
              ->where($where)
              ->order($order)
              ->paginate($num);
        return $result;
    }



    /**
     * 获取子级栏目
     * @param $condition
     * @return mixed
     */
    public function  getChildCountInPids($condition){
        $where[] = ["pid","in",$condition['pid']];
        $where[] = ["status","<>",config("status.mysql.table_delete")];
        $res = $this->where($where)
            ->field(["pid","count(*) as count"])
            ->group("pid")
            ->select();
        //echo $this->getLastSql();exit;
        return $res;
    }

    public function  getNormalByPid($pid = 0,$field){
        $where = [
            "pid" => $pid,
            "status" => config("status.mysql.table_normal"),
        ];
        $order = [
            "listorder" => "desc",
            "id" => "desc"
        ];
        $res  = $this->where($where)
             ->field($field)
             ->order($order)
             ->select();
        return $res;
    }
    public function getNormalGoodsRecommendCategoryInfo($categoryId,$limit = 10){
        $order = [
            "listorder" => "desc",
            "id" =>"desc"
        ];
        $field = "id as category_id,name,icon";
        $categoryInfo = $this->where("id|pid","=",$categoryId)
            ->where("status","=",config("status.mysql.table_normal"))
            ->order($order)
            ->field($field)
            ->limit($limit)
            ->select();

        return $categoryInfo->toArray();
    }
    public function getNormalCategoryInfoById($id){
        $order = [
            "listorder" => "desc",
            "id" =>"desc"
        ];
        $field = "id,name";
        $categoryInfo = $this->where("id|pid","=",$id)
            ->where("status","=",config("status.mysql.table_normal"))
            ->order($order)
            ->field($field)
            ->select();

        return $categoryInfo->toArray();
    }

    public  function  getNormalCategoryInfoSubById($id){
        $order = [
            "listorder" => "desc",
            "id" =>"desc"
        ];
        $field = "id,name";
        $categoryInfo = $this->where("pid","=",$id)
            ->where("status","=",config("status.mysql.table_normal"))
            ->order($order)
            ->field($field)
            ->select();
        return $categoryInfo->toArray();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/7
 * Time: 13:00
 */

namespace app\common\model\mysql;


use think\Model;

class BaseModel  extends  Model
{
    protected $autoWriteTimestamp =true;
    public  function updateById($id,$data){
        $data['update_time'] = time();
        return $this->where(["id" => $id])->save($data);
    }
    public function getNormalInIds($ids){
        return $this->whereIn("id",$ids)
            ->where("status","=",config("status.mysql.table_normal"))
            ->select();
    }
    /**
     * 根据条件查询 ，老师准备好的代码，带小伙伴解读下就可以
     * @param array $condition
     * @param array $order
     * @return bool|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getByCondition($condition = [], $order = ["id" => "desc"]) {
        if(!$condition || !is_array($condition)) {
            return false;
        }
        $result = $this->where($condition)
            ->order($order)
            ->select();

        ///echo $this->getLastSql();exit;
        return $result;
    }
}
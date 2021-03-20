<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/6
 * Time: 21:16
 */

namespace app\common\business;


class BusBase
{
    /*
    * 新增逻辑
    * */
    public function add($data){
        $data['status'] = config("status.mysql.table_normal");
        //根据name 查询 $name 是否存在 （需自行完成）
        try{
            $this->model->save($data);
        }catch (\Exception $e){
            //记录日志 ，便于后续问题的排查工作
            throw new \think\Exception($e->getMessage());
            return 0;
        }
        //返回主键ID
        return $this->model->id;
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
<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/24
 * Time: 14:21
 */

namespace app\common\model\mysql;


use think\Model;

class User extends  Model
{
    /**
     * 自动生成写入时间
     * @var bool
     */
    protected  $autoWriteTimestamp = true;
    public  function  getUserByPhoneNumber($phoneNumber){
    if(empty($phoneNumber)){
        return false;
    }
     $where =[
         "phone_number" => $phoneNumber,
     ];
    $result = $this->where($where)->find();
    return $result;
    }

    /**
     * 通过ID获取用户数据
     * @param $id
     * @return array|bool|null|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public  function  getUserById($id){
    $id = intval($id);
    if(!$id){
        return false;
    }
     return $this->find($id);
    }
    public  function  getUserByUsername($username){
        if(empty($username)){
            return false;
        }
        $where =[
            "username" => $username,
        ];
        $result = $this->where($where)->find();
        return $result;
    }
    /*
     * 根据主键ID更新数据表中的数据
     * */
    public function  updateById($id,$data){
      $id = intval($id);
      if(empty($id) || empty($data) || !is_array($data)){
          return false;
      }
      $where = [
          "id" => $id,
      ];
      return $this->where($where)->save($data);
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/3
 * Time: 9:21
 */

namespace app\common\business;

use app\common\model\mysql\Category as CategoryModel;
class Category
{
    public $model = null;
    public function  __construct()
    {
        $this->model = new CategoryModel();
    }

    public  function  add($data){
        $data['status'] = config("status.mysql.table_normal");
        $name = $data['name'];
        //根据$name 去数据库查询是否存在这条记录
        $categroyname = $this->model->getCategoryNameByName($name);
        if($categroyname){
            throw new \think\Exception("分类名已存在，请重新输入");
        }
        try{
        $this->model->save($data);
        }catch (\Exception $e){
            throw new \think\Exception("服务内部异常");
        }
        return $this->model->id;
    }
    public  function  getNormalCategorys(){
        $field = "id,name,pid";
        $categorys = $this->model->getNormalCategorys($field);
        if(!$categorys){
            $categorys = [];
        }
        $categorys = $categorys->toArray();
        return  $categorys;
    }
    public  function  getNormalAllCategorys(){
        $field = "id as category_id,name,pid";
        $categorys = $this->model->getNormalCategorys($field);
        if(!$categorys){
            $categorys = [];
        }
        $categorys = $categorys->toArray();
        return  $categorys;
    }
    public function  getLists($data,$num){
        $list = $this->model->getLists($data, $num);
        //模拟异常
        //throw new \think\Exception("abc");
        if(!$list) {
            return [];
        }

        $result = $list->toArray();
        $result['render'] = $list->render();

        /***以下为带领同学们解读代码***/
        // 思路： 第一步拿到列表中id 第二步：in mysql 求count  第三步：把count填充到列表页中
        $pids = array_column($result['data'], "id");
        if($pids) {
            $idCountResult = $this->model->getChildCountInPids(['pid' => $pids]);
            $idCountResult = $idCountResult->toArray(); //  如果没有的话会返回空数组

            $idCounts = [];
            // 第一种方式
            foreach($idCountResult as $countResult) {
                $idCounts[$countResult['pid']] = $countResult['count'];
            }
        }
        if($result['data']) {
            foreach($result['data'] as $k => $value) {
                /// $a ?? 0 等同于 isset($a) ? $a : 0。
                $result['data'][$k]['childCount'] = $idCounts[$value['id']] ?? 0;
            }
        }

        /****解读end*****/

        return $result;
    }

    /**
     * 根据ID获取某一条记录
     * @param $id
     * @return array|null|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
     public function  getById($id){
        $result = $this->model->find($id);
        if(empty($result)){
            return [];
        }
        $result = $result->toArray();
        return  $result;
     }
    /**
     * 排序bis
     * @param $id
     * @param $listorder
     * @return bool
     * @throws \think\Exception
     */
    public  function  listorder($id,$listorder){
        //查询 id这条数据是否存在
        $res = $this-> getById($id);
        if(!$res){
            throw new \think\Exception("不存在该条记录");
        }
        $data = [
            "listorder" => $listorder
        ];
        try{
            $res = $this-> model->updateById($id,$data);
        }catch (\Exception $e){
            //需要记录日志
            return false;
        }
        return $res;
    }

    /**
     * 修改状态
     * @param $id
     * @param $status
     */
    public  function  status($id,$status){
        //查询 ID
        $res = $this->getById($id);
        if(!$res){
            throw  new \think\Exception("不存在该条记录");
        }
        if($res['status'] == $status){
            throw new \think\Exception("状态修改前和修改后一样没有任何意义");
        }
        $data = [
            "status" => intval($status),
        ];
        try{
            $res = $this->model->updateById($id,$data);
        }catch (\Exception $e){
            return false;
        }
        return $res;
    }

    /**
     * 获取一级栏目
     * @param int $pid
     * @param string $field
     * @return array
     */
    public function  getNormalByPid($pid = 0 ,$field = "id , name, pid"){
        //$field = "id,name,pid"
        try{
            $res = $this->model->getNormalByPid($pid,$field);
        }catch (\Exception $e){
            //记录日志
            return [];
        }
        $res = $res->toArray();
        return $res;

    }

    /**
     * 根据id值获取该分类下所有相关的二级，三级分类
     * @param $id
     */
    public function getNormalCategoryInfoById($id)
    {

        $categoryInfo = $this->getById($id);
        if (!$categoryInfo) {
            return [];
        }
        if ($categoryInfo['pid'] == 0) {
            $categoryInfos = $this->model->getNormalCategoryInfoById($id);
            $result = \app\common\lib\Arr::getSearchCategoryInfoById($categoryInfos, $id);
            return $result;
        }
        //如果从二级栏目进入分类检索页面
        $categoryInfofir = $this->getById($categoryInfo['pid']);
        if($categoryInfofir['pid'] ==0){
            $categoryInfos = $this->model->getNormalCategoryInfoById($categoryInfo['pid']);
            $categorysubInfos = $this->model->getNormalCategoryInfoSubById($id);
            $result = \app\common\lib\Arr::getSearchCategoryInfoById($categoryInfos, $categoryInfo['pid'],$id,$categorysubInfos);
            return $result;
        }else{
            //如果从三级栏目进入
            $categoryInfos = $this->model->getNormalCategoryInfoById($categoryInfofir['pid']);
            $categorySubInfo = (new CategoryModel())->getNormalCategoryInfoSubById($categoryInfofir['id']);
            $result = \app\common\lib\Arr::getSearchThreeCategoryInfoById($categoryInfos,$categoryInfofir,$id,$categorySubInfo);
            return $result;
        }

    }


    /**
     * 根据id获取对应的三级分类数据
     * @param $id
     * @return array|void
     */
     public function getNormalCategoryInfoSubById($id){
         try{
             $categoryInfo = $this->model->getNormalCategoryInfoSubById($id);
         }catch (\Exception $e){
             return [];
         }
         return $categoryInfo;
     }

}
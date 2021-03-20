<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/6
 * Time: 10:15
 */

namespace app\api\controller;

use app\common\business\Category as CategoryBus;
use app\common\lib\Show;

class Category extends ApiBase
{
    public  function  index(){
        //获取所有分类的内容
        try{
       $categoryBusObj = new CategoryBus();
       $categorys = $categoryBusObj->getNormalAllCategorys();
       }catch (\Exception $e){
            //加日志
            return show(config("status.success"),"内部异常");
        }
        if(!$categorys){
            return show(config("status.success"),"数据为空");
        }
       $result = \app\common\lib\Arr::getTree($categorys);
       $result = \app\common\lib\Arr::sliceTreeArr($result);
       return show(config("status.success"),"OK",$result);

    }
    /**
     * api/category/search/51  预留给大家的作业记得完成
     * 商品列表页面中 按栏目检索的内容
     * @return \think\response\Json
     */
    public function search() {
        $id= input("param.id",0,"intval");
        if(!$id){
            return Show::success();
        }
        $result = (new CategoryBus())->getNormalCategoryInfoById($id);
        if(!$result){
            return Show::success();
        }
        return show(config("status.success"), "ok", $result);
    }

    /**
     * 获取子分类  category/sub/2   预留给大家的作业记得完成
     * @return \think\response\Json
     */
    public function sub() {
        $id= input("param.id",0,"intval");
        if(!$id){
            return Show::success();
        }
        $result = (new CategoryBus())->getNormalCategoryInfoSubById($id);
        if(!$result){
            return Show::success();
        }
        return show(config("status.success"), "ok", $result);
    }

}
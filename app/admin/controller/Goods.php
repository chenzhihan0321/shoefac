<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/6
 * Time: 13:56
 */

namespace app\admin\controller;

use app\common\business\Goods as GoodsBis;
class Goods extends AdminBase{
    public  function  index(){
        $data = [];
        $searchInput = \app\common\lib\Arr::searchInput();
        $title = input("param.title","","trim");
        $time = input("param.time","","trim");
        if(!empty($title)){
            $data['title'] =$title;
            $searchInput['title'] =$title;
        }
        if(!empty($time)){
            $searchInput['create_time'] =$time;
            $data['create_time'] = explode(" - ",$time);
        }
        $goods = (new GoodsBis())->getLists($data,5);
        return View("",[
            "goods" => $goods,
            "searchInput" => $searchInput,
        ]);
    }
    public  function  add(){
        return View();
    }
    public function  save(){
        //判断是否为post请求，也可以通过路由做配置支持post即可
        if(!$this->request->isPost()){
            return show(config('status.error'),"参数不合法");
        }
        //预留作业1：请用Validate验证机制自行验证
        $data = input("param.");
        $check = $this->request->checkToken('__token__');
        if(!$check){
            return show(config('status.error'),"非法请求");
        }
        //数据处理 => 基于 数据验证成功之后
        $data['category_path_id'] = $data['category_id'];
        $result = explode(",",$data['category_path_id']);
        $data['category_id'] = end($result);
        $res = (new GoodsBis())->insertData($data);
        if(!$res) {
            return show(config('status.error'), "商品新增失败");
        }

        return show(config('status.success'), "商品新增成功");
    }

}
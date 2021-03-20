<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/9
 * Time: 10:31
 */

namespace app\api\controller\mall;


use app\api\controller\ApiBase;
use app\common\lib\Show;
use app\common\business\Goods as GoodsBis;

class Lists extends ApiBase
{
    public function index(){
        $pageSize = input("param.page_size",10,"intval");
        $categoryId = input("param.category_id","","intval");
        if($categoryId){
            $data = [
                "category_path_id" => $categoryId,
            ];
        }
        $field = input("param.field","listorder","trim");
        $order = input("param.order",2,"intval");
        $title = input("param.keyword","","trim");
        if(!empty($title)){
            $data['title'] =$title;
        }
        $order = $order == 2 ? "desc": "asc";
        $order =[$field => $order];
        $goods =(new GoodsBis())->getNormalLists($data,$pageSize,$order);
        return Show::success($goods);
    }

}
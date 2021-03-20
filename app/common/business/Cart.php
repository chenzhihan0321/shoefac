<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/14
 * Time: 11:28
 */

namespace app\common\business;
use app\common\lib\Arr;
use think\Exception;
use think\facade\Cache;
use app\common\lib\Key;
class Cart extends  BusBase
{
    public function insertRedis($userId,$id,$num){
        // id 获取商品数据
        $goodsSku = (new GoodsSku())->getNormalSkuAndGoods($id);
        if(!$goodsSku){
            return FALSE;
        }
        $data = [
            "title" => $goodsSku['goods']['title'],
            "image" => $goodsSku['goods']['recommend_image'],
            "num" => $num,
            "goods_is" => $goodsSku['goods']['id'],
            "create_time" => time(),
        ];
        try{
            $get = Cache::hGet(Key::userCart($userId),$id);
            if($get){
                $get = json_decode($get,true);
                $data['num'] = $data['num'] + $get['num'];
                if( $goodsSku['goods']['stock'] < $data['num']){
                    throw new \think\Exception($data['title']."的商品库存不足");
                }
            }

            $res = Cache::hSet(Key::userCart($userId),$id,json_encode($data));
        }catch (\Exception $e){
            return FALSE;
        }
        return $res;

    }
    public function lists($userId,$ids){
        try{
            if($ids){
               $ids = explode(",",$ids);
               $res = Cache::hMget(Key::userCart($userId),$ids);
               if(in_array(false,array_values($res))){
                   return [];
               }
            }else{
               $res = Cache::hGetAll(Key::userCart($userId));
            }

        }catch (\Exception $e){
            $res = [];
        }
        if(!$res){
            return [];
        }

        $result = [];
        $skuIds = array_keys($res);
        $skus = (new GoodsSku())->getNormalInIds($skuIds);

        $stocks = array_column($skus,"stock","id");

        $skuIdPrice = array_column($skus,"price","id");
        $skuIdSpeceValueIds = array_column($skus,"specs_value_ids","id");
        $specsValues = (new SpecsValue())->dealSpecsValue($skuIdSpeceValueIds);
        foreach ($res as $k => $v){
            $price = $skuIdPrice[$k] ?? 0;
            $v = json_decode($v,true);
            if($ids && isset($stocks[$k]) && $stocks[$k] < $v['num']){
                throw new \think\Exception($v['title']."的商品库存不足");
            }
            $v['id'] = $k;
            $v['image'] = preg_match("/http:\/\//",$v['image']) ? $v['image'] :request()->domain().$v['image'];
            $v['price'] = $price;
            $v['total_price'] = $price * $v['num'];
            $v['sku'] =$specsValues[$k] ?? "暂无规则";
            $result[] = $v;
        }
        if(!empty($result)){
           $result =  Arr::arrsSortByKey($result,"create_time");
        }
        return $result;
    }
    /**
     * 删除购物车功能
     * @param $userId
     * @param $id
     * @return bool
     */
    public function deleteRedis($userId, $ids) {
        if(!is_array($ids)) {
            $ids = explode(",", $ids); // id=1  => [1]  ,  1,2 => [1, 2, 5,6]
        }
        try {
            // ... 是PHP提供一个特性 可变参数
            $res = Cache::hDel(Key::userCart($userId), ...$ids);
        }catch (\Exception $e) {
            return FALSE;
        }
        return $res;

        // 小伙伴请注意： 预留作业： 删除所有的购物车内容
    }


    /**
     * 更新购物车中的商品数量
     * @param $userId
     * @param $id
     * @param $num
     * @return bool
     * @throws \think\Exception
     */
    public function updateRedis($userId,  $id, $num) {

        try {
            $goodsSku = (new GoodsSku())->getNormalSkuAndGoods($id);
            if(!$goodsSku){
                return FALSE;
            }
            $get = Cache::hGet(Key::userCart($userId), $id);
        }catch (\Exception $e) {
            return FALSE;
        }
        if($get) {
            $get = json_decode($get, true);
            $get['num'] = $num;
            if( $goodsSku['goods']['stock'] < $get['num']){
                throw new \think\Exception($get['title']."的商品库存不足");
            }
        } else {
            throw new \think\Exception("不存在该购物车的商品，您更新没有任何意义");
        }
        try {
            $res = Cache::hSet(Key::userCart($userId), $id, json_encode($get));
        }catch (\Exception $e) {
            return FALSE;
        }
        return $res;
    }

    /**
     * 获取购物车数据
     * @param $userId
     * @return int
     */
    public function getCount($userId) {
        try {
            $count = Cache::hLen(Key::userCart($userId));
        }catch (\Exception $e) {
            return 0;
        }
        return intval($count);
    }
}
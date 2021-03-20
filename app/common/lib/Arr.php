<?php
/**
 * Created by singwa
 * User: singwa
 * motto: 现在的努力是为了小时候吹过的牛逼！
 * Time: 16:35
 */
namespace app\common\lib;

class Arr {
    /**
     * 分类树， 支持无限极分类
     */
    public static function getTree($data)
    {
        $items = [];
        foreach ($data as $v) {
            $items[$v['category_id']] = $v;
        }
        $tree = [];
        foreach ($items as $id => $item) {
            if (isset($items[$item['pid']])) {
                $items[$item['pid']]['list'][] = &$items[$id];
            } else {
                $tree[] = &$items[$id];
            }
        }
        return $tree;

    }

    public static function sliceTreeArr($data, $firstCount = 5, $secondCount = 3, $threeCount = 5) {
        $data = array_slice($data, 0, $firstCount);
        foreach($data as $k => $v) {
            if(!empty($v['list'])) {
                $data[$k]['list'] = array_slice($v['list'], 0, $secondCount);
                foreach($v['list'] as $kk => $vv) {
                    if(!empty($vv['list'])) {
                        $data[$k]['list'][$kk]['list'] = array_slice($vv['list'], 0, $threeCount);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * 分页默认返回的数据
     * @param $num
     * @return array
     */
    public static function getPaginateDefaultData($num) {
        $result = [
            "total" => 0,
            "per_page" => $num,
            "current_page" => 1,
            "last_page" => 0,
            "data" => [],
        ];
        return $result;
    }
    public  static function  searchInput(){
        $res = [
            'title'=>'',
            'create_time'=>''
        ];
        return $res;
    }
    public static function arrsSortByKey($result, $key, $sort = SORT_DESC) {
        if(!is_array($result) || !$key) {
            return [];
        }
        array_multisort(array_column($result, $key), $sort, $result);
        return $result;
    }
    public static  function  getGoodsCategoryTree($items,$categoryId){
        if(!$items){
            return [];
        }
        $tree = [
            'category_id'=>'',
            'name'=> '',
            'icon'=>'',
            'list'=>''
        ];
        foreach ($items as $k => $item) {
            if ($item['category_id'] == $categoryId ) {
                $tree = [
                    'category_id'=>$categoryId,
                    'name'=> $item['name'],
                    'icon'=>$item['icon'],
                ];
                unset($items[$k]);
            }

        }
        $tree['list'] = $items;
        return $tree;
    }
    public static function getSearchCategoryInfoById($items,$categoryId,$id ='',$categorysubInfos=''){
        if(!$items){
            return [];
        }
        $tree = [
            'name'=> '',
            'focus_ids' => [],
            'list'=>'',
         ];
        foreach ($items as $k => $item) {
            if ($item['id'] == $categoryId ) {
                $tree = [
                    'name'=> $item['name'],
                ];
                unset($items[$k]);
            }
        }
        $tree['focus_ids'] =[$id,$categorysubInfos];
        $tree['list'] = [$items,$categorysubInfos];

        return $tree;
    }

    public static function getSearchThreeCategoryInfoById($items,$categoryInfofir,$id,$categorySubInfo){
        if(!$items){
            return [];
        }
        $tree = [
            'name'=> '',
            'focus_ids' => [],
            'list'=>'',
        ];
        foreach ($items as $k => $item) {
            if ($item['id'] == $categoryInfofir['pid'] ) {
                $tree = [
                    'name'=> $item['name'],
                ];
                unset($items[$k]);
            }
        }

        $tree['focus_ids'] =[$categoryInfofir['id'],$id];
        $tree['list'] = [$items,$categorySubInfo];

        return $tree;
    }

}
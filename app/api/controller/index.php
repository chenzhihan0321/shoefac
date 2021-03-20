<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/28
 * Time: 10:45
 */

namespace app\api\controller;

use app\common\business\Goods as GoodsBis;
use app\common\lib\Show;
class Index  extends  ApiBase
{
    public function getRotationChart(){
        $result = (new GoodsBis())->getRotationChart();
        return Show::success($result);
    }

    public function cagegoryGoodsRecommend(){
        $categoryIds = [
            93,
            51
        ];
        $res = (new GoodsBis())->cagegoryGoodsRecommend($categoryIds);
        return Show::success($res);
    }
}
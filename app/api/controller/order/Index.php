<?php
/**
 * Created by singwa
 * User: singwa
 * motto: 现在的努力是为了小时候吹过的牛逼！
 * Time: 17:58
 */
namespace app\api\controller\order;

use app\api\controller\AuthBase;
use app\common\lib\Show;
use app\common\business\Order;

class Index extends AuthBase {

    /**
     *
     * 创建订单  order  post
     * address_id
     * cart_ids
     * @return \think\response\Json
     */
    public function save() {
        $addressId = input("param.address_id", 0, "intval");
        $ids = input("param.ids", "", "trim");
        if(!$ids) {
            // 参数适配
            $ids = input("param.cart_ids", "", "trim");
        }
        if(!$addressId || !$ids) {
            return Show::error("参数错误");
        }

        $data = [
            "ids" => $ids,
            "address_id" => $addressId,
            "user_id" => $this->userId,
        ];
        try {
            $result = (new Order())->save($data);
        }catch (\Exception $e) {
            return Show::error($e->getMessage());
        }
        if(!$result) {
            return Show::error("提交订单失败，请稍候重试");
        }
        return Show::success($result);

    }

    /**
     * 获取订单详情， 这个地方是老师准备好的代码
     * 需要带小伙伴解读下代码就可以
     * @return \think\response\Json
     */
    public function read() {
        $id = input("param.id", "0", "trim");
        if(empty($id)) {
            return Show::error("参数错误");
        }
        $data = [
            "user_id" => $this->userId,
            "order_id" => $id,
        ];

        $result = (new Order())->detail($data);

        if(!$result) {
            return Show::error("获取订单失败");
        }
        return Show::success($result);

    }
}
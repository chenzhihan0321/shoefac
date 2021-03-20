<?php
/**
 * 用户收获地址管理 不在本课程授课范围之后，大家自行的去完成
 * 地址管理就是对数据库的curd基本操作哈
 * User: singwa
 * motto: 现在的努力是为了小时候吹过的牛逼！
 * Time: 16:56
 */
namespace app\api\controller;
class Address extends AuthBase {
    public function index() {
        // 获取该用户下所有设置的收获地址
        $result = [
            [
                "id" => 1,
                // 收货人 信息
                "consignee_info" => "北京 海淀 科技园 上地10街 singwa收 180xxxx",
                "is_default" => 1,
            ],
            [
                "id" => 2,
                // 收货人 信息
                "consignee_info" => "北京 昌平 沙河镇 沙河高教园  麦迪收 180xxxx",
                "is_default" => 0,
            ],
            [
                "id" => 3,
                // 收货人 信息
                "consignee_info" => "江西省 抚州市 东乡区 小竹街190号 小竹收 180xxxx",
                "is_default" => 0,
            ],
        ];

        return show(1, "OK", $result);
    }
}
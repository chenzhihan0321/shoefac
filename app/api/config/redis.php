<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/28
 * Time: 15:09
 */
return [
    "code_pre" => "mall_code_pre_",
    "code_expire" => 60,
    "token_pre" => "mall_token_pre_",
    "cart_pre" => "mall_cart_",
    // 延迟队列 - 订单是否需要取消状态检查
    "order_status_key" => "order_status",
    "order_expire" => 20*60,

];
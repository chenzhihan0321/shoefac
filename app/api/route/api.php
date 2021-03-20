<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/23
 * Time: 15:10
 */
use think\facade\Route;

Route::rule("smscode", "sms/code", "POST");
Route::resource('user', 'User');
Route::rule("lists", "mall.lists/index");
Route::rule("category/search/:id", "category/search");
Route::rule("subcategory/:id", "category/sub");
Route::rule("detail/:id", "mall.detail/index");

Route::resource("order", "order.index");
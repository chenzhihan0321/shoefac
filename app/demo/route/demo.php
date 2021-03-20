<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/6/23
 * Time: 15:10
 */
use think\facade\Route;

Route::rule("test","index/test","GET");
Route::rule("detail","detail/index","GET")->middleware(\app\demo\middleware\Detail::class);
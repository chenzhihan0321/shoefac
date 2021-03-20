<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/3
 * Time: 9:03
 */

namespace app\admin\Validate;


use think\Validate;

class Category extends  Validate
{
    protected  $rule = [
        'id' => 'require',
        'listorder' => 'require|number',
        'name' => 'require',
        'pid' => 'require',
        'status' => ["require", "in"=>"0,1,99"]
    ];
    protected  $message = [
        'id' =>'分类ID必须存在',
        'listorder.require' =>'排序值必须存在' ,
        'listorder.number'=>'排序值必须为数字',
        'name' => '分类名称必须',
        'pid' => '父类ID必须',
        'status.require' => '状态必须',
        'status.in' => '状态数值错误'
    ];
    protected $scene = [
        'category_add' => ['name','pid'],
        'listorder' => ['id', 'listorder'],
        'listorder_status' => ['id', 'status'],
    ];

}
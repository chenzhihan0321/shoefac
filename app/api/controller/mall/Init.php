<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 2020/7/9
 * Time: 10:31
 */

namespace app\api\controller\mall;
use app\api\controller\AuthBase;
use app\common\lib\Show;
use app\common\business\Cart as CartBis;
class Init extends AuthBase
{
    public function index(){
       if(!$this->request->isPost()){
           return Show::error();
       }
       $count =  (new CartBis())->getCount($this->userId);
       $result = [
           "cart_num" => $count,
       ];
       return Show::success($result);
    }

}
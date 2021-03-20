<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/1
 * Time: 20:36
 */

namespace app\api\controller;

use think\Request;
use app\common\business\User as UserBis;
class User  extends  AuthBase
{
   public  function  index(){
      $user =  (new UserBis())->getNormalUserById($this->userId);
      $resultUser = [
          "id" => $user['id'],
          "username" => $user['username'],
          "sex" => $user['sex']
      ];
      return show(config("status.success"),"OK",$resultUser);
   }

    /**
     * @return \think\response\Json
     */
   public  function  update(){
       $username = input("param.username","","trim");
       $sex = input("param.sex",0,"intval");
       $id2 = input("param.id","","trim");
       $id = $this->request->id;
       echo $id;
       echo  $id2;
       //
       $data = [
           'username' => $username ,
           'sex' => $sex
       ];
       $validate  = (new \app\api\validate\User()) ->scene('update_user');
       if(!$validate->check($data)){
           return show(config('status.error'),$validate->getError());
       }
       $userBisObj = new UserBis();
       $user = $userBisObj->update($this->userId,$data);
       if(!$user){
           return show(config('status.error'),"更新失败");
       }
       //如果用户名被修改，redis里面的数据也需要同步一下
       return show(1,"OK");
   }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/6/23
 * Time: 20:15
 */


declare(strict_types =1 );
namespace app\api\middleware;


class Auth
{
   public  function  handle($requset,\Closure $next){

      //dump($requset->pathinfo());
      // return $next($request);
      $requset->id = 5;
       //前置中间件
       //if(empty(session(config("admin.session_admin"))) && !preg_match("/login/",$requset->pathinfo())){
      //     return redirect((string)url('login/index'));
       //}


     //if(empty(session(config("admin.session_admin"))) && $requset->controller() !="Login"){
        // return redirect((string)url('login/index'));
     //}
     return $next($requset);
     //后置中间件
   }
   /*
    * 中间件结束调度
    *
    * */
   public function end(\think\Response $response){

   }
}
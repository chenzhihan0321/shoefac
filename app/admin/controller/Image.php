<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/6
 * Time: 21:27
 */

namespace app\admin\controller;


class Image extends  AdminBase
{
    public  function upload(){
        if(!$this->request->isPost()){
            return show(config("status.error"),"请求不合法");
        }
       $file =  $this->request->file("file");
        //注意事项
        //1,上传图片类型png gif jpg 2.文件大小限制600kb
      // $filename = \think\facade\Filesystem::putFile('upload',$file);
        $filename = \think\facade\Filesystem::disk('public')->putFile("image",$file);
       if(!$filename){
           return show(config("status.error"),"上传图片失败");
       }
       $imageUrl  = [
           "image" => "/upload/".$filename
       ];
       return show(config("status.success"),"图片上传成功",$imageUrl);
    }
    public  function layUpload(){
        if(!$this->request->isPost()){
            return show(config("status.error"),"请求不合法");
        }

        $file =  $this->request->file("file");
        $filename = \think\facade\Filesystem::disk('public')->putFile("image",$file);
        if(!$filename){
            return json(["code" =>1 ,"data" =>[]],200);
        }

        $result = [
            "code" => 0,
            "data" =>[
                "src" =>  "/upload/".$filename
            ],
        ];
        return json($result,200);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: 张寒
 * Date: 2019/9/21 0021
 * Time: 下午 17:07
 * QQ: 425158482
 */
namespace app\admini\controller;

use think\Controller;
use think\Db;
use think\Config;

class Uploads extends Base
{
    /**
     * layui图片上传地址
     **/
    public function uploads_img()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file) {
            $info = $file->validate(['size'=>config('site.file_img_size') * 1024,'ext'=>config('site.file_img')])->move(ROOT_PATH . DS . 'uploads');
            if ($info) {
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                return ["code" => 1, "img_url" => str_replace("\\", "/", "/uploads/" . $info->getSaveName()),"id"=>rand(1000, 9999)];
            } else {
                // 上传失败获取错误信息
                return ["code" => 0,"error" =>$file->getError()];
            }
        }
    }

    /**
     * layui文件上传地址
     **/
    public function uploads_fie()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file) {
            $info = $file->validate(['size'=>config('site.file_size') * 1024,'ext'=>config('site.file_form')])->move(ROOT_PATH . DS . 'uploads/file/');
            if ($info) {
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                return ["code" => 1, "img_url" => str_replace("\\", "/", "/uploads/file/" . $info->getSaveName()),"id"=>rand(1000, 9999)];
            } else {
                // 上传失败获取错误信息
                return ["code" => 0,"error" =>$file->getError()];
            }
        }
    }


}
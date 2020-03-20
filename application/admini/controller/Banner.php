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

class Banner extends Base
{
    /**
     * banner管理显示页
     **/
    public function index()
    {
        $banner = Db::name("banner")->order("sort","asc")->select();
        $this->assign([
            "banner"=>$banner,
        ]);
        return $this->fetch();
    }

    /**
     * 添加图片显示页
     **/
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 修改指定图片显示页
     **/
    public function edit($id)
    {
        $banner = Db::name("banner")->where("id",$id)->find();
        $this->assign([
            "banner" => $banner,
        ]);
        return $this->fetch();
    }

    /**
     * 保存数据
     **/
    public function save()
    {
        $token = request()->session()['__token__'];
        $data = input("post.");
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["file"]);
            $res = Db::name("banner")->insert($data);
            if($res){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 2;
        }
    }

    /**
     * 更新指定数据
     **/
    public function update($id)
    {
        $token = request()->session()['__token__'];
        $data = input("post.");
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["file"]);
            $res = Db::name("banner")->where("id",$id)->update($data);
            if($res){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 2;
        }
    }

    /**
     * 表格更改排序
     **/
    public function editsort()
    {
        $data = input("post.");
        $msg = Db::name("banner")->where("id",$data["id"])->update(["sort"=>$data["sort"]]);
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 删除指定图片
     **/
    public function delete()
    {
        $data = input("post.");
        $msg = Db::name("banner")->where("id",$data["id"])->delete();
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }










}
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

class Links extends Base
{
    /**
     * 友情链接管理显示页
     **/
    public function index()
    {
        $links = Db::name("links")->order("sort","desc")->select();
        $this->assign("links",$links);
        return $this->fetch();
    }

    /**
     * 友情链接添加显示页
     **/
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 友情链接保存
     **/
    public function save()
    {
        $token = request()->session()['__token__'];
        $data = input("post.");
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["file"]);
            $res = Db::name("links")->insert($data);
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
     * $id = 友链id
     **/
    public function update($id)
    {
        $token = request()->session()['__token__'];
        $data = input("post.");
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["file"]);
            if(!isset($data["type"])){
                $data["type"]=1;
            }
            $res = Db::name("links")->where("id",$id)->update($data);
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
        $msg = Db::name("links")->where("id",$data["id"])->update(["sort"=>$data["sort"]]);
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 编辑指定碎片
     * $id = 友链id
     **/
    public function edit($id)
    {
        $links = Db::name("links")->where("id",$id)->find();
        $this->assign([
            "links" => $links,
        ]);
        return $this->fetch();
    }

    /**
     * 删除指定数据
     * $id = 友链id
     **/
    public function delete($id)
    {
        $msg = Db::name("links")->where("id",$id)->delete();
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }





}
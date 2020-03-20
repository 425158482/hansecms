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

class Menu extends Base
{
    /**
     * 显示栏目列表
     **/
    public function index()
    {
        $adminmenu = Db::name("menu")->where("pid",0)->order("sort","asc")->select();
        $adminmenusub = Db::name("menu")->where("pid",">",0)->order("sort","asc")->select();
        $this->assign([
            "adminmenu" => $adminmenu,
            "adminmenusub" => $adminmenusub
        ]);
        return $this->fetch();
    }


    /**
     * 添加栏目显示页
     **/
    public function add()
    {
        $adminmenu = Db::name("menu")->where("pid",0)->order("sort","asc")->select();
        $adminmenusub = Db::name("menu")->where("pid",">",0)->order("sort","asc")->select();
        $this->assign([
            "adminmenu" => $adminmenu,
            "adminmenusub" => $adminmenusub
        ]);
        return $this->fetch();
    }

    /**
     * 保存栏目
     **/
    public function save()
    {
        $token = request()->session()['__token__'];
        $data = input("post.");
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            isset($data["state"]) ? : $data["state"]=0;
            $data["add_time"] = time();
            $res = Db::name("menu")->insert($data);
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
     * 编辑排序
     **/
    public function editsort()
    {
        $data = input("post.");
        $res = Db::name("menu")->where("id",$data["id"])->update(["sort"=>$data["sort"]]);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 编辑状态
     **/
    public function editstate()
    {
        $data = input("post.");
        $res = Db::name("menu")->where("id",$data["id"])->update(["state"=>$data["state"]]);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 编辑栏目
     **/
    public function edit($id)
    {
        $menus = Db::name("menu")->where("id",$id)->find();
        $adminmenu = Db::name("menu")->where("pid",0)->order("sort","asc")->select();
        $adminmenusub = Db::name("menu")->where("pid",">",0)->order("sort","asc")->select();
        $this->assign([
            "menus" => $menus,
            "adminmenu" => $adminmenu,
            "adminmenusub" => $adminmenusub
        ]);
        return $this->fetch();
    }

    /**
     * 保存更新
     **/
    public function update()
    {
        $token = request()->session()['__token__'];
        $data = input("post.");
        $id = $data["id"];
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["id"]);
            isset($data["state"]) ? : $data["state"]=0;
            $res = Db::name("menu")->where("id",$id)->update($data);
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
     * 删除菜单
     **/
    public function delete()
    {
        $data = input("post.");
        $yse = Db::name("menu")->where("pid",$data['id'])->select();
        if($yse){//检测是否有子栏目
            return 2;
        }
        $res = Db::name("menu")->where("id",$data["id"])->delete();
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

}
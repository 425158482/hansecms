<?php
/**
 * Created by PhpStorm.
 * User: 张寒
 * Date: 2019/9/21 0021
 * Time: 下午 17:07
 * QQ: 425158482
 * 功能 : 自动替换
 */
namespace app\admini\controller;

use think\Controller;
use think\Db;
use think\Session;

class User extends Base
{
    /**
     * 显示栏目列表
     **/
    public function index()
    {
        if(Session::get("admini")["type"]!=1){
            return "<div style='position: absolute;top: 0;bottom: 0;margin: auto;text-align: center;height: 25px;left: 0;right: 0;'>您无权操作</div>";
        }
        $admin_user = Db::name("admin")->select();
        $this->assign("admin_user",$admin_user);
        return $this->fetch();
    }

    /**
     * 添加管理员
     **/
    public function adduser()
    {
        if(Session::get("admini")["type"]!=1){
            return "<div style='position: absolute;top: 0;bottom: 0;margin: auto;text-align: center;height: 25px;left: 0;right: 0;'>您无权操作</div>";
        }
        return $this->fetch();
    }

    /**
     * @return int|string
     * 保存
     */
    public function saveuser()
    {
        $data = input("post.");
        if($data["password"]=="" || $data["password1"]==null || $data["username"]=="" || $data["username"]==null){
            return "用户名或密码不能为空";
        }
        if($data["password"]!=$data["password1"]){
            return "两次密码不符合";
        }
        if(Session::get("admini")['type']!=1){
            return "对不起您权限不足";
        }
        if($data["type"]!=1){
            $data["type"]=2;
        }
        unset($data["file"]);
        unset($data["password1"]);
        $data["password"] = $pass = md5(sha1($data["password"].$data["username"]));
        $data["ip"] = "127.0.0.1";
        $data["create_time"] = time();
        $data["number"] = 0;
        $res = Db::name("admin")->insert($data);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 删除管理员
     */
    public function delete()
    {
        $data = input("post.");
        if(Session::get("admini")["type"]!=1){
            return "您无权操作";
        }
        $user = Db::name("admin")->where("id",$data["id"])->find();
        if($user["type"]==1){
            return "您无权操作";
        }
        $res = Db::name("admin")->where("id",$data["id"])->delete();
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 编辑用户
     */
    public function edit($id)
    {
        if(Session::get("admini")["type"]!=1){
            return "<div style='position: absolute;top: 0;bottom: 0;margin: auto;text-align: center;height: 25px;left: 0;right: 0;'>您无权操作</div>";
        }
        $user = Db::name("admin")->where("id",$id)->find();
        if($user["type"]==1){
            return "<div style='position: absolute;top: 0;bottom: 0;margin: auto;text-align: center;height: 25px;left: 0;right: 0;'>超级管理员无法修改</div>";
        }
        $this->assign("useri",$user);
        return $this->fetch();
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = input("post.");
        if(Session::get("admini")["type"]!=1){
            return "您无权操作";
        }
        $user = Db::name("admin")->where("id",$data["id"])->find();
        if($user["type"]==1){
            return "您无权操作";
        }
        if($data["data"]["username"]=="" || $data["data"]["username"]==null){
            return "用户名不能为空";
        }
        if($data["data"]["password"]!=$data["data"]["password1"]){
            return "两次密码不符合";
        }
        if(Session::get("admini")['type']!=1){
            return "对不起您权限不足";
        }
        if($data["data"]["type"]!=1){
            $data["data"]["type"]=2;
        }
        unset($data["data"]["file"]);
        unset($data["data"]["password1"]);
        $data["data"]["password"] = $pass = md5(sha1($data["data"]["password"].$data["data"]["username"]));
        $res = Db::name("admin")->where("id",$data["id"])->update($data["data"]);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 权限
     */
    public function grade($id)
    {
        if(Session::get("admini")["type"]!=1){
            return "<div style='position: absolute;top: 0;bottom: 0;margin: auto;text-align: center;height: 25px;left: 0;right: 0;'>您无权操作</div>";
        }
        $dqqx = Db::name("admin")->where("id",$id)->find();
        if($dqqx["type"]==1){
            return "<div style='position: absolute;top: 0;bottom: 0;margin: auto;text-align: center;height: 25px;left: 0;right: 0;'>超级管理员无法修改</div>";
        }
        $adminmenu = Db::name("menu")->select();
        $data = admingetChild($adminmenu);
        $web = [];
        foreach ($data as $k=>$v){
            $web[$k] = ['value'=>$v['id'],'title'=>$v['title']];
        }
        $json = json_encode($web,1);
        $this->assign([
            "json"=>$json,
            "dqqx"=>$dqqx,
        ]);
        return $this->fetch();
    }

    /**
     * @param $id
     * 保存权限
     */
    public function savegrade($id)
    {
        if(Session::get("admini")["type"]!=1){
            return "<div style='position: absolute;top: 0;bottom: 0;margin: auto;text-align: center;height: 25px;left: 0;right: 0;'>您无权操作</div>";
        }
        $dqqx = Db::name("admin")->where("id",$id)->find();
        if($dqqx["type"]==1){
            return "<div style='position: absolute;top: 0;bottom: 0;margin: auto;text-align: center;height: 25px;left: 0;right: 0;'>超级管理员无法修改</div>";
        }
        $json = input("post.");
        $data = "";
        if(!isset($json["getData"])){
            $json["getData"] = [];
        }
        foreach ($json["getData"] as $k=>$v){
            $data .= $v["value"].",";
        }
        $res = Db::name("admin")->where("id",$id)->update(["grade"=>$data]);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

}
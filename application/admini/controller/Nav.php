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

class Nav extends Base
{
    /**
     * 显示前台栏目列表
     **/
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 数据表格
     **/
    public function getnav()
    {
        $nav = Db::name("nav")
            ->alias('a')
            ->field("a.*,models.name as mname")
            ->join("models","a.model=models.id")
            ->order("a.id","asc")
            ->select();
        $index_nav = getChild($nav);
        $data = ["code"=>0, "msg"=>"", "count"=>100, "data"=>$index_nav];
        return $data;
    }

    /**
     * 添加栏目显示页
     **/
    public function addnav()
    {
        $nav = Db::name("nav")->order("id","asc")->select();
        $index_nav = getChild($nav);//栏目递归
        $models = Db::name("models")->order("sort","asc")->select();
        //获取模板
        $list = getFileFolderList("".ROOT_PATH."template/pc" , 2, 'list_*');//列表模板
        $view = getFileFolderList("".ROOT_PATH."template/pc" , 2, 'view_*');//内容模板
        $this->assign([
            "nav" => $index_nav,
            "models" => $models,
            "list" => $list,
            "view" => $view,
            "desc"=> uedi_mi("desc","desc"),//简约编辑器
            "content"=> uedi("content","content"),//丰富编辑器
        ]);
        return $this->fetch();
    }

    /**
     * 表格编辑
     **/
    public function table_up()
    {
        $data = input("post.");
        $field = $data["field"];
        $value = $data["value"];
        if($field=="url_static") {
            $url_static = Db::name("nav")->where("url_static", $value)->where("id","neq",$data["id"])->find();
            if ($url_static) {
                return 3;//静态名称重复
            }
        }
        $msg = Db::name("nav")->where("id",$data["id"])->update([$field=>$value]);
        if($msg){
            return 1;
        }else{
            return 0;
        }


    }

    /**
     * 保存栏目信息
     **/
    public function save()
    {
        $token = request()->session()['__token__'];
        $data = $_POST;
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["file"]);
            $url_static = Db::name("nav")->where("url_static",$data["url_static"])->find();
            if($url_static){
                return 3;//静态名称重复
            }
            $res = Db::name("nav")->insert($data);
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
     * 更新栏目信息显示页面
     **/
    public function edit($id)
    {
        $edit = Db::name("nav")->where("id",$id)->find();
        $nav = Db::name("nav")->order("sort","asc")->select();
        $index_nav = getChild($nav);//栏目递归
        $models = Db::name("models")->order("sort","asc")->select();
        //获取模板
        $list = getFileFolderList("".ROOT_PATH."template/pc" , 2, 'list_*');//列表模板
        $view = getFileFolderList("".ROOT_PATH."template/pc" , 2, 'view_*');//内容模板
        $this->assign([
            "nav" => $index_nav,
            "models" => $models,
            "list" => $list,
            "view" => $view,
            "edit" => $edit,
            "desc"=> uedi_mi("desc","desc",$edit["desc"]),//简约编辑器
            "content"=> uedi("content","content",$edit["content"]),//丰富编辑器
        ]);
        return $this->fetch();
    }

    /**
     * 保存更新信息
     **/
    public function update($id)
    {
        $token = request()->session()['__token__'];
        $data = $_POST;
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["file"]);
            $url_static = Db::name("nav")->where("url_static",$data["url_static"])->where("id","neq",$id)->find();
            if($url_static){
                return 3;//静态名称重复
            }
            $res = Db::name("nav")->where("id",$id)->update($data);
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
     * 删除指定数据
     **/
    public function delete()
    {
        $data = input("post.");
        $res = Db::name("nav")->where("pid",$data["id"])->find();
        if($res){
            return 2;//请先删除子栏目
        }
        $msg = Db::name("nav")->where("id",$data["id"])->delete();
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 删除所选数据
     **/
    public function deleteall()
    {
        $json = $_POST;
        $data = json_decode($json["data"]);
        $id = "";
        foreach ($data as $k=>$v){
            $id .= $v->id.",";
        }
        $msg = Db::name("nav")->where("id","in",$id)->delete();
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

}
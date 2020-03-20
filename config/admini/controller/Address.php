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

class Address extends Base
{

    /**
     * 地区分站入口
     **/
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 地区分站入口
     **/
    public function resssub($id)
    {
        $this->assign(["ressid"=>$id]);
        return $this->fetch();
    }

    /**
     * 获取顶级地区
     **/
    public function getadd($id="")
    {
        if($id){
            $address = Db::name("address")->where("pid",$id)->select();
            $this->assign([
                "address" => $address,
            ]);
            $data = ["code"=>0, "msg"=>"", "count"=>100, "data"=>$address];
            return $data;
        }else{
            $address = Db::name("address")->where("pid",0)->select();
            $this->assign([
                "address" => $address,
            ]);
            $data = ["code"=>0, "msg"=>"", "count"=>100, "data"=>$address];
            return $data;
        }
    }

    /**
     * 表格编辑
     **/
    public function table_up()
    {
        $data = input("post.");
        $field = $data["field"];
        $value = $data["value"];
        $msg = Db::name("address")->where("id",$data["id"])->update([$field=>$value]);
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 选中开启所选数据
     **/
    public function statick()
    {
        $json = input("post.");
        $data = $json["data"];
        $id = "";
        foreach ($data as $k=>$v){
            $id .= $v["id"].",";
        }
        $msg = Db::name("address")->where("id","in",$id)->update(["static"=>1]);
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 选中关闭所选数据
     **/
    public function staticg()
    {
        $json = input("post.");
        $data = $json["data"];
        $id = "";
        foreach ($data as $k=>$v){
            $id .= $v['id'].",";
        }
        $msg = Db::name("address")->where("id","in",$id)->update(["static"=>0]);
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }




}















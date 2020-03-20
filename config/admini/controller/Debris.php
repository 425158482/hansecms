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
use app\admini\controller\Witty;

class Debris extends Base
{
    /**
     * 碎片数据管理显示页
     **/
    public function index()
    {
        $debris = Db::name("debris")->select();
        $this->assign("debris",$debris);
        return $this->fetch();
    }

    /**
     * 碎片数据添加显示页
     **/
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 碎片数据保存
     **/
    public function save()
    {
        $token = request()->session()['__token__'];
        $data = $_POST;
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["file"]);
            $content = "content".$data["type"];
            $msg = Db::name("debris")->where("title",$data["title"])->find();
            if ($msg){
                return 3;//定义名称重复
            }
            $data["content"]=$data[$content];
            $data = Witty::witty($data);
            $res = Db::name("debris")->strict(false)->insert($data);
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
     * $id = 碎片id
     **/
    public function update($id)
    {
        $token = request()->session()['__token__'];
        $data = $_POST;
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["file"]);
            $content = "content".$data["type"];
            $msg = Db::name("debris")->where("title",$data["title"])->where("id","neq",$id)->find();
            if ($msg){
                return 3;//定义名称重复
            }
            $data["content"]=$data[$content];
            $data = Witty::witty($data);
            $res = Db::name("debris")->strict(false)->where("id",$id)->update($data);
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
     * 编辑指定碎片
     * $id = 碎片id
     **/
    public function edit($id)
    {
        $debris = Db::name("debris")->where("id",$id)->find();
        $this->assign([
            "debris" => $debris,
        ]);
        return $this->fetch();
    }

    /**
     * 删除指定数据
     * $id = 碎片id
     **/
    public function delete($id)
    {
        $msg = Db::name("debris")->where("id",$id)->delete();
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }





}
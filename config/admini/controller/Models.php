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

class Models extends Base
{
    /**
     * 显示模型列表
     **/
    public function index()
    {
        $models = Db::name("models")->order("sort","asc")->select();
        foreach ($models as $k=>$v){
            $models[$k]["count"] = Db::name("field")->where("mid",$v["id"])->count();
        }
        $this->assign([
            "models"=>$models,
        ]);
        return $this->fetch();
    }

    /**
     * 显示添加页面
     **/
    public function showadd()
    {
        return $this->fetch();
    }

    /**
     * 保存模型数据
     **/
    public function save()
    {
        $data = input("post.");
        $res = Db::name("models")->where("bname",$data["bname"])->find();
        if($res){
            return 2;
        }
        $msg = Db::name("models")->insert($data);
        $sql = "CREATE TABLE `".config('database.prefix')."new_".$data['bname']."` (`id` INT(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT)";
        Db::execute($sql);
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 字段管理页面
     **/
    public function showfield($mid)
    {
        $field = Db::name("field")->where("mid",$mid)->order("sort","asc")->select();
        //赋值已知数据
        foreach ($field as $k=>$v){
            switch ($v["type"]) {
                case "1":
                    $field[$k]["type"] = "单行文本框";
                    break;
                case "2":
                    $field[$k]["type"] = "多行文本框";
                    break;
                case "3":
                    $field[$k]["type"] = "简约编辑器";
                    break;
                case "4":
                    $field[$k]["type"] = "丰富编辑器";
                    break;
                case "5":
                    $field[$k]["type"] = "图片上传";
                    break;
                case "6":
                    $field[$k]["type"] = "多图上传";
                    break;
                case "7":
                    $field[$k]["type"] = "文件上传";
                    break;
                default:
                    $field[$k]["type"] = $v["type"];
            }
        }

        $this->assign([
            "mid"=>$mid,
            "field"=>$field
        ]);
        return $this->fetch();
    }

    /**
     * 字段添加页面
     **/
    public  function showfieldadd($mid)
    {
        $this->assign([
            "mid"=>$mid
        ]);
        return $this->fetch();
    }

    /**
     * 添加分割线页面
     **/
    public function showlineadd($mid){
        $this->assign([
            "mid"=>$mid
        ]);
        return $this->fetch();
    }

    /**
     * 保存分割线字段
     **/
    public function saveline($mid)
    {
        $data = input("post.");
        $data["mid"] = $mid;
        $data["field"] = "------";
        $data["space"] = 0;
        $data["type"] = "分割线";
        $msg = Db::name("field")->insert($data);
        if ($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 修改分割线字段
     **/
    public function updateline($id)
    {
        $data = input("post.");
        $data["field"] = "------";
        $data["type"] = "分割线";
        $msg = Db::name("field")->where("id",$id)->update($data);
        if ($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * ajax修改排序
     * $mid  = 1 修改字段排序  $mid = 2修改模型排序
     **/
    public function editsort($mid)
    {
        $data = input("post.");
        if($mid==1){//修改字段排序
            $msg = Db::name("field")->where("id",$data["id"])->update(["sort"=>$data["sort"]]);
            if ($msg){
                return 1;
            }else{
                return 0;
            }
        }elseif($mid==2){//修改模型排序
            $msg = Db::name("models")->where("id",$data["id"])->update(["sort"=>$data["sort"]]);
            if ($msg){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    /**
     * 保存数据表字段
     **/
    public  function savefield($mid)
    {
        $data = input("post.");
        $data["mid"] = $mid;
        $msg = Db::name("field")->insert($data);
        $models = Db::name("models")->field("bname")->where("id",$mid)->find();
        $table = config('database.prefix')."new_".$models["bname"];

        switch ($data["type"]) {
            case "1":
                $sql = "ALTER TABLE `{$table}` ADD `{$data['field']}` VARCHAR(255)";
                Db::execute($sql);
                break;
            case "2":
                $sql = "ALTER TABLE `{$table}` ADD `{$data['field']}` text";
                Db::execute($sql);
                break;
            case "3":
                $sql = "ALTER TABLE `{$table}` ADD `{$data['field']}` longtext";
                Db::execute($sql);
                break;
            case "4":
                $sql = "ALTER TABLE `{$table}` ADD `{$data['field']}` longtext";
                Db::execute($sql);
                break;
            case "5":
                $sql = "ALTER TABLE `{$table}` ADD `{$data['field']}` VARCHAR(255)";
                Db::execute($sql);
                break;
            case "6":
                $sql = "ALTER TABLE `{$table}` ADD `{$data['field']}` text";
                Db::execute($sql);
                break;
            case "7":
                $sql = "ALTER TABLE `{$table}` ADD `{$data['field']}` VARCHAR(255)";
                Db::execute($sql);
                break;
            default:
                return 0;
        }

        if ($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 编辑数据表
     **/
    public function editfield($id)
    {
        $field = Db::name("field")->where("id",$id)->find();
        $this->assign([
            "id"=>$id,
            "field"=>$field
        ]);
        if($field["field"]=="------"){
            return $this->fetch("models/editline");
        }else{
            return $this->fetch();
        }
    }

    /**
     * 更新数据表字段
     **/
    public function updatefield($id)
    {
        $data = input("post.");
        $field = Db::name("field")->field("field")->where("id",$id)->find();
        $msg = Db::name("field")->where("id",$id)->update($data);
        $mid = Db::name("field")->field("mid")->where("id",$id)->find();//查询字段所属模型
        $models = Db::name("models")->field("bname")->where("id",$mid["mid"])->find();
        $table = config('database.prefix')."new_".$models["bname"];
        switch ($data["type"]) {
            case "1":
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field['field']}` `{$data['field']}` VARCHAR(255)";
                Db::execute($sql);
                break;
            case "2":
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field['field']}` `{$data['field']}` text";
                Db::execute($sql);
                break;
            case "3":
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field['field']}` `{$data['field']}` longtext";
                Db::execute($sql);
                break;
            case "4":
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field['field']}` `{$data['field']}` longtext";
                Db::execute($sql);
                break;
            case "5":
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field['field']}` `{$data['field']}` VARCHAR(255)";
                Db::execute($sql);
                break;
            case "6":
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field['field']}` `{$data['field']}` text";
                Db::execute($sql);
                break;
            case "7":
                $sql = "ALTER TABLE `{$table}` CHANGE `{$field['field']}` `{$data['field']}` VARCHAR(255)";
                Db::execute($sql);
                break;
            default:
                return 0;
        }

        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 删除数据表字段
     **/
    public function deletefield($id){
        $field = Db::name("field")->where("id",$id)->find();//字段名
        if($field["field"]=="------"){//如果分割线
            $msg = Db::name("field")->where("id",$id)->delete();
            if($msg){
                return 1;
            }else{
                return 0;
            }
        }else{
            $models = Db::name("models")->where("id",$field["mid"])->find();//表明
            $tables = config('database.prefix')."new_".$models["bname"];//拼接表明
            Db::execute("ALTER TABLE `{$tables}` DROP `{$field["field"]}`;");//执行删除
            $msg = Db::name("field")->where("id",$id)->delete();
            if($msg){
                return 1;
            }else{
                return 0;
            }
        }
    }

}
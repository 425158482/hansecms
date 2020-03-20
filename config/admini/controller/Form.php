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

class Form extends Base
{
    /**
     * 显示表单列表
     **/
    public function index()
    {
        $formlist = Db::name("form")->select();
        foreach ($formlist as $k=>$v){
            $formlist[$k]["count"] = Db::name("field_form")->where("fid",$v["id"])->count();
            $formlist[$k]["weidu"] = Db::name("formcon")->where("fid",$v['id'])->where("static",1)->count();
            $formlist[$k]["yidu"] = Db::name("formcon")->where("fid",$v['id'])->where("static",0)->count();
        }
        $this->assign([
            "formlist"=>$formlist,
        ]);
        return $this->fetch();
    }

    /**
     * 显示代码
     **/
    public function show($id)
    {
        $field = Db::name("field_form")->where("fid",$id)->select();
        $data = "";
        $data .= "&lt;form action=&quot;/form/{$id}&quot; method=&quot;post&quot;&gt;<br>";
        $data .='&lt;input type=&quot;hidden&quot; name=&quot;__token__&quot; value=&quot;{$Request.token}&quot; /&gt;<br>';
        foreach ($field as $k=>$v){
            if($v["type"]==1){
                $data .="&lt;input type=&quot;text&quot; name=&quot;{$v["field"]}&quot; value=&quot;&quot; &gt;<br>";
            }elseif($v["type"]==2){
                $data .="&lt;textarea name=&quot;{$v["field"]}&quot;&gt;&lt;/textarea&gt;<br>";
            }elseif($v["type"]==3){
                $data .="&lt;input type=&quot;number&quot; name=&quot;{$v["field"]}&quot; value=&quot;&quot; &gt;<br>";
            }else{
                $data .="&lt;input type=&quot;text&quot; name=&quot;{$v["field"]}&quot; value=&quot;&quot; &gt;<br>";
            }
        }
        $data .='&lt;input type=&quot;text&quot; name=&quot;captcha&quot;&gt;&lt;img src=&quot;{:captcha_src()}&quot; onclick=&quot;this.src=this.src&quot; alt=&quot;&quot;&gt;<br>';
        $data .= "&lt;input type=&quot;submit&quot;&gt;&lt;br&gt;<br>";
        $data .="&lt;/form&gt;<br>";
        $this->assign([
            "datadm"=>$data,
        ]);
        return $this->fetch();
    }

    /**
     * 显示添加页面
     **/
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 保存表单数据
     **/
    public function save()
    {
        $data = input("post.");
        $res = Db::name("form")->where("bname",$data["bname"])->find();
        if($res){
            return 2;
        }
        $msg = Db::name("form")->insert($data);
        $sql = "CREATE TABLE `".config('database.prefix')."form_".$data['bname']."` (`id` INT(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT)";
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
    public function showfield($fid)
    {
        $field = Db::name("field_form")->where("fid",$fid)->select();
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
                    $field[$k]["type"] = "数字";
                    break;
                default:
                    $field[$k]["type"] = $v["type"];
            }
        }
        $this->assign([
            "fid"=>$fid,
            "field"=>$field
        ]);
        return $this->fetch();
    }

    /**
     * 字段添加页面
     **/
    public  function showfieldadd($fid)
    {
        $this->assign([
            "fid"=>$fid
        ]);
        return $this->fetch();
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
    public  function savefield($fid)
    {
        $data = input("post.");
        $data["fid"] = $fid;
        $cf = Db::name("field_form")->where("fid",$fid)->where("field",$data['field'])->find();
        if($cf){
            return 4;//数据表字段重复
        }
        $msg = Db::name("field_form")->insert($data);
        $models = Db::name("form")->field("bname")->where("id",$fid)->find();
        $table = config('database.prefix')."form_".$models["bname"];

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
        $field = Db::name("field_form")->where("id",$id)->find();
        $this->assign([
            "id"=>$id,
            "field"=>$field
        ]);
        return $this->fetch();
    }

    /**
     * 更新数据表字段
     **/
    public function updatefield($id)
    {
        $data = input("post.");
        $field = Db::name("field_form")->field("field")->where("id",$id)->find();
        $msg = Db::name("field_form")->where("id",$id)->update($data);
        $fid = Db::name("field_form")->field("fid")->where("id",$id)->find();//查询字段所属模型
        $models = Db::name("form")->field("bname")->where("id",$fid["fid"])->find();
        $table = config('database.prefix')."form_".$models["bname"];
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
     * 编辑数据表
     **/
    public function edittable($id)
    {
        $table = Db::name("form")->where("id",$id)->find();
        $this->assign([
            "table"=>$table
        ]);
        return $this->fetch();
    }

    /**
     * 更新数据表
     **/
    public function uptable($id)
    {
        $data = input("post.");
        $y = Db::name("form")->where("id",$id)->find();
        if($data["bname"]==$y["bname"]){//如果数据表名没有变化
            $msg = Db::name("form")->where("id",$id)->update($data);
            if($msg){
                return 1;
            }else{
                return 0;
            }
        }else{
            $ytable = config('database.prefix')."form_".$y["bname"];//原
            $xtable = config('database.prefix')."form_".$data["bname"];//现
            Db::execute("ALTER  TABLE `{$ytable}` RENAME TO `{$xtable}`;");
            $msg = Db::name("form")->where("id",$id)->update($data);
            if($msg){
                return 1;
            }else{
                return 0;
            }
        }
    }

    /**
     * 显示表单内容
     **/
    public function content($fid)
    {
        $form = Db::name("form")->where("id",$fid)->find();
        $content = Db::name("formcon")->where("fid",$fid)->order("create_time","desc")->select();//获取留言内容
        $this->assign([
            "form" => $form,
            "content" => $content
        ]);
        return $this->fetch();
    }

    /**
     * 查看内容
     **/
    public function showcon()
    {
        $data = input("post.");//id(统计)$conid(内容)
        Db::name("formcon")->where("id",$data["id"])->update(["static"=>0]);
        $form = Db::name("form")->where('id',$data['fid'])->find();//表单数据
        $field = Db::name("field_form")->where("fid",$form['id'])->select();
        $table = "form_".$form["bname"];//表名
        $con = Db::name($table)->where("id",$data["conid"])->find();
        $content ="<table class='layui-table'>";
        foreach ($field as $k=>$v){
            $content .="<tr><td>{$v['name']}</td><td>{$con[$v['field']]}</td></tr>";
        }
        $content .="</table>";
        return $content;
    }

    /**
     * 删除内容
     **/
    public function deletecon(){
        $data = input("post.");
        $msg = Db::name("formcon")->where('id',$data['id'])->delete();
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }




    /**
     * 邮件配置
     **/
    public function mail()
    {
        $mail_auto = config('site.mail_auto');
        $this->assign("mail_auto",$mail_auto);
        return $this->fetch();
    }

    /**
     * 更新邮箱配置
     */
    public function upmail()
    {
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $configarr = Config::get('','site');//读取配置文件所有配置(数组)
        $data = input("post.");
        if(!isset($data['mail_auto'])){
            $data["mail_auto"] = 0;
        }
        foreach ($data as $k=>$v){//根据表单写入配置文件
            $configarr[$k] = $v;
        }
        $res = upConfig($fileadd,$configarr);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }



    /**
     * 删除数据表字段
     **/
    public function deletefield($id){
        $field = Db::name("field_form")->where("id",$id)->find();//字段名
        $models = Db::name("form")->where("id",$field["fid"])->find();//表明
        $tables = config('database.prefix')."form_".$models["bname"];//拼接表明
        Db::execute("ALTER TABLE `{$tables}` DROP `{$field["field"]}`;");//执行删除
        $msg = Db::name("field_form")->where("id",$id)->delete();
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

    public function deletetable()
    {
        $data = input("post.");
        $table = Db::name("form")->where("id",$data["id"])->find();
        $d = Db::name("form")->where("id",$table["id"])->delete();
        if($d){
            Db::name("field_form")->where("fid",$table["id"])->delete();
            $tablename = config('database.prefix')."form_".$table["bname"];
            $this->deleteb($tablename);
            return 1;
        }else{
            return 0;
        }


    }

    /**
     * 删除数据表
     **/
    private function deleteb($table)
    {
        Db::execute("DROP TABLE `{$table}`;");
    }

}
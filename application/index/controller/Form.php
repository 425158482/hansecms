<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Form extends Base
{
    public function form($id)
    {
        $data = input("post.");
        $token = request()->session()['__token__'];
        if($token==$data["__token__"]){
            if(!captcha_check($data["captcha"])){
                $this->error("验证码验证失败");
            };
            $form = Db::name("form")->where("id",$id)->find();//查询表单名称
            $field = Db::name("field_form")->where("fid",$id)->select();//表单字段
            $table = "form_".$form["bname"];
            $content = "以下内容来自于->".config('site.site_url')."<span style='color:red'>".config('site.site_name')."</span><hr>";
            foreach ($field as $k=>$v){
                if($v["space"]==1){
                    if($data[$v["field"]]==""||$data[$v["field"]]==null){
                        $this->error("必填项不能为空");
                    }else{
                        $content .= $v["name"]." : ".$data[$v["field"]]."<br>";
                    }
                }else{
                    $content .= $v["name"]." : ".$data[$v["field"]]."<br>";
                }
            }
            $res["conid"] = Db::name($table)->strict(false)->insertGetId($data);
            $res["fid"] = $id;
            $res["ip"] = request()->ip();
            $res["static"]=1;
            $res["create_time"] = time();
            $msg = Db::name("formcon")->strict(false)->insertGetId($res);
            if($msg){
                if(config('site.mail_auto')){
                    $toemail=config('site.js_mail');
                    $name=config('site.jz_name');
                    $subject=$form["name"];
                    send_mail($toemail,$name,$subject,$content);
                }
                $this->success("保存成功");
            }else{
                $this->error("保存失败");
            }
        }else{
            $this->error("令牌验证失败");
        }

    }
}

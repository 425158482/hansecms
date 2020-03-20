<?php
namespace app\index\controller;

use think\Controller;
use think\Config;
class Base extends Controller
{
    protected function _initialize()
    {
        $file = ROOT_PATH."/config/database.loc";
        if(!file_exists($file))
        {
            return $this->redirect(url('install/install/index'),302);
        }
        $time = date("Y年m月d日",time());
        $res = db("system")->where("create_time",$time)->find();
        if($res){
            db("system")->where("id",$res["id"])->update(["number"=>$res["number"]+1]);
        }else{
            db("system")->insert(["number"=>1,"create_time"=>$time]);
        }


    }
}

<?php
/**
 * Created by PhpStorm.
 * User: 张寒
 * Date: 2019/9/21 0021
 * Time: 下午 17:07
 * QQ: 425158482
 */
namespace app\admini\controller;

use think\Cache;
use think\Controller;
use think\Db;
use think\Session;
use think\Config;


class Index extends Base
{
    public function index()
    {
        $inav = Db::name("nav")->where("pid",0)->where("show",1)->order("sort","asc")->select();
        $sys = Db::name("system")->order("create_time","desc")->limit(7)->select();
        $sort = sort_asc($sys);
        $num = "";
        $time = "";
        foreach ($sort as $k=>$v){
            $num .= $v["number"].",";
            $time .= "'".$v["create_time"]."',";
        }

        $this->assign([
            "num" =>$num,
            "time"=>$time,
            "inav"=>$inav,
        ]);
        return $this->fetch();
    }

    /**
     * 清除缓存
     **/
    public function caches()
    {
        $path = glob(LOG_PATH . '*');
        foreach ($path as $item) {
            array_map('unlink', glob($item . DS . '*.log'));
            rmdir($item);
        }
        Cache::clear();
        array_map('unlink', glob(TEMP_PATH . '/*.php'));
        return 1;
    }

    /**
     * 更改用户信息
     **/
    public function editadmin()
    {
        $admini = Db::name("admin")->where("id",Session::get("admini")["id"])->find();
        $this->assign([
            "admini" => $admini,
        ]);
        return $this->fetch();
    }

    /**
     * 保存更改用户信息
     **/
    public function userup()
    {
        $data = input("post.");
        if($data["password"]==""){
            $admini = [
                "pic"=>$data["pic"],
                "name"=>$data["name"]
            ];
            $msg = Db::name("admin")->where("id",Session::get("admini")["id"])->update($admini);
            Session::set("admini",Db::name("admin")->where("id",Session::get("admini")["id"])->find());
            if($msg){
                return 1;
            }else{
                return 0;
            }
        }else{
            $pass = md5(sha1($data["password"].$data["username"]));
            $admini = [
                "username"=>$data["username"],
                "pic"=>$data["pic"],
                "name"=>$data["name"],
                "password"=> $pass
            ];
            $msg = Db::name("admin")->where("id",Session::get("admini")["id"])->update($admini);
            Session::set("admini",Db::name("admin")->where("id",Session::get("admini")["id"])->find());
            if($msg){
                return 1;
            }else{
                return 0;
            }
        }

    }

    /**
     * 更改主题
     **/
    public function theme()
    {
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $configarr = Config::get('','site');//读取配置文件所有配置(数组)
        $data = input("post.");
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




}
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
use think\Cookie;
use think\Db;
use think\Session;
use think\Config;


class Login extends Controller
{
    public function login()
    {
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $slide = Config::get('slide','site');
        $this->assign("slide",$slide);
        return $this->fetch();
    }

    /**
     * 验证用户登录
     **/
    public function reglogin()
    {
        $token = request()->session()['__token__'];
        $data = input("post.");
        if($token==$data["__token__"]){
            $pass = md5(sha1($data["password"].$data["username"]));
            $msg = Db::name("admin")
                ->where("username",$data["username"])
                ->where("password",$pass)
                ->find();
            if($msg){
                Session::set("admini",$msg);
                $up = [
                    "ip" => $_SERVER['REMOTE_ADDR'],
                    "create_time" => time(),
                    "number" => $msg["number"]+1
                ];
                Db::name("admin")->where("id",$msg["id"])->update($up);
                return 1;
            }else{
                return 0;
            }

        }else{
            return 2;
        }
    }

    /**
     * 退出登录
     **/
    public function logoaut()
    {
        Session::delete("admini");
        return 1;
    }

}
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
use think\Session;


class Base extends Controller
{
    protected function _initialize()
    {
        if(Session::has("admini")){
            //获得登陆用户操作权限
            if(Session::get("admini")["type"]!=1) {
                $url = strtolower("/" . request()->module() . "/" . request()->controller() . "/" . request()->action());
                if ($url != "/admini/index/index") {
                    $menuid = Db::name("menu")->where("url", $url)->find();
                    if ($menuid) {
                        $dqqx = explode(",", Session::get("admini")["grade"]);
                        if(!in_array($menuid["id"],$dqqx)){
                            return $this->redirect(url("index/index"),null,302,["qxbz"=>"您权限不足,无法访问->".$menuid["title"]]);
                        }
                    }
                }
            }

            //获取主导航
            $menu = Db::name("menu")->where("pid",0)->where("state",1)->order("sort","asc")->select();
            foreach($menu as $k=>$v){
                $menusub = Db::name("menu")->where("pid",$v["id"])->where("state",1)->order("sort","asc")->find();
                $menusub ? $menu[$k]["url"] = $menusub["url"] : $menu[$k]["url"] = "/admini/index/index";
            }
            //获取栏目信息=url
            $url = strtolower("/".request()->module()."/".request()->controller()."/".request()->action());
            $action = Db::name("menu")->where("url",$url)->find();//当前栏目信息
            if($action){
                $top = Db::name("menu")->where("id",$action["pid"])->find();//检测是否是3级地址
                if($top["pid"]==0){
                    $menusub = Db::name("menu")->where("pid",$action["pid"])->where("state",1)->order("sort","asc")->select();//不是3级地址
                    $this->assign("curl",$top["id"]);//主导航选中
                    $this->assign("action",$action["id"]);
                }else{
                    $sub3 = Db::name("menu")->where("id",$action["pid"])->find();//是3及栏目
                    $menusub = Db::name("menu")->where("pid",$sub3["pid"])->where("state",1)->order("sort","asc")->select();
                    $this->assign("curl",$sub3["pid"]);//主导航选中
                    $this->assign("action",$sub3["id"]);
                }
            }
            $this->assign([
                "menusub" =>$menusub,//当前子栏目
                "menu" => $menu,//主栏目
            ]);
        }else{
            return $this->redirect(url("login/login"),302);
        }
    }
}
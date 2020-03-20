<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Config;

class Search extends Base
{

    /**
     * $id = 栏目id
     **/
    public function index()
    {
        $key = input("get.");
        $data = Db::name("content")
            ->alias("a")
            ->join("nav","nav.id=a.pid")
            ->field("a.*,nav.url_static as url")
            ->where("a.title","like","%".$key['key']."%")
            ->select();
        foreach ($data as $k=>$v){
            $data[$k]["url"]="/".$v["url"]."/".$v["id"].".html";
        }
        $this->assign([
            'content'=>$data,
            'title'=>false,
            "keys"=>$key['key'],
        ]);
        //手机跳转
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $slide = Config::get('map_auto','site');
        if($slide){//检测是否自动跳转
            if(isMobile() || $wapurl == $_SERVER['HTTP_HOST']){
                return $this->fetch("wap/search");
            }
        }
        return $this->fetch("pc/search");
    }

}

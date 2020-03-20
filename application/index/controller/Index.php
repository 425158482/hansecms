<?php
namespace app\index\controller;

use think\Controller;
use think\Config;

class Index extends Base
{
    public function index($title=false)
    {
        $this->assign(["title"=>$title]);
        //手机跳转
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $slide = Config::get('map_auto','site');
        $wapurl = Config::get('wap_url','site');
        if($slide){//检测是否自动跳转
            if(isMobile() || $wapurl == $_SERVER['HTTP_HOST']){
                return $this->fetch("wap/index");
            }
        }
        return $this->fetch("pc/index");
    }
}

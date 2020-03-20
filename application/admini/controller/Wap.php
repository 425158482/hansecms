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

class Wap extends Base
{
    /**
     * 手机配置显示页
     **/
    public function index()
    {
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $map_auto = Config::get('map_auto','site');
        $this->assign("map_auto",$map_auto);
        return $this->fetch();
    }

    /**
     * 更新配置文件
     **/
    public function upfiles()
    {
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $configarr = Config::get('','site');//读取配置文件所有配置(数组)
        $data = input("post.");
        if(!isset($data['map_auto'])){
            $data["map_auto"] = 0;
        }
        unset($data["file"]);//移除上传文件的file空
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
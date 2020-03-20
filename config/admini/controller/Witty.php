<?php
/**
 * Created by PhpStorm.
 * User: 张寒
 * Date: 2019/9/21 0021
 * Time: 下午 17:07
 * QQ: 425158482
 * 功能 : 自动替换
 */
namespace app\admini\controller;

use think\Controller;
use think\Db;
use think\Config;

class Witty extends Base
{
    /**
     * 显示栏目列表
     **/
    public function index()
    {
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $witty = Config::get('witty','site');
        $this->assign("witty",$witty);
        return $this->fetch();
    }

    /**
     * 保存自动替换数据
     **/
    public function save()
    {
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $configarr = Config::get('','site');//读取配置文件所有配置(数组)
        $data = $_POST;
        if(!isset($data['witty'])){
            $data["witty"] = 0;
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
     * 数据替换接口
     **/
    static function witty($data)
    {

        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件

        $witty = Config::get('witty','site');
        if($witty){
            $witty_con = Config::get('witty_con','site');
            $text = explode("\n", $witty_con);
            foreach ($text as $k => $v){
                $text[$k] = explode("|", $v);
                foreach ($data as $key => $value){
                    $data[$key] = str_replace($text[$k][0],$text[$k][1],$value);
                }
            }
            return $data;
        }else{
            return$data;
        }
    }


}
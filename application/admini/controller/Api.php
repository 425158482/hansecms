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

class Api extends Base
{
    /**
     * 显示栏目列表
     **/
    public function index()
    {
        $zdts = config('site.zdts');
        $this->assign("zdts",$zdts);
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
        unset($data["file"]);//移除上传文件的file空
        if(!isset($data['zdts'])){
            $data["zdts"] = 0;
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
     * 链接推送显示页面
     */
    public function pulink()
    {
        $links =[];
        $links[0] = config('site.site_url');
        $nav = Db::name("nav")->where("show",1)->select();
        foreach ($nav as $k=>$v){
            $links[$k+1] = config('site.site_url')."/".$v["url_static"].".html";
        }
        $content = $data = Db::name("content")
            ->alias('a')
            ->join("nav","nav.id=a.pid")
            ->field("a.*,nav.url_static as url_statics")
            ->order("a.create_Time","desc")
            ->select();
        foreach ($content as $k=>$v){
            $links[] = config('site.site_url')."/".$v["url_statics"]."/".$v["id"].".html";
        }
        $count = count($links);
        $this->assign("links",$links);
        $this->assign("count",$count);
        return $this->fetch();
    }

    /**
     * 以http方式提交
     */
    public function puhttp()
    {
        $links =[];
        $links[0] = config('site.site_url');
        $nav = Db::name("nav")->where("show",1)->select();
        foreach ($nav as $k=>$v){
            $links[$k+1] = config('site.site_url')."/".$v["url_static"].".html";
        }
        $content = $data = Db::name("content")
            ->alias('a')
            ->join("nav","nav.id=a.pid")
            ->field("a.*,nav.url_static as url_statics")
            ->order("a.create_Time","desc")
            ->select();
        foreach ($content as $k=>$v){
            $links[] = config('site.site_url')."/".$v["url_statics"]."/".$v["id"].".html";
        }
        $api = "http://data.zz.baidu.com/urls?site=".config('site.site_url')."&token=".config('site.baidu_ts');
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $links),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        return json_decode($result,1);
    }



}
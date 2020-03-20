<?php
namespace app\index\controller;

use think\Config;
use think\Controller;
use think\Db;

class Common extends Base
{

    /**
     * $id = 栏目id
     **/
    public function index()
    {
        $url = input("title");
        $etitle = explode("_",$url);
        //手机跳转
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $slide = Config::get('map_auto','site');
        $wapurl = Config::get('wap_url','site');
        if(count($etitle)==2){
            $nav = Db::name("nav")->where("url_static",$etitle[1])->find();//查询栏目获得模板名称
            if(!$nav){
                abort(404);
            }
            $topnav = topnav($nav['id']);//当前父级栏目id
            if($nav["list"]){
                $list = "pc/".explode('.', $nav['list'])[0];
                $this->assign([
                    'topnav'=>$topnav,
                    'navid'=>$nav['id'],
                    'title'=>$etitle[0]
                ]);
                if($slide){//检测是否自动跳转
                    if(isMobile() || $wapurl == $_SERVER['HTTP_HOST']){
                        $list = "wap/".explode('.', $nav['list'])[0];
                        return $this->fetch($list);
                    }
                }
                return $this->fetch($list);
            }else{
                return $this->error("没有选择模板","/");
            }
        }else{
            $nav = Db::name("nav")->where("url_static",$etitle[0])->find();//查询栏目获得模板名称
            if(!$nav){
                abort(404);
            }
            $topnav = topnav($nav['id']);//当前父级栏目id
            if($nav["list"]){
                $list = "pc/".explode('.', $nav['list'])[0];
                $this->assign([
                    'topnav'=>$topnav,
                    'navid'=>$nav['id'],
                    'title'=>0
                ]);
                if($slide){//检测是否自动跳转
                    if(isMobile() || $wapurl == $_SERVER['HTTP_HOST']){
                        $list = "wap/".explode('.', $nav['list'])[0];
                        return $this->fetch($list);
                    }
                }
                return $this->fetch($list);
            }else{
                return $this->error("没有选择模板","/");
            }
        }



    }

    /**
     * 显示详情页面
     * $id = 内容id
     * $navid = 栏目id
     **/
    public function show($title=false,$id)
    {
        $content = Db::name('content')->where('id',$id)->find();//简约内容
        if($content){//更新点击数
            Db::name("content")->where("id",$id)->update(["click"=>$content["click"]+1]);
        }
        $nav = Db::name("nav")->where("id",$content["pid"])->find();//获得所属栏目
        if(!$nav){
            abort(404);
        }
        //手机跳转
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $slide = Config::get('map_auto','site');
        $wapurl = Config::get('wap_url','site');
        $prev = Db::name("content")->where("pid",$content["pid"])->where("id",">",$id)->find();
        $next = Db::name("content")->where("pid",$content["pid"])->where("id","<",$id)->find();
        $content["prev"]["title"] = $prev["title"];
        $content["prev"]["url"] = "/".$nav["url_static"]."/".$prev["id"].".html";
        $content["next"]["title"] = $next["title"];
        $content["next"]["url"] = "/".$nav["url_static"]."/".$next["id"].".html";
        $model = Db::name("models")->where("id",$nav["model"])->find();//获得模型
        $table = "new_".$model["bname"];//拼接数据表名称
        $content["content"] = Db::name($table)->where("id",$content["content_id"])->find();//完全形数据
        $url = input("title");
        if($url){
            $etitle = explode("_",$url);
            $address = Db::name("address")->where("etitle",$etitle[0])->find();

            $content["title"] = $address["title"].$content["title"];
            $topnav = topnav($nav["id"]);//当前父级栏目id
            if($nav["view"]){
                $list = "pc/".explode('.', $nav['view'])[0];
                $this->assign([
                    'topnav'=>$topnav,
                    'navid'=>$nav['id'],
                    'content'=>$content,
                    'title'=>$etitle[0]
                ]);
                if($slide){//检测是否自动跳转
                    if(isMobile() || $wapurl == $_SERVER['HTTP_HOST']){
                        $list = "wap/".explode('.', $nav['view'])[0];
                        return $this->fetch($list);
                    }
                }
                return $this->fetch($list);
            }else{
                return $this->error("没有选择模板","/");
            }
        }else{
            $topnav = topnav($nav["id"]);//当前父级栏目id
            if($nav["view"]){
                $list = "pc/".explode('.', $nav['view'])[0];
                $this->assign([
                    'topnav'=>$topnav,
                    'navid'=>$nav['id'],
                    'content'=>$content,
                    'title'=>false
                ]);
                if($slide){//检测是否自动跳转
                    if(isMobile() || $wapurl == $_SERVER['HTTP_HOST']){
                        $list = "wap/".explode('.', $nav['view'])[0];
                        return $this->fetch($list);
                    }
                }
                return $this->fetch($list);
            }else{
                return $this->error("没有选择模板","/");
            }
        }
    }
}

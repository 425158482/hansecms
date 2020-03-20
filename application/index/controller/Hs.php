<?php
namespace app\index\controller;

use think\Controller;
use think\template\TagLib;
use think\Config;
use think\Cache;

class Hs extends TagLib
{
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'nav' => ["attr"=>"limit,address","close"=>1],//栏目调用标签
        'config' => ['attr'=>'name',"close"=>0],//配置信息调用
        'debris' => ['attr'=>'title',"close"=>0],//碎片信息调用
        'banner' => ["attr"=>"type,limit","close"=>1],//banner调用标签
        'list' => ["attr"=>"nid,order,limit,reco,pagesize","close"=>1],//banner调用标签
        'navsub' => ["attr"=>"pid,limit,order","close"=>1],//栏目调用标签
        'navcon' => ["attr"=>"id","close"=>1],//单个栏目调用标签
        'links' => ["attr"=>"type,limit","close"=>1],//友情链接调用标签
        'address' => ["attr"=>"static","close"=>1],//友情链接调用标签
        'seo' => ['attr'=>'name',"close"=>0],//配置信息调用
        'current' => ['attr'=>'name',"close"=>0],//配置信息调用
    ];

    /**
     * 当前位置调用标签
     * $attr 传参数组,array
     * $content 循环内容 HTML
     **/
    public function tagCurrent($attr,$content)
    {
        $name = $attr["name"];

        $sub = '<a href="/">首页</a>';
        $sub .= "{$name}";
        $sub .= '{if($topnav==$navid)}';
        $sub .= '<?php $nav = db("nav")->where("id",$topnav)->find(); ?>';
        $sub .= '<a href="/{$nav.url_static}.html">{$nav.name}</a>';
        $sub .= '{else}';
        $sub .= '<?php $nav = db("nav")->where("id",$topnav)->find(); ?>';
        $sub .= '<?php $sub = db("nav")->where("id",$navid)->find(); ?>';
        $sub .= '<a href="/{$nav.url_static}.html">{$nav.name}</a>';
        $sub .= "{$name}";
        $sub .= '<a href="/{$sub.url_static}.html">{$sub.name}</a>';
        $sub .= '{/if}';
        $sub .=$content;
        return $sub;
    }

    /**
     * 配置信息调用
     **/
    public function tagSeo($attr)
    {
        $name = $attr["name"];
        $str = '<?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; ?>';
        $str .= '<?php \think\Config::load($fileadd, "", "site"); ?>';
        $str .= '<?php $titlew = input("title"); ?>';
        $str .= '<?php $etitle = explode("_",$titlew); ?>';
        $str .= '{if($titlew)}';
        $str .= '{if count($etitle)==2}';
        $str .= '<?php $titles = $etitle[0]; ?>';
        $str .= '<?php $configarr = \think\Config::get("f_'.$name.'","site"); ?>';
        $str .= '<?php $address = db("address")->where("etitle",$titles)->find(); ?>';
        $str .= '<?php echo str_replace("[address]",$address["title"],$configarr); ?>';
        $str .= '{else}';
        $str .= '<?php $titles = $title; ?>';
        $str .= '<?php $address = db("address")->where("etitle",$titles)->find(); ?>';
        $str .= '{if($address)}';
        $str .= '<?php $configarr = \think\Config::get("f_'.$name.'","site"); ?>';
        $str .= '<?php echo str_replace("[address]",$address["title"],$configarr); ?>';
        $str .= '{else}';
        $str .= '<?php $configarr = \think\Config::get("'.$name.'","site"); ?>';
        $str .= '<?php echo $configarr; ?>';
        $str .= '{/if}';
        $str .= '{/if}';
        $str .= '{else}';
        $str .= '<?php $configarr = \think\Config::get("'.$name.'","site"); ?>';
        $str .= '<?php echo $configarr; ?>';
        $str .= '{/if}';
        return $str;
    }

    /**
     * 分站调用标签
     * $attr 传参数组,array
     * $content 循环内容 HTML
     **/
    public function tagAddress($attr,$content)
    {
        $menu = '{if($title)}';
        $menu .= '<?php $pid = db("address")->where("etitle",$title)->find();?>';
        $menu .= '<?php $data = db("address")->where("pid",$pid["id"])->select();?>';
        $menu .= '{if(!$data)}';
        $menu .= '<?php $data = db("address")->where("pid",$pid["pid"])->select();?>';
        $menu .= '{/if}';
        $menu .= '{else}';
        $menu .= '<?php $data = db("address")->where("static",1)->where("pid",0)->select();?>';
        $menu .= '{/if}';
        $menu .='{foreach($data as $k=>$address)}';
        $menu .='<?php $address["url"]="/address/".$address["etitle"].".html"; ?>';
        $menu .=$content;
        $menu .="{/foreach}";
        return $menu;
    }

    /**
     * 友情链接调用标签
     * $attr 传参数组,array
     * $content 循环内容 HTML
     **/
    public function tagLinks($attr,$content)
    {
        $type = $attr["type"];
        $limit = $attr["limit"];
        $menu = "<?php ";
        $menu .= '$data = db("links")->where("type",'.$type.')->limit('.$limit.')->order("sort","desc")->select();';
        $menu .=" ?>";
        $menu .='{foreach($data as $k=>$links)}';
        $menu .=$content;
        $menu .="{/foreach}";
        return $menu;
    }

    /**
     * 单个栏目调用标签
     * $attr 传参数组,array
     * $content 循环内容 HTML
     **/
    public function tagNavcon($attr,$content)
    {
        $id = $attr["id"];
        $sub = "<?php ";
        $sub .= '$navcon = db("nav")->where("id",'.$id.')->find();';
        $sub .= '$address = input("title");';
        $sub .= '$etitle = explode("_",$address);';
        $sub .=" ?>";
        $sub .= '{if count($etitle)==2}';
        $sub .= '<?php $address = $etitle[0]; ?>';
        $sub .= '{/if}';
        $sub .= '<?php $dq = db("address")->where("etitle",$address)->find(); ?>';
        $sub .= '{if $dq}';
        $sub .= '<?php $navcon["name"]=$dq["title"].$navcon["name"]; ?>';
        $sub .= '<?php $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; ?>';
        $sub .= '{else}';
        $sub .='<?php $navcon["url"]="/".$navcon["url_static"].".html"; ?>';
        $sub .= '{/if}';
        $sub .=$content;
        return $sub;
    }

    /**
     * 子栏目调用标签
     * $attr 传参数组,array
     * $content 循环内容 HTML
     **/
    public function tagNavsub($attr,$content)
    {
        $limit = $attr["limit"];
        $order = $attr["order"] ? $attr["order"] : "id asc";
        $pid = $attr["pid"];//父级id
        $sub = "<?php ";
        $sub .= '$f = '.$pid.';';
        $sub .= '$sub = db("nav")->where("pid",$f)->where("show",1)->limit('.$limit.')->order("'.$order.'")->select();';
        $sub .= '$address = input("title");';
        $sub .= '$etitle = explode("_",$address);';
        $sub .=" ?>";
        $sub .= '{if count($etitle)==2}';
        $sub .= '<?php $address = $etitle[0]; ?>';
        $sub .= '{/if}';
        $sub .='{foreach($sub as $k=>$navsub)}';
        $sub .= '<?php $dq = db("address")->where("etitle",$address)->find(); ?>';
        $sub .= '{if $dq}';
        $sub .= '<?php $navsub["name"]=$dq["title"].$navsub["name"]; ?>';
        $sub .= '<?php $navsub["url"]="/navs/".$dq["etitle"]."_".$navsub["url_static"].".html"; ?>';
        $sub .= '{else}';
        $sub .='<?php $navsub["url"]="/".$navsub["url_static"].".html"; ?>';
        $sub .= '{/if}';

        $sub .=$content;
        $sub .="{/foreach}";
        return $sub;
    }

    /**
     * 列表调用标签
     * $attr 传参数组,array
     * $content 循环内容 HTML
     **/
    public function tagList($attr,$content)
    {
        $nid = $attr["nid"];//栏目id
        $order = $attr["order"] ? $attr["order"] : "id asc";//排序
        $reco = $attr["reco"] ? '"reco","eq",1':'"reco","in","0,1"';//是否推荐
        $limit = $attr["limit"];
        $pagesize = $attr["pagesize"];//分页
        $menu = '<?php ';
        $menu .= '$nav = db("nav")->where("id",'.$nid.')->find();';
        $menu .= '$model = db("models")->where("id",$nav["model"])->find();';
        $menu .= '$table = "new_".$model["bname"];';
        $menu .= '$res = db("nav")->where("id",'.$nid.')->select();';
        $menu .= '$navids = numbernav($res);';//所有子栏目1,2,3.....
        if($pagesize){//如果有分页
            $menu .='$data = db("content")->where("pid","in",$navids)->where('.$reco.')->order("'.$order.'")->paginate('.$pagesize.');';
            $menu .='$page = $data->render();';
        }else{
            $menu .='$data = db("content")->where("pid","in",$navids)->where('.$reco.')->limit('.$limit.')->order("'.$order.'")->select();';
        }
        $menu .= '$address = input("title");';
        $menu .= '$etitle = explode("_",$address);';
        $menu .='?>';
        $menu .= '{if count($etitle)==2}';
        $menu .= '<?php $address = $etitle[0]; ?>';
        $menu .= '{/if}';

        $menu .='{foreach($data as $k=>$list)}';
        $menu .='<?php $dq = db("address")->where("etitle",$address)->find();?>';
        $menu .= '{if $dq}';//如果存在地区
        $menu .= '<?php ';
        $menu .='$list["content"] = db($table)->where("id",$list["content_id"])->find();';
        $menu .='$list["title"]=$dq["title"].$list["title"];';
        $menu .='$list["url"] = "/show/".$dq["etitle"]."_".$nav["url_static"]."/".$list["id"].".html";';
        $menu .='?>';
        $menu .= '{else}';
        $menu .= '<?php ';
        $menu .='$list["content"] = db($table)->where("id",$list["content_id"])->find();';
        $menu .='$list["url"] = "/".$nav["url_static"]."/".$list["id"].".html";';
        $menu .='?>';
        $menu .= '{/if}';
        $menu .=$content;
        $menu .="{/foreach}";
        if($pagesize){
            $menu .='<?php $pages = $page; ?>';
        }
        return $menu;
    }

    /**
     * banner调用标签
     * $attr 传参数组,array
     * $content 循环内容 HTML
     **/
    public function tagBanner($attr,$content)
    {
        $type = $attr["type"];
        $limit = $attr["limit"];
        $menu = "<?php ";
        $menu .= '$data = db("banner")->where("type",'.$type.')->limit('.$limit.')->select();';
        $menu .=" ?>";
        $menu .='{foreach($data as $k=>$banner)}';
        $menu .=$content;
        $menu .="{/foreach}";
        return $menu;
    }

    /**
     * 碎片数据调用
     **/
    public function tagDebris($attr)
    {
        $name = $attr["title"];
        $data = db("debris")->where("title",$name)->find();
        return $data["content"];
    }

    /**
     * 配置信息调用
     **/
    public function tagConfig($attr)
    {
        $name = $attr["name"];
        $fileadd = CONF_PATH.DS.'extra'.DS.'site.php';//配置文件地址
        Config::load($fileadd, '', 'site');//加载配置文件
        $data = Config::get($name,'site');
        return $data;
    }

    /**
     * 栏目调用标签
     * $attr 传参数组,array
     * $content 循环内容 HTML
     **/
    public function tagNav($attr,$content)
    {
        $limit = $attr["limit"];
        $menu = "<?php ";
        $menu .= '$data = db("nav")->where("pid",0)->where("show",1)->limit('.$limit.')->order("id","asc")->select();';
        $menu .= '$address = input("title");';
        $menu .= '$etitle = explode("_",$address);';
        $menu .=" ?>";
        $menu .='{foreach($data as $k=>$nav)}';
        $menu .= '{if count($etitle)==2}';
        $menu .= '<?php $address = $etitle[0]; ?>';
        $menu .= '{/if}';
        $menu .= '<?php $dq = db("address")->where("etitle",$address)->find(); ?>';
        $menu .= '{if ($dq)}';
        $menu .= '{if($nav["curl"])}';
        $menu .= '{if(is_numeric($nav["curl"]))}';
        $menu .= '<?php $curl=db("nav")->where("id",$nav["curl"])->find(); ?>';
        $menu .= '<?php $nav["name"]=$dq["title"].$nav["name"]; ?>';
        $menu .= '<?php $nav["url"]="/navs/".$dq["etitle"]."_".$curl["url_static"].".html"; ?>';
        $menu .= '{else}';
        $menu .= '<?php $nav["name"]=$dq["title"].$nav["name"]; ?>';
        $menu .= '<?php $nav["url"]=$nav["curl"]; ?>';
        $menu .= '{/if}';
        $menu .= '{else}';
        $menu .= '<?php $nav["name"]=$dq["title"].$nav["name"]; ?>';
        $menu .= '<?php $nav["url"]="/navs/".$dq["etitle"]."_".$nav["url_static"].".html"; ?>';
        $menu .= '{/if}';
        $menu .= '{else}';
        $menu .= '{if($nav["curl"])}';
        $menu .= '{if(is_numeric($nav["curl"]))}';
        $menu .= '<?php $curl=db("nav")->where("id",$nav["curl"])->find(); ?>';
        $menu .= '<?php $nav["url"]="/".$curl["url_static"].".html"; ?>';
        $menu .= '{else}';
        $menu .= '<?php $nav["url"]=$nav["curl"]; ?>';
        $menu .= '{/if}';
        $menu .= '{else}';
        $menu .= '<?php $nav["url"]="/".$nav["url_static"].".html"; ?>';
        $menu .= '{/if}';
        $menu .= '{/if}';
        $menu .=$content;
        $menu .="{/foreach}";
        return $menu;
    }





}

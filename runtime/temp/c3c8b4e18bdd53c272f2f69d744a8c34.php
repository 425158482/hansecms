<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:54:"D:\phpstudy_pro\WWW\hs.cn\/template/wap\view_news.html";i:1581506190;s:48:"D:\phpstudy_pro\WWW\hs.cn\template\wap\base.html";i:1581506101;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php if((isset($content['title']))): ?><?php echo $content['title']; else: $navcon = db("nav")->where("id",$navid)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?><?php echo $navcon['name']; endif; ?> - <?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_title","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_title","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_title","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_title","site"); ?><?php echo $configarr; endif; ?></title>
    <meta name="keywords" content="<?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_keywords","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_keywords","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_keywords","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_keywords","site"); ?><?php echo $configarr; endif; ?>">
    <meta name="description" content="<?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_description","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_description","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_description","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_description","site"); ?><?php echo $configarr; endif; ?>">
    <meta name="viewport" content="width=640,user-scalable=no">
    <!--主要样式-->
    <link rel="stylesheet" href="/template/wap/commons/css/mdui.css">
    <link rel="stylesheet" href="/template/wap/commons/css/app.css">
    <link rel="stylesheet" href="/template/wap/commons/css/common.css">
    <link rel="stylesheet" href="/template/wap/css/swiper.css">

    <script type="text/javascript" src="/template/wap/js/swiper.js"></script>
    <style>
        .list_pic>a>div:nth-child(2){
            color: #fff;
            background:#71CBD6;
        }
        .f_menu{
            background:rgba(241,220,113,1);
        }
        .list_pro>a>div:nth-child(4){
            color: #fff;
            background: #71CBD6;
        }
        .pic_pic_s .swiper-pagination-bullet-active{
            background: #71CBD6;
        }
        .n_logo{
            background:rgba(113,203,214,1);
        }
    </style>
</head>
<body class="drawer drawer-right">
<!--头部-->
<div class="top">
    <!--返回按钮-->
    <div class="tim" onClick="javascript :history.back(-1);"></div>
    <div class="dqlm">
        <?php $navcon = db("nav")->where("id",$navid)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?>
        <?php echo $navcon['name']; ?>
        
    </div>
    <!-- 栏目开关 -->
    <div class="drawer-toggle drawer-hamberger mdui-btn app-btn" mdui-drawer="{target: &#39;#left-drawer&#39;}">
        <span></span>
    </div>


</div>

<!--隐藏栏目-->


<div class="mdui-drawer mdui-drawer-right mdui-drawer-close" id="left-drawer">

    <ul class="mdui-list app-slide-menu app-collapse-menu" mdui-collapse="{accordion: true}">
        <li class="mdui-list-item mdui-ripple app-list-home ">
            <a href="/" class="app-list-item-link mdui-text-left ">
                <div class="mdui-list-item-content">
                    <i class="mdui-list-item-icon mdui-icon material-icons">
                        
                    </i>网站首页
                </div>
            </a>
        </li>
        <?php $data = db("nav")->where("pid",0)->where("show",1)->limit(10)->order("id","asc")->select();$address = input("title");$etitle = explode("_",$address); foreach($data as $k=>$nav): if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if(($dq)): if(($nav["curl"])): if((is_numeric($nav["curl"]))): $curl=db("nav")->where("id",$nav["curl"])->find(); $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]="/navs/".$dq["etitle"]."_".$curl["url_static"].".html"; else: $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]=$nav["curl"]; endif; else: $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]="/navs/".$dq["etitle"]."_".$nav["url_static"].".html"; endif; else: if(($nav["curl"])): if((is_numeric($nav["curl"]))): $curl=db("nav")->where("id",$nav["curl"])->find(); $nav["url"]="/".$curl["url_static"].".html"; else: $nav["url"]=$nav["curl"]; endif; else: $nav["url"]="/".$nav["url_static"].".html"; endif; endif; ?>
        <li class="mdui-collapse-item  app-hide-list  app-collapse-list">
            <div class="mdui-collapse-item-header mdui-list-item mdui-ripple  mdui-p-x-0">
                <div class="menu-click mdui-list-item-content mdui-text-left" onclick="">
                    <a href="<?php echo $nav['url']; ?>"><?php echo $nav['name']; ?></a>
                    <i class="mdui-collapse-item-arrow mdui-icon material-icons mdui-float-right">
                        
                    </i>
                </div>
            </div>
            <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">
                <?php $f = $nav['id'];$sub = db("nav")->where("pid",$f)->where("show",1)->limit(10)->order("id asc")->select();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; foreach($sub as $k=>$navsub): $dq = db("address")->where("etitle",$address)->find(); if($dq): $navsub["name"]=$dq["title"].$navsub["name"]; $navsub["url"]="/navs/".$dq["etitle"]."_".$navsub["url_static"].".html"; else: $navsub["url"]="/".$navsub["url_static"].".html"; endif; ?>
                <li class="mdui-list-item mdui-ripple app-sub-list  app-hide-list">
                    <a href="<?php echo $navsub['url']; ?>" class="app-list-item-link mdui-text-left">
                        <?php echo $navsub['name']; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<!--内页logo-->
<div class="n_logo">
    <a href=""><img src="" alt=""></a>
</div>
<!--内页子栏目-->
<div class="common_nav">
    <?php $f = $topnav;$sub = db("nav")->where("pid",$f)->where("show",1)->limit(10)->order("id asc")->select();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; foreach($sub as $k=>$navsub): $dq = db("address")->where("etitle",$address)->find(); if($dq): $navsub["name"]=$dq["title"].$navsub["name"]; $navsub["url"]="/navs/".$dq["etitle"]."_".$navsub["url_static"].".html"; else: $navsub["url"]="/".$navsub["url_static"].".html"; endif; ?>
    <div class="title"><a href="<?php echo $navsub['url']; ?>"><?php echo $navsub['name']; ?></a></div>
    <?php endforeach; ?>
</div>
<!--内容部分-->
<div class="comm_main">
    
<div class="show_news">
    <div><?php echo $content['title']; ?></div>
    <div>时间 : <?php echo date("Y-m-d",$content['create_Time']); ?></div>
    <div>
        <?php echo $content['content']['content']; ?>
    </div>
    <div>
        <a href="<?php echo $content['prev']['url']; ?>">上一篇 : <?php echo $content['prev']['title']; ?></a>
        <a href="<?php echo $content['next']['url']; ?>">下一篇 : <?php echo $content['next']['title']; ?></a>
        <div style="clear:both;"></div>
    </div>
</div>


</div>
<!--最新推荐-->
<div class="zxtj">
    <div>最新推荐</div>
    <div><span>THE LATEST</span></div>
</div>
<div class="list_zx">
    <?php $nav = db("nav")->where("id",5)->find();$model = db("models")->where("id",$nav["model"])->find();$table = "new_".$model["bname"];$res = db("nav")->where("id",5)->select();$navids = numbernav($res);$data = db("content")->where("pid","in",$navids)->where("reco","in","0,1")->limit(4)->order("create_Time desc")->select();$address = input("title");$etitle = explode("_",$address);if(count($etitle)==2): $address = $etitle[0]; endif; foreach($data as $k=>$list): $dq = db("address")->where("etitle",$address)->find();if($dq): $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["title"]=$dq["title"].$list["title"];$list["url"] = "/show/".$dq["etitle"]."_".$nav["url_static"]."/".$list["id"].".html";else: $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["url"] = "/".$nav["url_static"]."/".$list["id"].".html";endif; ?>
    <a href="<?php echo $list['url']; ?>">
        <div class="left"><img src="<?php echo $list['pic']; ?>" alt=""></div>
        <div class="right">
            <div><?php echo $list['title']; ?></div>
            <div><?php echo $list['content']['desc']; ?></div>
        </div>
        <div style="clear: both"></div>
    </a>
    <?php endforeach; ?>
</div>

<!--撑起高度-->
<div style="height: 120px"></div>







<!--底部按钮-->
<div class="f_menu">
    <a href="/">
        <div><img src="/template/commons/images/ff1.png" alt=""></div>
        <div>首页</div>
    </a>
    <?php $navcon = db("nav")->where("id",6)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?>
    <a href="<?php echo $navcon['url']; ?>">
        <div><img src="/template/commons/images/ff2.png" alt=""></div>
        <div>项目</div>
    </a>
    
    <?php $navcon = db("nav")->where("id",4)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?>
    <a href="<?php echo $navcon['url']; ?>">
        <div><img src="/template/commons/images/ff4.png" alt=""></div>
        <div>康复</div>
    </a>
    
    <a href="tel:">
        <div><img src="/template/commons/images/ff3.png" alt=""></div>
        <div>电话</div>
    </a>
</div>


<script src="/template/wap/commons/js/mdui.js"></script>


<script type="text/javascript">
    //打开隐藏栏目
    $(document).ready(function(){
        $('.drawer').drawer();
    });
    $(function () {
        $("a").click(function () {
            $("body").hide(1000);
        })
    })
</script>
<!-- 代码 结束 -->
</body>
</html>
<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:55:"D:\phpstudy_pro\WWW\hs.cn\/template/pc/index\index.html";i:1575359892;s:62:"D:\phpstudy_pro\WWW\hs.cn\template\pc\index\public_header.html";i:1575359874;s:62:"D:\phpstudy_pro\WWW\hs.cn\template\pc\index\public_footer.html";i:1571753560;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title><?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_title","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_title","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_title","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_title","site"); ?><?php echo $configarr; endif; ?></title>
    <meta name="keywords" content="<?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_keywords","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_keywords","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_keywords","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_keywords","site"); ?><?php echo $configarr; endif; ?>">
    <meta name="description" content="<?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_description","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_description","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_description","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_description","site"); ?><?php echo $configarr; endif; ?>">
    <link rel="stylesheet" type="text/css" href="/template/pc/index/css/swiper.css" />
    <link rel="stylesheet" type="text/css" href="/template/pc/index/css/style.css" />
    <script src="/template/pc/index/js/swiper.js"></script>

</head>
<body>
<!--头部-->
<div class="top_hy">
    <div>
        <div class="left">欢迎访问官网！</div>
        <div class="right">

        </div>
        <div style="clear: both"></div>
    </div>
</div>
<!--头部logo-->
<div class="top_logo">
    <div class="left">
        <div class="img"><img src="" alt=""></div>
        <div class="wz"></div>
        <div style="clear: both"></div>
    </div>
    <div class="right">
        <div>泓呈咨询热线</div>
        <div></div>
    </div>
    <div style="clear: both"></div>
</div>
<!--头部导航-->
<div class="top_nav" id="top_nav">
    <div>
        <?php $navid = isset($navid) ? $navid : 0;  $topnav = isset($topnav) ? $topnav : 0;  ?>
        <div class="title"><a href="/"  <?php if(($navid==0)): ?>class="active"<?php endif; ?> title="首页">首页</a></div>
        <?php $data = db("nav")->where("pid",0)->where("show",1)->limit(10)->order("id","asc")->select();$address = input("title");$etitle = explode("_",$address); foreach($data as $k=>$nav): if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if(($dq)): if(($nav["curl"])): if((is_numeric($nav["curl"]))): $curl=db("nav")->where("id",$nav["curl"])->find(); $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]="/navs/".$dq["etitle"]."_".$curl["url_static"].".html"; else: $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]=$nav["curl"]; endif; else: $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]="/navs/".$dq["etitle"]."_".$nav["url_static"].".html"; endif; else: if(($nav["curl"])): if((is_numeric($nav["curl"]))): $curl=db("nav")->where("id",$nav["curl"])->find(); $nav["url"]="/".$curl["url_static"].".html"; else: $nav["url"]=$nav["curl"]; endif; else: $nav["url"]="/".$nav["url_static"].".html"; endif; endif; ?>
        <div class="title"><a href="<?php echo $nav['url']; ?>" <?php if($navid==$nav["id"]||$topnav==$nav['id']): ?>class="active"<?php endif; ?> title="<?php echo $nav['name']; ?>"><?php echo $nav['name']; ?><span>/</span></a></div>
        <?php endforeach; ?>
        <div style="clear:both"></div>
    </div>
</div>

































<!--banner-->
<div class="banner">
    <div class="swiper-wrapper">
        <?php $data = db("banner")->where("type",1)->limit(10)->select(); foreach($data as $k=>$banner): ?>
        <div class="swiper-slide">
            <a href="<?php echo $banner['url']; ?>"><img src="<?php echo $banner['pic']; ?>" alt=""></a>
        </div>
        <?php endforeach; ?>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <!-- Add Pagination -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>













<!--底部-->
<!--底部-->
<div class="foot">
    <div>
        <div class="left">
            <div class="ft"><span>联系我们</span>Contact us</div>
            <div class="kuan"></div>
            <div class="con">
                <p></p>
                <p>座机 : &nbsp;&nbsp;&nbsp;&nbsp; Q &nbsp;Q : </p>
                <p>手机 : &nbsp;&nbsp;&nbsp;&nbsp;邮箱 : @qq.com</p>
            </div>
        </div>
        <div class="left">
            <div class="ft"><span>快捷导航</span>Shortcut navigation</div>
            <div class="fnav">
                <a href="/" title="泓呈首页">泓呈首页</a>
                <?php $data = db("nav")->where("pid",0)->where("show",1)->limit(10)->order("id","asc")->select();$address = input("title");$etitle = explode("_",$address); foreach($data as $k=>$nav): if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if(($dq)): if(($nav["curl"])): if((is_numeric($nav["curl"]))): $curl=db("nav")->where("id",$nav["curl"])->find(); $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]="/navs/".$dq["etitle"]."_".$curl["url_static"].".html"; else: $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]=$nav["curl"]; endif; else: $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]="/navs/".$dq["etitle"]."_".$nav["url_static"].".html"; endif; else: if(($nav["curl"])): if((is_numeric($nav["curl"]))): $curl=db("nav")->where("id",$nav["curl"])->find(); $nav["url"]="/".$curl["url_static"].".html"; else: $nav["url"]=$nav["curl"]; endif; else: $nav["url"]="/".$nav["url_static"].".html"; endif; endif; ?>
                <a href="<?php echo $nav['url']; ?>" title="<?php echo $nav['name']; ?>"><?php echo $nav['name']; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="left">
            <div class="ft"><span>关注我们</span>Pay attention to us</div>
            <div class="ewm">
                <img src="" alt="">
                <div>微信扫一扫关注我们</div>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
</div>
<!--底部版权-->
<div class="bq">
    <div>
        
    </div>
</div>

<script src="/template/pc/index/js/index.js"></script>
</body>
</html>
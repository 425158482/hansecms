<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:50:"D:\phpstudy_pro\WWW\hs.cn\/template/wap\index.html";i:1581505984;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title><?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_title","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_title","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_title","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_title","site"); ?><?php echo $configarr; endif; ?></title>
    <meta name="keywords" content="<?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_keywords","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_keywords","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_keywords","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_keywords","site"); ?><?php echo $configarr; endif; ?>">
    <meta name="description" content="<?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_description","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_description","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_description","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_description","site"); ?><?php echo $configarr; endif; ?>">
    <meta name="viewport" content="width=640,user-scalable=no">
    <link rel="stylesheet" href="/template/wap/css/swiper.css">
    <link rel="stylesheet" href="/template/wap/css/style.css">
    <script type="text/javascript" src="/template/wap/js/swiper.js"></script>
    <script type="text/javascript" src="/template/wap/js/jquery-1.11.1.min.js"></script>
</head>
<body>
<!--top-->
<div class="top">
    <div class="left">
        <div class="logo">
            <img src="" alt="">
        </div>
        <div style="clear: both"></div>
    </div>
    <div class="right">
        <div id="men_nav"></div>
        <div class="ds_men">
            <?php $data = db("nav")->where("pid",0)->where("show",1)->limit(10)->order("id","asc")->select();$address = input("title");$etitle = explode("_",$address); foreach($data as $k=>$nav): if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if(($dq)): if(($nav["curl"])): if((is_numeric($nav["curl"]))): $curl=db("nav")->where("id",$nav["curl"])->find(); $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]="/navs/".$dq["etitle"]."_".$curl["url_static"].".html"; else: $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]=$nav["curl"]; endif; else: $nav["name"]=$dq["title"].$nav["name"]; $nav["url"]="/navs/".$dq["etitle"]."_".$nav["url_static"].".html"; endif; else: if(($nav["curl"])): if((is_numeric($nav["curl"]))): $curl=db("nav")->where("id",$nav["curl"])->find(); $nav["url"]="/".$curl["url_static"].".html"; else: $nav["url"]=$nav["curl"]; endif; else: $nav["url"]="/".$nav["url_static"].".html"; endif; endif; ?>
            <a href="<?php echo $nav['url']; ?>" target=""><?php echo $nav['name']; ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <div style="clear: both"></div>
</div>
<script>
    $(function () {
        $("#men_nav").click(function () {
            $(".ds_men").toggle(200)
        })
    })
</script>
<!--banner-->
<div class="banner">
    <div class="swiper-wrapper">
        <?php $data = db("banner")->where("type",2)->limit(10)->select(); foreach($data as $k=>$banner): ?>
        <div class="swiper-slide">
            <a href="<?php echo $banner['url']; ?>">
                <img src="<?php echo $banner['pic']; ?>" width="640" height="350" alt="">
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>
<!--公司简介-->
<div class="i_about">
    <div class="t">
        <div class="left">PET HOSPITAL</div>
        <div class="left">
            <div>唯爱动物医馆 </div>
            <div>Animal hospital</div>
        </div>
        <div style="clear: both"></div>
    </div>
    <div class="con">
        <div><?php $navcon = db("nav")->where("id",1)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?><?php echo $navcon['desc']; ?></div>
        <div><?php $navcon = db("nav")->where("id",1)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?><a href="<?php echo $navcon['url']; ?>">更多></a></div>
    </div>
</div>
<!--康复故事-->
<div class="kfgs">
    <div class="ttt">
        <div>Rehabilitation story</div>
        <div>康复故事</div>
        <div>唯爱动物医馆24小时为您的毛孩子提供咨询服务</div>
    </div>
    <div class="kf_box">
        <div class="swiper-wrapper">
            <?php $nav = db("nav")->where("id",4)->find();$model = db("models")->where("id",$nav["model"])->find();$table = "new_".$model["bname"];$res = db("nav")->where("id",4)->select();$navids = numbernav($res);$data = db("content")->where("pid","in",$navids)->where("reco","in","0,1")->limit(10)->order("create_Time desc")->select();$address = input("title");$etitle = explode("_",$address);if(count($etitle)==2): $address = $etitle[0]; endif; foreach($data as $k=>$list): $dq = db("address")->where("etitle",$address)->find();if($dq): $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["title"]=$dq["title"].$list["title"];$list["url"] = "/show/".$dq["etitle"]."_".$nav["url_static"]."/".$list["id"].".html";else: $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["url"] = "/".$nav["url_static"]."/".$list["id"].".html";endif; ?>
            <div class="swiper-slide">
                <a href="<?php echo $list['url']; ?>">
                    <div><img src="<?php echo $list['pic']; ?>" alt=""></div>
                    <div>名字 : <?php echo $list['content']['name']; ?> &nbsp;&nbsp;&nbsp;&nbsp; 年龄 : <?php echo $list['content']['age']; ?></div>
                    <div><?php echo $list['content']['desc']; ?></div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!--服务项目-->
<div class="fwxm">
    <div class="ttt" style="text-align: right;margin-right: 20px">
        <div>Service Items</div>
        <div>服务项目</div>
        <div>唯爱动物医馆24小时为您的毛孩子提供咨询服务</div>
    </div>
    <div class="con">
        <?php $f = 2;$sub = db("nav")->where("pid",$f)->where("show",1)->limit(5)->order("id asc")->select();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; foreach($sub as $k=>$navsub): $dq = db("address")->where("etitle",$address)->find(); if($dq): $navsub["name"]=$dq["title"].$navsub["name"]; $navsub["url"]="/navs/".$dq["etitle"]."_".$navsub["url_static"].".html"; else: $navsub["url"]="/".$navsub["url_static"].".html"; endif; ?>
        <a href="<?php echo $navsub['url']; ?>" class="left">
            <img src="/template/images/fw<?php echo $k+1; ?>.png" alt="<?php echo $navsub['name']; ?>">
            <div><?php echo $navsub['name']; ?></div>
        </a>
        <?php endforeach; ?>
        <div style="clear: both"></div>
    </div>
</div>
<!--医疗团队-->
<div class="yltd">
    <div class="ttt">
        <div>Medical team</div>
        <div>医疗团队</div>
        <div>唯爱动物医馆24小时为您的毛孩子提供咨询服务</div>
    </div>
    <div class="td_box">
        <div class="swiper-wrapper">
            <?php $nav = db("nav")->where("id",3)->find();$model = db("models")->where("id",$nav["model"])->find();$table = "new_".$model["bname"];$res = db("nav")->where("id",3)->select();$navids = numbernav($res);$data = db("content")->where("pid","in",$navids)->where("reco","in","0,1")->limit(10)->order("create_Time desc")->select();$address = input("title");$etitle = explode("_",$address);if(count($etitle)==2): $address = $etitle[0]; endif; foreach($data as $k=>$list): $dq = db("address")->where("etitle",$address)->find();if($dq): $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["title"]=$dq["title"].$list["title"];$list["url"] = "/show/".$dq["etitle"]."_".$nav["url_static"]."/".$list["id"].".html";else: $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["url"] = "/".$nav["url_static"]."/".$list["id"].".html";endif; ?>
            <div class="swiper-slide">
                <a href="<?php echo $list['url']; ?>">
                    <div><img src="<?php echo $list['pic']; ?>" alt="<?php echo $list['title']; ?>"></div>
                    <div><?php echo $list['title']; ?></div>
                    <div><?php echo $list['content']['desc']; ?></div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!--新闻中心-->
<div class="i_news">
    <div class="ttt">
        <div>weiai information</div>
        <div>唯爱资讯</div>
        <div>唯爱动物医馆24小时为您的毛孩子提供咨询服务</div>
    </div>
    <div class="con">
        <?php $nav = db("nav")->where("id",5)->find();$model = db("models")->where("id",$nav["model"])->find();$table = "new_".$model["bname"];$res = db("nav")->where("id",5)->select();$navids = numbernav($res);$data = db("content")->where("pid","in",$navids)->where("reco","in","0,1")->limit(4)->order("create_Time desc")->select();$address = input("title");$etitle = explode("_",$address);if(count($etitle)==2): $address = $etitle[0]; endif; foreach($data as $k=>$list): $dq = db("address")->where("etitle",$address)->find();if($dq): $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["title"]=$dq["title"].$list["title"];$list["url"] = "/show/".$dq["etitle"]."_".$nav["url_static"]."/".$list["id"].".html";else: $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["url"] = "/".$nav["url_static"]."/".$list["id"].".html";endif; ?>
        <a href="<?php echo $list['url']; ?>">
            <div>
                <div class="left"><?php echo $list['title']; ?></div>
                <div class="right"><?php echo date("Y-m-d",$list['create_Time']); ?></div>
                <div style="clear: both"></div>
            </div>
            <div><?php echo $list['content']['desc']; ?></div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!--底部版权-->
<div class="foot">
    <div class="left">
        <p>联系电话 : </p>
        <p>地址 : </p>
        <p>服务项目 : <?php $f = 2;$sub = db("nav")->where("pid",$f)->where("show",1)->limit(5)->order("id asc")->select();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; foreach($sub as $k=>$navsub): $dq = db("address")->where("etitle",$address)->find(); if($dq): $navsub["name"]=$dq["title"].$navsub["name"]; $navsub["url"]="/navs/".$dq["etitle"]."_".$navsub["url_static"].".html"; else: $navsub["url"]="/".$navsub["url_static"].".html"; endif; ?><a href="<?php echo $navsub['url']; ?>"><?php echo $navsub['name']; ?> </a> &nbsp;&nbsp;<?php endforeach; ?></p>
        <p>Copyright © 2019 唯爱动物医馆 版权所有</p>
        <p></p>
    </div>
    <img src="" alt="">
    <div style="clear: both"></div>
</div>

<!--底部栏目-->
<div class="f-nav">
    <a href="/">
        <div class="img"><img src="/template/images/f1.png" alt=""></div>
        <div class="tit">首页</div>
    </a>
    <?php $navcon = db("nav")->where("id",6)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?>
    <a href="<?php echo $navcon['url']; ?>">
        <div class="img"><img src="/template/images/f2.png" alt=""></div>
        <div class="tit">服务项目</div>
    </a>
    
    <?php $navcon = db("nav")->where("id",4)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?>
    <a href="<?php echo $navcon['url']; ?>">
        <div class="img"><img src="/template/images/f3.png" style="height: 40px" alt=""></div>
        <div class="tit">康复故事</div>
    </a>
    
    <a href="tel:">
        <div class="img"><img src="/template/images/f4.png" alt=""></div>
        <div class="tit">一键拨号</div>
    </a>
    <div style="clear: both"></div>
</div>

<script type="text/javascript" src="/template/wap/js/index.js"></script>
</body>
</html>
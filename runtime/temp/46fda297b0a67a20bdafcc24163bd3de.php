<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:53:"D:\phpstudy_pro\WWW\hs.cn\/template/pc\view_news.html";i:1581505807;s:47:"D:\phpstudy_pro\WWW\hs.cn\template\pc\base.html";i:1581505768;s:56:"D:\phpstudy_pro\WWW\hs.cn\template\pc\public_header.html";i:1575359874;s:56:"D:\phpstudy_pro\WWW\hs.cn\template\pc\public_footer.html";i:1571753560;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title><?php if((isset($content['title']))): ?><?php echo $content['title']; else: $navcon = db("nav")->where("id",$navid)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?><?php echo $navcon['name']; endif; ?> - <?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_title","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_title","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_title","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_title","site"); ?><?php echo $configarr; endif; ?></title>
    <meta name="keywords" content="<?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_keywords","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_keywords","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_keywords","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_keywords","site"); ?><?php echo $configarr; endif; ?>">
    <meta name="description" content="<?php $fileadd = CONF_PATH.DS."extra".DS."site.php"; \think\Config::load($fileadd, "", "site"); $titlew = input("title"); $etitle = explode("_",$titlew); if(($titlew)): if(count($etitle)==2): $titles = $etitle[0]; $configarr = \think\Config::get("f_seo_description","site"); $address = db("address")->where("etitle",$titles)->find(); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $titles = $title; $address = db("address")->where("etitle",$titles)->find(); if(($address)): $configarr = \think\Config::get("f_seo_description","site"); ?><?php echo str_replace("[address]",$address["title"],$configarr); else: $configarr = \think\Config::get("seo_description","site"); ?><?php echo $configarr; endif; endif; else: $configarr = \think\Config::get("seo_description","site"); ?><?php echo $configarr; endif; ?>">
    <link rel="stylesheet" type="text/css" href="/template/pc/css/swiper.css" />
    <link rel="stylesheet" type="text/css" href="/template/pc/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/template/pc/common/animate.css" />
    <link rel="stylesheet" type="text/css" href="/template/pc/common/common.css" />
    <script src="/template/pc/common/jquery-1.11.1.min.js"></script>
    <script src="/template/pc/js/swiper.js"></script>
    <style>
        .tj_hs_n>a:hover>span{
            color: red;
        }
        .hs_fn{
            height: 100px;
            background: red;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .dqwz>div>.right:hover{
            color: red;
            font-weight: 700;
        }
        .dqwz>div>.left>a:hover{
            color: red;
            font-weight: 700;
        }
        .hs_n_nav>div>a:hover{
            background: red;
            color: #fff;
        }
        .n_product>.left>a>.p_dis>div:nth-child(3):hover{
            background: red;
            border: 1px solid red;
        }
        .hs_list_news>.right>div:nth-child(1)>a:hover{
            color: red;
        }
        .hs_list_news:hover{
            box-shadow: 0 5px 12px rgba(0, 0, 0, .5);
        }
        .hs_n_nav>div>a.suba{
            background: red;
            color: #fff;
        }
    </style>
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
<hr>

<!--当前位置-->
<div class="dqwz">
    <div>
        <div class="left">当前位置 : <a href="/">首页</a> >> <?php if(($topnav==$navid)): $nav = db("nav")->where("id",$topnav)->find(); ?><a href="/<?php echo $nav['url_static']; ?>.html"><?php echo $nav['name']; ?></a><?php else: $nav = db("nav")->where("id",$topnav)->find(); $sub = db("nav")->where("id",$navid)->find(); ?><a href="/<?php echo $nav['url_static']; ?>.html"><?php echo $nav['name']; ?></a> >> <a href="/<?php echo $sub['url_static']; ?>.html"><?php echo $sub['name']; ?></a><?php endif; ?></div>
        <div class="right" onclick="javascript :history.back(-1);">返回</div>
        <div style="clear: both"></div>
    </div>
</div>
<!--内容快-->
<div class="hs_main">
    <div class="left">
        <div class="hs_fn">
            <div></div>
            <div><?php $navcon = db("nav")->where("id",$topnav)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?><?php echo $navcon['name']; ?></div>
        </div>
        <div class="hs_n_nav">
            <?php $f = $topnav;$sub = db("nav")->where("pid",$f)->where("show",1)->limit(100)->order("id asc")->select();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; foreach($sub as $k=>$navsub): $dq = db("address")->where("etitle",$address)->find(); if($dq): $navsub["name"]=$dq["title"].$navsub["name"]; $navsub["url"]="/navs/".$dq["etitle"]."_".$navsub["url_static"].".html"; else: $navsub["url"]="/".$navsub["url_static"].".html"; endif; ?>
            <div>
                <a href="<?php echo $navsub['url']; ?>" class="animated <?php if(($navid==$navsub['id'])): ?>suba<?php endif; ?>"><?php echo $navsub['name']; ?></a>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="cp_tj">
            <div class="hs_tj_t">产品推荐</div>
            <div class="hs_tj_box">
                <div class="swiper-wrapper">
                    <?php $nav = db("nav")->where("id",1)->find();$model = db("models")->where("id",$nav["model"])->find();$table = "new_".$model["bname"];$res = db("nav")->where("id",1)->select();$navids = numbernav($res);$data = db("content")->where("pid","in",$navids)->where("reco","eq",1)->limit(5)->order("create_Time desc")->select();$address = input("title");$etitle = explode("_",$address);if(count($etitle)==2): $address = $etitle[0]; endif; foreach($data as $k=>$list): $dq = db("address")->where("etitle",$address)->find();if($dq): $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["title"]=$dq["title"].$list["title"];$list["url"] = "/show/".$dq["etitle"]."_".$nav["url_static"]."/".$list["id"].".html";else: $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["url"] = "/".$nav["url_static"]."/".$list["id"].".html";endif; ?>
                    <div class="swiper-slide">
                        <a href="">
                            <img src="<?php echo $list['pic']; ?>" alt="">
                            <div><?php echo $list['title']; ?></div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-nexthstj"></div>
                <div class="swiper-button-prev swiper-button-prevhstj"></div>
            </div>
        </div>
        <div class="cp_tj hs_news_tj">
            <div class="hs_tj_t">新闻推荐</div>
            <div class="tj_hs_n">
                <?php $nav = db("nav")->where("id",6)->find();$model = db("models")->where("id",$nav["model"])->find();$table = "new_".$model["bname"];$res = db("nav")->where("id",6)->select();$navids = numbernav($res);$data = db("content")->where("pid","in",$navids)->where("reco","eq",1)->limit(5)->order("create_Time desc")->select();$address = input("title");$etitle = explode("_",$address);if(count($etitle)==2): $address = $etitle[0]; endif; foreach($data as $k=>$list): $dq = db("address")->where("etitle",$address)->find();if($dq): $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["title"]=$dq["title"].$list["title"];$list["url"] = "/show/".$dq["etitle"]."_".$nav["url_static"]."/".$list["id"].".html";else: $list["content"] = db($table)->where("id",$list["content_id"])->find();$list["url"] = "/".$nav["url_static"]."/".$list["id"].".html";endif; ?>
                <a href="<?php echo $list['url']; ?>">
                    <span class="animated"><?php echo $list['title']; ?></span>
                    <span><?php echo date("m-d",$list['create_Time']); ?></span>
                    <div style="clear: both"></div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="right">
        <div class="hs_con_na"><?php $navcon = db("nav")->where("id",$navid)->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?><?php echo $navcon['name']; ?></div>
        
<div class="hs_news_view">
    <h1><?php echo $content['title']; ?></h1>
    <div class="news_info">
        <span>所属栏目 : <?php $navcon = db("nav")->where("id",$content['pid'])->find();$address = input("title");$etitle = explode("_",$address); if(count($etitle)==2): $address = $etitle[0]; endif; $dq = db("address")->where("etitle",$address)->find(); if($dq): $navcon["name"]=$dq["title"].$navcon["name"]; $navcon["url"]="/navs/".$dq["etitle"]."_".$navcon["url_static"].".html"; else: $navcon["url"]="/".$navcon["url_static"].".html"; endif; ?><?php echo $navcon['name']; ?></span>
        <span>发布时间 : <?php echo date("Y-m-d",$content['create_Time']); ?></span>
        <span>作者 : 壹恩建站,重庆网站设计,重庆网站制作,重庆公众号制作,重庆小程序制作,重庆seo排名,重庆网站改版,重庆网站托管</span>
        <span>点击量 : <?php echo $content['click']; ?></span>
        <span class="bdsharebuttonbox">
            <a href="#" class="bds_more" data-cmd="more"></a> <a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a> <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
        </span>
        <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"16"},"share":{},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
    </div>
    <!--详情-->
    <div class="pro_info">
        <div id="hs_contents">
            <?php echo $content['content']['content']; ?>
        </div>
    </div>
</div>
<!--翻页-->
<div class="hs_fy_con">
    <?php if(($content['prev']['title'])): ?>
    <a href="<?php echo $content['prev']['url']; ?>"><span><?php echo $content['prev']['title']; ?></span></a>
    <?php else: ?>
    <a><span>没有了...</span></a>
    <?php endif; if(($content['next']['title'])): ?>
    <a href="<?php echo $content['next']['url']; ?>"><span><?php echo $content['next']['title']; ?></span></a>
    <?php else: ?>
    <a><span>没有了...</span></a>
    <?php endif; ?>
    <div style="clear: both"></div>
</div>

    </div>
    <div style="clear: both"></div>
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


<script src="/template/pc/js/index.js"></script>
<script src="/template/pc/common/common.js"></script>
</body>
</html>

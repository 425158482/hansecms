<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:67:"/Users/zhanghan/www/hansecms/application/admini/view/seo/index.html";i:1570333976;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/head.html";i:1575261364;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/menu.html";i:1584714334;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo config('site.site_name'); ?>-寒舍CMS</title>
<link rel="shortcut icon" href="/static/admin/images/favicon.ico">
<link rel="stylesheet" href="/static/admin/layui/css/layui.css">
<link rel="stylesheet" href="/static/admin/css/style.css">
<script src="/static/admin/layui/layui.js"></script>
<script src="/static/admin/js/jquery-1.10.2.min.js"></script>


</head>
<body>
<div class="top_menu">

    <div class="left">
        <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$me): $mod = ($i % 2 );++$i;?>
        <a href="<?php echo $me['url']; ?>.html" class="<?php if(($me['id']==$curl)): ?>t_curl<?php endif; ?> "><div><i class="layui-icon <?php echo $me['ico']; ?>"></i></div><?php echo $me['title']; ?></a>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <a href="https://www.kancloud.cn/zhhan/hanse/1328649" target="_blank"><div><i class="layui-icon layui-icon-fonts-html"></i></div>文档助手</a>
    </div>
    <div class="right">
        <a href="/" target="_blank" title="首页"><i class="layui-icon layui-icon-release"></i></a>
        <a class="cache" title="清除缓存"><i class="layui-icon layui-icon-delete"></i></a>
        <a id="color1" title="更换主题"><i class="layui-icon layui-icon-theme"></i></a>
        <a class="logoaut" title="退出"><i class="layui-icon layui-icon-radio"></i></a>
    </div>
    <div style="clear: both"></div>
</div>
<style>

    #ueditor_1 img{
        width: 100%;
    }
    .layui-layer-molv .layui-layer-btn a,.layui-layer-molv .layui-layer-title,.layui-laypage .layui-laypage-curr .layui-laypage-em,.top_menu,.left_menu,.layui-btn,.btn_tj>.layui-btn,.layui-form-onswitch,.ad_in_na,::-webkit-scrollbar-thumb,.layui-form-select dl dd.layui-this,.layui-layer-lan .layui-layer-title{
        background-color: <?php echo config("site.color"); ?>;
    }
    .layui-elem-quote{
        border-left: 5px solid <?php echo config("site.color"); ?>;
    }
    .layui-layer-molv .layui-layer-btn a,.layui-form-onswitch{
        border-color: <?php echo config("site.color"); ?>;
    }
    .layui-tab-brief>.layui-tab-title .layui-this{
        color: <?php echo config("site.color"); ?>;
    }
    .layui-tab-brief>.layui-tab-more li.layui-this:after, .layui-tab-brief>.layui-tab-title .layui-this:after{
        border-bottom: 2px solid <?php echo config("site.color"); ?>;
    }
    .layui-btn-primary{
        border: 1px solid <?php echo config("site.color"); ?>;
    }
    .layui-btn{
        color: #fff;
    }
    .layui-colorpicker{
        border: 0;
    }
    .layui-colorpicker-trigger-span{
        border: 1px solid #fff;
    }
    .admin_main>.content_box>.admin_left_nav>.nav.navcur{
        background-color: <?php echo config("site.color"); ?>;
        color:#fff;
    }
</style>
<script>
    layui.use(['jquery','form','element', 'layedit','upload','colorpicker'], function() {
        var form = layui.form
            , layer = layui.layer
            , jquery = layui.jquery
            ,colorpicker = layui.colorpicker;
        <?php if((\think\Session::get('qxbz'))): ?>
        layer.msg('<?php echo \think\Session::get('qxbz'); ?>', {icon: 5,time: 2000});
        <?php endif; ?>
        colorpicker.render({
            elem: '#color1'
            ,color: '<?php echo config("site.color"); ?>'
            ,format: 'rgb'
            ,predefine: true
            ,alpha: true
            ,done: function(color){
                $('#test-all-input').val(color); //向隐藏域赋值
                jquery.ajax({
                    type: "post",
                    url: "<?php echo url('index/theme'); ?>",
                    data:{color:color},
                    success: function (msg) {
                        if(msg==1){
                            layer.msg('设置成功', {icon: 1,time: 2000});
                        }else{
                            layer.msg('设置失败', {icon: 1,time: 2000});
                        }
                    }
                })
                color || this.change(color); //清空时执行 change
            }
            ,change: function(color){
                //给当前页面头部和左侧设置主题色
                $('.top_menu,.left_menu,.layui-btn,.btn_tj>.layui-btn,.layui-form-onswitch,.ad_in_na,::-webkit-scrollbar-thumb').css('background-color', color);
            }
        });
        //询问框
        $(".logoaut").click(function () {
            layer.confirm('确定要退出当前账户吗？', {
                btn: ['确定','关闭'] //按钮
            }, function(){
                jquery.ajax({
                    type: "post",
                    url: "<?php echo url('login/logoaut'); ?>",
                    success: function (msg) {
                        if(msg==1){
                            layer.msg('退出成功', {icon: 1,time: 1000}, function() {
                                location.href="<?php echo url('login/login'); ?>";
                            });
                        }

                    }
                })
            });
        })
        //询问框
        $(".cache").click(function () {
            layer.confirm('确定要清除缓存？', {
                btn: ['确定','关闭'] //按钮
            }, function(){
                jquery.ajax({
                    type: "post",
                    url: "<?php echo url('index/caches'); ?>",
                    success: function (msg) {
                        console.log(msg)
                        if(msg==1){
                            layer.msg('清除成功', {icon: 1,time: 1000});
                        }
                    }
                })
            });
        })

    })
</script>
<!--左边栏目-->
<div class="left_menu">
    <div class="menu">

        <a href="<?php echo url('index/index'); ?>" style="text-align: center">管理控制台</a>

        <div class="touxiang">
            <a href="<?php echo url('index/editadmin'); ?>">
                <div style="background: #fff"><img src="<?php echo \think\Session::get('admini.pic'); ?>" alt=""></div>
                <div><?php echo \think\Session::get('admini.name'); ?></div>
                <div style="clear: both"></div>
            </a>

        </div>
        <?php if(is_array($menusub) || $menusub instanceof \think\Collection || $menusub instanceof \think\Paginator): $i = 0; $__LIST__ = $menusub;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menusubs): $mod = ($i % 2 );++$i;?>
        <a href="<?php echo $menusubs['url']; ?>.html" class=" <?php if(($menusubs['id']==$action)): ?>t_curl<?php endif; ?> ">
            <i class="layui-icon <?php echo $menusubs['ico']; ?>"></i>
            <?php echo $menusubs['title']; ?>
        </a>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div>
<!--中间内容-->
<div class="admin_main">
    <div class="container">
        <blockquote class="layui-elem-quote">SEO设置</blockquote>
        <form class="layui-form menu_form" method="post">
            <fieldset class="layui-elem-field seosite">
                <legend>常规配置</legend>
                <div class="layui-field-box">
                    <div class="layui-form-item">
                        <label class="layui-form-label">常规标题</label>
                        <div class="layui-input-inline">
                            <input type="text" name="seo_title" lay-verify="" value="<?php echo config('site.seo_title'); ?>" autocomplete="off" placeholder="常规标题" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">常规关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="seo_keywords" lay-verify="" value="<?php echo config('site.seo_keywords'); ?>" autocomplete="off" placeholder="常规关键词" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">常规摘要</label>
                        <div class="layui-input-inline">
                            <textarea placeholder="常规摘要" name="seo_description" class="layui-textarea"><?php echo config('site.seo_description'); ?></textarea>
                        </div>
                        <div class="layui-form-mid layui-word-aux"></div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="layui-elem-field seosite">
                <legend>分站配置</legend>
                <div class="layui-field-box">
                    <div class="layui-form-item">
                        <label class="layui-form-label">分站标题</label>
                        <div class="layui-input-inline">
                            <input type="text" name="f_seo_title" lay-verify="" value="<?php echo config('site.f_seo_title'); ?>" autocomplete="off" placeholder="分站标题" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">分站关键词</label>
                        <div class="layui-input-inline">
                            <input type="text" name="f_seo_keywords" lay-verify="" value="<?php echo config('site.f_seo_keywords'); ?>" autocomplete="off" placeholder="分站关键词" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">分站描述</label>
                        <div class="layui-input-inline">
                            <textarea placeholder="分站描述" name="f_seo_description" class="layui-textarea"><?php echo config('site.f_seo_description'); ?></textarea>
                        </div>
                        <div class="layui-form-mid layui-word-aux"></div>
                    </div>
                </div>
            </fieldset>

            <div class="layui-form-item">
                <label class="layui-input-inline"></label>
                <div class="layui-input-block">
                    <button  lay-submit lay-filter="menu" type="submit" class="layui-btn layui-btn-normal layui-btn-sm">立即提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use(['jquery','form','upload', 'layedit'], function() {
        var form = layui.form
            , layer = layui.layer
            , jquery = layui.jquery
            , upload = layui.upload
            , layedit = layui.layedit;
        //自定义验证规则
        form.on('submit(menu)', function(data){
            var data = data.field; //当前容器的全部表单字段，名值对形式：{name: value}
            jquery.ajax({
                type:"post",
                url :"<?php echo url('seo/upfiles'); ?>",
                data:data,
                success:function (msg) {
                    console.log(msg)
                    if(msg==1){
                        layer.msg('更新成功!', {icon: 1});
                    }else{
                        layer.msg('系统繁忙!', {icon: 5});
                    }
                }
            })
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#logoup'
            , url: '<?php echo url("uploads/uploads_img"); ?>'
            , before: function (obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    $('#logo1').attr('src', result); //图片链接（base64）
                });
            }
            , done: function (res) {
                //如果上传失败
                if (res.code == 1) {
                    $("#site_logo").val(res.img_url)
                    layer.msg('上传成功!', {icon: 1});
                }
                if(res.code == 0){
                    layer.msg(res.error, {icon: 5});
                }

            }
            , error: function () {
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function () {
                    uploadInst.upload();
                });
            }
        });
    })
</script>




















</body>
</html>
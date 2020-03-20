<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"/Users/zhanghan/www/hansecms/application/admini/view/banner/index.html";i:1570092210;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/head.html";i:1575261364;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/menu.html";i:1584714334;}*/ ?>
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
        <blockquote class="layui-elem-quote">banner管理</blockquote>
        <div class="btn_tj">
            <a href="<?php echo url('banner/add'); ?>" class="layui-btn layui-btn-sm"><i class="layui-icon"></i>添加图片</a>
        </div>
        <div class="layui-form">
            <table class="layui-table">
                <colgroup>
                    <col width="50">
                    <col width="200">
                    <col width="200">
                    <col>
                    <col width="100">
                    <col width="100">
                    <col width="130">
                </colgroup>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>图片名称</th>
                    <th>图片</th>
                    <th>链接地址</th>
                    <th>所属</th>
                    <th>排序</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$banner): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo $banner['id']; ?></td>
                        <td><?php echo $banner['name']; ?></td>
                        <td>
                            <img src="<?php echo $banner['pic']; ?>" class="bannerpic" data-pic="<?php echo $banner['pic']; ?>" height="30" alt="">

                        </td>
                        <td><?php echo $banner['url']; ?></td>
                        <td>
                            <?php if(($banner['type']==1)): ?>
                            电脑
                            <?php elseif(($banner['type']==2)): ?>
                            手机
                            <?php endif; ?>
                        </td>
                        <td>
                            <input type="text" class="sort" data-id="<?php echo $banner['id']; ?>" value="<?php echo $banner['sort']; ?>">
                        </td>
                        <td>
                            <a href="<?php echo url('banner/edit',['id'=>$banner['id']]); ?>" type="button" class="layui-btn layui-btn-primary layui-btn-sm"><i class="layui-icon"></i></a>
                            <button class="layui-btn layui-btn-primary layui-btn-sm delete" data-id="<?php echo $banner['id']; ?>"><i class="layui-icon"></i></button>
                        </td>
                    </tr>

                <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    layui.use(['jquery','form', 'layedit'], function() {
        var form = layui.form
            , layer = layui.layer
            , jquery = layui.jquery
            , layedit = layui.layedit;
        $(document).on('blur','.sort', function () {
            var id = $(this).attr('data-id');
            var obs = $(this);
            $.ajax({
                type: "POST",
                url: '<?php echo url("banner/editsort"); ?>',
                data:{'id':id,'sort':obs.val()},
                success: function(msg){
                    if(msg){
                        layer.msg('排序已更改', {icon: 1});
                    }else{
                        layer.msg('排序更改失败', {icon: 5});
                    }
                }
            });
        });
        $(document).on('click','.delete', function () {
            var id = $(this).attr('data-id');
            layer.confirm('确定要删除吗？', {
                btn: ['必须的','忍一手'] //按钮
            }, function(){
                $.ajax({
                    type: "POST",
                    url: '<?php echo url("banner/delete"); ?>',
                    data:{'id':id},
                    success: function(msg){
                        if(msg==1){
                            layer.msg('删除成功', {icon: 1,time:1000}, function() {
                                location.href="<?php echo url('banner/index'); ?>";
                            });
                            location.href;
                        }else if(msg==0){
                            layer.msg('系统繁忙', {icon: 5});
                        }else{
                            layer.msg('系统繁忙', {icon: 5});
                        }
                    }
                });
            });
        })
        $(".bannerpic").click(function () {
            var img = $(this).data("pic");
            layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                area: '516px',
                skin: '', //没有背景色
                shadeClose: true,
                content: "<img src='"+ img +"' style='width: 516px;'>"
            });
        })
    })
</script>




















</body>
</html>
<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"D:\phpstudy_pro\WWW\hs.cn/application/admini\view\login\login.html";i:1575288438;s:66:"D:\phpstudy_pro\WWW\hs.cn\application\admini\view\public\head.html";i:1575261362;}*/ ?>
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


    <script src="/static/admin/layui_exts/sliderVerify/sliderVerify.js"></script>
</head>
<body class="login_body" style="background: url('<?php echo config('site.login_bg'); ?>')">

<style>
    .layui-btn,.layui-bg-green{
        background-color: <?php echo config("site.color"); ?>;
    }
</style>

<div class="login_box">
    <form class="layui-form">
        <div class="title">欢迎登陆-<?php echo config('site.site_name'); ?></div>
        <input type="hidden" name="__token__" value="<?php echo \think\Request::instance()->token(); ?>" />
        <div class="layui-form-item">
            <input type="text" name="username" lay-verify="required" autocomplete="off" placeholder="请输入账号" class="layui-input">
        </div>
        <div class="layui-form-item">
            <input type="password" name="password" lay-verify="required"  placeholder="请输入密码" autocomplete="off" class="layui-input">
        </div>
        <?php if(($slide==1)): ?>
        <div class="layui-form-item">
            <div id="slider"></div>
        </div>
        <?php endif; ?>
        <div class="layui-form-item">
            <button type="submit" style="width: 100%" class="layui-btn" lay-submit="" lay-filter="login">立即登录</button>
        </div>
    </form>
    <p style="text-align: center;color: #fff">技术支持 <a href="https://dearests.cn" target="_blank">dearests.cn</a> 2019 1.5v</p>
</div>


<script type="text/javascript" charset="utf-8">
    //一般直接写在一个js文件中
    layui.config({
        base: '/static/admin/layui_exts/sliderVerify/'
    }).use(['sliderVerify', 'jquery', 'form'], function() {
        var sliderVerify = layui.sliderVerify,
            form = layui.form,
            jquery = layui.jquery;
        var slider = sliderVerify.render({
            elem: '#slider'
        })
        <?php if(($slide==1)): ?>
        //监听提交
        form.on('submit(login)', function(data) {
            var ok = slider.isOk()
            if(ok){
                jquery.ajax({
                    type:"post",
                    url :"<?php echo url('login/reglogin'); ?>",
                    data:data.field,
                    success:function (msg) {
                        if(msg==1){
                            layer.msg('登录成功!', {
                                icon: 1, //样式类名
                                time: 1000,
                            }, function() {
                                location.href="<?php echo url('index/index'); ?>";
                            })
                        }else if(msg==0){
                            layer.msg('账号或密码错误!', {icon: 5});
                        }else if(msg==2){
                            layer.msg('令牌验证失败!', {icon: 5});
                        }
                    }
                })
            }else{
                layer.msg("请先通过滑块验证");
            }
            return false
        });
        <?php else: ?>
        //监听提交
        form.on('submit(login)', function(data) {
            jquery.ajax({
                type:"post",
                url :"<?php echo url('login/reglogin'); ?>",
                data:data.field,
                success:function (msg) {
                    if(msg==1){
                        layer.msg('登录成功!', {
                            icon: 1, //样式类名
                            time: 1000,
                        }, function() {
                            location.href="<?php echo url('index/index'); ?>";
                        })
                    }else if(msg==0){
                        layer.msg('账号或密码错误!', {icon: 5});
                    }else if(msg==2){
                        layer.msg('令牌验证失败!', {icon: 5});
                    }
                }
            })
            return false
        });
        <?php endif; ?>


    })
</script>







</body>
</html>
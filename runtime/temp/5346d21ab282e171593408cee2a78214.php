<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"/Users/zhanghan/www/hansecms/application/admini/view/form/mail.html";i:1575704118;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/head.html";i:1575261364;}*/ ?>
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
<style>
    body{min-width: 100%}
    #ueditor_1 img{
        width: 100%;
    }
    .layui-laypage .layui-laypage-curr .layui-laypage-em,.top_menu,.left_menu,.layui-btn,.btn_tj>.layui-btn,.layui-form-onswitch,.ad_in_na,::-webkit-scrollbar-thumb,.layui-form-select dl dd.layui-this,.layui-layer-lan .layui-layer-title{
    background-color: <?php echo config("site.color"); ?>;
    }
    .layui-elem-quote{
    border-left: 5px solid <?php echo config("site.color"); ?>;
    }
    .layui-form-onswitch{
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
</style>
<!--中间内容-->

<form class="layui-form menu_form" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label">是否开启</label>
        <div class="layui-input-inline">
            <input type="checkbox" name="mail_auto" value="1" <?php if(($mail_auto)): ?>checked=""<?php endif; ?> lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">接收邮箱</label>
        <div class="layui-input-inline">
            <input type="text" name="js_mail" value="<?php echo config('site.js_mail'); ?>" lay-verify="mail" autocomplete="off" placeholder="接收邮箱" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">接受邮件的邮箱</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">发送邮箱</label>
        <div class="layui-input-inline">
            <input type="text" name="fs_mail" lay-verify="mail" value="<?php echo config('site.fs_mail'); ?>" autocomplete="off" placeholder="发送邮箱" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">发送方(建站公司邮箱)</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">公司名称</label>
        <div class="layui-input-inline">
            <input type="text" name="jz_name" lay-verify="required" lay-reqtext="公司名称岂能为空？" value="<?php echo config('site.jz_name'); ?>" autocomplete="off" placeholder="公司名称" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">(建站公司名称)</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">授权码</label>
        <div class="layui-input-inline">
            <input type="password" name="code_mail" lay-verify="required" lay-reqtext="授权码岂能为空？" autocomplete="off" value="<?php echo config('site.code_mail'); ?>" placeholder="授权码" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-input-inline"></label>
        <div class="layui-input-block">
            <button  lay-submit lay-filter="menu" type="submit" class="layui-btn layui-btn-normal layui-btn-sm">立即提交</button>
        </div>
    </div>
</form>


<script>
    layui.use(['jquery','form','upload', 'layedit'], function() {
        var form = layui.form
            , layer = layui.layer
            , jquery = layui.jquery
            , upload = layui.upload
            , layedit = layui.layedit;
        //自定义验证规则
        form.verify({
            mail: [
                /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/
                ,'邮箱格式不正确!'
            ]

        });
        //自定义验证规则
        form.on('submit(menu)', function (data) {
            var data = data.field; //当前容器的全部表单字段，名值对形式：{name: value}
            jquery.ajax({
                type: "post",
                url: "<?php echo url('form/upmail'); ?>",
                data: data,
                success: function (msg) {
                    console.log(msg)
                    if (msg == 1) {
                        layer.msg('更新成功!', {icon: 1});
                    } else {
                        layer.msg('系统繁忙!', {icon: 5});
                    }
                }
            })
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });
    })
</script>







</body>
</html>
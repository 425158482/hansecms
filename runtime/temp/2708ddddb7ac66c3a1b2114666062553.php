<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"/Users/zhanghan/www/hansecms/application/admini/view/user/adduser.html";i:1577281946;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/head.html";i:1575261364;}*/ ?>
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


    <style>
        .layui-form-item .layui-input-inline{
            width: 290px;
        }
    </style>
</head>
<body style="min-width: auto">
<form class="layui-form menu_form" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label">管理员类型</label>
        <div class="layui-input-inline">
            <select name="type">
                <option value="1" selected="">超级管理员</option>
                <option value="2">普通管理员</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">登录名</label>
        <div class="layui-input-inline">
            <input type="text" name="username"  value="" lay-verify="field" autocomplete="off" placeholder="请输入登录名" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">登录密码</label>
        <div class="layui-input-inline">
            <input type="password" name="password"  value="" lay-verify="field" autocomplete="off" placeholder="登录密码" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">确认密码</label>
        <div class="layui-input-inline">
            <input type="password" name="password1"  value="" lay-verify="password1" autocomplete="off" placeholder="登录密码" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux"></div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">头像</label>
        <div class="layui-input-inline">
            <input type="text" name="pic" lay-verify="required" id="site_logo" autocomplete="off" value="" placeholder="头像地址" class="layui-input">
        </div>
        <button type="button" class="layui-btn" id="logoup">上传图片</button>
    </div>
    <div class="layui-form-item" id="tx_pic" style="display: none">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <div class="layui-upload-list" style="margin: 0">
                <img class="layui-upload-img" height="50" id="logo1">
                <p id="demoText"></p>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">用户昵称</label>
        <div class="layui-input-inline">
            <input type="text" name="name" value="" lay-verify="required" autocomplete="off" placeholder="请输入昵称" class="layui-input">
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
            field:[
                /^[0-9a-zA-Z]+$/
                ,'必须是字母和数字'
            ]
            ,password1: function(value){
                if(value!=$("input[name='password']").val()){
                    return '管理员密码不一致';
                }
            }
        });
        form.on('submit(menu)', function(data){
            var data = data.field; //当前容器的全部表单字段，名值对形式：{name: value}
            jquery.ajax({
                type:"post",
                url :"<?php echo url('user/saveuser'); ?>",
                data:data,
                success:function (msg) {
                    if(msg==1){
                        layer.msg('添加成功!', {icon: 1});
                        setInterval(function () {
                            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            parent.location.reload();//刷新父页面，注意一定要在关闭当前iframe层之前执行刷新
                            parent.layer.close(index); //再执行关闭
                        },1000)
                    }else if(msg==2){
                        layer.msg('系统繁忙!', {icon: 5});
                    }else{
                        layer.msg(msg);
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
                    $('#tx_pic').show();
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
<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\phpstudy_pro\WWW\hs.cn/application/install\view\install\index.html";i:1575359055;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>寒舍CMS-系统安装</title>
    <link rel="shortcut icon" href="/static/admin/images/favicon.ico">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/style.css">
    <script src="/static/admin/layui/layui.js"></script>
    <script src="/static/admin/js/jquery-1.10.2.min.js"></script>
</head>
<body class="login_body" style="background: url('<?php echo config('site.login_bg'); ?>')">

<div class="install">
    <h3>系统安装</h3>
    <form class="layui-form">
        <div class="layui-form-item">
            <label class="layui-form-label">数据库地址</label>
            <div class="layui-input-inline insta">
                <input type="text" name="loc" lay-verify="required" lay-reqtext="岂能为空？" value="127.0.0.1" placeholder="请输入数据库地址" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">请输入数据库地址</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数据库账号</label>
            <div class="layui-input-inline insta">
                <input type="text" name="user" lay-verify="required" lay-reqtext="岂能为空？" value="root" placeholder="请输入数据库账号" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">请输入数据库账号</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数据库密码</label>
            <div class="layui-input-inline insta">
                <input type="password" name="pass" lay-verify="required" lay-reqtext="岂能为空？" value="" placeholder="请输入数据库密码" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">请输入数据库密码</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数据库名称</label>
            <div class="layui-input-inline insta">
                <input type="text" name="dbname" lay-verify="required" lay-reqtext="岂能为空？" value="" placeholder="请输入数据库名称" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">请输入数据库名称</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数据表前缀</label>
            <div class="layui-input-inline insta">
                <input type="text" name="field" lay-verify="field" lay-reqtext="岂能为空？"  placeholder="请输入数据表前缀" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">请输入数据表前缀</div>
        </div>
        <hr>
        <div class="layui-form-item">
            <label class="layui-form-label">管理员账号</label>
            <div class="layui-input-inline insta">
                <input type="text" name="username" lay-verify="required" lay-reqtext="岂能为空？" placeholder="请输入管理员账号" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">请输入管理员账号</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">管理员密码</label>
            <div class="layui-input-inline insta">
                <input type="password" name="password" lay-verify="password" lay-reqtext="岂能为空？" value="" placeholder="请输入管理员密码" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">请输入管理员密码</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">确认密码</label>
            <div class="layui-input-inline insta">
                <input type="password" name="password1" lay-verify="password1" lay-reqtext="岂能为空？" value="" placeholder="确认管理员密码" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">确认密码</div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>

<script>
    layui.use(['jquery','form','element', 'layedit','upload','laydate'], function() {
        var form = layui.form
            , layer = layui.layer
            , jquery = layui.jquery
            , element = layui.element
            , upload = layui.upload
            , layedit = layui.layedit;
        //自定义验证规则
        form.verify({
            password: [
                /^[\S]{6,18}$/
                ,'密码必须6到18位，且不能出现空格'
            ]
            ,field:[
                /^[a-z]{1,6}_$/
                ,'必须小写字母,以下划线结尾'
            ]
            ,password1: function(value){
                if(value!=$("input[name='password']").val()){
                    return '管理员密码不一致';
                }
            }
        });
        $("input[name='pass']").blur(function(){
            var loc = $("input[name='loc']").val();
            var user = $("input[name='user']").val();
            var pass = $("input[name='pass']").val();
            $.ajax({
                type:"post",
                url :"<?php echo url('install/regdb'); ?>",
                data:{loc:loc,user:user,pass:pass},
                success:function (msg) {
                    layer.msg("连接成功");
                },
                error:function (msg) {
                    layer.msg("数据库连接失败,检查账号密码");
                }
            })
        });
        form.on('submit(demo1)', function(data){
            $.ajax({
                type:"post",
                url :"<?php echo url('install/credb'); ?>",
                data:data.field,
                success:function (msg) {
                    console.log(msg)
                    if(msg==1){
                        layer.msg('创建成功,即将跳转', {
                            time: 1000,
                        }, function() {
                            location.href="/";
                        })
                    }
                    if(msg==3){
                        layer.msg("管理员密码不匹配");
                    }
                },
                error:function (msg) {
                    layer.msg("请求错误,请检查配置,若数据库存在请手动导入");
                }
            })
            return false;
        });

    })

</script>

</body>
</html>
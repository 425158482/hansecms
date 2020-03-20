<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:64:"D:\phpstudy_pro\WWW\hs.cn/application/admini\view\nav\index.html";i:1571639030;s:66:"D:\phpstudy_pro\WWW\hs.cn\application\admini\view\public\head.html";i:1575261362;s:66:"D:\phpstudy_pro\WWW\hs.cn\application\admini\view\public\menu.html";i:1577288697;}*/ ?>
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
        <a href="<?php echo url('index/index'); ?>">管理控制台</a>
    </div>
    <div class="left">
        <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$me): $mod = ($i % 2 );++$i;?>
        <a href="<?php echo $me['url']; ?>.html" class="<?php if(($me['id']==$curl)): ?>t_curl<?php endif; ?> "><i class="layui-icon <?php echo $me['ico']; ?>"></i><?php echo $me['title']; ?></a>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        <a href="https://www.kancloud.cn/zhhan/hanse/1328649" target="_blank"><i class="layui-icon layui-icon-fonts-html"></i>文档助手</a>
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
        <blockquote class="layui-elem-quote">菜单管理</blockquote>
        <div class="btn_tj">

        </div>

        <table class="layui-hide" id="test" lay-filter="test"></table>
        <script type="text/html" id="switchTpl">
            <!-- 这里的 checked 的状态只是演示 -->
            <input type="checkbox" name="show" value="{{d.show}}" data-id="{{d.id}}" lay-skin="switch" lay-text="ON|OFF" lay-filter="show" {{ d.show == 1 ? 'checked' : '' }}>
        </script>
        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container">
                <a href="<?php echo url('nav/addnav'); ?>" class="layui-btn layui-btn-sm"><i class="layui-icon"></i>添加</a>
                <button class="layui-btn layui-btn-sm" lay-event="getCheckData">删除选中行</button>
            </div>
        </script>

        <script type="text/html" id="barDemo">
            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" lay-event="content">内容</button>
            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" lay-event="edit"><i class="layui-icon"></i></button>
            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" lay-event="del"><i class="layui-icon"></i></button>
        </script>
    </div>
</div>

<script>
    layui.use(['table','jquery','form'], function(){
        var table = layui.table
            ,jquery = layui.jquery
            ,form = layui.form;

        table.render({
            elem: '#test'
            ,url:'<?php echo url("nav/getnav"); ?>'
            ,toolbar: '#toolbarDemo' //开启头部工具栏，并为其绑定左侧模板
            ,defaultToolbar: ['filter', 'exports', 'print']
            ,title: '用户数据表'
            ,cols: [[
                {type: 'checkbox', }
                ,{field:'id', title:'ID', width:80,  unresize: true, sort: true}
                ,{field:'name', title:'栏目名称'}
                ,{field:'url_static', title:'静态名称', width:150, edit: 'text'}
                ,{field:'mname', title:'栏目模型', width:120,}
                ,{field:'show', title:'状态', width:100,templet: '#switchTpl', unresize: true}
                ,{field:'sort', title:'排序', width:60, edit: 'text' }
                ,{fixed: 'right', title:'操作', toolbar: '#barDemo', width:190}
            ]]
        });
        //监听单元格编辑
        table.on('edit(test)', function(obj){
            var value = obj.value //得到修改后的值
                ,data = obj.data //得到所在行所有键值
                ,field = obj.field; //得到字段
                jquery.ajax({
                type:"post",
                url :"<?php echo url('nav/table_up'); ?>",
                data:{"id":data.id,"field":field,"value":value},
                success:function (msg) {
                    if (msg == 1) {
                        layer.msg('更新成功!', {icon: 1});
                    }else if(msg == 3){
                        layer.msg('静态名称重复!', {icon: 5});
                    }else{
                        layer.msg('更新失败!', {icon: 5});
                    }
                }
            })
        });
        //监听状态操作
        form.on('switch(show)', function(obj){
            var id = $(this).attr('data-id');
            var field = this.name;
            var value = obj.elem.checked ? "1" :"0";
            jquery.ajax({
                type: "post",
                url: "<?php echo url('nav/table_up'); ?>",
                data: {"id": id, "field": field, "value": value},
                success: function (msg) {
                    if (msg == 1) {
                        layer.msg('更新成功!', {icon: 1});
                    } else {
                        layer.msg('更新失败!', {icon: 5});
                    }
                }
            })
        });
        //头工具栏事件
        table.on('toolbar(test)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            switch(obj.event){
                case 'getCheckData':
                    var data = checkStatus.data;
                    layer.confirm('真的删除这'+ data.length +'行数据吗？', function () {
                        jquery.ajax({
                            type: "post",
                            url: "<?php echo url('nav/deleteall'); ?>",
                            data: {data: JSON.stringify(data)},
                            success: function (msg) {
                                if (msg == 1) {
                                    location.reload();
                                } else {
                                    layer.msg('系统繁忙!', {icon: 5});
                                }
                            }
                        })
                    })
                    break;
            };
        });

        //监听行工具事件
        table.on('tool(test)', function(obj){
            var data = obj.data;
            //console.log(obj)
            if(obj.event === 'del'){
                layer.confirm('真的删除行么', function(index){
                    jquery.ajax({
                        type: "post",
                        url: "<?php echo url('nav/delete'); ?>",
                        data: {"id": data.id},
                        success: function (msg) {
                            if (msg == 1) {
                                obj.del();
                                layer.close(index);
                            }else if(msg==2){
                                layer.msg('请先删除子栏目!', {icon: 5});
                            }else{
                                layer.msg('系统繁忙!', {icon: 5});
                            }
                        }
                    })

                });
            } else if(obj.event === 'edit'){
                console.log(data)
                location.href="/admini/nav/edit/id/"+data.id+".html";
            } else if(obj.event === 'content'){
                if(data.model==4){
                    location.href="/admini/nav/edit/id/"+data.id+".html";
                }else{
                    location.href="/admini/content/content/id/"+data.id+".html";
                }

            }
        });
    });
</script>




















</body>
</html>
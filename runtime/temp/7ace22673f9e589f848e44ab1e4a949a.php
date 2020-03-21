<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:73:"/Users/zhanghan/www/hansecms/application/admini/view/content/content.html";i:1575466690;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/head.html";i:1575261364;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/menu.html";i:1584762368;}*/ ?>
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
<!--头部栏目-->
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
        <?php if((isset($notice))): ?>
        layer.open({
            type: 1
            ,title: false //不显示标题栏
            ,closeBtn: false
            ,area: '300px;'
            ,shade: 0.8
            ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
            ,btn: ['前往官网', '关闭']
            ,btnAlign: 'c'
            ,moveType: 1 //拖拽模式，0或者1
            ,content: '<h2 style="text-align: center;background: red;color: #fff;padding: 5px 0">官方公告</h2><div style="padding: 10px 20px"><?php echo $notice; ?></div> '
            ,success: function(layero){
                var btn = layero.find('.layui-layer-btn');
                btn.find('.layui-layer-btn0').attr({
                    href: 'http://www.hs-cms.cn/'
                    ,target: '_blank'
                });
            }
        });
        <?php endif; if((\think\Session::get('qxbz'))): ?>
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
    <div class="content_box">
        <div class="admin_left_nav">
            <?php if(is_array($indexnav) || $indexnav instanceof \think\Collection || $indexnav instanceof \think\Paginator): $i = 0; $__LIST__ = $indexnav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$indexnav): $mod = ($i % 2 );++$i;if(($indexnav['model']==4)): ?>
            <a href="<?php echo url('nav/edit',['id'=>$indexnav['id']]); ?>" class="nav" style="color: red"><?php echo $indexnav['name']; ?></a>
            <?php else: ?>
            <a href="<?php echo url('content/content',['id'=>$indexnav['id']]); ?>" class="nav <?php if(($indexnav['id']==$curnav)): ?>navcur<?php endif; ?>"><?php echo $indexnav['name']; ?></a>
            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div class="admin_content">
            <div class="container">
                <blockquote class="layui-elem-quote" style="margin-bottom: 0"><?php echo $cnav['name']; ?></blockquote>
                <table class="layui-hide" id="test" lay-filter="test"></table>
                <script type="text/html" id="switchTpl">
                    <!-- 这里的 checked 的状态只是演示 -->
                    <input type="checkbox" name="reco" value="{{d.reco}}" data-id="{{d.id}}" lay-skin="switch" lay-text="ON|OFF" lay-filter="reco" {{ d.reco == 1 ? 'checked' : '' }}>
                </script>
                <script type="text/html" id="toolbarDemo" style="position: relative">
                    <div class="layui-btn-container">
                        <a href="<?php echo url('content/addcontent',['id'=>$curnav]); ?>" class="layui-btn layui-btn-sm"><i class="layui-icon"></i>添加</a>
                        <button class="layui-btn layui-btn-sm" lay-event="getCheckData" style="float: right">删除选中行</button>
                        <button class="layui-btn layui-btn-sm" lay-event="yidong">移动选中行</button>
                    </div>
                    <form class="layui-form" style="position: absolute;top: 6px;left: 180px">
                        <div class="layui-form-item" style="margin-bottom: 0">
                            <div class="layui-input-inline">
                                <select name="nav" id="nav">
                                    <option value="0" selected="">选择移动栏目</option>
                                    <?php if(is_array($yidong) || $yidong instanceof \think\Collection || $yidong instanceof \think\Paginator): $i = 0; $__LIST__ = $yidong;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$yidong): $mod = ($i % 2 );++$i;if(($yidong['model']!=$cnav['model'])): ?>
                                    <option value="<?php echo $yidong['id']; ?>" disabled=""><?php echo $yidong['name']; ?></option>
                                    <?php else: ?>
                                    <option value="<?php echo $yidong['id']; ?>"><?php echo $yidong['name']; ?></option>
                                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </script>

                <script type="text/html" id="barDemo">
                    <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" lay-event="edit"><i class="layui-icon"></i></button>
                    <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" lay-event="del"><i class="layui-icon"></i></button>
                </script>
            </div>
        </div>
    </div>
</div>











<script>
    layui.use(['table','jquery','form'], function(){
        var table = layui.table
            ,jquery = layui.jquery
            ,form = layui.form;
        table.render({
            elem: '#test'
            ,url:'<?php echo url("content/getcontent",["id"=>$curnav]); ?>'
            ,toolbar: '#toolbarDemo' //开启头部工具栏，并为其绑定左侧模板
            ,defaultToolbar: ['filter', 'exports', 'print']
            ,title: '用户数据表'
            ,cols: [[
                {type: 'checkbox', }
                ,{field:'id', title:'ID', width:80,  unresize: true, sort: true}
                ,{field:'title', title:'标题'}
                ,{field:'navname', title:'所属栏目', width:120,}
                ,{field:'reco', title:'推荐', width:100,templet: '#switchTpl', unresize: true}
                ,{field:'sort', title:'排序', width:60, edit: 'text' }
                ,{fixed: 'right', title:'操作', toolbar: '#barDemo', width:130}
            ]]
            ,limit:12
            ,limits:[
                15,20,25,30,35
            ]

            ,page: true
        });
        //监听单元格编辑
        table.on('edit(test)', function(obj){
            var value = obj.value //得到修改后的值
                ,data = obj.data //得到所在行所有键值
                ,field = obj.field; //得到字段
            jquery.ajax({
                type:"post",
                url :"<?php echo url('content/table_up'); ?>",
                data:{"id":data.id,"field":field,"value":value},
                success:function (msg) {
                    if(msg==1) {
                        layer.msg('更新成功!', {icon: 1});
                    }else{
                        layer.msg('更新失败!', {icon: 5});
                    }
                }
            })
        });
        //监听状态操作
        form.on('switch(reco)', function(obj){
            var id = $(this).attr('data-id');
            var field = this.name;
            var value = obj.elem.checked ? "1" :"0";
            jquery.ajax({
                type: "post",
                url: "<?php echo url('content/table_up'); ?>",
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
                            url: "<?php echo url('content/deleteall'); ?>",
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
                case 'yidong':
                    var data = checkStatus.data;
                    var nav = $("#nav").val();
                    if(nav==0 || nav==""){
                        layer.msg('请先选择目标栏目!', {icon: 5});
                    }else{

                        jquery.ajax({
                            type: "post",
                            url: "<?php echo url('content/getn'); ?>",
                            data: {id:nav},
                            success: function (msg) {
                                if(msg==0){
                                   return layer.msg('选择栏目不存在!', {icon: 5});
                                }
                                layer.confirm("确定将所选数据移动到<<<span style='color:red'>"+msg+"</span>>>", function () {
                                    jquery.ajax({
                                        type: "post",
                                        url: "<?php echo url('content/moves'); ?>",
                                        data: {data: JSON.stringify(data),navid:nav},
                                        success: function (msg) {
                                            console.log(msg)
                                            if (msg == 1) {
                                                layer.msg('所选数据移动成功!', {
                                                    icon: 1, //样式类名
                                                    time: 1500,
                                                }, function() {
                                                    location.reload();
                                                })
                                            } else {
                                                layer.msg('系统繁忙!', {icon: 5});
                                            }
                                        }
                                    })
                                })
                            }
                        })

                    }
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
                        url: "<?php echo url('content/delete'); ?>",
                        data: {"id": data.id},
                        success: function (msg) {
                            console.log(msg)
                            if (msg == 1) {
                                obj.del();
                                layer.close(index);
                            }else{
                                layer.msg('系统繁忙!', {icon: 5});
                            }
                        }
                    })

                });
            } else if(obj.event === 'edit'){
                location.href="/admini/content/edit/id/"+data.id+".html";
            }
        });
    });
</script>





</body>
</html>
<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"/Users/zhanghan/www/hansecms/application/admini/view/content/addcontent.html";i:1577247452;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/head.html";i:1575261364;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/menu.html";i:1584762368;}*/ ?>
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


    <script type="text/javascript" charset="utf-8" src="/static/admin/UEditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/static/admin/UEditor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="/static/admin/UEditor/lang/zh-cn/zh-cn.js"></script>
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
                <blockquote class="layui-elem-quote">添加内容</blockquote>
                <form class="layui-form menu_form" method="post">
                    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
                        <ul class="layui-tab-title">
                            <li class="layui-this">常规配置</li>
                            <li>SEO配置</li>
                            <li>其他配置</li>
                            <button lay-submit lay-filter="menu" type="submit" class="layui-btn layui-btn-normal layui-btn-sm top_submit">立即提交</button>
                        </ul>
                        <div class="layui-tab-content">
                            <input type="hidden" name="__token__" value="<?php echo \think\Request::instance()->token(); ?>" />
                            <!--基本配置-->
                            <div class="layui-tab-item layui-show">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">标题</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="title" id="title" lay-verify="title" placeholder="栏目标题" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">封面图片</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="pic" id="pic" lay-verify="pass" placeholder="上传图片" autocomplete="off" class="layui-input">
                                    </div>
                                    <button type="button" class="layui-btn" id="logoup">上传图片</button>
                                </div>
                                <div class="layui-form-item" id="imgshow" style="display: none">
                                    <label class="layui-form-label"></label>
                                    <div class="layui-input-inline">
                                        <div class="layui-upload-list" style="margin: 0;">
                                            <img class="layui-upload-img" src="" height="50" id="logo1">
                                            <p id="demoText"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">发布时间</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="create_Time" class="layui-input" id="test5" value="<?php echo date('Y-m-d H:i:s',time());?>" placeholder="{}yyyy-MM-dd HH:mm:ss">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">时间选择器</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">排序</label>
                                    <div class="layui-input-inline">
                                        <input type="number" name="sort" value="0" placeholder="栏目排序" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">不支持负数</div>
                                </div>
                                <?php if(is_array($field) || $field instanceof \think\Collection || $field instanceof \think\Paginator): $i = 0; $__LIST__ = $field;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;?>
                                <?php echo $field['type']; endforeach; endif; else: echo "" ;endif; ?>

                            </div>
                            <!--SEO配置-->
                            <div class="layui-tab-item seotit">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">标题</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="seo_title"  placeholder="SEO标签标题" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">title</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">关键词</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="seo_keywords"  placeholder="keywords关键词" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">keywords 词间' , '分割</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">描述</label>
                                    <div class="layui-input-inline">
                                        <textarea placeholder="description描述" name="seo_description" class="layui-textarea"></textarea>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">description</div>
                                </div>
                            </div>

                            <!--其他配置-->
                            <div class="layui-tab-item">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">点击数</label>
                                    <div class="layui-input-inline">
                                        <input type="number" name="click"  placeholder="点击数" autocomplete="off" value="0" class="layui-input">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">默认为0</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">推荐</label>
                                    <div class="layui-input-inline">
                                        <input type="checkbox" name="reco" value="1" lay-skin="switch" lay-text="ON|OFF">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    layui.use(['jquery','form','element', 'layedit','upload','laydate'], function() {
        var form = layui.form
            , layer = layui.layer
            , jquery = layui.jquery
            , element = layui.element
            , upload = layui.upload
            , layedit = layui.layedit
            , laydate = layui.laydate;
        laydate.render({
            elem: '#test5'
            ,type: 'datetime'
        });
        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 1) {
                    return '标题总得写点什么吧';
                }
            },
        });
        form.on('submit(menu)', function (data) {
            var data = data.field; //当前容器的全部表单字段，名值对形式：{name: value}
            jquery.ajax({
                type: "post",
                url: "<?php echo url('content/save',['id'=>$curnav]); ?>",
                data: data,
                success: function (msg) {
                    if (msg.success) {
                        layer.alert('保存成功,成功推送', {
                            skin: 'layui-layer-lan' //样式类名
                            , closeBtn: 0
                        }, function () {
                            location.href = "<?php echo url('content/content',['id'=>$curnav]); ?>";
                        })
                    } else if(msg == 1){
                        layer.alert('保存成功,不推送', {
                            skin: 'layui-layer-lan' //样式类名
                            , closeBtn: 0
                        }, function () {
                            location.href = "<?php echo url('content/content',['id'=>$curnav]); ?>";
                        })
                    } else if (msg == 2) {
                        layer.msg('验证器不通过!', {icon: 5});
                    } else if (msg == 0) {
                        layer.msg('数据保存失败!', {icon: 5});
                    } else {
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
                //如果上传成功
                if (res.code == 1) {
                    $("#imgshow").show();
                    $("#pic").val(res.img_url);
                    layer.msg('上传成功!', {icon: 1});
                }
                if (res.code == 0) {
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

        //多图片上传
        upload.render({
            elem: '#test2',
            url: '<?php echo url("uploads/uploads_img"); ?>'
            ,multiple: true
            ,before: function(obj){
                layer.msg('图片上传中...', {
                    icon: 16,
                    shade: 0.01,
                    time: 0
                })

            }
            ,done: function(res){
                //上传完毕
                layer.close(layer.msg());//关闭上传提示窗口
                var val = $("#piclist").val()
                $("#piclist").val(val + res.img_url +"|||");
                $('#demo2').append('<div class="images_list_box"><i class="layui-icon layui-icon-left img_left"></i><i class="layui-icon layui-icon-delete img_del"></i><img src="'+ res.img_url +'"  class="layui-upload-img"></div>')

                $(".img_del").click(function () {
                    var box=$(this).parent();  //获取按钮的父元素
                    var src = box.children(".layui-upload-img").attr("src");
                    var val = $("#piclist").val()
                    $("#piclist").val(val.replace(src+"|||",""));
                    $(this).parent().remove();
                })
                $('.img_left').click(function(){
                    var box=$(this).parent();  //获取按钮的父元素
                    var boxp=box.prev();
                    var val = $("#piclist").val();
                    var psrc = boxp.children(".layui-upload-img").attr("src");
                    var tsrc = box.children(".layui-upload-img").attr("src");
                    var yimgsrc = psrc+"|||"+tsrc+"|||";
                    var imgsrc = tsrc+"|||"+psrc+"|||";
                    $("#piclist").val(val.replace(yimgsrc,imgsrc));
                    box.insertBefore(boxp)
                });
            }
        });
        //指定允许上传的文件类型
        upload.render({
            elem: '#test3'
            ,url: '<?php echo url("uploads/uploads_fie"); ?>'
            ,accept: 'file' //普通文件
            ,done: function(res){
                //如果上传成功
                if (res.code == 1) {
                    $("#fie").val(res.img_url);
                    layer.msg('上传成功!', {icon: 1});
                }
                if (res.code == 0) {
                    layer.msg(res.error, {icon: 5});
                }
            }
        });

    })



</script>





















</body>
</html>
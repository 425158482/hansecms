<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"/Users/zhanghan/www/hansecms/application/admini/view/nav/addnav.html";i:1575262220;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/head.html";i:1575261364;s:69:"/Users/zhanghan/www/hansecms/application/admini/view/public/menu.html";i:1584714334;}*/ ?>
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
        <blockquote class="layui-elem-quote">添加菜单</blockquote>
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
                            <label class="layui-form-label">所属栏目</label>
                            <div class="layui-input-inline">
                                <select name="pid" lay-filter="aihao">
                                    <option value="0" selected="">顶级栏目</option>
                                    <?php if(is_array($nav) || $nav instanceof \think\Collection || $nav instanceof \think\Paginator): $i = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $nav['id']; ?>"><?php echo $nav['name']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">栏目名称</label>
                            <div class="layui-input-inline">
                                <input type="text" name="name" id="name" lay-verify="name" placeholder="栏目标题" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">辅助标题</label>
                            <div class="layui-input-inline">
                                <input type="text" name="cname" placeholder="辅助标题" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">辅助作用</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">栏目排序</label>
                            <div class="layui-input-inline">
                                <input type="number" name="sort" value="0" placeholder="栏目排序" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">不支持负数</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">栏目图片</label>
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
                        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                            <legend>选择模板</legend>
                        </fieldset>
                        <div class="layui-form-item">
                            <label class="layui-form-label">栏目类型</label>
                            <div class="layui-input-inline">
                                <select name="model" lay-filter="aihao" lay-verify="model">
                                    <option value=""></option>
                                    <?php if(is_array($models) || $models instanceof \think\Collection || $models instanceof \think\Paginator): $i = 0; $__LIST__ = $models;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$models): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $models['id']; ?>"><?php echo $models['name']; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">选择列表页</label>
                            <div class="layui-input-inline">
                                <select name="list" lay-filter="aihao">
                                    <option value="0" selected="">列表页模板</option>
                                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $list; ?>"><?php echo $list; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">选择详情页</label>
                            <div class="layui-input-inline">
                                <select name="view" lay-filter="aihao"  style="z-index: 9999999999999">
                                    <option value="0" selected="">详情页模板</option>
                                    <?php if(is_array($view) || $view instanceof \think\Collection || $view instanceof \think\Paginator): $i = 0; $__LIST__ = $view;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$view): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $view; ?>"><?php echo $view; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>
                        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                            <legend>详情内容</legend>
                        </fieldset>
                        <div class="layui-form-item">
                            <label class="layui-form-label">栏目简介</label>
                            <div class="layui-input-inline">
                                <?php echo $desc; ?>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">栏目内容</label>
                            <div class="layui-input-inline">
                                <?php echo $content; ?>
                            </div>
                        </div>
                    </div>
                    <!--SEO配置-->
                    <div class="layui-tab-item seotit">
                        <div class="layui-form-item">
                            <label class="layui-form-label">标题</label>
                            <div class="layui-input-inline">
                                <input type="text" name="title"  placeholder="SEO标签标题" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">title</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">关键词</label>
                            <div class="layui-input-inline">
                                <input type="text" name="keywords"  placeholder="keywords关键词" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux">keywords 词间' , '分割</div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">描述</label>
                            <div class="layui-input-inline">
                                <textarea placeholder="description描述" name="description" class="layui-textarea"></textarea>
                            </div>
                            <div class="layui-form-mid layui-word-aux">description</div>
                        </div>
                    </div>
                    <!--其他配置-->
                    <div class="layui-tab-item">
                        <div class="layui-form-item">
                            <label class="layui-form-label">外部链接</label>
                            <div class="layui-input-inline">
                                <input type="text" name="curl"  placeholder="跳转外部链接" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">静态名称</label>
                            <div class="layui-input-inline">
                                <input type="text" name="url_static" id="url_static" lay-verify="url_static"  placeholder="自动生成" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">新窗口</label>
                            <div class="layui-input-inline">
                                <input type="checkbox" name="target" value="1" lay-skin="switch" lay-text="ON|OFF">
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">栏目状态</label>
                            <div class="layui-input-inline">
                                <input type="radio" name="show" value="0" title="隐藏">
                                <input type="radio" name="show" value="1" title="显示" checked="">
                            </div>
                            <div class="layui-form-mid layui-word-aux"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_submit">
                <button  lay-submit lay-filter="menu" type="submit" class="layui-btn layui-btn-normal layui-btn-sm">立即提交</button>
            </div>
        </form>
    </div>

</div>
<script>
    //房子转拼音
    layui.config({
        base: '/static/admin/pingy/' //配置 layui 第三方扩展组件存放的基础目录
    }).extend({
        strpy: "strpy",
    }).use(["strpy"], function () {
        $("#name").on("input",function(e){
            //获取input输入的值
            var pingyin= layui.strpy(e.delegateTarget.value,"1");
            $("#url_static").val(pingyin);
        });
    });
    layui.use(['jquery','form','element', 'layedit','upload'], function() {
        var form = layui.form
            , layer = layui.layer
            , jquery = layui.jquery
            , element = layui.element
            , upload = layui.upload
            , layedit = layui.layedit;
        //自定义验证规则
        form.verify({
            name: function(value){
                if(value.length < 1){
                    return '标题总得写点什么吧';
                }
            },
            model: function(value){
                if(value.length < 1){
                    return '栏目类型是需要选择的';
                }
            },
            url_static: function(value){
                if(value.length < 1){
                    return '静态名称不应该没有';
                }
            },
        });
        form.on('submit(menu)', function(data){
            var data = data.field; //当前容器的全部表单字段，名值对形式：{name: value}
            jquery.ajax({
                type:"post",
                url :"<?php echo url('nav/save'); ?>",
                data:data,
                success:function (msg) {
                    if(msg==1){
                        layer.alert('栏目保存成功!', {
                            skin: 'layui-layer-lan' //样式类名
                            ,closeBtn: 0
                        }, function() {
                            location.href="<?php echo url('nav/addnav'); ?>";
                        })
                    }else if(msg==2){
                        layer.msg('验证器不通过!', {icon: 5});
                    }else if(msg==0){
                        layer.msg('数据保存失败!', {icon: 5});
                    }else if(msg==3){
                        layer.msg('静态名称重复!', {icon: 5});
                    } else{
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
                    $("#imgshow").show();
                    $("#pic").val(res.img_url);
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
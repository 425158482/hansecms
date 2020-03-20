<?php
/**
 * Created by PhpStorm.
 * User: 张寒
 * Date: 2019/9/21 0021
 * Time: 下午 17:07
 * QQ: 425158482
 */
namespace app\admini\controller;

use think\Controller;
use think\Db;
use think\Config;
use app\admini\controller\Witty;
use think\Request;

class Content extends Base
{

    /**
     * 添加内容入口
     * $id 所有id都是栏目id
     **/
    public function index()
    {
        $nav = Db::name("nav")->order("id","asc")->select();
        $inav = Db::name("nav")->where("pid",0)->where("show",1)->order("id","asc")->select();
        $index_nav = getChild($nav);
        $this->assign([
            "indexnav" => $index_nav,
            "inav"=>$inav,
        ]);
        return $this->fetch();
    }

    /**
     * 对应栏目显示内容
     **/
    public function content($id)
    {
        $nav = Db::name("nav")->order("sort","asc")->select();
        $cnav = Db::name("nav")->where("id",$id)->find();
        $index_nav = getChild($nav);
        $this->assign([
            "curnav" => $id,
            "cnav" => $cnav,
            "indexnav" => $index_nav,
            "yidong" => $index_nav,
        ]);
        return $this->fetch();
    }

    /**
     * 内容数据表格接口
     **/
    public function getcontent($id)
    {
        $res = Db::name("nav")->where("id",$id)->select();
        $navid = $this->numbernav($res);//所有子栏目1,2,3.....

        //获取每页显示的条数
        $limit= Request::instance()->param('limit');
        //获取当前页数
        $page= Request::instance()->param('page');
        //计算出从那条开始查询
        $tol=($page-1)*$limit;

        $data = Db::name("content")
            ->alias('a')
            ->join("nav","nav.id=a.pid")
            ->field("a.*,nav.name as navname")
            ->where("a.pid","in","{$navid}")
            ->order("a.create_Time","desc")
            ->limit($tol,$limit)
            ->select();
        $count = Db::name("content")
            ->alias('a')
            ->join("nav","nav.id=a.pid")
            ->field("a.*,nav.name as navname")
            ->where("a.pid","in","{$navid}")
            ->order("a.create_Time","desc")
            ->count();

        $arr = [
            "code"=>0, "count"=>$count, "data"=>$data
        ];
        $data = json_encode($arr,true);
        echo $data;
    }


    /**
     * 添加内容显示页
     **/
    public function addcontent($id)
    {
        $nav = Db::name("nav")->order("sort","asc")->select();//所有栏目
        $cnav = Db::name("nav")->where("id",$id)->find();//当前栏目配置详细
        $models = Db::name("models")->where("id",$cnav["model"])->find();//查询栏目所属模型
        $field = Db::name("field")->where("mid",$models["id"])->order("sort","asc")->select();//查询模型配置字段
        $field = $this->inputType($field);//拼接html
        $index_nav = getChild($nav);
        $this->assign([
            "curnav" => $id,//当前栏目id
            "field" => $field,//模型配置字段
            "indexnav" => $index_nav,//所有栏目
        ]);
        return $this->fetch();
    }

    /**
     * 执行保存内容
     **/
    public function save($id)
    {
        $cnav = Db::name("nav")->where("id",$id)->find();//当前栏目配置详细
        $models = Db::name("models")->where("id",$cnav["model"])->find();//查询栏目所属模型
        $table = "new_".$models["bname"];
        $token = request()->session()['__token__'];
        $data = $_POST;
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["file"]);
            $data = Witty::witty($data);
            $res = Db::name($table)->strict(false)->insertGetId($data);
            $data["pid"] = $id;
            $data["create_Time"] = strtotime(date($data["create_Time"]));
            $data["content_id"] = $res;
            if($res){
                $msg = Db::name("content")->strict(false)->insertGetId($data);
                //百度推送
                if(config("site.zdts") && config("site.baidu_ts") && $cnav["show"] && $msg){
                    $links = [];
                    $links[0] = config('site.site_url')."/".$cnav['url_static']."/".$msg.".html";
                    $api = "http://data.zz.baidu.com/urls?site=".config('site.site_url')."&token=".config('site.baidu_ts');
                    $ch = curl_init();
                    $options =  array(
                        CURLOPT_URL => $api,
                        CURLOPT_POST => true,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POSTFIELDS => implode("\n", $links),
                        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
                    );
                    curl_setopt_array($ch, $options);
                    $result = curl_exec($ch);
                    return json_decode($result,1);//返回推送结果
                }else if($msg){
                    return 1;//保存成功
                }else{
                    return 0;//添加失败
                }
            }else{
                return 0;//添加失败
            }
        }else{
            return 2;//令牌验证失败
        }
    }

    /**
     * 编辑指定内容
     **/
    public function edit($id)
    {
        $content = Db::name("content")->where("id",$id)->find();//公共表内容
        $nav = Db::name("nav")->order("sort","asc")->select();//所有栏目
        $cnav = Db::name("nav")->where("id",$content["pid"])->find();//当前栏目配置详细
        $models = Db::name("models")->where("id",$cnav["model"])->find();//查询栏目所属模型
        $field = Db::name("field")->where("mid",$models["id"])->order("sort","asc")->select();//查询模型配置字段
        $table = "new_".$models["bname"];
        $models = Db::name($table)->where("id",$content["content_id"])->find();
        $field = $this->inputType($field,$models);//拼接html
        $index_nav = getChild($nav);
        $this->assign([
            "curnav" => $content["pid"],//当前栏目id
            "field" => $field,//模型配置字段
            "indexnav" => $index_nav,//所有栏目
            "content" => $content,
        ]);
        return $this->fetch();
    }

    /**
     * 更新指定内容
     * $id = 内容id
     **/
    public function update($id)
    {
        $content = Db::name("content")->where("id",$id)->find();//查询对应数据
        $cnav = Db::name("nav")->where("id",$content["pid"])->find();//当前栏目配置详细
        $models = Db::name("models")->where("id",$cnav["model"])->find();//查询栏目所属模型
        $table = "new_".$models["bname"];
        $token = request()->session()['__token__'];
        $data = $_POST;
        $data["create_Time"] = strtotime(date($data["create_Time"]));
        if($token==$data["__token__"]){
            unset($data["__token__"]);
            unset($data["file"]);
            $data = Witty::witty($data);
            Db::name($table)->strict(false)->where("id",$content["content_id"])->update($data);
            Db::name("content")->strict(false)->where("id",$id)->update($data);
            return 1;//更新成功
        }else{
            return 2;//令牌验证失败
        }
    }

    /**
     * 表格编辑
     **/
    public function table_up()
    {
        $data = input("post.");
        $field = $data["field"];
        $value = $data["value"];
        $msg = Db::name("content")->where("id",$data["id"])->update([$field=>$value]);
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 删除指定内容
     **/
    public function delete()
    {
        $data = input("post.");
        $res = Db::name("content")
            ->alias('a')
            ->join("nav","nav.id=a.pid")
            ->join("models","models.id=nav.model")
            ->field("a.*,models.bname as tables")
            ->where("a.id",$data["id"])
            ->find();//获取内容基本信息,模型,内容id
        $table ="new_".$res["tables"];
        $field = Db::name($table)->where("id",$res["content_id"])->delete();
        if($field){
            $msg = Db::name("content")->where("id",$data["id"])->delete();
            if($msg){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    /**
     * 删除所选数据
     **/
    public function deleteall()
    {
        $json = $_POST;
        $data = json_decode($json["data"]);
        $id = "";
        foreach ($data as $k=>$v){
            $id .= $v->id.",";
        }
        $msg = Db::name("content")->where("id","in",$id)->delete();
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }



    /**
     * 添加时字段类型分类html
     **/
    function inputType($field,$data=false)
    {
        if($data){
            foreach ($field as $k=>$v){
                switch ($v["type"]) {
                    case "1":
                        $field[$k]["type"] = '
                                <div class="layui-form-item">
                                    <label class="layui-form-label">'. $v["name"] .'</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="'.$v["field"].'" value="'.$data[$v["field"]].'" placeholder="'. $v["name"] .'" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>';
                        break;
                    case "2":
                        $field[$k]["type"] = "多行文本框";
                        break;
                    case "3"://简约编辑器
                        $field[$k]["type"] = '
                                <div class="layui-form-item">
                                    <label class="layui-form-label">'. $v["name"] .'</label>
                                    <div class="layui-input-inline">
                                        '.uedi_mi($v["field"],$v["field"],$data[$v["field"]]).'
                                    </div>
                                </div>';
                        break;
                    case "4"://丰富编辑器
                        $field[$k]["type"] = '
                                <div class="layui-form-item">
                                    <label class="layui-form-label">'. $v["name"] .'</label>
                                    <div class="layui-input-inline">
                                        '.uedi($v["field"],$v["field"],$data[$v["field"]]).'
                                    </div>
                                </div>';
                        break;
                    case "5":
                        $field[$k]["type"] = "图片上传";
                        break;
                    case "6"://多图上传
                        $pieces = explode("|||", $data[$v['field']]);
                        array_pop($pieces);
                        $field[$k]["type"]  = '<div class="layui-form-item">';
                        $field[$k]["type"] .= '<label class="layui-form-label">'. $v["name"] .'</label>';
                        $field[$k]["type"] .= '<div class="layui-input-inline" style="width: 550px">';
                        $field[$k]["type"] .= '<input type="hidden" name="'.$v["field"].'" value="'.$data[$v["field"]].'" id="piclist" lay-verify="pass" placeholder="'. $v["name"] .'" autocomplete="off" class="layui-input">';
                        $field[$k]["type"] .= '<button type="button" class="layui-btn" id="test2">多图上传</button>';
                        $field[$k]["type"] .= '<div class="layui-upload-list piclist" id="demo2">';
                        foreach ($pieces as $a=>$b) {
                            $field[$k]["type"] .= '<div class="images_list_box"><i class="layui-icon layui-icon-left img_left"></i><i class="layui-icon layui-icon-delete img_del"></i><img src="'.$b.'"  class="layui-upload-img"></div>';
                        }
                        $field[$k]["type"] .= '</div>';
                        $field[$k]["type"] .= '</div>';
                        $field[$k]["type"] .= '</div>';
                        break;
                    case "7":
                        $field[$k]["type"] = '
                                <div class="layui-form-item">
                                    <label class="layui-form-label">'. $v["name"] .'</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="'.$v["field"].'" value="'.$data[$v["field"]].'" id="fie" lay-verify="pass" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                    <button type="button" class="layui-btn" id="test3"><i class="layui-icon"></i>上传文件</button>
                                </div>
                        ';
                        break;
                    default:
                        $field[$k]["type"] = '
                    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                            <legend>'. $v["name"] .'</legend>
                        </fieldset>
                    ';
                }
            }
        }else{
            foreach ($field as $k=>$v){
                switch ($v["type"]) {
                    case "1":
                        $field[$k]["type"] = '
                                <div class="layui-form-item">
                                    <label class="layui-form-label">'. $v["name"] .'</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="'.$v["field"].'" placeholder="'. $v["name"] .'" autocomplete="off" class="layui-input">
                                    </div>
                                    <div class="layui-form-mid layui-word-aux"></div>
                                </div>';
                        break;
                    case "2":
                        $field[$k]["type"] = "多行文本框";
                        break;
                    case "3":
                        $field[$k]["type"] = '
                                <div class="layui-form-item">
                                    <label class="layui-form-label">'. $v["name"] .'</label>
                                    <div class="layui-input-inline">
                                        '.uedi_mi($v["field"],$v["field"]).'
                                    </div>
                                </div>';
                        break;
                    case "4":
                        $field[$k]["type"] = '
                                <div class="layui-form-item">
                                    <label class="layui-form-label">'. $v["name"] .'</label>
                                    <div class="layui-input-inline">
                                        '.uedi($v["field"],$v["field"]).'
                                    </div>
                                </div>';
                        break;
                    case "5":
                        $field[$k]["type"] = "图片上传";
                        break;
                    case "6":
                        $field[$k]["type"]  = '<div class="layui-form-item">';
                        $field[$k]["type"] .= '<label class="layui-form-label">'. $v["name"] .'</label>';
                        $field[$k]["type"] .= '<div class="layui-input-inline" style="width: 550px">';
                        $field[$k]["type"] .= '<input type="hidden" name="'.$v["field"].'" id="piclist" lay-verify="pass" placeholder="'. $v["name"] .'" autocomplete="off" class="layui-input">';
                        $field[$k]["type"] .= '<button type="button" class="layui-btn" id="test2">多图上传</button>';
                        $field[$k]["type"] .= '<div class="layui-upload-list piclist" id="demo2"></div>';
                        $field[$k]["type"] .= '</div>';
                        $field[$k]["type"] .= '</div>';
                        break;
                    case "7":
                        $field[$k]["type"] = '
                                <div class="layui-form-item">
                                    <label class="layui-form-label">'. $v["name"] .'</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="'.$v["field"].'" value="" id="fie" lay-verify="pass" placeholder="" autocomplete="off" class="layui-input">
                                    </div>
                                    <button type="button" class="layui-btn" id="test3"><i class="layui-icon"></i>上传文件</button>
                                </div>
                                ';
                        break;
                    default:
                        $field[$k]["type"] = '
                    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
                            <legend>'. $v["name"] .'</legend>
                        </fieldset>
                    ';
                }
            }
        }
        return $field;
    }

    /**
     * 获取当前栏目下的所有子栏目,且模型相同 $navid = 1,2,3....
     **/
    function numbernav($data)
    {
        $navid = "";
        foreach ($data as $k=>$v){
            $res = Db::name("nav")->where("pid",$v["id"])->where("model",$v["model"])->select();
            if($res){
                $navid.=$v["id"].",";
                $navid.=$this->numbernav($res);
            }else{
                $navid.=$v["id"].",";
            }
        }
        return $navid;
    }

    /**
     * 获取指定栏目名称
     **/
    public function getn()
    {
        $id = input("post.");
        $name = Db::name("nav")->where("id",$id["id"])->find();
        if($name){
            return $name["name"];
        }else{
            return 0;
        }
    }

    /**
     * 移动所选数据
     **/
    public function moves()
    {
        $json = $_POST;
        $data = json_decode($json["data"]);
        $id = "";
        foreach ($data as $k=>$v){
            $id .= $v->id.",";
        }
        $msg = Db::name("content")->where("id","in",$id)->update(["pid"=>$json["navid"]]);
        if($msg){
            return 1;
        }else{
            return 0;
        }
    }

}














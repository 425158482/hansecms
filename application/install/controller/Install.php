<?php
namespace app\install\controller;

use think\Controller;
use PDO;
use think\config;

class Install extends Controller
{
    protected function _initialize()
    {
        $file = ROOT_PATH . "/config/database.loc";
        if (file_exists($file)) {
            return $this->redirect(url('/'), 302);
        }
    }


    /**
     * 系统安装界面
     **/
    public function index()
    {
        return $this->fetch();
    }


    /**
     * ajax验证数据库是否存在
     **/
    public function regdb()
    {
        $data = input("post.");
        $servername = $data['loc'];
        $username = $data['user'];
        $password = $data['pass'];
        new PDO("mysql:host=$servername", $username, $password);
        return 1;

    }

    /**
     * 创建数据库
     **/
    public function credb()
    {
        $data = input("post.");
        if($data["password"]!=$data["password1"]||$data["password"]==""){
            return 3;//密码不匹配
        }
        try {
            $conn = new PDO("mysql:host={$data['loc']}", $data["user"], $data["pass"]);
            // 设置 PDO 错误模式为异常
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE {$data['dbname']} DEFAULT CHARSET utf8 COLLATE utf8_general_ci";
            // 使用 exec() ，因为没有结果返回
            $conn->exec($sql);
            $conn->exec("use {$data['dbname']}");
            $file_path = ROOT_PATH."/config/hanse.sql";
            if(file_exists($file_path)) {
                $str = file_get_contents($file_path);//将整个文件内容读入到一个字符串中
                $str = str_replace("cms_",$data["field"],$str);
                $str = str_replace("dearest",$data["username"],$str);
                $str = str_replace("ad53793e1a5cd82270661e7a51dcb5b9",md5(sha1($data["password"].$data["username"])),$str);
                $res = $conn->query($str);
                if($res){
                    $myfile = fopen(ROOT_PATH."/config/database.loc", "w");//写入database配置文件
                    fwrite($myfile, "您的系统安装于".date("Y-m-d H:i:s",time()));
                    fclose($myfile);

                    $luyou = fopen(ROOT_PATH."/config/route.php", "w");//写入路由
                    $txt = '<?php
think\Route::get("/","index/index/index");
think\Route::get(":title","index/common/index");
think\Route::get("/address/:title","index/index/index");

think\Route::get("/navs/:title","index/common/index");
think\Route::get("/show/:title/:id","index/common/show");
think\Route::post("/form/:id","index/form/form");
think\Route::get("/search/","index/search/index");

$route = db("nav")->select();
foreach ($route as $k=>$v){
    think\Route::get("{$v[\'url_static\']}/:id","index/common/show");
}

                    ';
                    fwrite($luyou,$txt);
                    fclose($luyou);
                    $fileadd = CONF_PATH.'database.php';//配置文件地址
                    Config::load($fileadd, '', 'database');//加载配置文件
                    $configarr = Config::get('','database');//读取配置文件所有配置(数组)
                    $configarr["hostname"] = $data['loc'];
                    $configarr["database"] = $data["dbname"];
                    $configarr["username"] = $data["user"];
                    $configarr["password"] = $data["pass"];
                    $configarr["prefix"]   = $data["field"];
                    $res = upConfig($fileadd,$configarr);
                    if($res){
                        echo 1;
                    }else{
                        return 0;
                    }
                }

            }

        }
        catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

}

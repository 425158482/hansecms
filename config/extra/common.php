<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件



/**
 * 写入配置文件
 * $add = 配置文件地址 string
 * $config = 配置文件内容 array
 **/
function upConfig($add,$config){
    //拼接配置字符串
    $str="<?php \nreturn [\n";
    foreach($config as $k => $v){
        if($k=="params"){
            $str.= "\t'".$k."'=>[],\n";
        }else{
            $str.= "\t'".$k."'=>'".$v."',\n";
        }
    }
    $str.="];\n";
    return file_put_contents($add, $str);//执行写入
}

/**
 * 简约编辑器
 * $id = 实例化id string
 * $name = 表单name string
 * $content = 初始化内容
 **/
function uedi_mi($id,$name,$content=""){
    $edit = '
        <script type="text/plain" id="'.$id.'" name="'.$name.'" style="width:645px;height:150px;">
         '.$content.'
        </script>
        <script>
            var ue = UE.getEditor("'.$id.'",{
                //限制编辑器功能
                toolbars: [[
                    "fullscreen", "source", "|", 
                    "bold", "italic", "underline",  "removeformat", "formatmatch", "|", "forecolor", "insertorderedlist", "insertunorderedlist", "selectall",  "|",
                     "lineheight", "|",
                    "paragraph", "fontfamily", "fontsize","indent" ,"|",
                    "indent,justifyleft", "justifycenter", "justifyright", "justifyjustify", "|",
                    "link", "unlink",
                ]]
            });
        </script>
    ';
    return $edit;
}

/**
 * 丰富编辑器
 * $id = 实例化id string
 * $name = 表单name string
 * $content = 初始化内容
 **/
function uedi($id,$name,$content=""){
    $edit = '
        <script type="text/plain" id="'.$id.'" name="'.$name.'" style="width:645px;height:300px;">
           '.$content.'
        </script>
        <script>
            var ue = UE.getEditor("'.$id.'");
        </script>
    ';
    return $edit;
}


/**
 * 用递归获取子类信息
 * $data 所有分类
 * $parent_id 父级id
 * $level 层级
 * $result 分好类的数组
 */
function getChild($data,$parent_id = 0,$level = 0){
    //声明静态数组,避免递归调用时,多次声明导致数组覆盖
    static  $result;
    foreach ($data as $key => $info){
        //第一次遍历,找到父节点为根节点的节点 也就是parent_id=0的节点
        if($info['pid'] == $parent_id){
            if($level>0){
                $info['name'] = str_repeat("&nbsp;&nbsp;&nbsp;",$level)."|--".$info["name"];
            }
            $result[] = $info;
            //把这个节点从数组中移除,减少后续递归消耗
            unset($data[$key]);
            //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
            getChild($data,$info['id'],$level+1);
        }
    }
    return $result;
}
/**
 * 用递归获取子类信息
 * $data 所有分类
 * $parent_id 父级id
 * $level 层级
 * $result 分好类的数组
 */
function admingetChild($data,$parent_id = 0,$level = 0){
    //声明静态数组,避免递归调用时,多次声明导致数组覆盖
    static  $result;
    foreach ($data as $key => $info){
        //第一次遍历,找到父节点为根节点的节点 也就是parent_id=0的节点
        if($info['pid'] == $parent_id){
            if($level>0){
                $info['title'] = str_repeat("&nbsp;&nbsp;&nbsp;",$level)."|--".$info["title"];
            }
            $result[] = $info;
            //把这个节点从数组中移除,减少后续递归消耗
            unset($data[$key]);
            //开始递归,查找父ID为该节点ID的节点,级别则为原级别+1
            admingetChild($data,$info['id'],$level+1);
        }
    }
    return $result;
}
/**
 * getFileFolderList
 *@fileFlag 0 所有文件列表,1只读文件夹,2是只读文件(不包含文件夹)
 */
function getFileFolderList($pathname,$fileFlag = 0, $pattern='*') {
    $fileArray = array();
    $pathname = rtrim($pathname,'/') . '/';
    $list = glob($pathname.$pattern);
    if ($list) {
        foreach ($list as $i => $file) {
            switch ($fileFlag) {
                case 0:
                    $fileArray[] = basename($file);
                    break;
                case 1:
                    if (is_dir($file)) {
                        $fileArray[] = basename($file);
                    }
                    break;

                case 2:
                    if (is_file($file)) {
                        $fileArray[] = basename($file);
                    }
                    break;

                default:
                    break;
            }
        }
    }
    if(empty($fileArray)) $fileArray = NULL;
    return $fileArray;
}

/**
 * 获取当前栏目下的所有子栏目,且模型相同 $navid = 1,2,3....
 **/
function numbernav($data)
{
    $navid = "";
    foreach ($data as $k=>$v){
        $res = db("nav")->where("pid",$v["id"])->where("model",$v["model"])->select();
        if($res){
            $navid.=$v["id"].",";
            $navid.=numbernav($res);
        }else{
            $navid.=$v["id"].",";
        }
    }
    return $navid;
}

/**
 *  获取顶级栏目
 * */
function topnav($id)
{
    $top = db("nav")->where("id",$id)->find();
    if($top["pid"]!=0){
        $top["id"] = topnav($top["pid"]);
    }
    return $top["id"];


}

/**
 * 数组反向排序
 **/
function sort_asc($array)
{
    $num =  count($array)-1;
    $data = [];
    foreach ($array as $k=>$v){
        $data[$k] = $array[$num];
        $num = $num-1;
    }
    return $data;
}

/**
 * 判断是否移动端
 **/
function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}

/**
 * @param $tomail 发送邮件
 * @param $name
 * @param string $subject
 * @param string $body
 * @param null $attachment
 * @return bool
 */
function send_mail($tomail, $name, $subject = '', $body = '', $attachment = null) {
    $mail = new \PHPMailer\PHPMailer\PHPMailer();           //实例化PHPMailer对象
    $mail->CharSet = 'UTF-8';           //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();                    // 设定使用SMTP服务
    $mail->SMTPDebug = 0;               // SMTP调试功能 0=关闭 1 = 错误和消息 2 = 消息
    $mail->SMTPAuth = true;             // 启用 SMTP 验证功能
    $mail->SMTPSecure = 'ssl';          // 使用安全协议
    $mail->Host = "smtp.qq.com"; // SMTP 服务器
    $mail->Port = 465;                  // SMTP服务器的端口号
    $mail->Username = config('site.fs_mail');    // SMTP服务器用户名
    $mail->Password = config('site.code_mail');     // SMTP服务器密码
    $mail->SetFrom(config('site.fs_mail'), config('site.site_url'));
    $replyEmail = '';                   //留空则为发件人EMAIL
    $replyName = '';                    //回复名称（留空则为发件人名称）
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($tomail, $name);
    if (is_array($attachment)) { // 添加附件
        foreach ($attachment as $file) {
            is_file($file) && $mail->AddAttachment($file);
        }
    }
    return $mail->Send() ? true : $mail->ErrorInfo;
}

/**
 * curl get请求
 * $url str
 */
function getCurl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($output);
    return $output;
}


















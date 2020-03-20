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

class Census extends Base
{
    /**
     * 显示栏目列表
     **/
    public function index()
    {
        return $this->fetch();
    }






}
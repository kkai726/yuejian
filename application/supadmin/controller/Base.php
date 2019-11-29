<?php
namespace app\supadmin\controller;
use think\Controller;
class Base extends Controller
{
    public function _initialize(){
        if(!session('supadmin_name')){
            $this->error('请先登录系统！','Login/login');
        }
    }
}

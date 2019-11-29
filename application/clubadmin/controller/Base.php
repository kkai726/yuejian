<?php
namespace app\clubadmin\controller;
use think\Controller;
class Base extends Controller
{
    public function _initialize(){
        if(!session('clubadmin_name')){
            $this->error('请先登录系统！','Login/login');
        }
    }
}

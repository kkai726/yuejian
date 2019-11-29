<?php
namespace app\clubadmin\controller;

use app\clubadmin\controller\Base;

use think\Controller;

class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function logout(){
        session(null);
        $this->success('退出成功！','Login/login');
    }

    public function edit()
    {
        return $this->fetch();
    }


}

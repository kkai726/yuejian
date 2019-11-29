<?php
namespace app\supadmin\controller;

use think\Controller;

use app\supadmin\model\Supadmin;

class Login extends Controller
{
    public function login()
    {
        if(request()->isPost()){
            $supadmin=new Supadmin();
            $data=input('post.');
            $num=$supadmin->login($data);
            if($num==3){
                $this->success('信息正确，正在为您跳转...','Index/index');
            }
            else{
                $this->error('用户名或者密码错误');
            }

        }
        return $this->fetch('login');
    }

}    





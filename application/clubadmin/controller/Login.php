<?php
namespace app\clubadmin\controller;

use think\Controller;

use app\clubadmin\model\Clubadmin;

class Login extends Controller
{
    public function login()
    {
        if(request()->isPost()){
            $clubadmin=new Clubadmin();
            $data=input('post.');
            $num=$clubadmin->login($data);
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





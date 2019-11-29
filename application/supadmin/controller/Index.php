<?php
namespace app\supadmin\controller;
use think\Controller;
use think\Db;
use app\supadmin\controller\Base;
class Index extends Base
{
	

    public function index()
    {
        return $this->fetch('index');
    }


    public function logout(){
        session(null);
        $this->success('退出成功！','Login/login');
    }

    public function edit()
    {
        $id=input('supadmin_id');
        $info=db('supadmin')->find($id);
        $old_pwd=(md5(input('old_password')));
        if(request()->isPost()){
            if($old_pwd == $info['supadmin_password']){
                $data=[
                    'supadmin_id'=>$id,
                ];
                if(input('new_password') == input('again_password')){
                    if(input('new_password')){
                        $data['supadmin_password']=md5(input('new_password'));
                    }else{
                        $data['supadmin_password']=$info['supadmin_password'];
                    }
                    $save=db('supadmin')->update($data);
                    if($save != false){
                        $this->success('修改密码成功！','index');
                    }else{
                        $this->error('修改密码失败！');
                    }
                    return;
                }else{
                    $this->error('两次输入密码不一致！','edit');
                }
             }else{
            $this->error('请输入正确原密码！','edit');
        }
        
    }
        $this->assign('info',$info);
        return $this->fetch();
    }


}

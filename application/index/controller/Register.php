<?php
namespace app\index\controller;
use think\Controller;
class register extends Controller
{
	public function lists($user_name,$user_password,$user_tel){
        // $user_name=(input('user_password'));
        // $pwd=(md5(input('user_password')));
        // $user_tel=((input('user_tel')));
        // $lists=db('user')->field('user_name,user_password,user_tel')->select();
        // return json($lists);

          $data=[
            'user_name'=>input('user_name'),
            'user_password'=>md5(input('user_password')),
            'user_tel'=>input('user_tel'),
        ];
        $res=db('user')->insert($data);
        // dump($res);die;
        if($res){
            $this->success('添加用户成功！');
        }else{
            $this->error('添加用户失败...');
        }
         
    }
  }

<?php
namespace app\supadmin\controller;
use think\Controller;
use app\supadmin\controller\Base;
class User extends Base
{
	

    public function lst()
    {   

        $info=db("user")->alias('u')->join("club c","u.cid=c.club_id")->select();
        $this->assign('info',$info);
        return $this->fetch();
    }
    

    public function modify(){
        $user_id=input('user_id');
        $info=db("user")->where('user_id',$user_id)->find();
        if($info['user_status']==0){
            $data=['user_status'=>1];
        }else{
            $data=['user_status'=>0];
        }
        $res=db('user')->where('user_id',$user_id)->update($data);
        if($res){
            $this->success('修改用户状态成功！','lst');
        }else{
            $this->error('修改用户状态失败...');
        }
    }



}

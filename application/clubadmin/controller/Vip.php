<?php
namespace app\clubadmin\controller;
use think\Db;
use app\clubadmin\controller\Base;
use think\Session;
use think\Controller;

class Vip extends Base
{
    public function vip()
    {
    	$clubadmin_id=Session::get('clubadmin_id');
        $club=Db::name("club")->table('club c,clubadmin ca')->where("c.club_id=ca.club_id and clubadmin_id='$clubadmin_id'")->find();
        $club_id=$club["club_id"];

        $user=Db::name("user u")->join("club b","u.cid=b.club_id")->where("b.club_id",$club_id)->select();

        $this->assign("user",$user);

        return $this->fetch();
    }

    public function lock($user_id)
    {
        $user_id=input('user_id');
        $status=['user_status'=>1];
        $res=db('user')->where('user_id',$user_id)->update($status);
        if($res){
            $this->success('锁定该会员成功！');
        }else{
            $this->error('锁定该会员失败...');
        }
    }

    public function unlock($user_id)
    {
        $user_id=input('user_id');
        $status=['user_status'=>0];
        $res=db('user')->where('user_id',$user_id)->update($status);
        if($res){
            $this->success('解除锁定该会员成功！');
        }else{
            $this->error('解除锁定该会员失败...');
        }
    }
}

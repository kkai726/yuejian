<?php
namespace app\supadmin\controller;
use app\supadmin\controller\Base;
use think\Controller;
use think\Session;
use think\Db;
class Clubadmin extends Base
{
	

    public function lst()
    {
        $info=Db::name("clubadmin")->alias('cl')->join("club c","cl.club_id=c.club_id")
            ->select();
        $this->assign('info',$info);
        return $this->fetch();
    }



    public function add()
    {
        $clubadmin_id=input('clubadmin_id');
        $info=db('clubadmin')->alias('cl')->where('clubadmin_id',$clubadmin_id)->join("club c","cl.club_id=c.club_id")->find();
        $this->assign('info',$info);

        $club=db('club')->select();
        $this->assign('club',$club);
        return $this->fetch();
    }
    public function doadd()
    {
        $clubadmin_id=input('clubadmin_id');
        if(request()->isPost()){
            $file = request()->file('clubadmin_pic');
            if($file) {
                $info = $file->rule('uniqid')
                    ->validate(['size' => 64000000, 'ext' => 'jpg,png,gif'])
                    ->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'sup_admin' . DS . 'images');
                if ($info) {
                    $clubadmin_pic = $info->getFilename();
                    $data = [
                        'clubadmin_name' => input('clubadmin_name'),
                        'clubadmin_password' => md5(input('clubadmin_password'))    ,
                        'clubadmin_pic' => $clubadmin_pic,
                        'clubadmin_time' => input('clubadmin_time'),
                        'clubadmin_email' => input('clubadmin_email'),
                        'club_id' => input("club_id")

                    ];
                    $res = db('clubadmin')->insert($data);
                    if ($res) {
                        $this->success('添加俱乐部管理员信息成功！', 'lst');
                    } else {
                        $this->error('添加俱乐部管理员信息失败...');
                    }
                    return $this->fetch();
                }
            }}}

    public function edit(){
        $clubadmin_id=input('clubadmin_id');
        $info=db('clubadmin')->alias('cl')->where('clubadmin_id',$clubadmin_id)->join("club c","cl.club_id=c.club_id")->find();
        $this->assign('info',$info);

        $club=db('club')->select();
        $this->assign('club',$club);
        return $this->fetch();
    }
    public function doedit()
    {
        $clubadmin_id=input('clubadmin_id');
        if(request()->isPost()){
            $file = request()->file('clubadmin_pic');
            if($file){
                $info = $file->rule('uniqid')
                    ->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])
                    ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'sup_admin' .DS .'images');
                if($info){
                    $clubadmin_pic=$info->getFilename();
                    $data=[
                        'clubadmin_name'=>input('clubadmin_name'),
                        'clubadmin_pic'=>$clubadmin_pic,
                        'clubadmin_time'=>input('clubadmin_time'),
                        'clubadmin_email'=>input('clubadmin_email'),
                        'club_id'=>input("club_id")

                    ];
                    $res=db('clubadmin')->where('clubadmin_id',$clubadmin_id)->update($data);
                    if($res){
                        $this->success('修改俱乐部管理员信息成功！','lst');
                    }else{
                        $this->error('修改俱乐部管理员信息失败...');
                    }
                }else{
                    echo $file->getError();
                }
            }else{
                $data=[
                    'clubadmin_name'=>input('clubadmin_name'),
                    'clubadmin_time'=>input('clubadmin_time'),
                    'clubadmin_email'=>input('clubadmin_email'),
                    'club_id'=>input("club_id")
                ];
                $res=db('clubadmin')->where('clubadmin_id',$clubadmin_id)->update($data);
                if($res){
                    $this->success('修改俱乐部管理员信息成功！','lst');
                }else{
                    $this->error('修改俱乐部管理员信息失败...');
                }
            }
        }
    }
    public function pub(){
        {
            $clubadmin_id=input('clubadmin_id');
            $info=db("clubadmin")->where("clubadmin_id",$clubadmin_id)->find();
            if($info['clubadmin_status']==0){
            $status=['clubadmin_status'=>1];}
            else{
                $status=['clubadmin_status'=>0];
            }
            $res=db('clubadmin')->where('clubadmin_id',$clubadmin_id)->update($status);
            if($res){
                $this->success('修改状态成功！','lst');
            }else{
                $this->error('修改状态失败...');
            }
        }

    }
}

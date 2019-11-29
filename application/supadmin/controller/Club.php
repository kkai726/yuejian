<?php
namespace app\supadmin\controller;
use think\Controller;
use app\supadmin\controller\Base;
use think\Session;
use think\Db;
class Club extends Base
{


    public function lst()
    {
        $info=Db::name("club")->select();
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
    public function doadd()
    {
        $club_id=input('club_id');
        if(request()->isPost()){
            $file = request()->file('club_pic');
            if($file) {
                $info = $file->rule('uniqid')
                    ->validate(['size' => 64000000, 'ext' => 'jpg,png,gif'])
                    ->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'sup_admin' . DS . 'images');
                if ($info) {
                    $club_pic = $info->getFilename();
                    $data = [
                        'club_name' => input('club_name'),
                        'club_pic' => $club_pic,
                        'club_desc' => input('club_desc'),
                        'club_adress' => input('club_adress'),
                        'club_otime' => input('club_otime'),
                        'club_etime' => input('club_etime'),
                        'club_tel' => input('club_tel'),


                    ];
                    $res = db('club')->insert($data);
                    if ($res) {
                        $this->success('添加俱乐部信息成功！', 'lst');
                    } else {
                        $this->error('添加俱乐部信息失败...');
                    }
                    return $this->fetch();
                }
            }}}

    public function edit(){
        $club_id=input('club_id');
        $info=Db::name("club")->where("club_id",$club_id)->find();
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function doedit()
    {
        $club_id=input('club_id');
        if(request()->isPost()){
            $file = request()->file('club_pic');
            if($file){
                $info = $file->rule('uniqid')
                    ->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])
                    ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'sup_admin' .DS .'images');
                if($info){
                    $club_pic=$info->getFilename();
                    $data=[
                        'club_name' => input('club_name'),
                        'club_pic' => $club_pic,
                        'club_desc' => input('club_desc'),
                        'club_adress' => input('club_adress'),
                        'club_otime' => input('club_otime'),
                        'club_etime' => input('club_etime'),
                        'club_tel' => input('club_tel'),

                    ];
                    $res=db('club')->where('club_id',$club_id)->update($data);
                    if($res){
                        $this->success('修改俱乐部信息成功！','lst');
                    }else{
                        $this->error('修改俱乐部信息失败...');
                    }
                }else{
                    echo $file->getError();
                }
            }else{
                $data=[
                    'club_name' => input('club_name'),
                    'club_desc' => input('club_desc'),
                    'club_adress' => input('club_adress'),
                    'club_otime' => input('club_otime'),
                    'club_etime' => input('club_etime'),
                    'club_tel' => input('club_tel'),
                ];
                $res=db('club')->where('club_id',$club_id)->update($data);
                if($res){
                    $this->success('修改俱乐部信息成功！','lst');
                }else{
                    $this->error('修改俱乐部信息失败...');
                }
            }
        }
    }
    public function pub(){
        {
            $club_id=input('club_id');
            $info=db("club")->where("club_id",$club_id)->find();
            if($info['club_status']==0){
                $status=['club_status'=>1];}
            else{
                $status=['club_status'=>0];
            }
            $res=db('club')->where('club_id',$club_id)->update($status);
            if($res){
                $this->success('修改状态成功！','lst');
            }else{
                $this->error('修改状态失败...');
            }
        }

    }
}
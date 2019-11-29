<?php
namespace app\supadmin\controller;
use app\supadmin\controller\Base;
use think\Controller;
use think\Session;
use think\Db;
class Activity extends Base
{
	

    public function lst()
    {
        $supadmin_id=Session::get('supadmin_id');
        $info=Db::name("activity")->alias('a')->join("supadmin s","a.supera_id=s.supadmin_id")
            ->where("s.supadmin_id",$supadmin_id)->select();
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function detail()
    {
        $activity_id=input('activity_id');
        $supadmin_id=Session::get('supadmin_id');
        $info=Db::name("activity")->alias('a')->where('a.activity_id',$activity_id)->join("supadmin s","a.supera_id=s.supadmin_id")
            ->where("s.supadmin_id",$supadmin_id)->select();
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
    public function doadd()
    {
        if(request()->isPost()){
            $file = request()->file('activity_pic');
            if($file){
                $info = $file->rule('uniqid')
                    ->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])
                    ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'sup_admin' .DS .'images');
                if($info){
                    $activity_pic=$info->getFilename();
                }
                else{
                    echo $file->getError();
                }
            }else{
                $this->error('请选择活动图片！');
            }
            $supadmin_id=Session::get('supadmin_id');
            $data=[
                'activity_time'=>input('activity_time'),
                'activity_money'=>input('activity_money'),
                'activity_stime'=>input('activity_stime'),
                'activity_etime'=>input('activity_etime'),
                'activity_name'=>input('activity_name'),
                'activity_desc'=>input('activity_desc'),
                'activity_place'=>input('activity_place'),
                'activity_pic'=>$activity_pic,
                'supera_id'=>$supadmin_id
            ];
            $res=db('activity')->insert($data);
            if($res){
                $this->success('添加活动成功！','lst');
            }else{
                $this->error('添加活动失败...');
            }
            return $this->fetch();
        }
    }
    public function edit(){
        $activity_id=input('activity_id');
        $info=db('activity')->where('activity_id',$activity_id)->find();
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function doedit()
    {
        $activity_id=input('activity_id');
        $supadmin_id=Session::get('supadmin_id');
        if(request()->isPost()){
            $file = request()->file('activity_pic');
            if($file){
                $info = $file->rule('uniqid')
                    ->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])
                    ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'sup_admin' .DS .'images');
                if($info){
                    $activity_pic=$info->getFilename();
                    $data=[
                        'activity_time'=>input('activity_time'),
                        'activity_money'=>input('activity_money'),
                        'activity_stime'=>input('activity_stime'),
                        'activity_etime'=>input('activity_etime'),
                        'activity_name'=>input('activity_name'),
                        'activity_desc'=>input('activity_desc'),
                        'activity_place'=>input('activity_place'),
                        'activity_pic'=>$activity_pic,
                        'supera_id'=>$supadmin_id
                    ];
                    $res=db('activity')->where('activity_id',$activity_id)->update($data);
                    if($res){
                        $this->success('修改活动信息成功！','lst');
                    }else{
                        $this->error('修改活动信息失败...');
                    }
                }else{
                    echo $file->getError();
                }
            }else{
                $data=[
                    'activity_time'=>input('activity_time'),
                    'activity_money'=>input('activity_money'),
                    'activity_stime'=>input('activity_stime'),
                    'activity_etime'=>input('activity_etime'),
                    'activity_name'=>input('activity_name'),
                    'activity_desc'=>input('activity_desc'),
                    'activity_place'=>input('activity_place'),
                    'supera_id'=>$supadmin_id
                ];
                $res=db('activity')->where('activity_id',$activity_id)->update($data);
                if($res){
                    $this->success('修改活动信息成功！','lst');
                }else{
                    $this->error('修改活动信息失败...');
                }
            }
        }
    }
     public function del()
{
    $activity_id=input('activity_id');
    $status=['activity_status'=>2];
    $res=db('activity')->where('activity_id',$activity_id)->update($status);
    if($res){
        $this->success('结束活动成功！','lst');
    }else{
        $this->error('结束活动失败...');
    }
}


    public function pub(){
        {
            $activity_id=input('activity_id');
            $status=['activity_status'=>1];
            $res=db('activity')->where('activity_id',$activity_id)->update($status);
            if($res){
                $this->success('发布活动成功！','lst');
            }else{
                $this->error('发布活动失败...');
            }
        }

    }

    public function change(){
        {
            $aenter_id=input('aenter_id');
            $status=['apay_status'=>1];
            $res=db('aenter')->where('aenter_id',$aenter_id)->update($status);
            if($res){
                $this->success('支付成功！','enter');
            }else{
                $this->error('支付失败...');
            }
        }

    }



    public function enter()
    {
        $info=Db::name("aenter")->alias('a')->join("user u","a.uid=u.user_id")
            ->join("activity ac","a.aid=ac.activity_id")->select();
        $this->assign('info',$info);
        return $this->fetch();
    }
    

}

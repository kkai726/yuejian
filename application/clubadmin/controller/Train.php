<?php
namespace app\clubadmin\controller;
use think\Db;
use app\clubadmin\controller\Base;
use think\Session;
use think\Controller;

class Train extends Base
{

    public function lst()
    {
        $clubadmin_id=Session::get('clubadmin_id');
        $club=Db::name("club")->table('club c,clubadmin ca')->where("c.club_id=ca.club_id and clubadmin_id='$clubadmin_id'")->find();
        $club_id=$club["club_id"];

        $train=Db::name("train t")->join("club b","t.club_id=b.club_id")->join("level l","t.lid=l.lid")->where("b.club_id",$club_id)->select();

        $this->assign("train",$train);

        return $this->fetch();
    }

    public function add()
    {
        $level=Db::name("level")->select();
        $this->assign("level",$level);
        return $this->fetch();
    }

    public function doaddtrain()//添加课程
    {

        $clubadmin_id=Session::get('clubadmin_id');
        $club=Db::name("club")->table('club c,clubadmin ca')->where("c.club_id=ca.club_id and clubadmin_id='$clubadmin_id'")->find();
        $club_id=$club["club_id"];

        if(request()->isPost()){
        $file = request()->file('train_pic');
        if($file){
        $info = $file->rule('uniqid')
        ->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])
        ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'club_admin' .DS .'train');
        if($info){
            $train_pic=$info->getFilename();
            }
        else{
        echo $file->getError();
            }
        }
        $starttime=input("trainopen");
        $endtime=input("trainend");

        if($starttime > $endtime){
            $this->error('时间填写有误！');
        }
        else{
        $data=[
            'train_name'=>input('trainname'),
            'train_desc'=>input('trainintro'),
            'train_price'=>input('trainprice'),
            'train_address'=>input('trainaddress'),
            'train_otime'=>$starttime,
            'train_ctime'=>$endtime,
            'lid'=>input('level'),
            'train_status'=>0,
            'train_limit'=>input('trainnum'),
            'club_id'=>$club_id,
            'train_pic'=>$train_pic
        ];
        }

        $res=db('train')->insert($data);
        if($res){
            $this->success('添加训练成功！','lst');
        }else{
            $this->error('添加训练失败！');
        }
        }

    }

    

    public function edit($train_id)//修改显示
    {

        $clubadmin_id=Session::get('clubadmin_id');
        $club=Db::name("club")->table('club c,clubadmin ca')->where("c.club_id=ca.club_id and clubadmin_id='$clubadmin_id'")->find();
        $club_id=$club["club_id"];
        
        $train=Db::name('train')->find($train_id);
        $this->assign("train",$train);

        $level=Db::name("level")->select();
        $this->assign("level",$level);

        return $this->fetch();

    }

    public function updatetrain($train_id)
    {
        $file = request()->file('train_pic');

        $train_pic="";
        $train_pic2=input('train_pic2');
        if($file){
        $info = $file->rule('uniqid')->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'club_admin' .DS .'train');
      
        if($info){
            $train_pic=$info->getFilename();
            }
        else{
        echo $file->getError();
            }
        }

        $starttime=input("trainopen");
        $endtime=input("trainend");

        if($starttime > $endtime){
            $this->error('时间填写有误！');
        }
        else{
        if (request()->isPost()) {
        //插入数据
        $data=[
        "train_name"=>input('trainname'),
        "train_desc"=>input('trainintro'),
        "train_price"=>input('trainprice'),
        'lid'=>input('level'),
        "train_address"=>input('trainaddress'),
        'train_otime'=>$starttime,
        'train_ctime'=>$endtime,
        'train_limit'=>input('trainnum'),
        'train_pic'=>empty($train_pic)?$train_pic2:$train_pic
        ];
        
        if(Db::name('train')->where("train_id",$train_id)->update($data))
            $this->success('更新成功','lst');
        else
            $this->error('更新失败');

        }
      }
    }

    public function pub($train_id)
    {
        $train_id=input('train_id');
        $status=['train_status'=>1];
        $res=db('train')->where('train_id',$train_id)->update($status);
        if($res){
            $this->success('发布训练成功！','lst');
        }else{
            $this->error('发布训练失败...');
        }
    }

    public function down($train_id)
    {
        $train_id=input('train_id');
        $status=['train_status'=>0];
        $res=db('train')->where('train_id',$train_id)->update($status);
        if($res){
            $this->success('下架训练成功！','lst');
        }else{
            $this->error('下架训练失败...');
        }
    }

    public function deltrain($train_id)//删除训练
    {
       if(Db::name('train')->where('train_id',$train_id)->delete($train_id)){
            $this->success('删除成功');
        }else $this->error('删除失败');
    }

    public function enter($train_id)//训练报名
    {
        $trainorder=Db::name("tenter te")->join("train t","te.train_id=t.train_id")->join("user u","te.uid=u.user_id")->where("te.train_id",$train_id)->select();

        $this->assign("trainorder",$trainorder);

        return $this->fetch();
    }

    public function check($tenter_id)
    {
        $tenter_id=input('tenter_id');
        $status=['tpay_status'=>1];
        $res=db('tenter')->where('tenter_id',$tenter_id)->update($status);
        if($res){
            $this->success('审核成功！');
        }else{
            $this->error('审核失败...');
        }
    }


}

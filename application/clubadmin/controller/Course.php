<?php
namespace app\clubadmin\controller;
use think\Db;
use app\clubadmin\controller\Base;
use think\Session;
use think\Controller;

class Course extends Base
{
    public function lst()//课程列表
    {
    	$clubadmin_id=Session::get('clubadmin_id');
    	$club=Db::name("club")->table('club c,clubadmin ca')->where("c.club_id=ca.club_id and clubadmin_id='$clubadmin_id'")->find();
    	$club_id=$club["club_id"];

        $course=Db::name("course c")->join("club b","c.club_id=b.club_id")->join("coach ch","c.coach_id=ch.coach_id")->join("level l","c.lid=l.lid")
        // ->where("b.club_id",$club_id)
        ->select();

    	$this->assign("course",$course);

        return $this->fetch();

        //测试当前俱乐部所有课程列表接口
        // return json($course);
    }

    public function add()//添加课程显示
    {
        $clubadmin_id=Session::get('clubadmin_id');
        $club=Db::name("club")->table('club c,clubadmin ca')->where("c.club_id=ca.club_id and clubadmin_id='$clubadmin_id'")->find();
        $club_id=$club["club_id"];

        $level=Db::name("level")->select();
        $this->assign("level",$level);

        $coach=Db::name("coach c")->join("club b","c.cid=b.club_id")
        // ->where("b.club_id",$club_id)->order('coach_id desc')
        ->select();
        // dump($coach);die;
        $this->assign("coach",$coach);
        return $this->fetch();
    }

    public function doaddcourse()//添加课程
    {

        $clubadmin_id=Session::get('clubadmin_id');
        $club=Db::name("club")->table('club c,clubadmin ca')->where("c.club_id=ca.club_id and clubadmin_id='$clubadmin_id'")->find();
        $club_id=$club["club_id"];

        if(request()->isPost()){
        $file = request()->file('course_pic');
        if($file){
        $info = $file->rule('uniqid')
        ->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])
        ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'club_admin' .DS .'course');
        if($info){
            $course_pic=$info->getFilename();
            }
        else{
        echo $file->getError();
            }
        }

        $data=[
            'course_name'=>input('coursename'),
            'course_desc'=>input('courseintro'),
            'course_price'=>input('courseprice'),
            'course_address'=>input('courseaddress'),
            'course_otime'=>input('courseopen'),
            'lid'=>input('level'),
            'course_status'=>0,
            'club_id'=>$club_id,
            'course_pic'=>$course_pic,
            'coach_id'=>input('master')
        ];
        $validate = \think\Loader::validate('Course');
    		if(!$validate->scene('doaddcourse')->check($data)){
			   $this->error($validate->getError()); die;
			}
        $res=db('course')->insert($data);
        if($res){
            $this->success('添加课程成功！','lst');
        }else{
            $this->error('添加课程失败！');
        }
        }

    }

    public function edit($course_id)//修改显示
    {

        $clubadmin_id=Session::get('clubadmin_id');
        $club=Db::name("club")->table('club c,clubadmin ca')->where("c.club_id=ca.club_id and clubadmin_id='$clubadmin_id'")->find();
        $club_id=$club["club_id"];
        
    	$course=Db::name('course')->find($course_id);
        $this->assign("course",$course);

        $level=Db::name("level")->select();
        $this->assign("level",$level);

        $coach=Db::name("coach c")->join("club b","c.cid=b.club_id")
        // ->where("b.club_id",$club_id)->order('coach_id desc')
        ->select();
        $this->assign("coach",$coach);
        return $this->fetch();

        //测试当前课程详情接口
        // return json($course);
    }

    public function updatecourse($course_id){//修改课程信息
        $file = request()->file('course_pic');

        $course_pic="";
        $course_pic2=input('course_pic2');
        if($file){
        $info = $file->rule('uniqid')->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'club_admin' .DS .'course');
      
        if($info){
            $course_pic=$info->getFilename();
            }
        else{
        echo $file->getError();
            }
        }
        if (request()->isPost()) {
        //插入数据
        $data=[
        "course_name"=>input('coursename'),
        "course_desc"=>input('courseintro'),
        "course_price"=>input('courseprice'),
        'lid'=>input('level'),
        "coach_id"=>input('master'),
        "course_address"=>input('courseaddress'),
        "course_otime"=>input('courseopen'),
        'course_pic'=>empty($course_pic)?$course_pic2:$course_pic
        ];
        $validate = \think\Loader::validate('Course');
    		if(!$validate->scene('updatecourse')->check($data)){
			   $this->error($validate->getError()); die;
			}

        if(Db::name('course')->where("course_id",$course_id)->update($data))
            $this->success('更新成功','lst');
        else
            $this->error('更新失败');

        }

    }

    public function pub()//一键发布课程
    {
        $course_id=input('course_id');
        $status=['course_status'=>1];
        $res=db('course')->where('course_id',$course_id)->update($status);
        if($res){
        	$this->success('发布课程成功！','lst');
        }else{
        	$this->error('发布课程失败...');
        }
    }

    public function down()//一键下架课程
    {
        $course_id=input('course_id');
        $status=['course_status'=>0];
        $res=db('course')->where('course_id',$course_id)->update($status);
        if($res){
            $this->success('下架课程成功！','lst');
        }else{
            $this->error('下架课程失败...');
        }
    }

    public function delcourse($course_id)//删除课程
    {
       if(Db::name('course')->where('course_id',$course_id)->delete($course_id)){
            $this->success('删除成功');
        }else $this->error('删除失败');
    }
}

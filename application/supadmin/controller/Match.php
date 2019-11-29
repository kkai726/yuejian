<?php
namespace app\supadmin\controller;
use think\Controller;
use think\Db;
use think\Session;
use app\supadmin\controller\Base;
class Match extends Base
{
	

    public function lst()
    {
        $supadmin_id=Session::get('supadmin_id');
        // $match_id=input('match_id');
        $info=Db::name("match")->alias('m')->join("supadmin s","m.sid=s.supadmin_id")
        ->where("s.supadmin_id",$supadmin_id)->select();
        // dump($info);die;
        $this->assign('info',$info);
        return $this->fetch();
    }




    public function add(){
        return $this->fetch();
    }
    public function doadd()
    {
        if(request()->isPost()){
        $file = request()->file('match_post');
        if($file){
        $info = $file->rule('uniqid')
        ->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])
        ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'sup_admin' .DS .'images');
        if($info){
        	$match_post=$info->getFilename();
            }
        else{
        echo $file->getError();
        	}
        }else{
            $this->error('请选择比赛海报！');
        }

        $supadmin_id=Session::get('supadmin_id');
        $data=[
            'match_time'=>input('match_time'),
            'match_stime'=>input('match_stime'),
            'match_etime'=>input('match_etime'),
            'match_name'=>input('match_name'),
            'match_limit'=>input('match_limit'),
            'match_desc'=>input('match_desc'),
            'match_address'=>input('match_address'),
            'match_post'=>$match_post,
            'sid'=>$supadmin_id
        ];
        $validate = \think\Loader::validate('Match');
    		if(!$validate->scene('doadd')->check($data)){
			   $this->error($validate->getError()); die;
			}
        $res=db('match')->insert($data);
        if($res){
            $this->success('添加比赛成功！','lst');
        }else{
            $this->error('添加比赛失败...');
        }
        return $this->fetch();
        }
    }




    public function del()
    {
        $match_id=input('match_id');
        $res=db('match')->where('match_id',$match_id)->delete();
        if($res){
            $this->success('删除比赛成功！','lst');
        }else{
            $this->error('删除比赛失败...');
        }
    }



    public function edit(){
        $match_id=input('match_id');
        $info=db('match')->where('match_id',$match_id)->find();
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function doedit()
    {
        $match_id=input('match_id');
        $supadmin_id=Session::get('supadmin_id');
        if(request()->isPost()){
        $file = request()->file('match_post');
        if($file){
        $info = $file->rule('uniqid')
        ->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])
        ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'sup_admin' .DS .'images');
        if($info){
            $match_post=$info->getFilename();
            $data=[
                'match_time'=>input('match_time'),
                'match_stime'=>input('match_stime'),
                'match_limit'=>input('match_limit'),
                'match_etime'=>input('match_etime'),
                'match_name'=>input('match_name'),
                'match_desc'=>input('match_desc'),
                'match_address'=>input('match_address'),
                'match_post'=>$match_post,
                'sid'=>$supadmin_id
            ];
            $validate = \think\Loader::validate('Match');
    		if(!$validate->scene('doedit')->check($data)){
			   $this->error($validate->getError()); die;
			}
            $res=db('match')->where('match_id',$match_id)->update($data);
            if($res){
                $this->success('修改比赛信息成功！','lst');
            }else{
                $this->error('修改比赛信息失败...');
            }
            }else{
                echo $file->getError();
        	}
        }else{
            $data=[
            'match_time'=>input('match_time'),
            'match_stime'=>input('match_stime'),
            'match_limit'=>input('match_limit'),
            'match_etime'=>input('match_etime'),
            'match_name'=>input('match_name'),
            'match_desc'=>input('match_desc'),
            'match_address'=>input('match_address'),
            'sid'=>$supadmin_id
        ];
        $validate = \think\Loader::validate('Match');
    		if(!$validate->scene('doedit_p')->check($data)){
			   $this->error($validate->getError()); die;
			}
        $res=db('match')->where('match_id',$match_id)->update($data);
        if($res){
            $this->success('修改比赛信息成功！','lst');
        }else{
            $this->error('修改比赛信息失败...');
        }
        }
        }
    }




    public function enter()
    {
        $match_id=input('match_id');
        $info=Db::name("menter")->alias('m')->join("user u","m.uid=u.user_id")
        ->join("match ma","m.mid=ma.match_id")->where('ma.match_id',$match_id)->select();
        $this->assign('info',$info);
        return $this->fetch();
    }


    public function detail()
    {
        $match_id=input('match_id');
        $supadmin_id=Session::get('supadmin_id');
        $info=Db::name("match")->alias('m')->where('m.match_id',$match_id)->join("supadmin s","m.sid=s.supadmin_id")
        ->where("s.supadmin_id",$supadmin_id)->select();
        $this->assign('info',$info);
        return $this->fetch();
    }


    public function pub(){
        $match_id=input('match_id');
        $status=['match_status'=>1];
        $res=db('match')->where('match_id',$match_id)->update($status);
        if($res){
            $this->success('发布比赛成功！','lst');
        }else{
            $this->error('发布比赛失败...');
        }
    }

}

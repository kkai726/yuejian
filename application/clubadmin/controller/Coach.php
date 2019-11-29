<?php
namespace app\clubadmin\controller;

use app\clubadmin\controller\Base;

use think\Controller;
use think\Session;
use think\Db;

use think\Request;

class Coach extends Base
{

    public function lst()
    {   
        $clubadmin_id=Session::get('clubadmin_id');
        // dump("$clubadmin_id");die;
        $info=Db::name("coach")->select();
        $info=Db::name("coach")->alias('co')->join("club c","co.cid=c.club_id")->select();
            // $info=Db::name("coach")->alias('co')->join("club c","co.cid=c.club_id")->join("clubadmin ca","c.club_id=ca.club_id")->select();
        // var_dump($info);exit;
        // $this->assign('info',$info);
        function getAge($coach_age){
            //格式化出生时间年月日
            $byear=date('Y',$coach_age);
            $bmonth=date('m',$coach_age);
            $bday=date('d',$coach_age);
        
            //格式化当前时间年月日
            $tyear=date('Y');
            $tmonth=date('m');
            $tday=date('d');
        
            //开始计算年龄
            $age=$tyear-$byear;
            if($bmonth>$tmonth || $bmonth==$tmonth && $bday>$tday){
                $age--;
            }
            return $age;
        }
        
        // $riqi=date('Y-m-d H:i:s',time());
        // $riqi='1997-12-31 15:20:36';
        $sum=db('coach')->count();
        for($i=0;$i<$sum;$i++){
        $riqi=$info[$i]['coach_age'];
       
        $uriqi=strtotime($riqi);      //将日期转化为时间戳
        
        $age=getAge($uriqi);
        $info[$i]['coach_age']=$age;
        // echo '<br><br>年龄计算结果：'.$age.'岁';
        $this->assign('info',$info); }
        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
    public function doadd()
    {
        if(request()->isPost()){
        $file = request()->file('coach_pic');
        
        if($file){

        $info = $file->rule('uniqid')
        ->validate(['size'=>64000000,'ext'=>'jpg,png'])
        ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'sup_admin' .DS .'images'.DS .'coach');
           
        if($info){
        	$coach_pic=$info->getFilename();
            }
        else{
        echo $file->getError();
        	}
        }else{
            $this->error('请选择图片！');
        }
        
        $clubadmin_id=Session::get('clubadmin_id');
        // $data=Db::name("video")->select();
        $data=Db::name("coach")->alias('co')
        ->join("club c","co.cid=c.club_id")->select();
        // dump($data);die;
        // $gender = $this->_post('cgender');
        $this->assign('info',$info);
        // dump($info);die;
        // $uptime=date('Y-m-d H:i:s',time());
        $data=[
            'coach_name'=>input('coach_name'),
            'coach_desc'=>input('coach_desc'),
            'cgender'=>input('cgender'),
            'coach_age'=>input('coach_age'),
            'coach_time'=>input('coach_time'),
            'coach_pic'=>$coach_pic,
            'cid'=>empty($cid)
        ];
        // dump($data);die;
        $res=db('coach')->insert($data);
        // dump($res);die;
        if($res){
            $this->success('添加教练成功！','lst');
        }else{
            $this->error('添加教练失败...');
        }
        }
    }
    public function del($coach_id)
    {
        // $video_id=input('video_id');
        if(Db::name('coach')->delete($coach_id)){
            $this->success('删除教练成功！','lst');
        }else{
            $this->error('删除教练失败！');
        }
    }
    public function update($coach_id)
    {
    //    $video_id=input('video_id');
       $info=Db::name('coach')->find($coach_id);
        $this->assign('info',$info);
        return $this->fetch();
    }
  
    public function doupdate($coach_id)
    {   $file=request()->file('coach_pic');
        $coach_pic="";
        $coach_pic2=input("club_pic2");
        if($file){
            $info=$file->rule('uniqid')
            ->validate(['size'=>64000000,"ext"=>'jpg,png,gif'])
            ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'sup_admin' .DS .'images'.DS .'coach');
        if($info){
            $coach_pic=$info->getFilename();
        $data=[
                    'coach_name'=>input('coach_name'),
                    'coach_desc'=>input('coach_desc'),
                    'cgender'=>input('cgender'),
                    'coach_age'=>input('coach_age'),
                    'coach_time'=>input('coach_time'),
                    'coach_pic'=>$coach_pic,
                    'cid'=>empty($cid)
                ];  
                if(Db::name('coach')->where("coach_id",$coach_id)->update($data)){
                            $this->success('修改教练信息成功！','lst');
                        }else{
                            $this->error('修改教练信息失败...');
                        }
                    }else{
                echo $file->getError();
            }
        }else{
            $data=[
            'coach_name'=>input('coach_name'),
                    'coach_desc'=>input('coach_desc'),
                    'cgender'=>input('cgender'),
                    'coach_age'=>input('coach_age'),
                    'coach_time'=>input('coach_time'),
                    'cid'=>empty($cid)
        ];
        $res=db('coach')->where('coach_id',$coach_id)->update($data);
        if($res){
            $this->success('修改教练信息成功！','lst');
        }else{
            $this->error('修改教练信息失败！');
        }
        }
        
    }
    public function pub($coach_id)
    {
            // dump($coach_id);die;
            $status=['coach_status'=>1];
            $res=db('coach')->where('coach_id',$coach_id)->update($status);
            if($res){
                $this->success('推荐成功！','lst');
            }else{
                $this->error('推荐失败...');
            }
        }

}

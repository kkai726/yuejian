<?php
namespace app\supadmin\controller;
use app\supadmin\controller\Base;
use think\Controller;
use think\Session;
use think\Db;
class Master extends Base
{
	public function check()
    {
        $supadmin_id=Session::get('superadmin_id');
        $info=Db::name("coach")->select();
            $info=Db::name("coach")->alias('co')->join("club c","co.cid=c.club_id")->select();
        //    dump($info);die;
        // var_dump($goods);exit;
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
        $this->assign('info',$info); 
    }
        return $this->fetch();
    }
    public function share()
    {
        $supadmin_id=Session::get('superadmin_id');
        $info=Db::name("coach")->select();
        $info=Db::name("coach")->alias('co')->join("club c","co.cid=c.club_id")->select();
        //    dump($info);die;
        // var_dump($goods);exit;
        // $this->assign('info',$info);
        function getAgee($coach_age){
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
        
        $age=getAgee($uriqi);
        $info[$i]['coach_age']=$age;
        // echo '<br><br>年龄计算结果：'.$age.'岁';
        $this->assign('info',$info); 
    }
        return $this->fetch();
    }

    public function pass($coach_id)
    {
            // dump($coach_id);die;
            $status=['coach_status'=>3];
            $res=db('coach')->where('coach_id',$coach_id)->update($status);
            if($res){
                $this->success('审核通过！该名教练成为大师！');
            }else{
                $this->error('操作失败...');
            }
        }
   public function fail($coach_id)
    {
            // dump($coach_id);die;
            $status=['coach_status'=>2];
            $res=db('coach')->where('coach_id',$coach_id)->update($status);
            if($res){
                $this->success('审核不通过！');
            }else{
                $this->error('操作失败...');
            }
        }

           public function start($coach_id)
    {
            // dump($coach_id);die;
            $status=['share_status'=>0];
            $res=db('coach')->where('coach_id',$coach_id)->update($status);
            if($res){
                $this->success('启用成功！');
            }else{
                $this->error('启用操作失败...');
            }
        }

           public function stop($coach_id)
    {
            // dump($coach_id);die;
            $status=['share_status'=>1];
            $res=db('coach')->where('coach_id',$coach_id)->update($status);
            if($res){
                $this->success('禁用成功！');
            }else{
                $this->error('禁用操作失败...');
            }
        }

}

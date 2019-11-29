<?php
namespace app\index\controller;
use think\Controller;
class Activity extends Controller
{
    public function lists(){
        $lists=db('activity')->select();
        return json($lists);
    }

    public function detail(){
        $activity_id=input('activity_id');
        $detail=db('activity')->where('activity_id',$activity_id)->select();
        return json($detail);
    }

    public function focus(){
        $activity_id=input('activity_id');
        $user_id=input('user_id');
        $data=[
            'aid'=>$activity_id,
            'uid'=>$user_id,
            'focus_status'=>1
        ];
        $res=db('focus')->insert($data);
        if($res){
            return json($res);
        }
    }


    public function cancelfocus(){
        $activity_id=input('activity_id');
        $user_id=input('user_id');
        $focus_id=input('focus_id');
        $res=db('focus')->alias('f')
            ->join('activity a','f.mid=a.activity_id')
            ->where('a.activity_id',$activity_id)->join('user u','f.uid=u.user_id')
            ->where('u.user_id',$user_id)
            ->find();
        if($res){
            $res=['focus_status'=>0];
            db('focus')->where('focus_id',$focus_id)->delete();
            return json($res);
        }

    }


    public function enter(){
        $activity_id=input('activity_id');
        // $res=db('activity')->where('activity_id',$activity_id)->find();
        $res=db('activity')->where('activity_id',$activity_id)->find();
        $activity_sum=$res['activity_sum'];
        $activity_limit=$res['activity_limit'];
        if($activity_sum<$activity_limit){
            return json('报名成功');
        }else{
            return json('报名失败，人数已满...');
        }
    }


}


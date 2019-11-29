<?php
namespace app\index\controller;
use think\Controller;
class Match extends Controller
{
    //htk
	public function lists(){
        $lists=db('match')->where->('match_status=1')->select();
        return json($lists);
    }

    public function detail(){
        $match_id=input('match_id');
        $detail=db('match')->where('match_id',$match_id)->select();
        return json($detail);
    }

    public function focus(){
        $match_id=input('match_id');
        $user_id=input('user_id');
        $data=[
            'mid'=>$match_id,
            'uid'=>$user_id,
            'focus_status'=>1
        ];
        $res=db('focus')->insert($data);
        if($res){
            return json($res);
        }
        }

        
    public function cancelfocus(){
        $match_id=input('match_id');
        $user_id=input('user_id');
        $focus_id=input('focus_id');
        $res=db('focus')->alias('f')
        ->join('match m','f.mid=m.match_id')
        ->where('m.match_id',$match_id)->join('user u','f.uid=u.user_id')
        ->where('u.user_id',$user_id)
        ->find();
        if($res){
            $res=['focus_status'=>0];
            db('focus')->where('focus_id',$focus_id)->delete();
            return json($res);
        }

    }


    public function enter(){
        $match_id=input('match_id');
        // $res=db('match')->where('match_id',$match_id)->find();
        $res=db('match')->where('match_id',$match_id)->find();
        $match_sum=$res['match_sum'];
        $match_limit=$res['match_limit'];
        if($match_sum<$match_limit){
            return json('报名成功');
        }else{
            return json('报名失败，人数已满...');
        }
    }

    //end htk

}

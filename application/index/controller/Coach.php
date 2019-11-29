<?php
namespace app\index\controller;
use think\Controller;
class coach extends Controller
{
	public function lists(){
        // $lists=db('coach')->select();
        $lists=db("coach")->alias('co')->join("club c","co.cid=c.club_id")->field('coach_id,coach_name,coach_pic,cgender,coach_age,coach_time,coach_desc,coach_status,share_status,cid,club_name')->select();
       
        return json($lists);
    }
    public function detail(){
        // $lists=db("coach")->alias('co')->join("club c","co.cid=c.club_id")->select();
           $lists=db("coach")->alias('co')->join("club c","co.cid=c.club_id")->field('coach_id,coach_name,coach_pic,cgender,coach_age,coach_time,coach_desc,coach_status,share_status,cid,club_name')->select();
     
        return json($lists);
    }


       // public function focus(){
       //   $coach_id=input('coach_id');
       //    $user_id=input('user_id');
       //  $data=[
       //      'maid'=>$coach_id,
       //      'uid'=>$user_id,
       //      'follow_status'=>1
       //  ];
       //  $res=db('focus')->insert($data);
       //  if($res){
       //      return json($data);
       //  }
       //  }


        
		public function focus(){
        // $lists=db("coach")->alias('co')->join("club c","co.cid=c.club_id")->select();
         
           $lists=db("focus")->where('maid is not null')->field('maid,uid,follow_status')->select();
      

        return json($lists);
    }
        
    // public function cancelfocus(){
    //     $coach_id=input('coach_id');
    //     $user_id=input('user_id');
    //     $focus_id=input('focus_id');
    //     $res=db('focus')->alias('f')
    //     ->join('coach co','f.maid=co.coach_id')
    //     ->where('co.coach_id',$coach_id)->join('user u','f.uid=u.user_id')
    //     ->where('u.user_id',$user_id)
    //     ->find();
    //     if($res){
    //         $res=['follow_status'=>0];
    //         db('focus')->where('focus_id',$focus_id)->delete();
    //         return json($data['follow_status']);
    //     }

    // }
    public function cancelfocus(){
    $lists=db("focus")->where('maid is not null')->field('maid,uid,follow_status')->select();
        return json($lists);
}

}
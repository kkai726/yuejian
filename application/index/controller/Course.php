<?php
namespace app\index\controller;
use think\Controller;
use \think\Db;
class Course extends Controller
{
//start lqn
    
	//测试当前俱乐部课程列表信息接口
	//http://localhost/yuejian5/public/index/course/lists/club_id/2
	public function lists($club_id){
        $lists=db('course')->select();
        return json($lists);
    }

    //测试当前课程信息接口
    //http://localhost/yuejian5/public/index/course/detail/club_id/2/course_id/2
	public function detail($club_id,$course_id){
        $detail=db('course')->where('club_id',$club_id)->where('course_id',$course_id)->select();
        return json($detail);
    }

// end lqn 




//     public function lists(){
//         // $lists=db('course')->select();
//         // return json($lists);
//     $lists=db("course")
//     ->alias('course')->join("club c","course.club_id=c.club_id")->join("coach co","course.coach_id=co.coach_id")
//     ->field('course_id,course_name,course_desc,lid,course_price,course_otime,course_status,course_pic,course.club_id,course.coach_id,club_name,coach_name')->select();
       
//         return json($lists);
//     }
//     public function detail(){
//         $lists=db("course")
//     ->alias('course')->join("club c","course.club_id=c.club_id")->join("coach co","course.coach_id=co.coach_id")
//     ->field('course_id,course_name,course_desc,lid,course_price,course_otime,course_status,course_pic,course.club_id,course.coach_id,club_name,coach_name')->select();
       
//         return json($lists);
//     }

//        // public function like(){
//        //   $course_id=input('course_id');
//        //    $user_id=input('user_id');
//        //  $data=[
//        //      'coid'=>$course_id,
//        //      'uid'=>$user_id,
//        //      'like_status'=>1
//        //  ];
//        //  $res=db('focus')->insert($data);
//        //  if($res){
//        //      return json($data);
//        //  }
//        //  }


        
//         public function like(){
//         // $lists=db("coach")->alias('co')->join("club c","co.cid=c.club_id")->select();
         
//            $lists=db("focus")->where('coid is not null')->field('coid,uid,like_status')->select();
//         return json($lists);
//     }
        
//     // public function cancellike(){
//     //     $course_id=input('course_id');
//     //     $user_id=input('user_id');
//     //     $focus_id=input('focus_id');
//     //     $res=db('focus')->alias('f')
//     //     ->join('course course','f.coid=course.course_id')
//     //     ->where('course.course_id',$course_id)->join('user u','f.uid=u.user_id')
//     //     ->where('u.user_id',$user_id)
//     //     ->find();
//     //     if($res){
//     //         $res=['like_status'=>0];
//     //         db('focus')->where('focus_id',$focus_id)->delete();
//     //         return json($data['like_status']);
//     //     }

//     // }

//     public function cancellike(){
//    $lists=db("focus")->where('coid is not null')->field('coid,uid,like_status')->select();
//         return json($lists);
// }
}	
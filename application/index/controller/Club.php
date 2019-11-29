<?php
namespace app\index\controller;
use think\Controller;
use \think\Db;
class Club extends Controller
{
//start lqn

	//测试俱乐部列表信息接口
	// http://localhost/yuejian5/public/index/club/lists
	public function lists(){
        $lists=db('club')->select();
        return json($lists);
    }

    //测试当前俱乐部信息接口
    //http://localhost/yuejian5/public/index/club/detail/club_id/2
	public function detail($club_id){
        $detail=db('club')->find($club_id);
        return json($detail);
    }

     //测试当前俱乐部视频信息接口
    //http://localhost/yuejian5/public/index/club/videolists/club_id/2
    public function videolists($club_id){
        $lists=db('video')->find($club_id);
        return json($lists);
    }

    //测试当前俱乐部视频详细信息接口
    //http://localhost/yuejian5/public/index/club/videodetail/club_id/2/video_id/1
    public function videodetail($club_id,$video_id){
        $detail=db('video')->where('club_id',$club_id)->where('video_id',$video_id)->select();
        return json($detail);
    }

    //测试关注/取消关注当前俱乐部详细信息接口
    //http://localhost/yuejian5/public/index/club/detailcreatefans/club_id/2/user_id/1
    public function detailcreatefans($club_id,$user_id){
        $num=Db::name("focus")->where("cid='$club_id'")->where("uid='$user_id'")->count();//单引号不解析，
        if($num>0) return json(["success"=>0]);
        $data=[
              'uid'=>$user_id,
              'cid'=>$club_id
        ];
        $res=Db::name('focus')->insert($data);
        //处理结果
        if($res){
            return json(["success"=>0]);
        }
        else{
            return json(["success"=>1]);
        }
    }

    //测试判断是否关注当前俱乐部详细信息接口
    // http://localhost/yuejian5/public/index/club/isfolloeClub/club_id/2/user_id/1
    public function isfolloeClub($user_id,$club_id){
        $attention_club=Db::name("focus")->where("cid='$club_id'")->where("uid='$user_id'")->count();
        if($attention_club>0)
         return json(["isattention"=>0]);
        else
            return json(["isattention"=>1]);
    }
// end lqn 
}	
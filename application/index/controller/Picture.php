<?php
namespace app\index\controller;
use think\Controller;
class Picture extends Controller
{
    //htk
	public function lists(){
        $lists=db('picture')->alias('p')->join('user u','p.uid=u.user_id')->where('p.ptcture_status=0')->select();
        $lists[0]['picture']=explode(',', $lists[0]['picture']);
        return json($lists);
    }

    public function comment()
    {   
        $picture_id=input('picture_id');
        // dump($picture_id);die;
        $info=db("comment")->alias('c')->join("user u","c.uid=u.user_id")
        ->join("picture p","c.pid=p.picture_id")->where('p.picture_id',$picture_id)->where('c.comment_status=0')->select();
        if($info){
            $info[0]['picture']=explode(',', $info[0]['picture']);
        }else{
            $this->error('此图片暂无评论信息。');
        }
        return json($info);
    }

    public function detail(){
        $picture_id=input('picture_id');
        $lists=db('picture')->alias('p')->where('p.picture_id',$picture_id)->join('user u','p.uid=u.user_id')->select();
        $lists[0]['picture']=explode(',', $lists[0]['picture']);
        return json($lists);
    }
    //end htk

    }
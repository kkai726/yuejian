<?php
namespace app\supadmin\controller;
use think\Controller;
use app\supadmin\controller\Base;
class Picture extends Base
{
	

    public function lst()
    {   
        $info=db("picture")->alias('p')->join("user u","p.uid=u.user_id")->select();
        $sum=db('picture')->count();
        for($i=0;$i<$sum;$i++){
        $info[$i]['picture']=explode(',', $info[$i]['picture']);
        }
        // dump($info);die;
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function modify(){
        $picture_id=input('picture_id');
        $info=db("picture")->where('picture_id',$picture_id)->find();
        if($info['picture_status']==0){
            $data=['picture_status'=>1];
        }else{
            $data=['picture_status'=>0];
        }
        $res=db('picture')->where('picture_id',$picture_id)->update($data);
        if($res){
            $this->success('修改图片状态成功！','lst');
        }else{
            $this->error('修改图片状态失败...');
        }
    }


    public function comment()
    {   
        $picture_id=input('picture_id');
        // dump($picture_id);die;
        $info=db("comment")->alias('c')->join("user u","c.uid=u.user_id")
        ->join("picture p","c.pid=p.picture_id")->where('p.picture_id',$picture_id)->select();
        if($info){
            $info[0]['picture']=explode(',', $info[0]['picture']);
        }else{
            $this->error('此图片暂无评论信息。');
        }
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function cmodify(){
        $comment_id=input('comment_id');
        $info=db("comment")->where('comment_id',$comment_id)->find();
        if($info['comment_status']==0){
            $data=['comment_status'=>1];
        }else{
            $data=['comment_status'=>0];
        }
        $res=db('comment')->where('comment_id',$comment_id)->update($data);
        if($res){
            $this->success('修改评论状态成功！');
        }else{
            $this->error('修改评论状态失败...');
        }
    }

}

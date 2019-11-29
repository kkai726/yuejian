<?php
namespace app\index\controller;
use think\Controller;
class Me extends Controller
{
    //htk
	public function mypic(){
        $user_id=input('user_id');
        $picture_id=input('picture_id');
        $info=db("me")->alias('m')->join("user u","m.uid=u.user_id")
        ->where('u.user_id',$user_id)
        ->join("picture p","m.pid=p.picture_id")
        ->where('p.picture_id',$picture_id)->select();
        if($info){
            $info[0]['picture']=explode(',', $info[0]['picture']);
    }
        return json($info);
    
    }
    //end htk
}
<?php
namespace app\index\controller;
use think\Controller;
class Rpmap extends Controller
{
    //htk
	public function lists(){
        $lists=db('rpmap')->select();
        return json($lists);
    }

    public function detail(){
        $rpmap_id=input('rpmap_id');
        $info=db('rpmap')->where('rpmap_id',$rpmap_id)->select();
        return json($info);
    }
    //end htk
    }
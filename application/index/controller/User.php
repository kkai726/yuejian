<?php
namespace app\index\controller;
use think\Controller;
class User extends Controller
{
	public function lists(){
        $lists=db('user')->select();
        return json($lists);
    }

}
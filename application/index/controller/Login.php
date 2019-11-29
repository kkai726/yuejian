<?php
namespace app\index\controller;
use think\Controller;
class login extends Controller
{
	public function lists($user_name,$user_password){
		$pwd=(md5(input('user_password')));
		$lists=db('user')->where('user_name',$user_name)->where('user_password',$pwd)->find();
		// dump($lists);die();
		if($lists['user_status']==1){
			return "您已被锁定！";
		}else{
			return json($lists);
		}
    	} 	
         
    
}
?>

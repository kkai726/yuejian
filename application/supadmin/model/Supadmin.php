<?php
namespace app\supadmin\model;
use think\Model;
use think\Db;
class Supadmin extends Model
{

	public function login($data){
		$user=Db::name('supadmin')->where('supadmin_name','=',$data['supadmin_name'])->find();
		if($user){
			if($user['supadmin_password'] == md5($data['supadmin_password'])){
                session('supadmin_name',$user['supadmin_name']);
				session('supadmin_id',$user['supadmin_id']);
				return 3; //信息正确
			}else{
				return 2; //密码错误
			}
		}else{
			return 1; //用户不存在
		}
	}

}
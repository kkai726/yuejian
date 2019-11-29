<?php
namespace app\clubadmin\model;
use think\Model;
use think\Db;
class Clubadmin extends Model
{

	public function login($data){
		$user=Db::name('clubadmin')->where('clubadmin_name','=',$data['clubadmin_name'])->find();
		if($user){
			if($user['clubadmin_password'] == md5($data['clubadmin_password'])){
                session('clubadmin_name',$user['clubadmin_name']);
				session('clubadmin_id',$user['clubadmin_id']);
				return 3; //信息正确
			}else{
				return 2; //密码错误
			}
		}else{
			return 1; //用户不存在
		}
	}

}
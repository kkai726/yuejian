<?php
namespace app\clubadmin\controller;
use think\Db;
use think\Controller;
use app\clubadmin\controller\Base;
use think\Session;

class Club extends Base
{
    public function lst()//俱乐部信息
    {
    	$clubadmin_id=Session::get('clubadmin_id');
    	$club=Db::name("club c")->join("clubadmin ca","c.club_id=ca.club_id")
    	->where("ca.clubadmin_id",$clubadmin_id)->select();

    	$this->assign("club",$club);

        return $this->fetch();

        //测试获取俱乐部列表信息接口
        // return json($club);
    }

    public function edit($club_id)//显示修改信息
    {
    	$club=Db::name('club')->find($club_id);
        $this->assign("club",$club);
        return $this->fetch();

        //测试获取当前俱乐部信息接口
        // return json($club);
    }

    public function updateclub($club_id){//修改俱乐部信息
    	$file = request()->file('club_pic');

    	// dump($file);exit();
    	$club_pic="";
        $club_pic2=input('club_pic2');
        if($file){
        $info = $file->rule('uniqid')->validate(['size'=>64000000,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'club_admin' .DS .'club');
      
        if($info){
        	$club_pic=$info->getFilename();
        	}
        else{
        echo $file->getError();
        	}
        }
		if (request()->isPost()) {
    	//插入数据
        $data=[
        "club_name"=>input('clubname'),
        "club_desc"=>input('clubintro'),
        "club_tel"=>input('clubtel'),
        "club_adress"=>input('clubaddress'),
        "club_otime"=>input('clubopen'),
        "club_etime"=>input('clubclose'),
        'club_pic'=>empty($club_pic)?$club_pic2:$club_pic
        ];
        $validate = \think\Loader::validate('Club');
    		if(!$validate->scene('updateclub')->check($data)){
			   $this->error($validate->getError()); die;
			}
	      if(Db::name('club')->where("club_id",$club_id)->update($data))
	        $this->success('更新成功','lst');
	      else
	        $this->error('更新失败');

    	}

    }



}






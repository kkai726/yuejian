<?php
namespace app\index\controller;
use think\Controller;
use \think\Db;
class Train extends Controller
{
//start lqn

	//测试当前俱乐部训练列表信息接口
	//http://localhost/yuejian5/public/index/train/lists/club_id/1
	public function lists($club_id){
        $lists=db('train')->select();
        return json($lists);
    }

    //测试当前训练详细信息接口
    //http://localhost/yuejian5/public/index/train/detail/club_id/1/train_id/1
	public function detail($club_id,$train_id){
        $detail=db('train')->where('club_id',$club_id)->where('train_id',$train_id)->select();
        return json($detail);
    }

    //测试当前训练报名信息接口
    //http://localhost/yuejian5/public/index/train/trainorder/train_id/1/user_id/4/trainorder_amount/1/trainorder_price/100/trainorder_time/2019070513:00:00/trainorder_ordernum/12687148/trainorder_bmnum/1
    public function trainorder($train_id,$user_id,$trainorder_amount,$trainorder_price,$trainorder_time,$trainorder_ordernum,$trainorder_bmnum){
         $data=[
          'train_id'=>$train_id,
          'uid'=>$user_id,
          'tenter_amount'=>$trainorder_amount,
          'tenter_price'=>$trainorder_price,
          'tenter_time'=>date('Y-m-d H:i:s'),
          'tenter_ordernum'=>$trainorder_ordernum,
          'tpay_status'=>0,
          'tenter_num'=>$trainorder_bmnum
        ]; 

        if(Db::name('tenter')->insert($data)){
            $arrayName = array('success' => 0 );
            return json($arrayName);
        }
        else
        {
           $arrayName = array('success' => 1 );
            return json($arrayName);
        }
    }

    //测试收藏/取消收藏当前训练接口
    //http://localhost/yuejian5/public/index/train/detailcreatefans/user_id/1/train_id/1
    public function detailcreatefans($train_id,$user_id){
        $num=Db::name("focus")->where("tid='$train_id'")->where("uid='$user_id'")->count();//单引号不解析，
        if($num>0) return json(["success"=>0]);
        $data=[
              'uid'=>$user_id,
              'tid'=>$train_id
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

    //测试判断是否收藏当前训练详细信息接口
    // http://localhost/yuejian5/public/index/train/isfolloeTrain/train_id/2/user_id/1
    public function isfolloeTrain($user_id,$train_id){
        $attention_train=Db::name("focus")->where("tid='$train_id'")->where("uid='$user_id'")->count();
        if($attention_train>0)
         return json(["isattention"=>0]);
        else
            return json(["isattention"=>1]);
    }
// end lqn    
}	
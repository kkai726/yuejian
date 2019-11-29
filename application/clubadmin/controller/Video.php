<?php
namespace app\clubadmin\controller;

use app\clubadmin\controller\Base;

use think\Controller;
use think\Session;
use think\Db;
use think\Request;

class Video extends Base
{

    // public function lst()//课程列表
    // {
    // 	$clubadmin_id=Session::get('clubadmin_id');
    // 	$club=Db::name("club")->table('club c,clubadmin ca')->where("c.club_id=ca.club_id and clubadmin_id='$clubadmin_id'")->find();
    // 	$club_id=$club["club_id"];

    //     $course=Db::name("course c")->join("club b","c.club_id=b.club_id")->join("coach ch","c.coach_id=ch.coach_id")->join("level l","c.lid=l.lid")
    //     // ->where("b.club_id",$club_id)
    //     ->select();

    // 	$this->assign("course",$course);

    //     return $this->fetch();

    //     //测试当前俱乐部所有课程列表接口
    //     // return json($course);
    // }
    //  public function lst()//课程列表
    // {
    // 	$clubadmin_id=Session::get('clubadmin_id');
    // 	$club=Db::name("video")->table('video v,clubadmin ca')->where("v.video_id=ca.club_id and clubadmin_id='$clubadmin_id'")->find();
    // 	$club_id=$club["club_id"];

    //     $course=Db::name("course c")->join("club b","c.club_id=b.club_id")->join("coach ch","c.coach_id=ch.coach_id")->join("level l","c.lid=l.lid")
    //     // ->where("b.club_id",$club_id)
    //     ->select();

    // 	$this->assign("course",$course);

    //     return $this->fetch();

    //     //测试当前俱乐部所有课程列表接口
    //     // return json($course);
    // }
    public function lst()
    {
        $clubadmin_id=Session::get('clubadmin_id');
        $info=Db::name("video")->select();
            $info=Db::name("video")->alias('v')->join("clubadmin ca","v.clubadmin_id=ca.clubadmin_id")->join("club c","v.club_id=c.club_id")->select();
        // var_dump($goods);exit;
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function add(){
        return $this->fetch();
    }
    public function doadd()
    {

        if(request()->isPost()){
        $file = request()->file('video_content');
        // dump($file);die;
        if($file){
        $info = $file->rule('uniqid')
        ->validate(['size'=>64000000,'ext'=>'mp4'])
        ->move(ROOT_PATH . 'public' . DS . 'static'.  DS . 'club_admin' .DS .'video');
        
        if($info){
        	$video_content=$info->getFilename();
            }
        else{
            $this->error('格式错误，请重新上传！');
        	}
        }else{
            $this->error('请选择视频！');
        }
        
        $clubadmin_id=Session::get('clubadmin_id');
        // $data=Db::name("video")->select();
        $data=Db::name("video")->alias('v')
        ->join("clubadmin ca","v.clubadmin_id=ca.clubadmin_id")
        ->join("club c","v.club_id=c.club_id")->select();
        // dump($data);die;
        $this->assign('info',$info);
        $uptime=date('Y-m-d H:i:s',time());
        // dump($uptime);die;  


        $data=[
            'video_name'=>input('video_name'),
            'video_desc'=>input('video_desc'),
            'video_time'=>$uptime,
            'video_content'=>$video_content,
            'clubadmin_id'=>$clubadmin_id,
            // 'del_status'=>$del_status,
            'club_id'=>empty($club_id)
        ];
        $res=db('video')->insert($data);
        // dump($res);die;
        if($res){
            $this->success('添加视频成功！','lst');
        }else{
            $this->error('添加视频失败...');
        }
        }
    }

    public function update($video_id)
    {
    //    $video_id=input('video_id');
       $info=Db::name('video')->find($video_id);
    //    dump($info);die;
       $this->assign("info",$info);
       return $this->fetch();
    }
  
    public function doupdate()
    {
        $video_id=input('video_id');
        $clubadmin_id=Session::get('clubadmin_id');
        // $uptime=date('Y-m-d H:i:s',time());
        if(request()->isPost()){
            $data=[
                'video_name'=>input('video_name'),
                'video_desc'=>input('video_desc'),
                // 'video_time'=>empty($uptime),
                'clubadmin_id'=>$clubadmin_id,
                 // 'del_status'=>$del_status,
                'club_id'=>empty($club_id)
            ];
            $res=db('video')->where('video_id',$video_id)->update($data);
            if($res){
                $this->success('修改视频信息成功！','lst');
            }else{
                $this->error('修改视频信息失败...');
            }
            }
        }
        

      public function pub($video_id){
        $status=['video_status'=>1];
        $res=db('video')->where('video_id',$video_id)->update($status);
        if($res){
            $this->success('发布视频成功！','lst');
        }else{
            $this->error('发布视频失败...');
        }
    }
     public function sub($video_id){
        $status=['video_status'=>0];
        $res=db('video')->where('video_id',$video_id)->update($status);
        if($res){
            $this->success('视频下架成功！','lst');
        }else{
            $this->error('视频下架失败...');
        }
    }

 // public function del($video_id)
 //    {
 //        // $video_id=input('video_id');
 //        if(Db::name('video')->delete($video_id)){
 //            $this->success('删除视频成功！','lst');
 //        }else{
 //            $this->error('删除视频失败！');
 //        }
 //    }
     public function del($video_id){
        $status=['del_status'=>1];
        $res=db('video')->where('video_id',$video_id)->update($status);
        if($res){
            $this->success('删除视频成功！','lst');
        }else{
            $this->error('删除视频失败...');
        }
    }

  //    public function show(){
  //       return $this->fetch();
  //   }
  // public function doshow(){
  //       // return $this->fetch();
    
// /**
//  * upload.php
//  *
//  * Copyright 2013, Moxiecode Systems AB
//  * Released under GPL License.
//  *
//  * License: http://www.plupload.com/license
//  * Contributing: http://www.plupload.com/contributing
//  */

// #!! IMPORTANT: 
// #!! this file is just an example, it doesn't incorporate any security checks and 
// #!! is not recommended to be used in production environment as it is. Be sure to 
// #!! revise it and customize to your needs.


// // Make sure file is not cached (as it happens for example on iOS devices)
// header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// header("Cache-Control: no-store, no-cache, must-revalidate");
// header("Cache-Control: post-check=0, pre-check=0", false);
// header("Pragma: no-cache");

// /* 
// // Support CORS
// header("Access-Control-Allow-Origin: *");
// // other CORS headers if any...
// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//    exit; // finish preflight CORS requests here
// }
// */

// // 5 minutes execution time
// @set_time_limit(5 * 60);

// // Uncomment this one to fake upload time
// // usleep(5000);

// // Settings
// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
// //$targetDir = 'uploads';
// $cleanupTargetDir = true; // Remove old files
// $maxFileAge = 5 * 3600; // Temp file age in seconds


// error_log(var_export($_REQUEST,true),3,'/home/zhouyu/txt.log');

// // Create target dir
// if (!file_exists($targetDir)) {
//    @mkdir($targetDir);
// }

// // Get a file name
// if (isset($_REQUEST["name"])) {
//    $fileName = $_REQUEST["name"];
// } elseif (!empty($_FILES)) {
//    $fileName = $_FILES["file"]["name"];
// } else {
//    $fileName = uniqid("file_");
// }

// $filePath = "E:\wampp\wamp\www\yuejian5\public\static\club_admin\video\$fileName";


// // Chunking might be enabled
// $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
// $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// // Remove old temp files   
// if ($cleanupTargetDir) {
//    if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
//       die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
//    }

//    while (($file = readdir($dir)) !== false) {
//       $tmpfilePath ="E:\wampp\wamp\www\yuejian5\public\static\club_admin\video\$file";

//       // If temp file is current file proceed to the next
//       if ($tmpfilePath == "{$filePath}.part") {
//          continue;
//       }

//       // Remove temp file if it is older than the max age and is not the current file
//       if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
//          @unlink($tmpfilePath);
//       }
//    }
//    closedir($dir);
// }  


// // Open temp file
// if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
//    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
// }

// if (!empty($_FILES)) {
//    if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
//       die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
//    }

//    // Read binary input stream and append it to temp file
//    if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
//       die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
//    }
// } else {   
//    if (!$in = @fopen("php://input", "rb")) {
//       die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
//    }
// }

// while ($buff = fread($in, 4096)) {
//    fwrite($out, $buff);
// }

// @fclose($out);
// @fclose($in);

// // Check if file has been uploaded
// if (!$chunks || $chunk == $chunks - 1) {
//    // Strip the temp .part suffix off 
//    rename("{$filePath}.part", $filePath);
// }

// // Return Success JSON-RPC response
// die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

// }
}

?>












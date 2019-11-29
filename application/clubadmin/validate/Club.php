<?php
namespace app\clubadmin\validate;
use think\Validate;
class Club extends Validate
{
    protected $rule = [
        'club_name'  =>  'require',
        'club_pic' =>  'require',
        'club_desc' =>  'require',
        'club_tel' =>  'require|max:11',
        'club_etime' =>  'require|time',
        'club_otime' =>  'require|time',
        'club_adress' =>  'require'
    ];

    protected $message  =   [
        'club_name.require' => '俱乐部名称必须填写',
        'club_pic.require' => '必须选择图片',
        'club_desc.require' => '必须填写俱乐部简介',
        'club_tel' => '必须正确填写俱乐部电话号码',
        'club_otime.require' => '必须填写俱乐部开放时间',
        'club_otime.date' => '必须正确填写俱乐部开放时间',
        'club_etime.require' => '必须填写俱乐部关闭时间',
        'club_etime.date' => '必须正确填写俱乐部关闭时间',
        'club_adress.require' => '俱乐部地址必须填写',
    ];

    protected $scene = [
        
        'updateclub'  =>  [
            'club_name'  =>  'require',
            'club_pic' =>  'require',
            'club_desc' =>  'require',
            'club_tel' =>  'require|max:11',
            'club_etime' =>  'require|date',
            'club_otime' =>  'require|date',
            'club_adress' =>  'require'
        ],
    ];




}

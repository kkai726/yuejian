<?php
namespace app\clubadmin\validate;
use think\Validate;
class Course extends Validate
{
    protected $rule = [
        'course_name'  =>  'require',
        'course_pic' =>  'require',
        'course_desc' =>  'require',
        'course_otime' =>  'require|date',
        'course_address' =>  'require'
    ];

    protected $message  =   [
        'course_name.require' => '课程名称必须填写',
        'course_pic.require' => '必须选择图片',
        'course_desc.require' => '必须填写课程简介',
        'course_otime.require' => '必须填写开课时间',
        'course_otime.date' => '必须正确填写开课时间',
        'course_address.require' => '课程地址必须填写',
    ];

    protected $scene = [
        'doaddcourse'  =>  [
            'course_name'  =>  'require',
            'course_post' =>  'require',
            'course_desc' =>  'require',
            'course_otime' =>  'require|date',
            'course_address' =>  'require'
        ],
        'updatecourse'  =>  [
            'course_name'  =>  'require',
            'course_post' =>  'require',
            'course_desc' =>  'require',
            'course_otime' =>  'require|date',
            'course_address' =>  'require'
        ],
    ];




}
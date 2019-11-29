<?php
namespace app\supadmin\validate;
use think\Validate;
class Match extends Validate
{
    protected $rule = [
        'match_name'  =>  'require',
        'match_post' =>  'require',
        'match_desc' =>  'require',
        'match_time' =>  'require|date',
        'match_etime' =>  'require|date',
        'match_stime' =>  'require|date',
        'match_limit' =>  'require|number',
        'match_address' =>  'require'
    ];

    protected $message  =   [
        'match_name.require' => '比赛名称必须填写',
        'match_post.require' => '必须选择图片',
        'match_desc.require' => '必须填写比赛简介',
        'match_time.require' => '必须填写比赛时间',
        'match_time.date' => '必须正确填写比赛时间',
        'match_stime.require' => '必须填写比赛开始报名时间',
        'match_stime.date' => '必须正确填写比赛报名时间',
        'match_etime.require' => '必须填写比赛结束报名时间',
        'match_etime.date' => '必须正确填写比赛结束报名时间',
        'match_limit.require' => '比赛限制人数必须填写',
        'match_limit.number' => '比赛限制人数必须为数字',
        'match_address.require' => '比赛地址必须填写',
    ];

    protected $scene = [
        'doadd'  =>  [
            'match_name'  =>  'require',
            'match_post' =>  'require',
            'match_desc' =>  'require',
            'match_time' =>  'require|date',
            'match_etime' =>  'require|date',
            'match_stime' =>  'require|date',
            'match_limit' =>  'require|number',
            'match_address' =>  'require'
        ],
        'doedit'  =>  [
            'match_name'  =>  'require',
            'match_post' =>  'require',
            'match_desc' =>  'require',
            'match_time' =>  'require|date',
            'match_etime' =>  'require|date',
            'match_stime' =>  'require|date',
            'match_limit' =>  'require|number',
            'match_address' =>  'require'
        ],
        'doedit_p'  =>  [
            'match_name'  =>  'require',
            'match_desc' =>  'require',
            'match_time' =>  'require|date',
            'match_etime' =>  'require|date',
            'match_stime' =>  'require|date',
            'match_limit' =>  'require|number',
            'match_address' =>  'require'
        ],
    ];




}

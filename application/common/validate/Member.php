<?php


namespace app\common\validate;


use think\Validate;

class Member extends Validate
{
    //通用验证
    protected $rule = [
        'username|用户名' => 'require',
        'password|密码' => 'require',
        'conpass|确认密码' => 'require|confirm:password',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|unique:member|email',
        'captcha|验证码'=>'require|captcha'
    ];

    //场景验证
    protected $scene = [
        'sceneAdd' => ['username'=>'unique:member','password','nickname','email'],
        'sceneEdit' => ['username','nickname','email'],
        'sceneRegister' => ['username','password','conpass','email','nickname','captcha'],
        'sceneLogin' => ['username','password','captcha']
    ];

}
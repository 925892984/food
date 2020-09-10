<?php


namespace app\common\validate;

use think\Validate;

class Admin extends  Validate
{
//    通用验证
    protected $rule = [
    'username|管理员账户' => 'require',
    'password|账户密码' => 'require',
    'repassword|确认密码'=>'require|confirm:password',
    'nickname|昵称' => 'require',
    'email|邮箱' => 'email|require',
    'code|重置密码' => 'require',
    'sort|排序' => 'require',
     'id|ID' => 'require'
];
//验证场景
    protected $scene = [
        //    登陆验证场景
        'sceneLogin' => ['email','password'],
        //邮箱格式验证
        'sceneEmail' => ['email'=>'email|require|unique:admin'],
        //    注册场景验证
        'sceneRegister' => ['email'=>'email|require|unique:admin','password','repassword'],
        //    忘记密码场景验证
        'sceneForget' => ['password','repassword'],
//        重置密码验证场景
        'sceneReset' => ['code'],
//        栏目添加验证
        'sceneAdd' => ['catename','sort'],
//        排序验证场景
        'sceneSort' => ['sort','id'],
//        编辑验证场景
        'sceneEdit' => ['catename'],
        'sceneAdminEdit' => ['username' => 'require|unique:admin','nickname','email'=>'require|unique:admin']
    ];
}

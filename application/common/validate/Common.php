<?php


namespace app\common\validate;

use think\Validate;

class Common extends  Validate
{
//    通用验证
    protected $rule = [
        'nickname|用户名' => 'require|unique:common',
        'password|账户密码' => 'require',
        'repassword|确认密码'=>'require',
        'username|姓名' => 'require',
        'dep|科室' => 'require',
        'newPassword|新密码' => 'require'
];
//验证场景
    protected $scene = [
        //    添加管理员验证
        'sceneAdd' => ['nickname','password','repassword','username','department'],
        //    完全校验---修改管理员验证
        'sceneEdit' => ['nickname','password','repassword','username','department'],
        //    部分校验---修改管理员验证
        'scenePartEdit' => ['nickname','username','department'],
    ];
}

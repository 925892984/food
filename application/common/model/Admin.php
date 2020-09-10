<?php

namespace app\common\model;
//use think\model\concern\SoftDelete;
use	traits\model\SoftDelete;
use think\Model;
use think\Db;

class Admin extends Model
{
    //软删除
    use SoftDelete;
    // 登录校验
    public function  login($data)
    {
        $validate = new \app\common\validate\Admin();
        $result	= $validate->scene('sceneLogin')->check($data);
        if (!$result){
            return $validate->getError();
        }
        $result = $this->where($data)->find();
        if($result){
//            检查账户是否可用,status为1可用，
            if($result['status'] != 1) {
                return '此账户被禁用';
            }
//            登陆成功后保存状态
            $sessionData = [
                'id' =>$result['id'],
                'username'=>$result['email']
            ];
            session('admin',$sessionData);
//            1表示有这个用户，用户名和密码正确
            return 1;
        }else{
            return '用户名或密码错误！';
        }
    }
    //邮箱格式校验
    public  function getSms($data){
        $validate = new \app\common\validate\Admin();
        //先验证是注册还是忘记密码，如果是忘记密码，验证邮箱，未注册提示去注册，已注册正常发送验证码不报邮箱已存在
        $result	= $validate->scene('sceneEmail')->check($data);
        if($data['type'] == 'forget'){
            if (!$result) {//邮箱已注册，验证发送验证密码
                return 1;
            }else{
                return '邮箱未注册，请前往注册页面';
            }
        }else{
            if (!$result) {
                return $validate->getError();
            }else{
                return 1;
            }
        }

    }
    //注册
    public  function register($data){
        $validate = new \app\common\validate\Admin();
        $result	= $validate->scene('sceneRegister')->check($data);
        if (!$result) {
            return $validate->getError();
        }
        if ($data['code'] != session('mobile_code')) {
            return '验证码不正确!';
        }
        $result = $this->allowField(true) -> save($data);
        if($result) {
            return 1;
        } else {
            return '注册失败!';
        }
    }
    //忘记密码
    public  function forget($data){
        $validate = new \app\common\validate\Admin();
        //先验证邮箱是否注册
        $result	= $validate->scene('sceneEmail')->check($data);
        if (!$result){//邮箱已注册
            $result1 = $validate->scene('sceneForget')->check($data);
            if (!$result1) {
                return $validate->getError();
            }
            if ($data['code'] != session('mobile_code')) {
                return '验证码不正确!';
            }
            $res = model('admin')->allowField(true)->isUpdate(true,['email'=>$data['email']])->save(['password'=>$data['password']]);
            if($res) {
                return 1;
            } else {
                return '修改密码失败!';
            }
        }else{//邮箱未注册
            return '邮箱未注册，请注册！';
        }
    }

//   重置密码
    public function add($data)
    {
        $validata = new \app\common\validate\Admin();
        if(!$validata->scene('$sceneReset')->check($data)) {
            $validata->getError();
        }
        if ($data['code'] != session('code')) {
            return '验证码不正确!';
        }

        if($result) {
            return 1;
        } else {
            return '密码重置失败！';
        }
    }

    //添加管理员
    public  function adminAdd($data){
        $validate = new \app\common\validate\Admin();
        $result	= $validate->scene('sceneRegister')->check($data);
        if (!$result) {
            return $validate->getError();
        }
        $result = $this->allowField(true) -> save($data);
        if($result) {
            return 1;
        } else {
            return '添加失败!';
        }

    }

    //更新管理员信息
    public function edit($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('sceneAdminEdit')->check($data)) {
            return $validate->getError();
        }
        $adminInfo = $this->find($data['id']);
        $adminInfo->nickname = $data['nickname'];
        $adminInfo->username = $data['username'];
        $adminInfo->email = $data['email'];
        $result = $adminInfo -> save();
        if ($result) {
            return 1;
        } else {
            return '编辑失败！';
        }
    }

}



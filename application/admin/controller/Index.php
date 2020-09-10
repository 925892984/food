<?php

namespace app\admin\controller;

use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use think\Controller;
use think\Model;

class Index extends Controller
{
    //    后台登陆
    public function login()
    {
//        return $this->view();
        if (request()->isAjax()){
            //接收数据，input()可接受数据
            $data = [
                'email'=>input('post.email'),
                'password'=>input('post.password')
            ];
//去common中找model，common中放公共model，助手函数model(),首先会去相应控制器（即admin）中找model，
//如果没有，就去commom中寻找
//          new \app\common\model\Admin();
            $result = model('Admin')->login($data);
            if($result == 1){
                return $this->success('登陆成功','admin/home/index');
            }else{
                return $this->error($result);
            }
        }
        return view();
    }

    //后台注册
    public function register(){
        if (request()->isAjax()){
            $data = [
                'email' => input('post.email'),
                'password' => input('post.password'),
                'repassword' => input('post.repassword'),
                'code' => input('post.code')
            ];
            $result = model('Admin')->register($data);
            if ($result == 1){
                return $this->success('注册成功！','admin/index/login');
            }else{
                return $this->error($result);
            }
        }
        return view();
    }

    //点击发送验证码，进行数据校验
    public function getSms(){
        if(request()->isAjax()){
            $data = json_decode(file_get_contents("php://input"), true);
            //判断是忘记密码还是注册账户
            if($data['type'] == 'forget'){
                //对email进行判断
                //1、email格式是否符合规范
                //2.email是否已注册，未注册则提示去注册
                $result = model('Admin')->getSms($data);
                header('Content-Type:application/json');//加上这行,前端那边就不需要var result = $.parseJSON(data);
                if($result == 1){
                    $title = '【远安人民医院用餐系统】';
                    $content = '此密码禁止给他人使用,你的设置新密码验证码是:';
                    $send_data =   $this->sendSms($data['email'],$title,$content);
                    if ($send_data == 1){
                        return $this->success('邮箱验证码发送成功，请注意查收');
                    }else{
                        return $this->error($send_data);
                    }
                }else{
                    return $this->error($result);
                }
            }
            if($data['type'] == 'register'){
                //对email进行判断
                //1、email格式是否符合规范
                //2.email是否已注册，避免重复注册
                $result = model('Admin')->getSms($data);
                header('Content-Type:application/json');//加上这行,前端那边就不需要var result = $.parseJSON(data);
                if($result == 1){
                    $title = '【远安人民医院用餐系统】';
                    $content = '此密码禁止给他人使用,你的注册验证码是:';
                    $send_data =   $this->sendSms($data['email'],$title,$content);
                    if ($send_data == 1){
                        return $this->success('邮箱验证码发送成功，请注意查收');
                    }else{
                        return $this->error($send_data);
                    }
                }else{
                    return $this->error($result);
                }
            }
        }
    }

    //发送验证码
    public function sendSms($email,$title,$content){
        $code = rand(100000,999999);
        session('mobile_code',$code);
//        session('session_start_time',time(),'yzm');
        $result = mailto($email,$title,$content.$code);
        echo session('mobile_code');
        header('Content-Type:application/json');//加上这行,前端那边就不需要var result = $.parseJSON(data);
        if($result){
            return 1;
        }else{
            return $this->error($result);
        }
    }

    // 忘记密码
    public  function forget()
    {
        if (request()->isAjax()){
            $data = [
                'email' => input('post.email'),
                'password' => input('post.password'),
                'repassword' => input('post.repassword'),
                'code' => input('post.code')
            ];
            $result = model('Admin')->forget($data);
            if ($result == 1){
                return $this->success('设置新密码成功！','admin/index/login');
            }else{
                return $this->error($result);
            }
        }
        return view();
    }

}

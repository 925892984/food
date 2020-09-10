<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\model;


class Common extends Controller
{
    //普通管理员列表
    public function commonList() {
        $commonList = model('common')->order(['status' => 'desc','id' => 'desc'])->select();
        $this->assign('commonList', $commonList);
        return view();
    }

    //添加管理员
    public function add() {
        if (request()->isAjax()){
            $data = [
                'nickname' => input('post.nickname'),
                'password' => input('post.password'),
                'repassword' => input('post.repassword'),
                'username' => input('post.username'),
                'dep' => input('post.department')
            ];
            $result = model('Common')->add($data);
            if($result == 1){
                return $this->success('添加管理员成功！','/admin/common/commonList');
            }else{
                return $this->error($result);
            }
        }
        return view();
    }

    //编辑普通管理员
    public function edit() {
        if (request()->isAjax()){
            $data = [
                'nickname' => input('post.nickname'),
                'password' => input('post.password'),
                'newPassword' => input('post.newPassword'),
                'username' => input('post.username'),
                'dep' => input('post.department')
            ];
            $result = model('Common')->edit($data);
            if($result == 1){
                return $this->success('保存成功！','/admin/common/commonList');
            }else{
                return $this->error($result);
            }
        }
        $commonInfo = model('common')->find(input('id'));
        $this->assign('commonInfo',$commonInfo);
        return view();
    }
}

<?php

namespace app\common\model;
use	traits\model\SoftDelete;
use think\Model;


class Common extends Model
{
    //软删除
    use SoftDelete;

    //添加管理员
    public function add($data)
    {
        $validate = new \app\common\validate\Common();
        $result = $validate->scene('sceneAdd')->check($data);
        if (!$result) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        } else {
            return '添加失败!';
        }
    }

    //修改管理员
    public function edit($data)
    {
        $validate = new \app\common\validate\Common();
//        if (!$data['password']){
//            //前端没有填写密码，只校验部分字段
//            $result = $validate->scene('scenePartEdit')->check($data);
//        }
//        if ($data['password']){
//            $result = $validate->scene('sceneEdit')->check($data);
//        }
//        if (!$result) {
//            return $validate->getError();
//        }
        $result = $validate->scene('sceneEdit')->check($data);
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        } else {
            return '添加失败!';
        }

    }
}

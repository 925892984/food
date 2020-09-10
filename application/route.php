<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];

//后台路由
Route::group('admin',function (){
    Route::rule('/','admin/index/login','get|post');
    Route::rule('register','admin/index/register','get|post');
    Route::rule('getSms','admin/index/getSms','get|post');
    Route::rule('forget','admin/index/forget','get|post');
    Route::rule('login','admin/index/login','get|post');
    Route::rule('index','admin/home/index','get|post');
    Route::rule('commonList','admin/common/commonList','get|post');
    Route::rule('commonAdd','admin/common/add','get|post');
    Route::rule('commonEdit/[:id]','admin/common/edit','get|post');
});

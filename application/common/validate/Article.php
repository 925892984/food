<?php


namespace app\common\validate;

use think\Validate;
class Article extends  Validate
{
    //通用验证
    protected $rule = [
        'title|文章标题' => 'require|unique:article',
        'tags|标签' => 'require',
        'cateid|所属栏目' => 'require',
        'desc|文章概要' => 'require',
        'content|文章内容' => 'require',
        'is_top' => 'require'
    ];
    //场景验证
    protected $scene = [
        'sceneAdd' => ['title','tags','cateid','desc','content'],
        'sceneEdit' => ['title','tags','cateid','desc','content','is_top']
    ];

}
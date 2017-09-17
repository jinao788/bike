<?php
namespace app\admin\validate;
use think\Validate;
class Link extends Validate
{
     protected $rule = [
        'title'  =>  'require|max:25|unique:link',
        'url' =>  'url|require|unique:link',
    ];

     protected $message  =   [
        'title.require' => '链接名称不能为空',
        'title.max' => '名称不得多于25个字符',
        'title.unique' => '链接名称已经存在',
        'url.unique' => '链接地址已经存在',
        'url.require' => '链接地址不能为空',
         'url.url' => '链接地址格式错误',
        
        
    ];

     protected $scene = [
        
    ];
    



        
    

 




}

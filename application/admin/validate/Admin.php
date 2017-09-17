<?php
namespace app\admin\validate;
use think\Validate;
class Admin extends Validate
{
     protected $rule = [
        'name'  =>  'require|min:3|max:25|unique:admin',
        'password' =>  'require|min:6|max:32',
    ];

     protected $message  =   [
        'name.require' => '管理员名称不能为空',
        'name.min' => '名称必须在3-25个字符之间',
        'name.max' => '名称必须在3-25个字符之间',
        'name.unique' => '名称已经存在',
        'password.min' => '密码不能少于六位',
        'password.max'     => '密码过长',
        'password.require' => '密码不能为空',
        
        
    ];

     protected $scene = [
        
    ];
    



        
    

 




}

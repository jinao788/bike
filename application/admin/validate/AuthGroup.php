<?php
namespace app\admin\validate;
use think\Validate;
class AuthGroup extends Validate
{
     protected $rule = [
        'title'  =>  'require|unique:link',
        'rules' =>  'require',
    ];

     protected $message  =   [
        'title.require' => '用户组名称不能为空',
       
       
        'rules.require' => '用户组权限不能为空',
         
        
    ];

     protected $scene = [
        
    ];
    



        
    

 




}

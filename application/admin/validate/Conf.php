<?php
namespace app\admin\validate;
use think\Validate;
class Conf extends Validate
{
     protected $rule = [
        'type'  =>  'require',
        'cnname'  =>  'require|unique:conf',
        'enname'  =>  'require|unique:conf',
        
    ];

     protected $message  =   [
        'type.require' => '配置类型不能为空',
        'cnname.require' => '中文名称不能为空',
        'cnname.unique' => '中文名称已经存在',
        'enname.require' => '英文名称不能为空',
        'enname.unique' => '英文名称已经存在',
        
        
        
    ];

     protected $scene = [
     	 'edit' =>['cnname','enname'],
        
    ];
    



        
    

 




}

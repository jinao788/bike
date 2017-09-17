<?php
namespace app\admin\validate;
use think\Validate;
class Cate extends Validate
{
      protected $rule = [
        'catename'  =>  'require|max:25|unique:cate',
       
        
    ];

     protected $message  =   [
        'catename.require' => '栏目名称不能为空',
        'catename.max' => '名称不得多于25个字符',
        'catename.unique' => '栏目名称已经存在',
       
        
        
    ];

     protected $scene = [
       // 'edit' =>['catename'=>'require|max:25' //|unique:cate
       // ],
    ];
    



        
    

 




}

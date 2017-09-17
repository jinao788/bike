<?php
namespace app\admin\validate;
use think\Validate;
class Article extends Validate
{
     protected $rule = [
        'title'  =>  'require|max:120|unique:article',
        'cateid'  =>  'require',
        'content'  =>  'require',
       
    ];

     protected $message  =   [
        'title.require' => '文章标题不能为空',
        'title.max' => '标题不得多于120个字符',
        'title.unique' => '文章标题已经存在',
        'cateid.require' => '所属栏目不能为空',
        'content.require' => '文章内容不能为空',
        
        
        
    ];

     protected $scene = [ 
        'edit' =>['title','content'],
        
    ];
    



        
    

 




}

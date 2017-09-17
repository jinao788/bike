<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
class Base extends Controller
{
    public function _initialize()
    {
        if(!session('name') || !session('id')){
            $this->error('请先登录','login/index');
        }

        $auth = new Auth();
        $request=Request::instance();
        $con=$request->controller();
        $action=$request->action();
        $name=$con.'/'.$action;
        $notCheck=array('Index/index','Admin/logout');
        if(session('id')!=1){
        	if(!in_array($name,$notCheck)){
        		if(!$auth->check($name,session('id'))){
        		$this->error('没有权限','index/index');
        		}
        	}
        	
        }
       
        
    }

}

<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin;
//use think\Db;
class Login extends Controller
{
   /* public function index()
    {
       if(request()->isPost()){
 			$admin=new Admin();
            $data=input('post.');
            $num=$admin->login($data);
            if($num==3){
	       		$this->success('信息正确,正在跳转','index/index');
			}elseif($num==4){
                $this->error('验证码错误');
            }
            else{
                $this->error('用户名或者密码错误');
            }

        }
        return $this->fetch('login');
    }*/

        public function index()
        {
            if(request()->isPost()){
            	$this->check(input('code'));
                $admin=new Admin();
                $num=$admin->login(input('post.'));
                if($num=='1'){
                  $this->  error('用户不存在');
                }
                if($num=='2'){
                  $this->  success('登陆成功',('index/index'));
                }
                if($num=='3'){
                   $this-> error('密码错误');
                }
                return;
            }    
            return view('login');
        }

//******************************************************************
         public function check($code='')
    {
        if (!captcha_check($code)) {
            $this->error('验证码错误');
        } else {
            return true;
        }
    }
}

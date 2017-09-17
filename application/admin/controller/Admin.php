<?php
namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use app\admin\controller\Base;
//use think\Db;
class Admin extends Base
{
    //使用模型方法获取数据
    public function lst()
    {
        $auth=new Auth();
        $admin = new AdminModel();
        $adminres = $admin->getadmin();
       // dump($adminres);die; //需要连auth_group表查status不为0的
        $authOnRes=db('auth_group_access')->alias('a')->join('bk_admin b','a.uid=b.id')
                                                      ->join('bk_auth_group c','a.group_id=c.id')
                                             ->where('c.status','neq','0')
                                             ->field('b.id,b.name,c.title')->select();//->paginate(4);//
//dump($authOnRes);die;

        $this->assign(['authOnRes'=>$authOnRes]);
        return view();
    }
       

        
//********************************************************************
/*    public function add()
    {

        if(request()->isPost()){
    		
           $data=[
              
    			'name'=>input('name'),
    			'password'=>input('password'),
    		];

//dump($data);die;
    		$validate = \think\Loader::validate('Admin');
    		if(!$validate->check($data)){
			   $this->error($validate->getError()); die;
			}

			$data=[
                
    			'name'=>input('name'),
    			'password'=>md5(input('password')),
    		];
//dump($data);die;
    		$res=db('admin')->insert($data) ;

        //$res=Db::name('admin')->insert(input('post.'));
        //$res=\think\Db::name('admin')->insert(input('post.'));
                if($res){
                   $this->success('添加管理员成功！',url('lst'));
                }else{
                   $this->error('添加管理员失败!');   			
    		    }
    		    return;
    	}
         
    	    return view();

    }
*/       

//用model方法的add
        public function add()
    {
         if(request()->isPost()){
            $data=[
                
                'name'=>input('name'),
                'password'=>input('password'),
            ];

//dump($data);die;
            $validate = \think\Loader::validate('Admin');
            if(!$validate->check($data)){
               $this->error($validate->getError()); die;
            }

            $data=[
                'name'=>input('name'),
                'password'=>md5(input('password')),
            ];
//dump($data);die;


            $admin = new AdminModel();
            if($admin -> addadmin($data)){  
               $this->success('添加管理员成功！',url('lst'));
            }else{
               $this->error('添加管理员失败!');            
            }
            return;
        }
        $authGroupres=db('auth_group')->select();
        $this->assign('authGroupres',$authGroupres);
        return view();
    
    }

//*********************************************************************

    public function edit()
    {
        $id=input('id');
        $admins=db('admin')->find($id);

        if(request()->isPost()){
            $data=[
                'id'=>input('id'),
                'name'=>input('name')];
            //dump($data);die;

                if(input('password')){
                    $data['password']=input('password');
                    //dump($data);die;
                    $validate = \think\Loader::validate('Admin');
                    if(!$validate->check($data)){
                    $this->error($validate->getError()); die;
                    }
                    
                    $data=[
                        'id'=>input('id'),
                        'name'=>input('name'),
                        'password'=>md5(input('password'))
                        ];
                    
                }else{
                    
                    $data=[
                        'id'=>input('id'),
                        'name'=>input('name'),
                        'password'=>$admins['password']
                    ];

                    $validate = \think\Loader::validate('Admin');
                    if(!$validate->check($data)){
                    $this->error($validate->getError()); die;
                    }

                }
                    //dump(input('post.'));die;
                    //dump(input('group_id'));die;
                    $auth_group_access=db('auth_group_access')->where(array('uid'=>$data['id']))->update(['group_id'=>input('group_id')]);
                    //dump($auth_group_access);die;
                    //dump(db('admin')->update($data));die;
                    if (db('admin')->update($data)||$auth_group_access) {
                        $this->success('修改管理员成功','lst');
                    }else{
                        $this->error('修改管理员失败!');
                    }
                 return;   
        }
        
        $authGroupres=db('auth_group')->select();
        $authGroupAccess=db('auth_group_access')->where(array('uid'=>$id))->find();
        $this->assign('groupId',$authGroupAccess['group_id']);
        $this->assign('authGroupres',$authGroupres);
        $this->assign('admins',$admins);
        return $this->fetch();
    
}
    
    //使用模型方法修改  
/*    public function edit()
    {   

            $id=input('id');
            $admins=db('admin')->find($id);
        if(request()->isPost()){

            $data=[
                'id'=>input('id'),
                'name'=>input('name'),
            ];

                if(input('password')){

                    $data['password']=input('password');
                    
                    $validate = \think\Loader::validate('Admin');
                    if(!$validate->check($data)){
                    $this->error($validate->getError()); die;
                    }

                $data['password']=md5(input('password'));

                    
//dump($data);die;
            }else{
                $data['password']=$admins['password'];
            
                $validate = \think\Loader::validate('Admin');
                if(!$validate->check($data)){
                $this->error($validate->getError()); die;
                }
//dump($data);die;
            }
//dump($data);die;
                $admin=new AdminModel;
                $res=$admin->saveadmin($data);
                //dump($res);die;
                if ($res) {
                    $this->success('修改管理员成功','lst');
                    }else{
                    $this->error('修改管理员失败!');
                    }
                    return;
            }   
            $this->assign('admins',$admins);
            return $this->fetch();
}*/

//*************************************************************************
 /*   public function del()
    {
        $id=input('id');
        if ($id !== '1'){
                if(db('admin')->delete(input('id'))){
                    $this->success('删除管理员成功','lst');
            }else{
                    $this->error('删除管理员失败');
            }
        }else{
            $this->error('初始化管理员不得删除');
        }
    }*/

    //使用模型方法
    public function del($id)
    {
       
        if ($id !== '1'){
            $admin=new AdminModel();
            $delnum=$admin->deladmin($id);
            if($delnum=1){
                $this->success('删除管理员成功','lst');
            }else{
                $this->error('删除管理员失败');
            }
        }else{
            $this->error('初始化管理员不得删除');
        } 
    }
//************************************************************
     public function logout(){
        session(null);
        $this->success('退出成功','login/index');
     }


}

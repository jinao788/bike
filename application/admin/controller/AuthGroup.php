<?php
namespace app\admin\controller;

use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\controller\Base;
//use think\Db;
class AuthGroup extends Base
{
    public function lst(){
        $authGroupres=AuthGroupModel::paginate(10);
        $this->assign('authGroupres',$authGroupres);
        return view();
    }
//***********************************************************
   public function add(){
     if(request()->isPost()){
        $data=input('post.');

         $validate = \think\Loader::validate('auth_group');
            if(!$validate->check($data)){
               $this->error($validate->getError()); die;
            }

        if($data['rules']){
            $data['rules']=implode(',',$data['rules']);
        }
        $add=db('auth_group')->insert($data);
        if($add){
                $this->success('添加用户组成功','lst');
            }else{
                 $this->error('添加用户组失败');
            }
        return;
    }
     $authRule=new \app\admin\model\AuthRule();
     $authRuleRes=$authRule->authRuleTree();
     $this->assign('authRuleRes',$authRuleRes);
        


        return view();
    }

//***********************************************************
   public function del(){
        $del=db('auth_group')->delete(input('id'));
        if($del){
                $this->success('删除用户组成功','lst');
            }else{
                 $this->error('删除用户组失败');
            }
        }

//***********************************************************
   public function edit(){

      if(request()->isPost()){
        $data=input('post.');

        $validate = \think\Loader::validate('auth_group');
            if(!$validate->check($data)){
               $this->error($validate->getError()); die;
            }
            
        if($data['rules']){
            $data['rules']=implode(',',$data['rules']);
        }
        if(empty($data['status'])){
            $data['status']=0;
        }
        $update=db('auth_group')->update($data);
        if($update){
                $this->success('修改用户组成功','lst');
            }else{
                 $this->error('修改用户组失败');
            }
            return;
        }
        $authRule=new \app\admin\model\AuthRule();
         $authRuleRes=$authRule->authRuleTree();
         $this->assign('authRuleRes',$authRuleRes);

        $authGroupres=db('auth_group')->find(input('id'));
         $this->assign('authGroupres',$authGroupres);
        return view();
    }






}
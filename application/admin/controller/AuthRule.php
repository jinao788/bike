<?php
namespace app\admin\controller;

use app\admin\model\AuthRule as AuthRuleModle;
use app\admin\controller\Base;
//use think\Db;
class AuthRule extends Base
{
    public function lst(){
         $authRule=new AuthRuleModle();
        if(request()->isPost()){
            //$sortres=input('post.');
            $sortres = array_filter(input('post.'));
            
            foreach ($sortres as $k => $v) {
                $authRule->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新栏目排序成功','lst');
            return;
        }
       
        $authRuleres=$authRule->authRuleTree();
        //dump($authRuleres);die;
        $this->assign('authRuleres',$authRuleres);
      
        return view();
    }
//***********************************************************


    public function add(){

      if(request()->isPost()){
        $data=input('post.');
         
         $validate = \think\Loader::validate('auth_rule');
            if(!$validate->check($data)){
               $this->error($validate->getError()); die;
            }

        $plevel=db('auth_rule')->where('id',$data['pid'])->field('level')->find();
           if($plevel){  //直接数据库设计顶级分类level值为-1 
            $data['level']=$plevel['level']+1;
            }else{
            $data['level']=0;
         }
       
        $add=db('auth_rule')->insert($data);
        if($add){
                $this->success('添加权限成功','lst');
        }else{
                 $this->error('添加权限失败');
        }
        return;
    }
      $authrule=new AuthRuleModle();
        $authruleres=$authrule->authruleTree();
        //dump($authRuleres);die;
        $this->assign('authruleres',$authruleres);
     return view();
    }

//***********************************************************


    public function edit(){
        if(request()->isPost()){
            $data=input('post.');

             $validate = \think\Loader::validate('auth_rule');
            if(!$validate->check($data)){
               $this->error($validate->getError()); die;
            }
            //dump($data);die;
            //$level=db('auth_rule')->field('level')->find();
            $authrule=new AuthRuleModle();
            $authRuleIds= $authrule->getchilrenid($data['id']);
            //dump($authRuleIds);die; //

            if(in_array($data['pid'],$authRuleIds)){
                $this->error('别作死好吗');
                die;

            }
            
            
            //原来母级权限
            $preRule=db('auth_rule')->where('id',$data['id'])->field('pid,level')->find();  
            $preRule=$preRule['level'];
            //dump($preRule);die;  //int
            
            //提交过来的母级权限没有level字段,必须先保存再读取其父级权限再+1
            //postRule是母级权限level 的int值
            //dump($data['pid']);die;
            if($data['pid']){
                    $data['level']=db('auth_rule')->where('id',$data['pid'])->field('level')->find();
                    //dump($data['level']['level']);die;  //int
                    $postRule=$data['level']['level']+1;   //int   
                   //
                }else{
                    $postRule=intval(0); //=$data['level']['level']
                    //dump($data['level']['level']);die;  //int
                }
            //dump($postRule);die; 




            $postRule1=intval($postRule); 
            //dump($postRule1);die;
            if($preRule === $postRule1){
                $save=db('auth_rule')->update($data);
            }else{
               //差值
                $a=$preRule-$postRule1;
                //dump($a);die;

                //原来母权限下的全部子权限id
                //默认都有子权限,递归获取子权限id
                $authrule=new AuthRuleModle();
                $authRuleIds= $authrule->getchilrenid($data['id']);
                //dump($authRuleIds);die; //子权限是一维数组或者空
                //$chilRuleId=array_unique($chilRuleId);
                if($authRuleIds){
                    foreach ($authRuleIds as $k => $v) {
                         $b=db('auth_rule')->where('id',$v)->field('level')->select();
                         //dump($b);die;
                         $c=$b[0]['level']-$a;
                         //dump($c);die;
                      $savechild=db('auth_rule')->where('id',$v)->update(['level'=>$c]);
                    }
                    $saveparent=db('auth_rule')->where('id',$data['id'])->update(['level'=>$postRule,'pid'=>$data['pid']]);
                    //dump($savechild);die;
                    //dump($saveparent);die;
                        if($savechild && $saveparent){ //
                            $this->success('修改父级权限附带子级权限都成功','lst');
                        }else{
                             $this->error('修改父级权限或其子级权限失败');
                        }

                }else{
                        $saveparent2=db('auth_rule')->where('id',$data['id'])->update(['level'=>$postRule,'pid'=>$data['pid']]);
                        if($saveparent2){
                            $this->success('修改无子级的权限成功','lst');
                        }else{
                             $this->error('修改无子级的权限失败');
                        }
                }
}
             /*   die;
                //dump($data['pid']);die;
                //如果为0是顶级权限.不为0就读取其父级level,加1赋给她
               
                        
               
                

                $pid=db('auth_rule')->update($data);

                
               // dump($level);die;
                if($level){
                      $data['level']=$level['level']+1;
                        }else{
                            $data['level']=0;
                        }
                $save=db('auth_rule')->update($data);
                }
                //
                //计算修改的差值
               
                //dump($a);die;
                //子权限level加差值
                foreach ($chilRuleId as $k => $v) {
                     $b=db('auth_rule')->where('id',$v)->field('level')->select();
                     $c=$b[$k]['level']+$a;
                     db('auth_rule')->where('id',$v)->update(['level'=>'$c']);
                     //这个循环只执行一遍就不执行了
                }
                dump($c);die;
                
                if($save){
                        $this->success('修改权限成功','lst');
                }else{
                         $this->error('修改权限失败');
                }
            //无
           
            //dump($plevel);die;
            //$a=$level['level']-$plevel['level'];
              
                $authRules=new AuthRuleModle();
                $authRuleIds=$authRules->getchilrenid(input('id'));
                //dump($authRuleIds);die;
                $level=db('auth_rule')->where('id',$authRuleIds)->field('level')->find();
                dump($level);die;
                $level['level']=$plevel['level']+1;*/
              
            return;
        }

        $authrule=new AuthRuleModle();
        $authruleres=$authrule->authruleTree();
        $authrules=$authrule->find(input('id'));
        //dump($authRuleres);die;
        $this->assign(array(
            'authruleres'=>$authruleres,
            'authrules'=>$authrules,
            ));
        return view();
    }

//*************************************************************
    public function del(){
        $authrule=new AuthRuleModle();
        $authrule->getparentid(input('id'));
        $authRuleIds=$authrule->getchilrenid(input('id'));
        //dump($authRuleIds);die;
        $authRuleIds[]=input('id');
        //dump($authRuleIds);die;
        $del= $authrule->destroy($authRuleIds);
        if($del){
            $this->success('删除权限成功！',url('lst'));
        }else{
            $this->error('删除权限失败！');
        }
    }






}


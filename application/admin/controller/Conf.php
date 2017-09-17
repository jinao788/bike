<?php
namespace app\admin\controller;

use app\admin\model\Conf as ConfModel;
use app\admin\controller\Base;
//use think\Db;
class Conf extends Base
{
    
//***********************************************************
    public function lst(){

        if(request()->isPost()){
            //$sortres=input('post.');
            $conf=new ConfModel;
            $sortres = array_filter(input('post.'));
            foreach ($sortres as $k => $v) {
                $conf->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新栏目排序成功','lst');
    //print_r(input('post.'));die;
            return;
        }

        $confres=ConfModel::order('sort desc')->paginate(20);
        //dump($confres);die;
        $this->assign('confres',$confres);

        return view();

    }


//***********************************************************
    public function add(){
        if(request()->isPost()){
            $data=input('post.');
            if($data['values']){
                $data['values']=str_replace('，',',',$data['values']);
            }

            
            $validate = \think\Loader::validate('Conf');
            if(!$validate->check($data)){
               $this->error($validate->getError()); die;
            }

            $conf=new ConfModel;

            if($conf->save($data)){
                 $this->success('添加配置成功','lst');
            }else{
                 $this->error('添加配置失败');
            }
        }
        return view();
       
    }


//***********************************************************
     public function edit(){
        if(request()->isPost()){
            $data=input('post.');

             if($data['values']){
                $data['values']=str_replace('，',',',$data['values']);
            }


            $validate = \think\Loader::validate('Conf');
            if(!$validate->scene('edit')->check($data)){
               $this->error($validate->getError()); die;
            }

            $conf=new ConfModel;
            $save=$conf->save($data,['id'=>$data['id']]);
            if($save){
                $this->success('修改配置成功','lst');
            }else{
                $this->error('修改栏目失败');
            }
            
        }
        $confres=ConfModel::find(input('id'));
        $this->assign('confres',$confres);
        return view();
        
    }


//***********************************************************
     public function del(){

       $del=ConfModel::destroy(input('id'));
       if($del){
                $this->success('删除配置项成功','lst');
            }else{
                 $this->error('删除配置项失败');
            }
    }


//***********************************************************
     public function conf(){
        if(request()->isPost()){
            $data=input('post.');
            //dump($data);die;  //一维数组 表单提交来的6个字段 选择单选则8个字段
           // $dataarr=array();
            foreach ($data as $k => $v){
               // $dataarr=array();
                $dataarr[]=$k;
            }
// dump($dataarr);die; //表单提交来的9个字段
            $_confarr=db('conf')->field('enname')->select();
            //dump($_confarr);die;
            foreach($_confarr as $k=>$v){
                $confarr[]=$v['enname'];
            }
            //dump($confarr);die;  //数据库读取的9个字段
            $checkboxarr=array();
            foreach($confarr as $k=>$v){
                if(!in_array($v,$dataarr)){
                   
                    $checkboxarr[]=$v;

                } 
            }
            //dump($checkboxarr);die;

            if($checkboxarr){
                foreach ($checkboxarr as $ke => $v) {
                    ConfModel::where('enname',$v)->update(['value'=>'']);
                }
            }
            if($data){
                foreach($data as $k=>$v){
                    ConfModel::where('enname',$k)->update(['value'=>$v]);
                }
                $this->success('修改配置成功');
            
            }
            return;
        }
        $confres=ConfModel::order('sort desc')->select();
        //dump($confres);die;
        $this->assign('confres',$confres);    
        return view();
    }





}
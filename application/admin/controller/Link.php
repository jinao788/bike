<?php
namespace app\admin\controller;

use app\admin\model\Link as LinkModel;
use app\admin\controller\Base;
//use think\Db;
class Link extends Base
{
    
//***********************************************************
    public function lst(){
        $link = new LinkModel();
        if(request()->isPost()){
            //$sortres=input('post.');
            $sortres = array_filter(input('post.'));
            //dump($sortres);die;
            foreach ($sortres as $k => $v) {
                $link->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新栏目排序成功','lst');
    //print_r(input('post.'));die;
            return;
        }
        $linkres=$link->order('sort desc')->paginate(10);
        
        $this->assign('linkres',$linkres);
        return view();
}



//***********************************************************
     public function add(){
        if(request()->isPost()){
            
            $data=input('post.');
              $validate = \think\Loader::validate('Link');
            if(!$validate->check($data)){
               $this->error($validate->getError()); die;
            }

            $linkaddata=LinkModel::create($data);
            if($linkaddata){
                $this->success('添加友情链接成功','lst');
            }else{
                 $this->error('添加友情链接失败');
            }
        }
       return view();
     }
//***********************************************************
    public function edit(){
       if(request()->isPost()){

        $data=input('post.');
        $validate = \think\Loader::validate('Link');
            if(!$validate->check($data)){
               $this->error($validate->getError()); die;
            }

        $link=new LinkModel;
        $save=$link->save($data,['id'=>input('id')]);
            if($save){
                 $this->success('修改友情链接成功','lst');
            }else{
                 $this->error('修改友情链接失败');
            }
          return;
        }

        $linkres=LinkModel::find(input('id'));
        $this->assign('linkres',$linkres);
        return view();
}


//***********************************************************
    public function del(){
       $del=LinkModel::destroy(input('id'));
       if($del){
                $this->success('删除友情链接成功','lst');
            }else{
                 $this->error('删除友情链接失败');
            }
}



}
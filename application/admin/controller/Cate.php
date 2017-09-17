<?php
namespace app\admin\controller;
use app\admin\controller\Article;
use app\admin\model\Article as ArticleModel;
use app\admin\model\Cate as CateModel;
use app\admin\controller\Base;
//use think\Db;
class Cate extends Base
{
    //使用模型方法获取数据 // 不能分页显示
    public function lst()
    {
       $cate = new CateModel();
       if(request()->isPost()){
            //$sortres=input('post.');
            $sortres = array_filter(input('post.'));
            //dump($orders);die;
            foreach ($sortres as $k => $v) {
                $cate->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新栏目排序成功','lst');
    //print_r(input('post.'));die;
            return;
        }
        
       $cateres=$cate->catetree();
       $this->assign('cateres',$cateres);
        return view();
    }

//----------------------------------------------------     
    public function add()
    {   
        $cate = new CateModel();
        if(request()->isPost()){

              $data=input('post.');
              $validate = \think\Loader::validate('Cate');
                if(!$validate->check($data)){
               $this->error($validate->getError()); die;
            }
            
            $add=$cate->save($data);
            if($add){
                $this->success('添加栏目成功',('lst'));
            }else{
                $this->error('添加栏目失败');
            }

        }
        $cateres=$cate->catetree();
        $this->assign('cateres',$cateres);
        return view();
    }
    
//***********************************************************

    public function edit(){
        $cate = new CateModel();
        $cates=$cate->find(input('id'));
        //dump($cates);die;

       
        
        if(request()->isPost()){

            $data=input('post.');

//dump($data);die;
            $validate = \think\Loader::validate('Cate');
            if(!$validate->check($data)){  //->scene('edit')
               $this->error($validate->getError()); die;
            }

           
          
            $cate = new CateModel();
            $save=$cate->save($data,['id'=>input('id')]);

           // dump($save);die;
            if($save){
                $this->success('修改栏目成功','cate/lst');
            }else{
                $this->error('修改栏目失败');
            }
            return;
        }

       
        $cateres=$cate->catetree();
        $this->assign([
            'cateres'=>$cateres,
            'cates'=>$cates,
            ]);
        return view();

    }

//***********************************************************
    public function del(){
    	$sonids=input('id');
    		
           
       	
        $del=db('cate')->delete(input('id'));
        //dump($del);die;
       
    }

//*******************************************************
    protected $beforeActionList = [
        'delsoncate' =>['only' =>'del']
        ];

    public function delsoncate(){
        $delcateid=input('id');
        $cate = new CateModel();
        $sonids=$cate->getchildrenid($delcateid);
        $sonids[]=$delcateid;
        $sonidsStr=implode(',',$sonids);

        $delthumb=db('article')->alias('a')->field('a.*,b.id')->join('bk_cate b','a.cateid=b.id')->where("a.cateid IN($sonidsStr)")->select();
        //dump($delthumb);die;
       
        
            $thumb=array();
            foreach ($delthumb as $k => $v) {
              $thumb[$k]=$v['thumb'];
              @unlink(ROOT_PATH.'public' . DS . 'uploads'.'/'.$thumb[$k]);
              }
               //dump(ROOT_PATH.'public' . DS . 'uploads'.'/'.$thumb[$k]);die;
              
              // $thumb = array_filter($thumb);
        
        
        $article123= db('article')->where("cateid IN($sonidsStr)")->delete();
    	//dump($article123);die;

        if($sonids){
        $del=db('cate')->delete($sonids);

          if($del&&$article123){
              $this->success('删除栏目及栏目下文章成功','lst');
          }elseif($del){
          	$this->success('删除无文章栏目成功','lst');
          }else{
              $this->error('删除栏目和栏目下文章均失败');
          }
        }
        
    }
       
//*******************************************************************
}
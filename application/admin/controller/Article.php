<?php
namespace app\admin\controller;
use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;
use app\admin\controller\Base;
//use think\Db;
class Article extends Base
{
    
//***********************************************************
    public function lst(){
        $artres=db('article')->field('a.*,b.catename')->alias('a')->join('bk_cate b','a.cateid=b.id')->order('a.id desc')->paginate(12);
        //dump($artres);die;
        $this->assign('artres',$artres);
        return view();
}
//***********************************************************
  /*  public function add(){
        if(request()->isPost()){
            $data=input('post.');
//dump($data);die;
            $article= new ArticleModel();
            if($_FILES['thumb']['tmp_name']){
                 $file = request()->file('thumb');
                 $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    //$thumb=ROOT_PATH . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                    $thumb=SITE_URE . '/'.'public' . DS . 'uploads'.'/'.$info->getSaveName();
                    $data['thumb']= $thumb;
                }
            }
            if($article->save($data)){
                $this->success('添加文章成功','article/lst');
            }else{
                 $this->error('添加文章失败');
            }
            return;
        }

        $cate = new CateModel();
        $cateres=$cate->catetree();
        $this->assign('cateres',$cateres);

        return view();
    }*/
       

//模型层处理
    public function add(){
        if(request()->isPost()){
            $data=input('post.');
            // if(in_array('thumb',$data)==false){
            //    $data['thumb']='/bike\public\static\index\images\error.png';
            // }

            $data['time']=time();
            //dump($data);die;
            $article= new ArticleModel;

            $validate = \think\Loader::validate('Article');
            if(!$validate->check($data)){
               $this->error($validate->getError()); die;
            }
         /*   if($_FILES['thumb']['tmp_name']){
                 $file = request()->file('thumb');
                 $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    //$thumb=ROOT_PATH . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                    $thumb=SITE_URE . '/'.'public' . DS . 'uploads'.'/'.$info->getSaveName();
                    $data['thumb']= $thumb;
                }
            }*/
            if($article->save($data)){
                $this->success('添加文章成功','article/lst');
            }else{
                 $this->error('添加文章失败');
            }
            return;
        }

        $cate = new CateModel();
        $cateres=$cate->catetree();
        $this->assign('cateres',$cateres);

        return view();
    }
       
   
//***********************************************************
    public function edit(){
        if(request()->isPost()){
            $article= new ArticleModel;

            $data=input('post.');
            $validate = \think\Loader::validate('Article');
            if(!$validate->scene('edit')->check($data)){
               $this->error($validate->getError()); die;
            }

            //$update=$article->update($data);  //updata是更新全部数据,不论是否更新,都有值返回,模型下用save报错
            // dump($save);die;
            $save=$article->save($data,['id'=>input('id')]); //返回是0和1
            //$save=db('article')->update($data,['id'=>input('id')]); 返回是0和1
            //$save=db('article')->save($data,['id'=>input('id')]); //报错 不存在此方法
           //dump($save);die;
            if($save){
                $this->success('文章修改成功','lst');
            }else{
                $this->error('文章修改失败');
            }
            return;
        }
        $cate = new CateModel();
        $cateres=$cate->catetree();
        $arts=db('article')->find(input('id'));
        $this->assign(array(
            'cateres'=>$cateres,
            'arts'=>$arts
            ));

        

        return view();
}


//***********************************************************
    public function del(){
       //
            if(ArticleModel::destroy(input('id'))){
                $this->success('删除文章成功','lst');
            }else{
                $this->success('删除文章失败');
            }
    


  /*  public function del2($delartid){
        if(ArticleModel::destroy($delartid)){
            $this->success('删除文章成功','lst');
        }else{
            $this->success('删除文章失败');
        }*/

}



}
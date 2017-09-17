<?php
namespace app\admin\model;
use think\Model;

class Article extends Model
{
    protected static function init()
    {
        Article::event('before_insert', function ($article) {
           if($_FILES['thumb']['tmp_name']){
                 $file = request()->file('thumb');
                 $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    //$thumb=ROOT_PATH . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                    $article['thumb']=$info->getSaveName();
                    
                }
            }    
        });

/////////////////////////////////////////////////////////////////////////////////////////////////////
   
        Article::event('before_update', function ($article) {
           if($_FILES['thumb']['tmp_name']){
                $arts=Article::find($article->id);
                $thunmpath=ROOT_PATH.'public' . DS . 'uploads'.'/'.$arts['thumb'];
                //dump($thunmpath);die;
                if(file_exists($thunmpath)){
                     @unlink($thunmpath);
                }
                $file = request()->file('thumb');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    //$thumb=ROOT_PATH . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                    $article['thumb']=$info->getSaveName();
                   
                }
                    
              
            }    
        });    
/////////////////////////////////////////////////////////////////////////////////////////////////  

        Article::event('before_delete', function ($article) {
           
                $arts=Article::find($article->id);
                $thunmpath=ROOT_PATH.'public' . DS . 'uploads'.'/'.$arts['thumb'];
               // dump($thunmpath);die;
                
                //dump($thunmpath1);die;
                if(file_exists($thunmpath)){
                     @unlink($thunmpath);
                }
              
        });    

    }
   
   
    
   







}
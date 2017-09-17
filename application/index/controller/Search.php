<?php
namespace app\index\controller;
use app\index\model\Article;
class Search extends Common
{
    public function index()
    {
    	$article=new Article();
        $serHot=$article->getHotSer();
       
        $keywords=input('keywords');
        $serRes=db('article')->order('id desc')->where('title','like','%'.$keywords.'%')->paginate(2,false,$config=['query'=>array('keywords'=>$keywords)]);

       // dump($serRes);die;
        $this->assign(array(
            'serRes'=>$serRes,
            'keywords'=>$keywords,
            'serHot'=>$serHot
            ));
        return view('search');
    }
}

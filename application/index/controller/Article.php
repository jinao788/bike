<?php
namespace app\index\controller;

class Article extends Common
{
    public function index()
    {
    	$artid=input('artid');


    	db('article')->where(array('id'=>$artid))->setInc('click');
    	$articles=db('article')->find($artid);
		$article = new \app\index\model\Article();
    	$hotRes=$article ->getHotArticles($articles['cateid']);

        $cate=new \app\index\model\Cate();
        $cateInfo=$cate->getCateInfo($articles['cateid']);
        //猜你喜欢
        $cate=db('cate')->find($articles['cateid']);
        $guessArtRes=db('article')->where(array('cateid'=>$cate['id']))->limit(6)->select();
    	
    	$this->assign(array(
    		'articles'=>$articles,
    		'hotRes'=>$hotRes,
            'guessArtRes'=> $guessArtRes,
            'cateInfo'=>$cateInfo
    		));
        return view('article');
    }



    



}

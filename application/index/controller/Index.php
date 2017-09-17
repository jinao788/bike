<?php
namespace app\index\controller;

class Index extends Common
{
    public function index()

    {
    	//首页最新文章调用
    	$artileModele = new \app\index\model\Article();
    	$newArticleRes=$artileModele->getNewArticle();
    	$siteHotArt=$artileModele->getSiteHot();
        $recArt =$artileModele->getRecArt();
    	//友情链接
    	$linkRes=db('link')->order('sort desc')->select();
        //推荐栏目
        $cateMolde= new \app\index\model\Cate();
        $recIndex=$cateMolde->getRecIndex();
        //首页右竖图
        $frontImgR=$artileModele->frontImgR();
        
    	$this->assign(array(
    		'newArticleRes'=>$newArticleRes,
    		'siteHotArt'=>$siteHotArt,
    		'linkRes'=>$linkRes,
            'recArt'=>$recArt,
            'recIndex'=>$recIndex,
            'frontImgR'=>$frontImgR
            
    		));
        //dump($frontImgR);die;
        return view();
    }
}

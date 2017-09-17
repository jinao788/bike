<?php
namespace app\index\controller;
use think\Controller;
class Common extends Controller
{
    public function _initialize()
    {
    	//当前位置
    	if(input('cateid')){
    		$this->getPosition(input('cateid'));
		}
		if(input('artid')){
			$articles=db('article')->field('cateid')->find(input('artid'));
			$cateid=$articles['cateid'];
			$this->getPosition($cateid);
		}
    	//网站配置项
        $this->getConf();
        //网站栏目导航
        $this->getNavCates();
        //底部导航
        $cateMolde= new \app\index\model\Cate();
        $recBottom=$cateMolde->getRecBottom();
        $this->assign('recBottom',$recBottom);
    }
//**********************************************************    
    public function getNavCates(){
    	$cateres=db('cate')->where(array('pid'=>0))->select();
    	foreach ($cateres as $k => $v){
    		$childres=db('cate')->where(array('pid'=>$v['id']))->select();
    		if ($childres) {
    			$cateres[$k]['childres']=$childres;
    		}else{
    			$cateres[$k]['childres']=0;
    		}
    	}
    	$this->assign('cateres',$cateres);
        $this->assign('childres',$childres);
    }
//******************************************************************
//
    public function getConf(){
    	$conf=new \app\index\model\Conf();
        $_confres=$conf->getAllConf();
        //获取配置中文名称 针对input输入的有效
        foreach($_confres as $k=>$v){
        	$confres[$v['enname']]=$v['cnname'];  //$confcnnameres
        }
        //dump($confcnnameres);
        //获取配置中选框的value值.对所有类类有效
        foreach($_confres as $k=>$v){
            $confvalueres[$v['enname']]=$v['value'];
        }
        //dump($confvalueres);die;;
        if($confvalueres['close']=='是'){
           // return view('index');die;
           error('网站维护中');die;
        }else{
            $this->assign('confvalueres',$confvalueres);
            $this->assign('confres',$confres);
        }
    }

//******************************************************************
//
    public function getPosition($cateid){
    	$cate= new \app\index\model\Cate();
    	$posArr=$cate->getparents($cateid);
    	$this->assign('posArr',$posArr);
    }

 










}

<?php
namespace app\admin\model;
use think\Model;

class Cate extends Model
{
    public function catetree(){
        $cateres=$this->order('sort desc')->select();  //->paginate(10)
        //dump($cateres);die;
        return $this->sort($cateres);

    }
   
//********* 
    public function sort($data,$pid=0,$level=0){
        static $arr=array();
        foreach($data as $k => $v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $arr[]=$v;
                $this->sort($data,$v['id'],$level+1);
            }
        }
        return $arr;
    }

//****************************************************************
    
    public function getchildrenid($delcateid){
        $cateres=$this->select();
       
        return $this->_getchildrenid($cateres,$delcateid);
    }

//***********
    public function _getchildrenid($cateres,$delcateid){
        static $arr=array();
        foreach($cateres as $k => $v){
            if($v['pid'] == $delcateid){
                $arr[]=$v['id'];
                $this->_getchildrenid($cateres,$v['id']);
            }
        }
        return $arr;
    }
//***************************************************************






}
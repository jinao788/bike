<?php
namespace app\index\model;
use think\Model;
class Cate extends Model

{
    public function getchildrenid($cateid){
        $cateres=$this->select();
        $arr=$this->_getchildrenid($cateres,$cateid);
        $arr[]=$cateid;
        $strId=implode(',',$arr);
        return $strId;
    }


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

//*********************************************************************
    public function getparents($cateid){
        $cateres=$this->field('id,pid,catename')->select();
        $cates=db('cate')->field('id,pid,catename')->find($cateid);
        $pid=$cates['pid'];
        if($pid){
            $arr=$this->_getparentsid($cateres,$pid);
        }
        $arr[]=$cates;
        return $arr;
    }

    public function _getparentsid($cateres,$pid){
        static $arr=array();
        foreach ($cateres as $k => $v) {
            if($v['id'] == $pid){
                $arr[]=$v;
                $this->_getparentsid($cateres,$v['pid']);
            }
        }
        return $arr;
    }

    public function getRecIndex(){
        $recIndex=$this->order('id asc')->where('rec_index','=','1')->select();
        return $recIndex;
    }
    
    public function getRecBottom(){
        $recBottom=$this->order('id asc')->where('rec_bottom','=','1')->select();
        return $recBottom;
    }

    public function getCateInfo($cateid){
        $cateInfo=$this->field('catename,keywords,desc')->find($cateid);
        return $cateInfo;
    }



}
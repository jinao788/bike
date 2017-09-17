<?php
namespace app\admin\model;
use think\Model;

class Admin extends Model
{
   /*在ADMIN控制器中使用模型添加用户时打开*/
   
    public function addadmin($data){
       
        if( $this->save($data)){
            $groupAccess['uid']=$this->id;
            $groupAccess['group_id']=input('groupid');
            //dump($groupAccess);die;
            db('auth_group_access')->insert($groupAccess);
            return true;
        }else{
            return false;
        }
       
    }
//*************************************************************************

    public function getadmin(){
        return $this::order('id asc')->paginate(12);
    }

//******************************************************************************************************
    public function saveadmin($data){
        
        
        return $this::save(['name'=>$data['name'],'password'=>$data['password']],['id'=>$data['id']]);

    }    


//*******************************************************************

    public function deladmin($id){
        $a_g_aId=db('auth_group_access')->where('uid',$id)->delete();
//dump($a_g_aId);die;
        if($this::destroy($id) &&  $a_g_aId){
            return 1;
        }else{
            return 2;
        }
    }




//*******************************************************************
    public function login($data){

        $admin=Admin::getByName($data['name']);
         //dump($admin);die;
        if($admin){
            if($admin['password'] == md5($data['password'])){
                session('id', $admin['id']);
                session('name', $admin['name']);
                return 2; //
            }else{
                return 3;
            }
        }else{
            return 1; //
        }


    }

}
<?php
/**============================================================
    @Author:liping <liping@ucweb.com>
    @File:  User.php
    @Date:  2011-5-27 18:11:13
    @Des:  用户管理控制器 
   ============================================================
 */
class User extends AdminControl {

    function index(){
        $v=$this->loadView('user');
        $data['mysql']=$mysql=new Mysql();
        $data['action']='';
        $v->setViewData($data);
        $v->show();
    }
    function changePass(){
        $v=$this->loadView('user');
        $id=$this->req->getRequest('id');
        $done=$this->req->getPost('done');
        $data['action']='changePass';
        $data['id']=$id;
        $data['mysql']=$mysql=new Mysql();
        $flag=false;
        if($id&&$done){
              $mysql->query("select * from userinfo where id='$id'");
              $arr=$mysql->fetcharray();
              if($arr['password']!=md5($this->req->getPost('password'))){
                  $this->goBack("密码错误！");
                  return false;
              }
              $password=md5(addslashes($_POST["newpassword"]));	
	          $sql="update userinfo set password='$password' where id='$id'";
	          if($mysql->query($sql)){
                    $this->goBack("修改成功！");
                    return true;
              }
        }        
        $v->setViewData($data);
        $v->show();
    }

}

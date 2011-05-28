<?php

#后台管理基类

class AdminControl extends mvc_Controller{
    
	public function __construct(){
		
	}
    public function preCall(){
        if($_SESSION["username"]=="" || $_SESSION["password"]=="")
	    {
		    exit("没有登录,<a href='root/login.php'>返回登录</a>");
	    }
        return true;
    }
    

    function showMsg($message,$url,$time)
    {
        @header("Location:error.php?message=$message&url=$url&time=$time");
    }

    function goBack($msg='')
    {
        if($msg){
            echo "<script language='javascript'>alert(".'"'.$msg.'"'.");";
        }else{
            echo "<script language='javascript'>";
        }
        echo "window.history.go(-1)</script>";
    }        
     /**
      * @desc 加载视图
      * @param string $viewName
      * @param string $viewType
      * @param string $theme
      */
     public function loadView($viewName){
     	    return mvc_View::loadView('',$viewName,'default');
     }
}

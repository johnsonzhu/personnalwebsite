<?php
//后台管理控制器
class Admin extends AdminControl {
    
    function login(){
    	$username=addslashes($this->req->get("username"));
	    $password=md5(addslashes($this->req->get("password")));
	    $code=addslashes($this->req->get("code"));
	    //验证码判断
	    if($code!=$_SESSION["code"])
	    {
		    $this->showMsg("验证码错误","login.php","2");
		    die("验证码错误");
	    }

	    //信息验证
	    if($username=="" || strlen($username)<5 || $password=="" || $code=="")
	    {
		    $this->showMsg("请核对好数据重新登录","login.php","2");
		    die("请核对好数据重新登录");
	    }
	    //用户验证
	    $mysql=new Mysql();
        $result=$mysql->query("select * from userinfo where username='$username'");
	    $pass=$mysql->fetcharray();
	    $time=date();
	    $ip=$this->getip();
	    $logincount=intval($pass["logincount"]);
	    $id=$pass["id"];
	    if($pass)
	    {
		    if($password==$pass["password"])
		{
			$mysql->query("update userinfo set logintime='$time',loginip='$ip',logincount=$logincount+1 where id=$id");
			$_SESSION["username"]=$username;
			$_SESSION["password"]=$password;
			unset($username,$password);
			$mysql->close();
			$this->index();
		}
		else
		{
			$this->showMsg("密码有错误","login.php","2");
			die("密码有误");
		}
	    }
	    else
	    {
		    $this->showMsg("无此用户","login.php","2");
	    }
    }
    
    function logout(){
	        $_SESSION["username"]="";
	        $_SESSION["password"]="";
	        $this->showMsg("登出成功","login.php","2");
    }

    function index(){
        $v=$this->loadView('index');
        $v->show();
    }
    function left(){
        $v=$this->loadView('left');
        $v->show();
    }
    function info(){
        $name=$_SESSION["username"];
        $mysql=new Mysql();
        $mysql->query("select * from userinfo where username='$name'");
        $arr=$mysql->fetcharray();
        //var_dump($arr);
        $data['ip']=$arr["loginip"];
        $data['count']=$arr["logincount"];
        $data['pNums']=$mysql->rownums("select * from product");
        $data['newNums']=$mysql->rownums("select * from news");
        $data['name']=$name;
        if(function_exists("gd_info"))
	    {   
		    $gdarray=gd_info();
		    $gd=$gdarray["GD Version"]?$gdarray["GD Version"]:"未知";
	    	unset($gdarray);
	    }
	    else
	    {
		    $gd="未知";
	    }
        $data['gd']=$gd;
        $v=$this->loadView('info');
        $v->setViewData($data);
        $v->show();
        $mysql->close();
    }
}
?>

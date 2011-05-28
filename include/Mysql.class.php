<?php
class Mysql
{
	public $dbhost;           //数据库地址
	public $dbname;           //数据库名字
	public $dbuser;           //数据库用户
	public $dbpassword;       //数据库密码
	public $conn;             //连接标志
	public $sql;              //sql语句
	public $result;           //显示结果集
	public $showerror=false;//错误信息是否显示

//数据库的连接
public function Mysql($dbhost='',$dbname='',$dbuser='',$dbpassword='',$conn='pconn')
{   
    if(!$dbhost||!$dbname||!$dbuser){
         $conf=env_Config::getModuleConf('mysql','common');        
         $this->dbhost=$conf['host'];
         $this->dbname=$conf['db'];
         $this->dbuser=$conf['user'];
         $this->dbpassword=$conf['pass'];
         $this->conn=$conn;
    }else{
        $this->dbhost=$dbhost;
         $this->dbname=$dbname;
         $this->dbuser=$dbuser;
         $this->dbpassword=$dbpassword;
         $this->conn=$conn;
    }
    $this->connect();
}
 public function connect()
{
	$this->dbhost=$dbhost;
	if($conn=='pconn')
	{
		$this->conn=mysql_pconnect($this->dbhost,$this->dbuser,$this->dbpassword);
	}
	else
	{
		$this->conn=mysql_connect($this->dbhost,$this->dbuser,$this->dbpassword);
	}

//选择数据库
 if(!mysql_select_db($this->dbname,$this->conn))
 {
	 
	if($this->showerror)
	{
		$this->showerror("数据库不能使用:",$dbname);
	}
 }
 mysql_query("SET NAMES UTF-8");
}
	
//执行sql语句
public function query($sql)
{
	mysql_query("set names uft8_bin");
	if($sql=="")
	{
		$this->showerror("sql语句错误","sql语句不能为空");
	}
	
	$this->sql=$sql;
    
	$result=mysql_query($this->sql);
	

	if($result)
	{
		$this->result=$result;
		
	}
	else
	{
		$this->showerror("sql语法错误",$this->sql);
	}
	return $result;
}

public function fetcharray()
{
	return mysql_fetch_array($this->result);
}


//获取一条记录的数组

public function onequery($sql)
{
	$sql=mysql_query($sql);
	return mysql_fetch_array($sql);
}
//记录数
public function rownums($sql)
{
	$sql=mysql_query($sql);
	return mysql_num_rows($sql);
	
}

//字段数目

public function numfields($sql)
{
	$sql=mysql_query($sql);
	return mysql_num_fields($sql);
}

function insert_id() 
{
	$id = mysql_insert_id();
	return $id;
}

//获取字段类型

function fieldtype($sql,$field)
{
	$result=mysql_query($sql);
	
	return mysql_field_type($result,$field);
}

//释放result

function freeresult()
{
	mysql_free_result($this->result);
}

public function close()
{
	return mysql_close();
}


//错误信息显示函数
 public function showerror($message,$sql) 
{
	if($this->showerror)
	{
		if(!$sql)
		{
			echo $message;
		}
		else
		{
			echo $message;
			echo $sql;
		}
	}
}

}
?>

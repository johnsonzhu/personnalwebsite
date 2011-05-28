
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/index.css" />
<title></title>
</head>
<script language="javascript">
function check(a)
{
	if(document.form1.username.value=="")
	{
		alert("填写用户名");
		return false;
	}
	
	if(document.form1.password.value=="")
	{
		alert("填写密码");
		return false;
	}
    if(a==1){
        if(document.form1.password.value=="")
	{
		alert("填写密码");
		return false;
	}
    }
	return true;
}
</script>
<body>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" bordercolordark="#FFFFFF" class="tableborder">
  <tr>
    <td height="31" colspan="2" align="center" class="title">用户管理</td>
    <td width="27%" height="31" align="center" class="title"><a href="index.php?m=User&do=add">添加用户</a></td>
  </tr>
  <tr class="normal">
    <td width="26%" height="24" align="center" bgcolor="#F3F3F3">用户ID</td>
    <td width="47%" align="center" bgcolor="#F3F3F3">用户名</td>
    <td align="center" bgcolor="#F3F3F3">操作</td>
  </tr>
<?php  $mysql->query("select * from userinfo");
while($arr=$mysql->fetcharray())
{
?> 
  <tr>
    <td align="center"><?php echo $arr["id"];?></td>
    <td align="center"><?php echo $arr["username"];?></td>
    <td align="center"><a href="index.php?m=User&do=changePass&id=<?php echo $arr['id'];?>">修改密码</a>&nbsp;&nbsp;<a href="index.php?m=User&do=delUser&id=<?php echo $arr["id"];?>" onclick="return confirm('确定要删除吗')">删除</a></td>
  </tr>
  <?php  }?>
</table>

<?php 
if($action=="add")
{
?>
<br />
<form id="form1" name="form1" method="post" action="index.php?m=User&do=addUser&action=add" onsubmit="return check(0)">
  <table width="90%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolordark="#FFFFFF" bordercolor="#CCCCCC">
    <tr>
      <td width="29%" height="30" align="right" class='normal'>用户名:</td>
      <td width="71%"><label>
        <input name="username" type="text" class="text" id="username" />
      </label></td>
    </tr>
    <tr>
      <td height="30" align="right" class='normal'>密码:</td>
      <td><label>
        <input name="password" type="password" class="text" id="password" />
      </label></td>
    </tr>
    <tr>
      <td height="30" colspan="2" align="center"><label>
        <input type="submit" name="button" id="button" value="提交" />
      </label></td>
    </tr>
  </table>
</form>
<?php }?>

<?php 
if($action=="changePass")
{
$mysql->query("select * from userinfo where id='$id'");
$arr=$mysql->fetcharray();
?>
<br />
<form id="form1" name="form1" method="post" action="index.php?m=User&do=changePass" onsubmit="return check(1)">
  <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolordark="#FFFFFF" bordercolor="#CCCCCC">
    <tr>
      <td width="29%" height="30" align="right"  class='normal'>用户名:</td>
      <td width="71%"><label>
        <input name="username" type="text" class="text" id="textfield" value="<?php echo $arr["username"];?>" disabled="disabled">
      </label></td>
    </tr>
    <tr>
      <td height="30" align="right"  class='normal'>密码:</td>
      <td><label>
        <input name="password" type="password" class="text" id="password" value="">
      </label></td>
    </tr>
    <tr>
      <td height="30" align="right"  class='normal'>新密码:</td>
      <td><label>
        <input name="newpassword" type="password" class="text" id="newpassword" value="">
        <input name="done" type="hidden" class="text" id="done" value="1">
        <input name="id" type="hidden" class="text" id="cid" value="<?php echo $id?>">
      </label></td>
    </tr>
    <tr>
      <td height="30" colspan="2" align="center"><label>
        <input type="submit" name="button" id="button" value="提交" />
      </label></td>
    </tr>
  </table>
</form>
<?php 
}
?>
</body>
</html>

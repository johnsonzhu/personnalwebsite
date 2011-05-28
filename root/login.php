<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpweb登录</title>
<style type="text/css">
body
{
	padding:0px;
	margin:0px;
}
.border1
{
	border:#CCC 1px solid;
	font-size:12px;
	font-weight:bold;
	color:#FFF;
}

.user
{
	width:150px;
	height:20px;
}
.code
{
	width:70px;
	height:20px;
}

.button
{
	width:90px;
	height:30px;
	color:#FFF;
	
}
.title
{
	font-size:14px;
	font-weight:bold;
	color:#006;
}
</style>
<script language="javascript" type="text/javascript">
function checkform()
{
	if(document.getElementById("username").value=="" || document.getElementById("username").value.length<3)
	{
		alert("用户名为空或者小于3个字符");
		return false;
	}
	if(document.getElementById("password").value=="")
	{
		alert("密码不能为空");
		return false;
	}
	if(document.getElementById("code").value=="")
	{
		alert("验证码不能为空");
		return false;
	}
	return true;
}
function refreshcode()
{
	document.getElementById("codeimg").setAttribute('src','../include/code.php?'+Math.random());

}
</script>
</head>

<body>

<br />
<br />
<br />
<br />
<br />
<br />
<form action="admin.php" method="get" onsubmit="return checkform();">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#003399" background="images/loginbg.jpg" class="border1" >
  <tr>
    <td height="87" colspan="8" align="center" class="title"><img src="images/logintitle.jpg" width="390" height="37" /></td>
    </tr>
  <tr>
    <td height="94" colspan="8" align="center" class="title" ><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" background="images/login2.jpg" >
      <tr>
        <td width="8%" height="46" align="center" class="title" >用户名:</td>
        <td width="16%" align="center"><label>
          <input name="username" type="text" class="user" id="username" />
        </label></td>
        <input name="action2" type="hidden" value="login" />
        <td width="6%" align="center" class="title">密码：</td>
        <td width="21%" align="center" ><label>
          <input name="password" type="password" class="user" id="password" />
        </label></td>
        <td width="7%" align="center" class="title">验证码：</td>
        <td width="9%" align="center"><label>
          <input name="code" type="text" class="code" id="code" />
        </label></td>
        <td width="9%" align="center"><img src="../include/code.php" name="codeimg" width="58" height="22" id="codeimg" style="cursor:hand;padding:2px 8px 0pt 3px;" onclick="refreshcode();" /></td>
        <td width="24%" align="center"><label>
          <input name="button" type="submit" id="button" value="登录" />
&nbsp;          &nbsp;&nbsp;
          <input name="button2" type="reset" id="button2" value="重置" />
        </label></td>
      </tr>
    </table></td>
    <input name="action" type="hidden" value="login" />
    </tr>
  <tr>
    <td width="8%" height="58">&nbsp;</td>
    <td width="16%">&nbsp;</td>
    <td width="6%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="24%">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>

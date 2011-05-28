
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/index.css" />
<title></title>
</head>

<body>
<table width="99%" height="200px" border="0" align="center" cellpadding="0" cellspacing="0" class="tableborder" >
  <tr>
    <td height="25px" colspan="4" align="center" class="title"></td>
  </tr>
  <tr>
    <td width="26%" align="center" class="normal">用户名:</td>
    <td width="21%" align="center"><?php echo $name;?>&nbsp;</td>
    <td width="29%" align="center" class="normal">PHP环境安全设置摘要:
  
    </td>
    <td width="24%" align="center">
      <?php 
	if(ini_get("regist_global"))
	{
		echo "Regist_global:<font color='red'>on</font><br>";
	}
	else
	{
		echo "Regist_global:<font color='red'>off</font><br>";
	}
	
	if(ini_get("magic_quotes_gpc"))
	{
		echo "Magic_quotes_gpc:<font color='red'>on</font>";
	}
	else
	{
		echo "Magic_quotes_gpc:<font color='red'>off</font>";
	}
	?>
    </td>
  </tr>
  <tr>
    <td align="center" class="normal">IP地址:</td>
    <td align="center"><?php echo $ip;?></td>
    <td align="center" class="normal">PHP/MYSQL版本信息:</td>
    <td align="center"><?php echo phpversion();?>&nbsp;/&nbsp;<?php echo substr(mysql_get_server_info(),0,6);?></td>
  </tr>
  <tr>
    <td align="center" class="normal">GD版本：</td>
    <td align="center"><?php echo substr($gd,9,7);?></td>
    <td align="center" class="normal">登录次数：</td>
    <td align="center"><?php echo $count;?></td>
  </tr>
  <tr>
    <td align="center" class="normal">产品数:</td>
    <td align="center"><?php echo $pNums;?></td>
    <td align="center" class="normal">新闻数:</td>
    <td align="center"><?php echo $newNums;?></td>
  </tr>
</table>

</body>
</html>

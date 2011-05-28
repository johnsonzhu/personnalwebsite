<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style/index.css" />
<title>管理后台</title>
<script language="javascript">
function hide()
{
	if(document.getElementById('left').style.display=='none')
	{
		document.getElementById('left').style.display="inline";
		document.getElementById("text").innerHTML="关闭左栏";
	}
	else
	{
		document.getElementById('left').style.display='none';
		document.getElementById('right').style.height='99%';
		document.getElementById("text").innerHTML="打开左栏";
	}
}
</script>
</head>
<style type="text/css">
html,body
{
	height:100%;
	width:100%;
	overflow:hidden
	
	
}
.top{ font-size:12px; text-align:left}
.top a{ font-size:12px; color:#FFF; font-weight:bold; text-decoration:none}
a{ font-size:12px}
</style>

<body>
<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="tableid">
  <tr>
    <td height="10%" colspan="2" align="center" background="images/index_02.jpg" style="border-bottom:#CCC solid 2px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="21%" height="85"><img src="images/index_05.jpg" width="260" height="43" /></td>
        <td width="50%">&nbsp;</td>
        <td width="2%"><img src="images/index_08.jpg" width="20" height="22" /></td>
        <td width="6%" class="top"><a href="../">返回主页</a></td>
        <td width="2%" class="top"><img src="images/index_10.jpg" width="19" height="20" /></td>
        <td width="6%" class="top"><a href="#" onclick="hide()"><span id="text">关闭左栏</span></a></td>
        <td width="2%" class="top"><img src="images/index_12.jpg" width="16" height="17" /></td>
        <td width="11%" class="top"><a href="index.php?m=Admin&do=logout">退出系统</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td id='left' width="21%" height="88%" align="center" valign="top" class="leftborder">
    <div style="height:5px; margin:0px; padding:0px;"></div>
    <iframe src="index.php?m=Admin&do=left" scrolling="auto" frameborder="0" height="100%" width="98%"></iframe></td>
    <td id="right" height="88%" width="79%" align="center" valign="top"> <div style="height:5px; margin:0px; padding:0px;"></div><iframe name="main" hspace="0" vspace="0" scrolling="auto"  frameborder="0" src="index.php?m=Admin&do=info" height="100%" width="100%" marginheight="0" marginwidth="0" ></iframe></td>
  </tr>
</table>
</body>
</html>

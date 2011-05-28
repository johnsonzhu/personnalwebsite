<?
@header("content-Type:text/html; charset=UTF-8");
$message=$_GET["message"];
$url=$_GET["url"];
$time=$_GET["time"];
if($message=="")
{
	die("错误参数");
}
elseif($url=="")
{
	$url="../index.php";
}
elseif($time=="")
{
	$time="2";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="refresh" content="<?=$time?>;url='<?=$url?>'"/>
<title>错误跳转页面</title>
</head>

<body>

<table width="700" border="0" align="center" cellpadding="4" cellspacing="10">
  <tr>
    <td align="center">提示信息:<? echo $message ?></td>
  </tr>
  <tr>
    <td align="center">系统<?=$time?>秒后自动转向……</td>
  </tr>
</table>
</body>
</html>
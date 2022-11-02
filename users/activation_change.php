<?php
define( '_NO', 1 );
header("Content-type: text/html; charset=utf-8");
$lang = $_GET["lang"];
if(isset($_GET["lang"]))
{ 
	if($lang=="rus") 
	{
  		$lng="../lang/rus/rus.php";
	}
	elseif ($lang=="lat") 
	{
		$lng="../lang/lat/lat.php";
	}
	else
	{
		$lng="../lang/lat/lat.php";
	}
}
else
{
	$lng="../lang/lat/lat.php";
}

if(empty($_GET["lang"]))
{
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat&id=".$_GET['id']."&num=".$_GET['num']."'>";
}

@setcookie("lang", $lang, time()+2592000);   
if(isset($_COOKIE["lang"]))
{ 
	if($_COOKIE["lang"]=="rus")
	{
   		 $lng="../lang/rus/rus.php"; 
	}
	elseif ($_COOKIE["lang"]=="lat") 
	{
		$lng="../lang/lat/lat.php";
	}
	else
	{
		$lng="../lang/lat/lat.php"; 
	}
}
@setcookie("lang", $_COOKIE["lang"], time()+2592000);

include_once $lng;
include_once("../block/bd.php");
include_once("footer_fns.php");
include_once("valid_fns.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");

if(isset($_GET['num']))
{
	$activ = $_GET['num'];
}
else
{
	exit("<meta http-equiv='Refresh' content='0; URL=../login.php?lang=".$lang."'>");
}

if(isset($_GET['id']))
{
	$id = $_GET['id'];
}
else
{
	exit("<meta http-equiv='Refresh' content='0; URL=../login.php?lang=".$lang."'>");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $activation_title; ?></title>
<meta name="robots" content="no-cache, no-follow" /> 
<meta name="revisit-after" content="no-cache, no-revisit"/>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache" />
<link href="../CSS/eccss.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="../CSS/ie7.css" />
<![endif]-->
<script type="text/javascript">
if(window.opera) {document.write('<link rel="stylesheet" type="text/css" href="../CSS/opera.css" />');}
</script>
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
</head>
<body>
<table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("../block/header_user.php"); ?>
  </tr>
  <tr>
    <?php include_once ("../block/bannerup_user.php"); ?>
  </tr>
  <tr>
    <td colspan="3"><div id="bwrap"><table width="100%" border="0">
  <tr>
    <td valign="top"><div id="textwrap">
<?php
$result_check = mysql_query("SELECT activation FROM users WHERE login = '$id'");
$row_check = mysql_fetch_array($result_check);
if($row_check['activation'] == 1)
{
	message_succes($lang,"<p align='center' class='join_us_error'>".$activation_already."</p>");
}
else
{

$number = rand(2345678912345,9876543254321);	
$rand = md5($rand);

	if($rand == $activ)
	{
		$result_update = mysql_query("UPDATE users SET activation = '1' WHERE login = '$id'");
		if(!$result_update)
		{
			message_succes($lang,"<p align='center' class='join_us_error'>".$reg_user_db_err."</p>");
		}
		else
		{
			message_succes($lang,"<meta http-equiv='Refresh' content='2; URL=../login.php?lang=".$lang."'><h4 align='center'>".$activation_succ."</h4>");
		}
	}
	else
	{
		message_succes($lang,"<p align='center' class='join_us_error'>".$activation_err."</p>");	
	}
}
?>
</div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
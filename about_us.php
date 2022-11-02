<?php define( '_NO', 1 ); header("Content-type: text/html; charset=utf-8"); ?>
<?php

$lang = $_GET["lang"];
if(isset($_GET["lang"]))
{ 
	if($lang=="rus") 
	{
  		$lng="lang/rus/rus.php";
	}
	elseif ($lang=="lat") 
	{
		$lng="lang/lat/lat.php";
	}
	else
	{
		$lng="lang/lat/lat.php";
	}
}
else
{
	$lng="lang/lat/lat.php";
}

if(empty($_GET["lang"]))
{
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat'>";
}

@setcookie("lang", $lang, time()+2592000);   
if(isset($_COOKIE["lang"]))
{ 
	if($_COOKIE["lang"]=="rus")
	{
   		 $lng="lang/rus/rus.php"; 
	}
	elseif ($_COOKIE["lang"]=="lat") 
	{
		$lng="lang/lat/lat.php";
	}
	else
	{
		$lng="lang/lat/lat.php"; 
	}
}
@setcookie("lang", $_COOKIE["lang"], time()+2592000);

include_once $lng;
include ("block/bd.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
if ($lang == "rus")
$result = mysql_query ("SELECT * FROM common_text_rus WHERE page='about_us'",$db); 
else
$result = mysql_query ("SELECT * FROM common_text_lat WHERE page='about_us'",$db);
?>
<?php if (!$result)
{
echo "<p align='center'>Error no 1.
<br />Please report to administration through admin@econom.lv</p>";
exit (mysql_error());
}
if (mysql_num_rows($result) > 0)
{
$myrow = mysql_fetch_array ($result);
}
else {
echo "<p align='center'>Error no 2. <br /> Please report to administration through admin@econom.lv</p>";
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $myrow["meta_k"]?>;" />
<meta name="description" content="<?php echo $myrow["meta_d"]?>;" />
<title><?php echo $myrow["title"] ?></title>
<META HTTP-EQUIV="EconomLV" CONTENT="cache" />
<META HTTP-EQUIV="Pragma" CONTENT="cache" />
<meta name="robots" content="INDEX,FOLLOW"> 
<meta name="revisit-after" content="1 week"> 
<meta http-equiv="content-language" content="Russian, Latvian"> 
<meta name="author" content="Econom LV">  
<meta name="publisher" content="Econom LV">  
<meta name="made" content="admin@econom.lv">  
<meta name="copyright" content="www.econom.lv">  
<meta name="audience" content="All">  
<meta name="page-topic" content="EconomLV - Все скидки Латвии - Atlaides Latvijā."> 
<link href="CSS/eccss.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="CSS/ie7.css" />
<![endif]-->
<script type="text/javascript">
if(window.opera) {document.write('<link rel="stylesheet" type="text/css" href="CSS/opera.css" />');}
</script>
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
</head>
<body>
<table align="center" width="1010" border="0">
  <tr>
    <?php include_once ("block/header.php"); ?>
  </tr>
  <tr>
    <?php include_once ("block/bannerup.php"); ?>
  </tr>
  <tr>
    <td colspan="3"><div id="bwrap"><table width="100%" border="0">
  <tr>
    <td valign="top" width="75px"></td>
    <td valign="top"><div id="textwrap"><?php eval ($myrow['text']); ?></div></td>
    <td valign="top" width="75px"></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010" border="0">
  <tr>
    <?php include_once ("block/footer.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
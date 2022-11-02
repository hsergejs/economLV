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

if(empty($_GET["lang"]) && isset($_GET['city']) && isset($_GET['b_def']) && isset($_GET['defcat']))
{
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat&city=".$_GET['city']."&b_def=".$_GET['b_def']."&defcat=".$_GET['defcat']."'>";
}
elseif(empty($_GET["lang"]) && isset($_GET['city']) && isset($_GET['b_def']))
{
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat&city=".$_GET['city']."&b_def=".$_GET['b_def']."'>";
}
elseif(empty($_GET["lang"]) && isset($_GET['city']))
{
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat&city=".$_GET['city']."'>";
}
elseif(empty($_GET["lang"]))
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
include_once ("block/bd.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
if ($lang == "rus")
$result = mysql_query ("SELECT * FROM common_text_rus WHERE page='def_cat'",$db); 
else
$result = mysql_query ("SELECT * FROM common_text_lat WHERE page='def_cat'",$db);
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
    <td valign="top"><div id="textwrap_cat"><table align="center" width="100%" border="0" cellspacing="0" cellpadding="30px">
  <tr valign="top">
    <td style="padding-left:30px;">
<?php
if($lang == "rus")
{
$query_c = "SELECT city FROM catalogue_rus WHERE activation = '2'
		  GROUP BY city 
		  ORDER BY city";
}
else
{
$query_c = "SELECT city FROM catalogue_lat WHERE activation = '2'
		  GROUP BY city 
		  ORDER BY city";
}
$row_c = mysql_query($query_c);
if(mysql_num_rows($row_c) > 0)
{
while($city = mysql_fetch_array($row_c))
{
	echo "<div id='catalogue'><a href=".$_SERVER['PHP_SELF']."?lang=".$lang."&city=".urlencode($city['city']).">".$city['city']."</a></div>";}}
else echo "<p align='center'>".$city_cat_error."</p>";
?>
</td><td>
<?php
if($lang == "rus")
{
$query_s = "SELECT b_def AS b_def FROM catalogue_rus WHERE city = '".$_GET['city']."' AND activation = '2'
		  GROUP BY b_def 
		  ORDER BY b_def";
}
else
{
$query_s = "SELECT b_def AS b_def FROM catalogue_lat WHERE city = '".$_GET['city']."' AND activation = '2'
		  GROUP BY b_def 
		  ORDER BY b_def";
}
$row_s = mysql_query($query_s);
if(mysql_num_rows($row_s) > 0)
{
while($b_def = mysql_fetch_array($row_s))
{
	echo "<div id='catalogue'><a href=".$_SERVER['PHP_SELF']."?lang=".$lang."&city=".urlencode($_GET['city'])."&b_def=".urlencode($b_def['b_def']).">".$b_def['b_def']."</a></div>";}}
else echo "<p align='center'>".$def_cat_error."</p>";
?>
</td><td>
<?php
if($lang == "rus")
{
$query2_s = "SELECT definition AS defcat 
          FROM catalogue_rus WHERE city = '".$_GET['city']."' AND b_def = '".$_GET['b_def']."' AND activation = '2'
          GROUP BY defcat
          ORDER BY defcat";
}
else
{
	$query2_s = "SELECT definition AS defcat 
          FROM catalogue_lat WHERE city = '".$_GET['city']."' AND  b_def = '".$_GET['b_def']."' AND activation = '2'
          GROUP BY defcat
          ORDER BY defcat";
}
$row2_s = mysql_query($query2_s);
if( mysql_num_rows( $row2_s ) > 0) 
{
  while( $defcat = mysql_fetch_array( $row2_s ) ) 
  {
    echo "<div id='catalogue'><a href='".$_SERVER['PHP_SELF']."?lang=".$lang."&city=".urlencode($_GET['city'])."&b_def=".urlencode($_GET['b_def'])."&defcat=".urlencode($defcat['defcat'])."'>".$defcat['defcat']."</a></div>";  }}
else echo "<p align='center'>".$def_cat_b_def_error."</p>";
?>
</td>
    <td style="padding-top:30px"><?
	if ($lang == "rus")
	{
  $query3_s =  "SELECT ltd_name
			FROM catalogue_rus WHERE city = '".$_GET['city']."' AND  b_def = '".$_GET['b_def']."' AND definition = '".$_GET['defcat']."' AND activation = '2'
			ORDER BY ltd_name";
	}
	else
	{
	$query3_s =  "SELECT ltd_name
			FROM catalogue_lat WHERE city = '".$_GET['city']."' AND  b_def = '".$_GET['b_def']."' AND definition = '".$_GET['defcat']."' AND activation = '2'
			ORDER BY ltd_name";
	}
$row3_s = mysql_query($query3_s);
if( mysql_num_rows( $row3_s ) > 0 )
{
while ($link = mysql_fetch_array($row3_s))
{
    echo "<div id='linkcat'><a href='page.php?lang=".$lang."&city=".urlencode($_GET['city'])."&b_def=".urlencode($_GET['b_def'])."&defcat=".urlencode($_GET['defcat'])."&link=".urlencode($link['ltd_name'])."'>".$link['ltd_name']."</a></div>"; }}
else echo "<p align='center'>".$def_cat_link_error."</p>";
?>
</td>
</tr>
</table></div></td>
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
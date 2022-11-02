<?php
define( '_NO', 1 );
session_start();
header("Content-type: text/html; charset=utf-8");
include_once("../block/bd.php");
$lang = $_GET["lang"];
if($_SESSION['session_count'] == 0) 
{ 
	$_SESSION['session_count'] = 1;
	$_SESSION['session_start_time'] = time();
} 
else 
{
	$_SESSION['session_count'] = $_SESSION['session_count'] + 1;
}

$session_timeout = 1200; // 5 min = 300, 10 min = 600, 30 min = 1800

$session_duration = time() - $_SESSION['session_start_time'];
if ($session_duration > $session_timeout) 
{ 
	mysql_query("UPDATE users SET last_visit = NOW() WHERE login = '$login' AND passwd = '$passwd'");
	session_unset();
	session_destroy();
	session_start();
	session_regenerate_id(true);
	$_SESSION["expired"] = "yes";
	header("Location: ../login.php?lang=".$lang.""); // Redirect to Login Page
}
else
{
	$_SESSION['session_start_time'] = time();
}
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
<title><?php echo $myrow["title"] ?></title>
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
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
</head>
<body>
<table align="center" width="1010" border="0">
  <tr>
    <?php include_once ("../block/header_user.php"); ?>
  </tr>
  <tr>
    <?php include_once ("../block/bannerup_user.php"); ?>
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
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
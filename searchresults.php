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
include_once ("users/valid_fns.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Your search results</title>
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
    <?php include ("block/header.php"); ?>
  </tr>
  <tr>
    <?php include ("block/bannerup.php"); ?>
  </tr>
  <tr>
    <td colspan="3"><div id="bwrap"><table width="100%" border="0">
  <tr>
    <td valign="top" width="75px"></td>
    <td valign="top"><div id="textwrap"><p>

<div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = 795;
  var googleSearchDomain = "www.google.lv";
  var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>

</p></div></td>
    <td valign="top" width="75px"></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010" border="0">
  <tr>
    <?php include ("block/footer.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</body>
</html>
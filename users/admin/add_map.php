<?php
define( '_NO', 1 );
session_start();
header("Content-type: text/html; charset=utf-8");
include_once("../../block/bd.php");
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
	$login = $_SESSION['login'];
	$passwd = $_SESSION['passwd'];
	mysql_query("UPDATE users SET last_visit = NOW() WHERE login = '$login' AND passwd = '$passwd'");
	session_unset();
	session_destroy();
	session_start();
	session_regenerate_id(true);
	$_SESSION["expired"] = "yes";
	header("Location: ../../login.php?lang=".$lang.""); // Redirect to Login Page
}
else
{
	$_SESSION['session_start_time'] = time();
}
if(isset($_GET["lang"]))
{ 
	if($lang=="rus") 
	{
  		$lng="../../lang/rus/rus.php";
	}
	elseif ($lang=="lat") 
	{
		$lng="../../lang/lat/lat.php";
	}
	else
	{
		$lng="../../lang/lat/lat.php";
	}
}
else
{
	$lng="../../lang/lat/lat.php";
}

setcookie("lang", $lang, time()+2592000);   
if(isset($_COOKIE["lang"]))
{ 
	if($_COOKIE["lang"]=="rus")
	{
   		 $lng="../../lang/rus/rus.php"; 
	}
	elseif ($_COOKIE["lang"]=="lat") 
	{
		$lng="../../lang/lat/lat.php";
	}
	else
	{
		$lng="../../lang/lat/lat.php"; 
	}
}
setcookie("lang", $_COOKIE["lang"], time()+2592000);

include_once $lng;
include_once("../footer_fns.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $profile_title; ?></title>
<meta name="robots" content="no-cache, no-follow" /> 
<meta name="revisit-after" content="no-cache, no-revisit"/>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache" />
<link href="../../CSS/eccss.css" rel="stylesheet" type="text/css" />
<!--[if IE ]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="../../CSS/ie7.css" />
<![endif]-->
<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon" />
</head>
<body>
<table align="center" width="1010px" border="0">
  <tr>
    <td colspan="3"><div style="margin-top:100px;" id="bwrap"><table width="100%" border="0">
  <tr>
    <td valign="top"><div id="textwrap">
<?php
if(empty($_SESSION['login']) && empty($_SESSION['passwd']))
{
	profile_footer($lang,"<p align='center' class='join_us_error'>".$profile_not_loged."</p>");
}
else
{
	$login = $_SESSION['login'];
	$passwd = $_SESSION['passwd'];
	$result = mysql_query("SELECT * FROM users WHERE login = '$login' AND passwd = '$passwd'");
	$row = mysql_fetch_array($result);
	$login_db = $row['login'];
	$passwd_db = $row['passwd'];
	if(mysql_num_rows($result)>0 && $login === $login_db && $passwd === $passwd_db)
	{	
		if($login === "YaykoZajko@inbox.ua.au" && $passwd === "d7482bf6737fa194d218347e7da25ae444TrAh0885")
		{
			if(isset($_GET['ltd']))
			{
				$sh_name = $_GET['ltd'];
				$sh_name = htmlspecialchars(stripslashes(trim($sh_name)));
			}
			if($sh_name == '')
			{
				unset($sh_name);
				exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
			}
			
			if($_POST['submit'])
			{
				$map_value = $_POST['map'];
				trim($map_value);
				
				$result_update_rus = mysql_query("UPDATE ltd_page_rus SET map = '$map_value' WHERE sh_name = '$sh_name'");
				$result_update_lat = mysql_query("UPDATE ltd_page_lat SET map = '$map_value' WHERE sh_name = '$sh_name'");
				if($result_update_rus && $result_update_lat)
				{
					echo "<p align='center'>Updated. Wait...</p> <meta http-equiv='Refresh' content='2; URL=profile.php?lang=".$lang."'>";
				}
				else
				{
					echo "<p align='center'>Error updating one of the pages!</p>";
				}
			}
			
			?>
            <p><a href="profile.php?lang=<?php echo $lang; ?>">Back to the Ltd preview</a></p>
            <h3 align="center">Map adding to the page of the <?php echo $sh_name; ?> LTD</h3>
			<table border="0" align="center">
            <form action="add_map.php?lang=<?php echo $lang; ?>&ltd=<?php echo $sh_name; ?>" method="post">
            <tr>
            <td>Enter map: </td>
            <td><textarea name="map" cols="40" rows="10"><?php echo $map_value; ?></textarea></td>
            </tr>
            <tr>
            <td align="center" colspan="2"><input type="submit" name="submit" value="Add map to the page" /></td>
            </tr>
			<?php
		}
		else
		{
			unset($login);
			unset($passwd);
			session_unset();
			session_destroy();
			exit("<meta http-equiv='Refresh' content='0; URL=../../login.php?lang=".$lang."'>");
		}
	}
	else
	{
		profile_footer($lang,"<p align='center' class='join_us_error'>".$profile_no_user."</p>");
	}
}

?>
    </div></td>
  </tr>
</table></div>
</td>
</tr>
</table>
</body>
</html>
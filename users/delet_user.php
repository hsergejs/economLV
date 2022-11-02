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

if(empty($_GET["lang"]))
{
	echo "<meta http-equiv='Refresh' content='0; URL=profile.php?lang=lat'>";
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
include_once("footer_fns.php");
include_once("valid_fns.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $delet_user_title; ?></title>
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
if(empty($_SESSION['login']) && empty($_SESSION['passwd']))
{
	profile_footer($lang,"<p align='center' class='join_us_error'>".$profile_not_loged."</p>");
}
else
{               
	$login = $_SESSION['login'];
	$passwd = $_SESSION['passwd'];
	$result = mysql_query("SELECT login,passwd FROM users WHERE login = '$login' AND passwd = '$passwd'");
	$row_user_db = mysql_fetch_array($result);
	$login_db = $row_user_db['login'];
	$passwd_db = $row_user_db['passwd'];
	if(mysql_num_rows($result)>0 && $login === $login_db && $passwd === $passwd_db)
	{	
		if($_GET['proof'] == 'yes')
		{
			$result_check_ltd_rus = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE login = '$login'");
			$result_check_ltd_lat = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE login = '$login'");
				
			if(mysql_num_rows($result_check_ltd_rus)>0 && mysql_num_rows($result_check_ltd_lat)>0)
			{
				$result_check_cat_rus = mysql_query("SELECT ltd_name FROM catalogue_rus WHERE login = '$login'");
				$result_check_cat_lat = mysql_query("SELECT ltd_name FROM catalogue_lat WHERE login = '$login'");
				if(mysql_num_rows($result_check_cat_rus)>0 && mysql_num_rows($result_check_cat_lat)>0)
				{
					mysql_query("DELETE FROM catalogue_rus WHERE login = '$login'");
					mysql_query("DELETE FROM catalogue_lat WHERE login = '$login'");
				}
					
				mysql_query("DELETE FROM ltd_page_lat WHERE login = '$login'");
				mysql_query("DELETE FROM ltd_page_rus WHERE login = '$login'");
			}
				
			$result_check_gallery = mysql_query("SELECT sh_name FROM gallery WHERE login = '$login'");
			if(mysql_num_rows($result_check_gallery)>0)
			{
				while($row_gallery = mysql_fetch_array($result_check_gallery))
				{
					$sh_name = $row_gallery['sh_name'];
					$folder = "../img/ltd/".$sh_name;
					deltree($folder);
				}
				$result_delet_gallery = mysql_query("DELETE FROM gallery WHERE login = '$login'");
			}
			
			$result_check_message = mysql_query("SELECT login FROM messages WHERE login = '$login'");
			if(mysql_num_rows($result_check_message)>0)
			{
				mysql_query("DELETE FROM messages WHERE login = '$login'");
			}
			
			$result_check_stats = mysql_query("SELECT login FROM stats WHERE login = '$login'");
			if(mysql_num_rows($result_check_stats)>0)
			{
				mysql_query("DELETE FROM stats WHERE login = '$login'");
			}
						
			$result_delet_user = mysql_query("DELETE FROM users WHERE login = '$login' AND passwd = '$passwd'");
					
			if(!$result_delet_user)
			{
				message_succes($lang,"<p align='center' class='join_us_error'>".$reg_user_db_err."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
			}
			else
			{
				session_unset();
				session_destroy();
						
				message_succes($lang,"<p align = 'center'>".$delet_user_succes."</p>
						   <meta http-equiv='Refresh' content='5; URL=../index.php?lang=".$lang."'>");
			}			

		}
		elseif($_GET['proof'] == 'no')
		{
			exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
		}
		?>
        <table align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td align="center" colspan="2"><p class="join_us_error"><?php echo $delet_user_warning."?"; ?></p></td>
        </tr>
        <tr>
        <td><a style="padding-left:120px; text-decoration:none;" href='delet_user.php?lang=<?php echo $lang;?>&ltd=<?php echo $sh_name; ?>&proof=yes'><?php echo $delet_yes; ?></a></td>
        <td><a  style="padding-right:70px; text-decoration:none;" href='profile.php?lang=<?php echo $lang;?>&proof=no'><?php echo $delet_no; ?></a></td>
        </tr>
        </table>
	<?php
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
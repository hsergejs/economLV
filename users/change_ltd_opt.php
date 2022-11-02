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
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $change_ltd_opt_title; ?></title>
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
		
		if($lang == 'rus')
		{
			$result_check_old = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$sh_name'");
			$result_check_owner = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$sh_name' AND login = '$login'");
		}
		else
		{
			$result_check_old = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$sh_name'");
			$result_check_owner = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$sh_name' AND login = '$login'");
		}
				
		if(!mysql_num_rows($result_check_old)>0)
		{
			 message_succes($lang,"<p align='center' class='join_us_error'>".$ltd_create_ltd_check_old_1.$sh_name.$ltd_create_ltd_check_old_2."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");	}
						
		if(!mysql_num_rows($result_check_owner)>0)
		{
			 message_succes($lang,"<p align='center' class='join_us_error'>".$change_ltd_no_owner."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
		}
		?>
		<table align="center" border="0" cellpadding="0" cellspacing="0">
        <form action="change_ltd.php?lang=<?php echo $lang; ?>" method="post">
        <tr>
        <td colspan="2"><h4><?php echo $change_ltd_opt_h; ?></h4></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_reg; ?></p></td>
        <td align="center"><input type="checkbox" name="pvn_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_name; ?></p></td>
        <td align="center"><input type="checkbox" name="sh_name_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_descr; ?></p></td>
        <td align="center"><input type="checkbox" name="descr_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_web; ?></p></td>
        <td align="center"><input type="checkbox" name="web_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_phone_1; ?></p></td>
        <td align="center"><input type="checkbox" name="phone_1_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_phone_2; ?></p></td>
        <td align="center"><input type="checkbox" name="phone_2_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_fax; ?></p></td>
        <td align="center"><input type="checkbox" name="fax_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_address; ?></p></td>
        <td align="center"><input type="checkbox" name="address_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_city; ?></p></td>
        <td align="center"><input type="checkbox" name="city_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_post; ?></p></td>
        <td align="center"><input type="checkbox" name="post_ch" /></td>
        </tr>
        <tr>
        <td colspan="2"><h4><?php echo $change_ltd_opt_offer_h; ?></h4></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_offer_descr; ?></p></td>
        <td align="center"><input type="checkbox" name="offer_descr_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_offer_dates; ?></p></td>
        <td align="center"><input type="checkbox" name="dates_ch" /></td>
        </tr>
        <tr>
        <td colspan="2"><h4><?php echo $change_ltd_opt_sec_lang_h; ?></h4></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_sec_lang_descr_ltd; ?></p></td>
        <td align="center"><input type="checkbox" name="descr_sec_lang_ch" /></td>
        </tr>
        <tr>
        <td align="right"><p><?php echo $change_ltd_opt_sec_lang_descr_offer; ?></p></td>
        <td align="center"><input type="checkbox" name="offer_descr_sec_lang_ch" /></td>
        </tr>
        <tr>
        <td colspan="2"><input type="hidden" name="ltd" value="<?php echo $sh_name; ?>" /></td>
        </tr>
        <tr>
        <td colspan="2" align="center"><p><input type="submit" name="submit" value="<?php echo $ltd_create_opt_but; ?>" /></p></td>
        </tr>
        </form>
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
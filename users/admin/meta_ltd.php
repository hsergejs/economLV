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
    <td colspan="3"><div style="margin-top:50px;" id="bwrap"><table style="margin-bottom:50px;" width="100%" border="0">
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
			
			echo "<p><a href='profile.php?lang=".$lang."'>Back to the Ltd preview</a></p>";
			
			if($_POST['ltd_meta'])
			{
				if($_POST['m_keywords_ru'])
				{
					$key_w_ru = $_POST['m_keywords_ru'];
					$key_w_ru = htmlspecialchars(stripslashes(trim($key_w_ru)));
				}
				if($key_w_ru == '')
				{
					unset($key_w_ru);
				}
			
				if($_POST['m_description_ru'])
				{
					$m_descr_ru = $_POST['m_description_ru'];
					$m_descr_ru = htmlspecialchars(stripslashes(trim($m_descr_ru)));
				}
				if($m_descr_ru == '')
				{
					unset($m_descr_ru);
				}
								
				if($_POST['m_keywords_lv'])
				{
					$key_w_lv = $_POST['m_keywords_lv'];
					$key_w_lv = htmlspecialchars(stripslashes(trim($key_w_lv)));
				}
				if($key_w_lv == '')
				{
					unset($key_w_lv);
				}
			
				if($_POST['m_description_lv'])
				{
					$m_descr_lv = $_POST['m_description_lv'];
					$m_descr_lv = htmlspecialchars(stripslashes(trim($m_descr_lv)));
				}
				if($m_descr_lv == '')
				{
					unset($m_descr_lv);
				}
				
				
				if(!empty($key_w_ru))
				{
					$result_upd_key_ru = mysql_query("UPDATE ltd_page_rus SET meta_k = '$key_w_ru' WHERE sh_name = '$sh_name'");
					if($result_upd_key_ru)
					{
						echo "<p align='center'>Successfuly updated keywords for Russian part! Wait...";
						echo "<meta http-equiv='Refresh' content='2; URL=profile.php?lang=".$lang."'></p>";
					}
					else
					{
						echo "<p align='center'>Keywords for Russian part update error!</p>";
					}
				}
				else
				{
					echo "<p align='center'>Keywords for Russian part wasn't changed. Wait...";
					echo "<meta http-equiv='Refresh' content='2; URL=profile.php?lang=".$lang."'></p>";
				}
				
				if(!empty($m_descr_ru))
				{
					$result_upd_descr_ru = mysql_query("UPDATE ltd_page_rus SET meta_d = '$m_descr_ru' WHERE sh_name = '$sh_name'");
					if($result_upd_descr_ru)
					{
						echo "<p align='center'>Successfuly updated meta description for Russian part! Wait...";
						echo "<meta http-equiv='Refresh' content='2; URL=profile.php?lang=".$lang."'></p>";
					}
					else
					{
						echo "<p align='center'>Meta description for Russian part update error!</p>";
					}
				}
				else
				{
					echo "<p align='center'>Description for Russian part wasn't changed. Wait...";
					echo "<meta http-equiv='Refresh' content='2; URL=profile.php?lang=".$lang."'></p>";
				}


				if(!empty($key_w_lv))
				{
					$result_upd_key_lv = mysql_query("UPDATE ltd_page_lat SET meta_k = '$key_w_lv' WHERE sh_name = '$sh_name'");
					if($result_upd_key_lv)
					{
						echo "<p align='center'>Successfuly updated keywords for Latvian part! Wait...";
						echo "<meta http-equiv='Refresh' content='2; URL=profile.php?lang=".$lang."'></p>";
					}
					else
					{
						echo "<p align='center'>Keywords for Latvian part update error!</p>";
					}
				}
				else
				{
					echo "<p align='center'>Keywords for Latvian part wasn't changed. Wait...";
					echo "<meta http-equiv='Refresh' content='2; URL=profile.php?lang=".$lang."'></p>";
				}
				
				if(!empty($m_descr_lv))
				{
					$result_upd_descr_lv = mysql_query("UPDATE ltd_page_lat SET meta_d = '$m_descr_lv' WHERE sh_name = '$sh_name'");
					if($result_upd_descr_lv)
					{
						echo "<p align='center'>Successfuly updated meta description for Latvian part! Wait...";
						echo "<meta http-equiv='Refresh' content='2; URL=profile.php?lang=".$lang."'></p>";
					}
					else
					{
						echo "<p align='center'>Meta description for Latvian part update error!</p>";
					}
				}
				else
				{
					echo "<p align='center'>Description for Latvian part wasn't changed. Wait...";
					echo "<meta http-equiv='Refresh' content='2; URL=profile.php?lang=".$lang."'></p>";
				}
				
			}
			
				$select_ltd_info_rus = mysql_query("SELECT meta_k,meta_d FROM ltd_page_rus WHERE sh_name = '$sh_name'");			
				$select_ltd_info_lat = mysql_query("SELECT meta_k,meta_d FROM ltd_page_lat WHERE sh_name = '$sh_name'");
			
			$row_ltd_info_rus = mysql_fetch_array($select_ltd_info_rus);
			$row_ltd_info_lat = mysql_fetch_array($select_ltd_info_lat);
			
					?>			
			<table width="400px" align="center" border="0" cellpadding="2" cellspacing="0">
            <form action="meta_ltd.php?lang=<?php echo $lang; ?>&ltd=<?php echo $sh_name;?>" method="post">
            <tr>
            <td colspan="3"><input type="hidden" name="hidden" size="3" maxlength="3"></td>
            </tr>
            <tr>
            <td colspan="2" align="center"><h4>Russian part</h4></td>
            </tr>
            <tr>
			<td><p>Meta keywords</p></td>
			<td><textarea name="m_keywords_ru" rows="10" cols="30"><?php echo $row_ltd_info_rus['meta_k']; ?></textarea></td>
			</tr>
            <tr>
            <td><p>Meta description</p></td>
            <td><textarea name="m_description_ru" rows="10" cols="30"><?php echo $row_ltd_info_rus['meta_d']; ?></textarea></td>
            </tr>
            <tr>
            <td colspan="2" align="center"><h4>Latvian part</h4></td>
            </tr>
            <tr>
			<td><p>Meta keywords</p></td>
			<td><textarea name="m_keywords_lv" rows="10" cols="30"><?php echo $row_ltd_info_lat['meta_k']; ?></textarea></td>
			</tr>
            <tr>
            <td><p>Meta description</p></td>
            <td><textarea name="m_description_lv" rows="10" cols="30"><?php echo $row_ltd_info_lat['meta_d']; ?></textarea></td>
            </tr>
            <tr>
			<td align="center" colspan="3"><p><input name="ltd_meta" type="submit" value="<?php echo $ltd_create_opt_but; ?>" /></p></td>
            </tr>
            </form>
            </table>
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
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
		if($row['flag'] === '2')
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
				if($_POST['Value_1'])
				{
					$value = '0';
				}
				elseif($_POST['Value_2'])
				{
					$value = '1';
				}
				elseif($_POST['Value_3'])
				{
					$value = '2';
				}
				else
				{
					$value = '3';
				}
				
				
				if($_POST['page_0'])
				{
					$page_value = '0';
				}
				elseif($_POST['page_1'])
				{
					$page_value = '1';
				}
				else
				{
					$page_value = '3';
				}
				
				
				if(isset($_POST['mess_yes']))
				{
					$mess_yes = $_POST['mess_yes'];
				}
				
				if($mess_yes == '')
				{
					unset($mess_yes);
				}
				
				$value = htmlspecialchars(stripslashes(trim($value)));
				$page_value = htmlspecialchars(stripslashes(trim($page_value)));
				$mess_yes = htmlspecialchars(stripslashes(trim($mess_yes)));

				if($value !== '3')
				{
					$result_update_rus = mysql_query("UPDATE catalogue_rus SET activation = '$value' WHERE ltd_name = '$sh_name'");
					$result_update_lat = mysql_query("UPDATE catalogue_lat SET activation = '$value' WHERE ltd_name = '$sh_name'");
					
					if($result_update_rus && $result_update_lat)
					{
						echo "<p align='center'>Updated catalogue activation values. Wait... <meta http-equiv='Refresh' content='4; URL=profile.php?lang=".$lang."'></p>";
					}
					else
					{
						echo "<p align='center'>Error updating one of the catalogue activation values!</p>";
					}
				}
				else
				{
					echo "<p align='center'>Catalogue activation value wasn't changed. Wait... <meta http-equiv='Refresh' content='4; URL=profile.php?lang=".$lang."'></p>";
				}
					
				if($page_value !== '3')
				{
					$result_update_page_r = mysql_query("UPDATE ltd_page_rus SET activation = '$page_value' WHERE sh_name = '$sh_name'");
					$result_update_page_l = mysql_query("UPDATE ltd_page_lat SET activation = '$page_value' WHERE sh_name = '$sh_name'");
					
					if($result_update_page_r && $result_update_page_l)
					{
						echo "<p align='center'>Updated ltd page activation value. Wait... <meta http-equiv='Refresh' content='4; URL=profile.php'></p>";
					}
					else
					{
						echo "<p align='center'>Error update ltd page activation value!</p>";
					}
				}
				else
				{
					echo "<p align='center'>Ltd page activation value wasn't changed. Wait... <meta http-equiv='Refresh' content='4; URL=profile.php'></p>";
				}
					
				if($mess_yes)
				{
					if($lang == 'rus')
					{
						$result_sh_log = mysql_query("SELECT login FROM catalogue_rus WHERE ltd_name = '$sh_name'");
					}
					else
					{
						$result_sh_log = mysql_query("SELECT login FROM catalogue_lat WHERE ltd_name = '$sh_name'");
					}
							
					$row_sh_log = mysql_fetch_array($result_sh_log);
					$to = $row_sh_log['login'];
							
					if($lang == 'rus')
					{
						$from = "admin@econom.lv";
						$date = date("Y-m-d");
						$info = "Ваша страница была деактивирована, так как время действия представленных вами акций/скидок закончилось.";
					}
					else
					{
						$from = "admin@econom.lv";
						$date = date("Y-m-d");
						$info = "Sakarā ar akciju/atlaižu termiņa beigām, Jūsu lapa tika deaktivizēta.";
					}
							
					$send_mess = mysql_query("INSERT INTO messages VALUES ('','$to','$sh_name','$from','$date','$info','0')");
							
					if(!$send_mess)
					{
						echo "<p><strong>Send message error!</strong><p>";
					}
					else
					{
						echo "<p align='center'>Message successfuly sent. Wait... <meta http-equiv='Refresh' content='4; URL=profile.php?lang=".$lang."'></p>";
					}
				}
				else
				{
					echo "<p align='center'>Message wasn't send. Wait... <meta http-equiv='Refresh' content='4; URL=profile.php?lang=".$lang."'></p>";
				}
					
			}
			?>
            <p><a href="profile.php?lang=<?php echo $lang; ?>">Back to the Ltd preview</a></p>
            <h3 align="center">Activation value of the <?php echo $sh_name; ?> LTD</h3>
            <?php 
			if($lang == 'rus')
			{
				$result_activ = mysql_query("SELECT activation FROM catalogue_rus WHERE ltd_name = '$sh_name'");
				$result_activ_page = mysql_query("SELECT activation FROM ltd_page_rus WHERE sh_name = '$sh_name'");
			}
			else
			{
				$result_activ = mysql_query("SELECT activation FROM catalogue_lat WHERE ltd_name = '$sh_name'");
				$result_activ_page = mysql_query("SELECT activation FROM ltd_page_lat WHERE sh_name = '$sh_name'");
			}
			$row_activ = mysql_fetch_array($result_activ);
			$row_activ_page = mysql_fetch_array($result_activ_page);
			?>
            <h4>Current activation status</h4>
			<p>Page activation status is:
            <?php 
            if($row_activ_page['activation'] == '0')
			{
				echo "<strong>Not activated!</strong>";
			}
			elseif($row_activ_page['activation'] == '1')
			{
				echo "<strong>Page activated!</strong>";
			}
			else
			{
				echo "<strong>Not correct value!</strong>";
			}
			?>
			<br /></p>
            <p>Catalogue activation status is:
			<?php 
			if($row_activ['activation'] == '0')
			{
				echo "<strong>Not activated!</strong>";
			}
			elseif($row_activ['activation'] == '1')
			{
				echo "<strong>Page preview in progress!</strong>";
			}
			elseif($row_activ['activation'] == '2')
			{
				echo "<strong>Catalogue activated!</strong>";
			}
			else
			{
				echo "<strong>Not correct value!</strong>";
			}
			?></p>
            
            <table border="0" align="center" width="330px" align="center">
            <form action="activation.php?lang=<?php echo $lang; ?>&ltd=<?php echo $sh_name; ?>" method="post">
            <tr>
            <td colspan="3" align="center"><p><strong>Page activation</strong></p></td>
            </tr>
            <tr>
            <td align="center"><input type="radio" name="page_0" /></td>
            <td align="center"><input type="radio" name="page_1" /></td>
            <td></td>
            </tr>
            <tr>
            <td align="center"><p>Not activated</p></td>
            <td align="center"><p>Page activated</p></td>
            <td></td>
            </tr>
            <tr>
            <td colspan="3" align="center"><p><strong>Catalogue activation</strong></p></td>
            </tr>
            <tr>
            <td align="center"><input type="radio" name="Value_1" /></td>
            <td width="95px" align="center"><input type="radio" name="Value_2" /></td>
            <td width="95px" align="center"><input type="radio" name="Value_3" /></td>
            </tr>
            <tr>
            <td align="center"><p>Not activated</p></td>
            <td align="center"><p>Page preview in progress</p></td>
            <td align="center"><p>Page activated</p></td>
            </tr>
            <tr>
            <td colspan="3" align="center"><p><strong>Send deactivation message?</strong></p></td>
            </tr>
            <tr>
            <td align="center"></td>
            <td align="center"><input type="checkbox" name="mess_yes" /></td>
            <td align="center"><p>Yes</p></td>
            </tr>
            <tr>
            <td align="center" colspan="3"><input type="submit" name="submit" value="Change" /></td>
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
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
				$old_sh_name = $_GET['ltd'];
				$old_sh_name = htmlspecialchars(stripslashes(trim($old_sh_name)));
			}
			if($old_sh_name == '')
			{
				unset($old_sh_name);
				exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
			}
			
			echo "<p><a href='profile.php?lang=".$lang."'>Back to the Ltd preview</a></p>";
			
			if($_POST['ltd_create'])
			{
				if(!empty($_POST['hidden']))
				{
					exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
				}
				
				if(isset($_POST['sh_name']))
				{
					$sh_name = $_POST['sh_name'];
				}
				if($sh_name == '')
				{
					unset($sh_name);
				}
				
				if(!empty($sh_name))
				{
							
					$sh_name = str_replace("'","",$sh_name);
					$sh_name = str_replace("_"," ",$sh_name);
					$sh_name = str_replace('"',"",$sh_name);
					$sh_name = str_replace('?',"",$sh_name);
					$sh_name = str_replace('<',"",$sh_name);
					$sh_name = str_replace('>',"",$sh_name);
					$sh_name = str_replace('/',"",$sh_name);
					$sh_name = str_replace('|',"",$sh_name);
					$sh_name = str_replace('[',"",$sh_name);
					$sh_name = str_replace(']',"",$sh_name);
					$sh_name = str_replace('{',"",$sh_name);
					$sh_name = str_replace('}',"",$sh_name);
					$sh_name = str_replace('^',"",$sh_name);
					$sh_name = str_replace('£',"",$sh_name);
					$sh_name = str_replace('$',"",$sh_name);
					$sh_name = str_replace('#',"",$sh_name);
					$sh_name = str_replace('~',"",$sh_name);
					$sh_name = str_replace(" & "," and ",$sh_name);
					$sh_name = str_replace("&"," and ",$sh_name);
					$sh_name = str_replace(" @ "," at ",$sh_name);
					$sh_name = str_replace("@"," at ",$sh_name);
					$sh_name = htmlspecialchars(stripslashes(trim($sh_name)));
					
					if($lang == 'rus')
					{
						$result_check_old = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$old_sh_name'");
					}
					else
					{
						$result_check_old = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$old_sh_name'");
					}
					
					if(!mysql_num_rows($result_check_old)>0)
					{
						echo "<p align='center' class='join_us_error'>".$ltd_create_ltd_check_old_1.$old_sh_name.$ltd_create_ltd_check_old_2."</p>";
					}
					else
					{
						if(strlen($sh_name)>50 || strlen($sh_name)<2)
						{
							echo "<p align='center' class='join_us_error'>".$ltd_create_strlen_sh_name."</p>";
						}
						else
						{	
								$result_ch_comm = mysql_query("SELECT sh_name FROM comments WHERE sh_name = '$old_sh_name'");
								if(mysql_num_rows($result_ch_comm)>0)
								{
									mysql_query("UPDATE comments SET sh_name = '$sh_name' WHERE sh_name = '$old_sh_name'");
								}
								
								$result_ch_stats = mysql_query("SELECT sh_name FROM stats WHERE sh_name = '$old_sh_name'");
								if(mysql_num_rows($result_ch_stats)>0)
								{
									mysql_query("UPDATE stats SET sh_name = '$sh_name' WHERE sh_name = '$old_sh_name'");
								}
								
								mysql_query("UPDATE catalogue_rus SET ltd_name = '$sh_name' WHERE ltd_name = '$old_sh_name'");
								mysql_query("UPDATE catalogue_lat SET ltd_name = '$sh_name' WHERE ltd_name = '$old_sh_name'");
								
								mysql_query("UPDATE ltd_page_rus SET sh_name = '$sh_name', title = '$sh_name' WHERE sh_name = '$old_sh_name'");
								mysql_query("UPDATE ltd_page_lat SET sh_name = '$sh_name', title = '$sh_name' WHERE sh_name = '$old_sh_name'");
								
								$result_check_gallery = mysql_query("SELECT * FROM gallery WHERE sh_name = '$old_sh_name'");
								$row_check_gallery = mysql_fetch_array($result_check_gallery);
								if($row_check_gallery['photo_1'] != '' || $row_check_gallery['photo_2'] != '' || 
								   $row_check_gallery['photo_3'] != '' || $row_check_gallery['photo_4'] != '' || 
								   $row_check_gallery['photo_logo'] != '')
								{
									@rename("../../img/ltd/".$old_sh_name,"../../img/ltd/".$sh_name);
						
									if($row_check_gallery['photo_1'] != '')
									{
										mysql_query("UPDATE gallery SET 
													photo_1 = 'img/ltd/$sh_name/1.jpeg', 
													photo_1_s = 'img/ltd/$sh_name/small/1.jpeg' 
													WHERE sh_name = '$old_sh_name'");
									}
									
									if($row_check_gallery['photo_2'] != '')
									{
										mysql_query("UPDATE gallery SET 
													photo_2 = 'img/ltd/$sh_name/2.jpeg', 
													photo_2_s = 'img/ltd/$sh_name/small/2.jpeg' 
													WHERE sh_name = '$old_sh_name'");
									}
									
									if($row_check_gallery['photo_3'] != '')
									{
										mysql_query("UPDATE gallery SET 
													photo_3 = 'img/ltd/$sh_name/3.jpeg', 
													photo_3_s = 'img/ltd/$sh_name/small/3.jpeg'
													WHERE sh_name = '$old_sh_name'");
									}
									
									if($row_check_gallery['photo_4'] != '')
									{
										mysql_query("UPDATE gallery SET 
													photo_4 = 'img/ltd/$sh_name/4.jpeg', 
													photo_4_s = 'img/ltd/$sh_name/small/4.jpeg' 
													WHERE sh_name = '$old_sh_name'");
									}
									
									if($row_check_gallery['photo_logo'] != '')
									{
										mysql_query("UPDATE gallery SET 
													photo_logo = 'img/ltd/$sh_name/logo.jpeg',
													logo_s = 'img/ltd/$sh_name/small/logo_s.jpeg'
													WHERE sh_name = '$old_sh_name'");
									}
									
									mysql_query("UPDATE gallery SET sh_name = '$sh_name'
												WHERE sh_name = '$old_sh_name'");
									
								}
								
								echo "<p align='center'>Information succesfuly updated! Wait...</p>";
								exit("<meta http-equiv='Refresh' content='1; URL=profile.php?lang=".$lang."'>");
						}
					}
				}
				else
				{
					echo "<p align='center'>No information to update! Wait...</p>";
					exit("<meta http-equiv='Refresh' content='1; URL=profile.php?lang=".$lang."'>");
				}
			}
			
			if($lang == 'rus')
			{
				$select_ltd_info = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$old_sh_name'");
			}
			else
			{
				$select_ltd_info = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$old_sh_name'");
			}
			$row_ltd_info = mysql_fetch_array($select_ltd_info);
			
					?>			
			<table width="400px" align="center" border="0" cellpadding="2" cellspacing="0">
            <form action="change_ltd_info.php?lang=<?php echo $lang; ?>&ltd=<?php echo $old_sh_name;?>" method="post">
            <tr>
            <td colspan="3"><input type="hidden" name="hidden" size="3" maxlength="3"></td>
            </tr>
            <tr>
			<td><p><?php echo $ltd_create_name; ?></p></td>
            <td width="50px" align="right"></td>
			<td><input type="text" name="sh_name" size="20" maxlength="50" value="<?php echo $row_ltd_info['sh_name']; ?>" /></td>
			</tr>
            <tr>
			<td align="center" colspan="3"><p><input name="ltd_create" type="submit" value="<?php echo $ltd_create_opt_but; ?>" /></p></td>
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
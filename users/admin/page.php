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
<title><?php echo $page_preview_title; ?></title>
<meta name="robots" content="no-cache, no-follow" /> 
<meta name="revisit-after" content="no-cache, no-revisit"/>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache" />
<link href="../../CSS/eccss.css" rel="stylesheet" type="text/css" />
<!--[if IE ]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="../../CSS/ie7.css" />
<![endif]-->
<link rel="shortcut icon" href="../../img/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="../../js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../../js/fancybox/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="../../js/fancybox/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../../js/fancybox/jquery.fancybox-1.2.1.pack.js"></script>
<script type="text/javascript" src="../../js/gallery.js"></script>
</head>
<body>
<table align="center" width="1010px" border="0">
  <tr>
    <td colspan="3"><div style="margin-top:50px; margin-bottom:50px;" id="bwrap"><table width="100%" border="0">
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
			
			if($lang == 'rus')
			{
				$result_check_old = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$sh_name'");
			}
			else
			{
				$result_check_old = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$sh_name'");
			}
					
			if(!mysql_num_rows($result_check_old)>0)
			{
				message_succes($lang,"<p align='center' class='join_us_error'>".$ltd_create_ltd_check_old_1.$sh_name.$ltd_create_ltd_check_old_2."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
			}
			
			if($lang == 'rus')
			{
				$result_select = mysql_query("SELECT * FROM ltd_page_rus WHERE sh_name = '$sh_name'");
			}
			else
			{
				$result_select = mysql_query("SELECT * FROM ltd_page_lat WHERE sh_name = '$sh_name'");
			}
			
			$result_gallery = mysql_query("SELECT * FROM gallery WHERE sh_name = '$sh_name'");
			$row_gallery = mysql_fetch_array($result_gallery);
			$row_info = mysql_fetch_array($result_select);
			
			echo "<p><a href='profile.php?lang=".$lang."'>Back to the Ltd preview</a></p>";
			
			if($row_gallery['photo_logo'] !== '')
			{
				echo "<p align='center'><img style='position:relative;' src='../../".$row_gallery['photo_logo']."' alt='".$row_info['sh_name']."' /></p>";
			}
			else
			{
				echo "<h2 align = 'center'>".$row_info['sh_name']."</h2>";
			}
			
			echo "<br /><p><strong>PVN number:</strong> ".$row_info['pvn']."</p><br />";
					
			if($lang == 'rus')
			{
				if(!empty($row_info['descr']))
				{
					echo "<br><p>".$row_info['descr']."</p>";
				}
				
				echo "<br /><p><strong>Наше Предложение:</strong><br>".$row_info['descr_offer']."</p>";
				echo "<p class='p1'>*Предложение доступно ".str_replace(" ","",$row_info['from_date_offer'])." - ".str_replace(" ","",$row_info['till_date_offer'])."</p>";
				
				if(!empty($row_info['web']))
				{
					echo "<br><p><strong>Наш веб-сайт: </strong><a href='http://www.".$row_info['web']."' target='_blank'>www.".$row_info['web']."</a></p>";
				}
				
				if(!empty($row_gallery['photo_1']) || !empty($row_gallery['photo_2']) || !empty($row_gallery['photo_3']) || !empty($row_gallery['photo_4']))
				{
					echo "<br><table width='20%' border='0' cellspacing='8' cellpadding='8' align='center'>
					  <tr>
					  <td colspan='4' align='center'><p><strong>Фото Галерея</strong></p></td>
					  </tr>
					  <tr>";
					  if(!empty($row_gallery['photo_1']))
					  {
						echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../../".$row_gallery['photo_1']."'><img style='position:relative;' src='../../".$row_gallery['photo_1_s']."' /></a></fieldset></td>";
					  }
					  
					  if(!empty($row_gallery['photo_2']))
					  {
						echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../../".$row_gallery['photo_2']."'><img style='position:relative;' src='../../".$row_gallery['photo_2_s']."' /></a></fieldset></td>";
					  }
					  
					  if(!empty($row_gallery['photo_3']))
					  {
						echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../../".$row_gallery['photo_3']."'><img style='position:relative;' src='../../".$row_gallery['photo_3_s']."' /></a></fieldset></td>";
					  }
					  
					  if(!empty($row_gallery['photo_4']))
					  {
						echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../../".$row_gallery['photo_4']."'><img style='position:relative;' src='../../".$row_gallery['photo_4_s']."' /></a></fieldset></td>";
					  }
					  
					  echo "</tr>
					  </table>";
				}
					  echo "<br>
							<p><strong>Контакты: </strong>";
							if(!empty($row_info['phone']))
							{
								echo "<br />Телефон: +371 ".$row_info['phone'];
							}
							
							if(!empty($row_info['phone_2']) && !empty($row_info['phone']))
							{
								echo ", +371 ".$row_info['phone_2'];
							}
							
							if(!empty($row_info['fax']))
							{
								echo "<br />
							Факс: +371 ".$row_info['fax'];
							}
							
							echo "<br />E-mail: <a href=\"\" onClick=\"window.open('../ltd_message.php?lang=".$lang."&link=".$sh_name."', 'newWin', 'Toolbar=0, Location=0, Directories=0, Status=0, Menubar=0, Scrollbars=0, Resizable=0, Copyhistory=0, Width=700, Height=510')\">".$page_email."</a></p>"; // v email sdelatj prosto otpravitj soob6enie a ne vistavljatj mail adress
							
							if(!empty($row_info['address']))
							{
								if(!empty($row_info['map']))
								{
									echo "<br>".$row_info['map'];
								}
								else
								{
									echo "<br /><p><a href='add_map.php?lang=".$lang."&ltd=".$sh_name."'>Add map to the page</a></p>";
								}
								
								echo "<br /><p><strong>Контактный адрес:</strong><br />
							".$row_info['address'].", ".$row_info['city'].", Latvija</p><br />";
							}
			}
			else
			{
				if(!empty($row_info['descr']))
				{
					echo "<br><p>".$row_info['descr']."</p>";
				}
				
				echo "<br /><p><strong>Mūsu Piedāvājums:</strong><br>".$row_info['descr_offer']."</p>";
				echo "<p class='p1'>*Piedāvājums spēkā ".str_replace(" ","",$row_info['from_date_offer'])." - ".str_replace(" ","",$row_info['till_date_offer'])."</p>";
				
				if(!empty($row_info['web']))
				{
					echo "<br /><p><strong>Mājaslapa: </strong><a href='http://www.".$row_info['web']."' target='_blank'>www.".$row_info['web']."</a></p>";
				}
				
				if(!empty($row_gallery['photo_1']) || !empty($row_gallery['photo_2']) || !empty($row_gallery['photo_3']) || !empty($row_gallery['photo_4']))
				{
					echo "<br /><table width='20%' border='0' cellspacing='8' cellpadding='8' align='center'>
					  <tr>
					  <td colspan='4' align='center'><p><strong>Foto galerija</strong></p></td>
					  </tr>
					  <tr>";
					  if(!empty($row_gallery['photo_1']))
					  {
						echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../../".$row_gallery['photo_1']."'><img style='position:relative;' src='../../".$row_gallery['photo_1_s']."' /></a></fieldset></td>";
					  }
					  
					  if(!empty($row_gallery['photo_2']))
					  {
						echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../../".$row_gallery['photo_2']."'><img style='position:relative;' src='../../".$row_gallery['photo_2_s']."' /></a></fieldset></td>";
					  }
					  
					  if(!empty($row_gallery['photo_3']))
					  {
						echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../../".$row_gallery['photo_3']."'><img style='position:relative;' src='../../".$row_gallery['photo_3_s']."' /></a></fieldset></td>";
					  }
					  
					  if(!empty($row_gallery['photo_4']))
					  {
						echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../../".$row_gallery['photo_4']."'><img style='position:relative;' src='../../".$row_gallery['photo_4_s']."' /></a></fieldset></td>";
					  }
					  
					  echo "</tr>
					  </table>";
				}
					  echo "<br>
							<p><strong>Kontakti: </strong>";
							if(!empty($row_info['phone']))
							{
								echo "<br />Telefona numurs: +371 ".$row_info['phone'];
							}
							
							if(!empty($row_info['phone_2']) && !empty($row_info['phone']))
							{
								echo ", +371 ".$row_info['phone_2'];
							}
							
							if(!empty($row_info['fax']))
							{
								echo "<br />
							Fakss: +371 ".$row_info['fax'];
							}
							
							echo "<br />E-mail: <a href=\"\" onClick=\"window.open('../ltd_message.php?lang=".$lang."&link=".$sh_name."', 'newWin', 'Toolbar=0, Location=0, Directories=0, Status=0, Menubar=0, Scrollbars=0, Resizable=0, Copyhistory=0, Width=700, Height=510')\">".$page_email."</a></p>";
							
							if(!empty($row_info['address']))
							{
								if(!empty($row_info['map']))
								{
									echo $row_info['map'];
								}
								else
								{
									echo "<br /><p><a href='add_map.php?lang=".$lang."&ltd=".$sh_name."'>Add map to the page</a></p>";	
								}
								
								echo "<br /><p><strong>Adrese:</strong><br />
							".$row_info['address'].", ".$row_info['city'].", Latvija</p><br />";
							}
			}
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
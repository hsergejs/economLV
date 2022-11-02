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

if(empty($_GET["lang"]) && isset($_GET['city']) && isset($_GET['b_def']) && isset($_GET['defcat']) && isset($_GET['link']))
{
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat&city=".$_GET['city']."&b_def=".$_GET['b_def']."&defcat=".$_GET['defcat']."&link=".$_GET['link']."'>";
}
elseif(empty($_GET["lang"]) && isset($_GET['city']) && isset($_GET['b_def']) && isset($_GET['defcat']))
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
include_once("footer_fns.php");
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
<link href="../CSS/eccss.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="../CSS/ie7.css" />
<![endif]-->
<script type="text/javascript">
if(window.opera) {document.write('<link rel="stylesheet" type="text/css" href="../CSS/opera.css" />');}
</script>
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="../js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../js/fancybox/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="../js/fancybox/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../js/fancybox/jquery.fancybox-1.2.1.pack.js"></script>
<script type="text/javascript" src="../js/gallery.js"></script>
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
	$row = mysql_fetch_array($result);
	$login_db = $row['login'];
	$passwd_db = $row['passwd'];
	if(mysql_num_rows($result)>0 && $login === $login_db && $passwd === $passwd_db)
	{	if(isset($_GET['ltd']))
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
				  message_succes($lang,"<p align='center' class='join_us_error'>".$ltd_create_ltd_check_old_1.$sh_name.$ltd_create_ltd_check_old_2."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
			}
						
		if(!mysql_num_rows($result_check_owner)>0)
			{
				  message_succes($lang,"<p align='center' class='join_us_error'>".$change_ltd_no_owner."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
			}
		
		if($lang == 'rus')
		{
			$result_select = mysql_query("SELECT * FROM ltd_page_rus WHERE login = '$login' AND sh_name = '$sh_name'");
		}
		else
		{
			$result_select = mysql_query("SELECT * FROM ltd_page_lat WHERE login = '$login' AND sh_name = '$sh_name'");
		}
		
		$result_gallery = mysql_query("SELECT * FROM gallery WHERE login = '$login' AND sh_name = '$sh_name'");
		$row_gallery = mysql_fetch_array($result_gallery);
		$row_info = mysql_fetch_array($result_select);

		if(!empty($row_gallery['photo_logo']))
		{
			echo "<p align='center'><img style='position:relative;' src='../".$row_gallery['photo_logo']."' alt='".$row_info['sh_name']."' /></p>";
		}
		else
		{
            echo "<h2 align = 'center'>".$sh_name."</h2>";
		}
		
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
    			  	echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_1']."'><img style='position:relative;' src='../".$row_gallery['photo_1_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_2']))
				  {
    			  	echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_2']."'><img style='position:relative;' src='../".$row_gallery['photo_2_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_3']))
				  {
				  	echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_3']."'><img style='position:relative;' src='../".$row_gallery['photo_3_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_4']))
				  {
				  	echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_4']."'><img style='position:relative;' src='../".$row_gallery['photo_4_s']."' /></a></fieldset></td>";
				  }
				  
				  echo "</tr>
				  </table>";
			}
			
			if(!empty($row_info['phone']) || (!empty($row_info['phone_2']) && !empty($row_info['phone'])) || !empty($row_info['fax']))
			{
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
						Факс: +371 ".$row_info['fax']."</p>";
						}
						
						if(!empty($row_info['address']))
						{
							if(!empty($row_info['map']))
							{
								echo "<br><p>".$row_info['map']."</p>";
							}
							else
							{
								echo "<br><p style='margin-top:80px; margin-bottom:30px;'>".$page_preview_no_map."</p>";
							}
							
							echo "<br /><p><strong>Контактный адрес:</strong><br />
						".$row_info['address'].", ".$row_info['city'].", Latvija</p><br />";
						}
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
    			  	echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_1']."'><img style='position:relative;' src='../".$row_gallery['photo_1_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_2']))
				  {
    			  	echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_2']."'><img style='position:relative;' src='../".$row_gallery['photo_2_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_3']))
				  {
				  	echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_3']."'><img style='position:relative;' src='../".$row_gallery['photo_3_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_4']))
				  {
				  	echo "<td><fieldset><a class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_4']."'><img style='position:relative;' src='../".$row_gallery['photo_4_s']."' /></a></fieldset></td>";
				  }
				  
				  echo "</tr>
				  </table>";
			}
			
			if(!empty($row_info['phone']) || (!empty($row_info['phone_2']) && !empty($row_info['phone'])) || !empty($row_info['fax']))
			{
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
						Fakss: +371 ".$row_info['fax']."</p>";
						}
						
						if(!empty($row_info['address']))
						{
							if(!empty($row_info['map']))
							{
								echo "<br><p>".$row_info['map']."</p>";
							}
							else
							{
								echo "<br><p style='margin-top:80px; margin-bottom:30px;'>".$page_preview_no_map."</p>";
							}
							
							echo "<br /><p><strong>Adrese:</strong><br />
						".$row_info['address'].", ".$row_info['city'].", Latvija</p><br />";
						}
			}
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
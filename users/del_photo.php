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
<title><?php echo $del_photo_title; ?></title>
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
				  message_succes($lang,"<p align='center' class='join_us_error'>".$ltd_create_ltd_check_old_1.$sh_name.$ltd_create_ltd_check_old_2."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
			}
						
		if(!mysql_num_rows($result_check_owner)>0)
			{
				  message_succes($lang,"<p align='center' class='join_us_error'>".$change_ltd_no_owner."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
			}
		
		$result_gallery = mysql_query("SELECT * FROM gallery WHERE login = '$login' AND sh_name = '$sh_name'");
		$row_gallery = mysql_fetch_array($result_gallery);
		
		if($_POST['del_photo'])
		{
			$photo_g_1 = $row_gallery['photo_1'];
			$photo_g_1_s = $row_gallery['photo_1_s'];
			
			$photo_g_2 = $row_gallery['photo_2'];
			$photo_g_2_s = $row_gallery['photo_2_s'];
			
			$photo_g_3 = $row_gallery['photo_3'];
			$photo_g_3_s = $row_gallery['photo_3_s'];
			
			$photo_g_4 = $row_gallery['photo_4'];
			$photo_g_4_s = $row_gallery['photo_4_s'];
			
			$photo_g_5 = $row_gallery['photo_logo'];
			
			if($_POST['photo_1'])
			{
				$result_del = mysql_query("UPDATE gallery SET photo_1 = '' WHERE login = '$login' AND sh_name = '$sh_name'");
				$result_del_s = mysql_query("UPDATE gallery SET photo_1_s = '' WHERE login = '$login' AND sh_name = '$sh_name'");
				$photo_cat_1 = "../".$photo_g_1;
				$photo_cat_1_small = "../".$photo_g_1_s;
				unlink($photo_cat_1);
				unlink($photo_cat_1_small);
			}
			
			if($_POST['photo_2'])
			{
				$result_del = mysql_query("UPDATE gallery SET photo_2 = '' WHERE login = '$login' AND sh_name = '$sh_name'");
				$result_del_s = mysql_query("UPDATE gallery SET photo_2_s = '' WHERE login = '$login' AND sh_name = '$sh_name'");
				$photo_cat_2 = "../".$photo_g_2;
				$photo_cat_2_small = "../".$photo_g_2_s;
				unlink($photo_cat_2);
				unlink($photo_cat_2_small);
			}
			
			if($_POST['photo_3'])
			{
				$result_del = mysql_query("UPDATE gallery SET photo_3 = '' WHERE login = '$login' AND sh_name = '$sh_name'");
				$result_del_s = mysql_query("UPDATE gallery SET photo_3_s = '' WHERE login = '$login' AND sh_name = '$sh_name'");
				$photo_cat_3 = "../".$photo_g_3;
				$photo_cat_3_small = "../".$photo_g_3_s;
				unlink($photo_cat_3);
				unlink($photo_cat_3_small);
			}
			
			if($_POST['photo_4'])
			{
				$result_del = mysql_query("UPDATE gallery SET photo_4 = '' WHERE login = '$login' AND sh_name = '$sh_name'");
				$result_del_s = mysql_query("UPDATE gallery SET photo_4_s = '' WHERE login = '$login' AND sh_name = '$sh_name'");
				$photo_cat_4 = "../".$photo_g_4;
				$photo_cat_4_small = "../".$photo_g_4_s;
				unlink($photo_cat_4);
				unlink($photo_cat_4_small);
			}
			
			if($_POST['logo'])
			{
				$result_del = mysql_query("UPDATE gallery SET photo_logo = '' WHERE login = '$login' AND sh_name = '$sh_name'");
				$photo_cat_5 = "../".$photo_g_5;
				unlink($photo_cat_5);
			}
			
			echo "<meta http-equiv='Refresh' content='0; URL=del_photo.php?lang=".$lang."&ltd=".$sh_name."'>";
			
		}
		
		if(!empty($row_gallery['photo_1']) || !empty($row_gallery['photo_2']) || !empty($row_gallery['photo_3']) || !empty($row_gallery['photo_4']) || !empty($row_gallery['photo_logo']))
		{
			echo "<br><table width='20%' border='0' cellspacing='8' cellpadding='8' align='center'>
   				  <tr>
    			  <td colspan='5' align='center'><p><strong>".$del_photo."</strong></p></td>
    			  </tr>
  				  <tr>";
				  if(!empty($row_gallery['photo_1']))
				  {
    			  	echo "<td><fieldset><a class='gallery' rel='".$sh_name."' title='".$sh_name."' href='../".$row_gallery['photo_1']."'><img style='position:relative;' src='../".$row_gallery['photo_1_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_2']))
				  {
    			  	echo "<td><fieldset><a class='gallery' rel='".$sh_name."' title='".$sh_name."' href='../".$row_gallery['photo_2']."'><img style='position:relative;' src='../".$row_gallery['photo_2_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_3']))
				  {
				  	echo "<td><fieldset><a class='gallery' rel='".$sh_name."' title='".$sh_name."' href='../".$row_gallery['photo_3']."'><img style='position:relative;' src='../".$row_gallery['photo_3_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_4']))
				  {
				  	echo "<td><fieldset><a class='gallery' rel='".$sh_name."' title='".$sh_name."' href='../".$row_gallery['photo_4']."'><img style='position:relative;' src='../".$row_gallery['photo_4_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_logo']))
				  {
				  	echo "<td><fieldset><a class='gallery' rel='".$sh_name."' title='".$sh_name."' href='../".$row_gallery['photo_logo']."'><img style='position:relative;' src='../".$row_gallery['photo_logo']."' /></a></fieldset></td>";
				  }
				  
				  echo "</tr>
				  <tr><form action='del_photo.php?lang=".$lang."&ltd=".$sh_name."' method='post'>";
				  
				  if(!empty($row_gallery['photo_1']))
				  {
    			  	echo "<td align='center'><input type='checkbox' name='photo_1' /><p>".$pic." 1</p></td>";
				  }
				  
				  if(!empty($row_gallery['photo_2']))
				  {
    			  	echo "<td align='center'><input type='checkbox' name='photo_2' /><p>".$pic." 2</p></td>";
				  }
				  
				  if(!empty($row_gallery['photo_3']))
				  {
    			  	echo "<td align='center'><input type='checkbox' name='photo_3' /><p>".$pic." 3</p></td>";
				  }
				  
				  if(!empty($row_gallery['photo_4']))
				  {
    			  	echo "<td align='center'><input type='checkbox' name='photo_4' /><p>".$pic." 4</p></td>";
				  }
				  
				  if(!empty($row_gallery['photo_logo']))
				  {
    			  	echo "<td align='center'><input type='checkbox' name='logo' /><p>".$profile_logo_td."</p></td>";
				  }
				  
				  echo "</tr>
				  <tr>
				  <td colspan='5' align='center'><input type='submit' name='del_photo' value=".$del_photo_butt." /></td>
				  </tr>
				  </table>";
				  
				  echo "<p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>";
		}
		else
		{
            echo "<hr /><h3 style='margin-top:50px; margin-bottom:50px;' align = 'center'>".$del_photo_no."</h3><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>";
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
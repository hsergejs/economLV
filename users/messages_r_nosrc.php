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
<title><?php echo $message_r_nosrc_title; ?></title>
<meta name="robots" content="no-cache, no-follow" /> 
<meta name="revisit-after" content="no-cache, no-revisit"/>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache" />
<link href="../CSS/eccss.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="../CSS/ie7.css" />
<![endif]-->
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
    <td colspan="3"><div id="bwrap"><table style="margin-bottom:20px;" width="100%" border="0">
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
	?>
<div style="margin-left:450px; margin-bottom:10px;">
<table border="0" cellpadding="10" cellspacing="0">
<tr>
<td width="200px" align="center"><p><strong><a style="font-size:12px;" href='messages.php?lang=<?php echo $lang; ?>'><?php echo $profile_message; ?> (<?php 
														$result_message = mysql_query("SELECT COUNT(text) FROM messages WHERE login = '$login' AND active = '0'");
														$row_message = mysql_fetch_array($result_message);
														if(mysql_num_rows($result_message)>0)
														{
															if($row_message[0] == '0')
															{
																echo $row_message[0];
															}
															else
															{
																$mess = $row_message[0] - 1;
																echo $mess;
															}
														}
														?>)</a></strong></p>
</td>
<td width="200px" align="center"><p><strong><a style="font-size:12px;" href='logout.php?lang=<?php echo $lang; ?>'><?php echo $profile_logout; ?></a></strong></p></td>
</tr>
</table>
</div>
<div style="position:relative; float:left; margin-right:50px; margin-top:50px;">
<table style="border:#CCC solid 1px;" border="1" cellpadding="0" cellspacing="0">
<tr>
<td><img style="position:relative;" src="<?php echo $row['avatar'];?>" /></td>
</tr>
</table>
</div>
<table border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
<td><p><?php echo $profile_nick; ?>: </p></td>
<td colspan="2"><p><?php echo $row['nick']; ?></p></td>
</tr>
<tr>
<td><p><?php echo $profile_mail; ?>: </p></td>
<td colspan="2"><p><?php echo $row['login']; ?></p></td>
</tr>
<tr>
<td><p style="margin-right:60px;"><?php echo $profile_reg_date; ?> </p></td>
<td><p style="margin-right:40px;"><?php 
$date_time = $row['reg_date'];
$date_time = explode(" ",$date_time);
$date_time[0] = explode("-",$date_time[0]);
$date_time[1] = explode(":",$date_time[1]);
echo $comm_date." ".$date_time[0][2]."/".$date_time[0][1]."/".$date_time[0][0]."</p></td><td><p>".$comm_time." ".$date_time[1][0].":".$date_time[1][1] ;?></p></td>
</tr>
<tr>
<td><p style="margin-right:60px;"><?php echo $profile_last_visit; ?> </p></td>
<td><p style="margin-right:40px;"><?php 
$date_time = $row['last_visit'];
$date_time = explode(" ",$date_time);
$date_time[0] = explode("-",$date_time[0]);
$date_time[1] = explode(":",$date_time[1]);
echo $comm_date." ".$date_time[0][2]."/".$date_time[0][1]."/".$date_time[0][0]."</p></td><td><p>".$comm_time." ".$date_time[1][0].":".$date_time[1][1] ;?></p></td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
		<?php        
			if(isset($_GET['id']))
			{
				$id = $_GET['id'];
			}
			if($id == '')
			{
				unset($id);
			}
			
			if(isset($_GET['act']))
			{
				$act = $_GET['act'];
			}
			if($act == '')
			{
				unset($act);
			}			
            
			if($act == 'r')
			{
				$result_message = mysql_query("SELECT * FROM messages WHERE login = '$login' AND id = '$id'");
				if(mysql_num_rows($result_message)>0)
				{
					$row_message = mysql_fetch_array($result_message);
					if($row_message['active'] == '0')
					{
						$result_activ = mysql_query("UPDATE messages SET active = '1' WHERE login = '$login' AND id = '$id'");
					}
					?>
					<table style="margin-top:20px;" width="100%" class="profile_table" border="1" cellpadding="10" cellspacing="0">
					<tr>
					<td width="100px"><p><strong><?php echo $messages_sender; ?>: </strong></p></td>
					<td><p><?php echo $row_message['from']; ?></p></td>
					</tr>
					<tr>
					<td><p><strong><?php echo $messages_date; ?>: </strong></p></td>
					<td><p><?php
						$date = $row_message['date'];
						$date = explode('-',$date);
						echo $date[2]."/".$date[1]."/".$date[0]; ?></p></td>
					</tr>
					<tr>
					<td valign="top"><p><strong><?php echo $messages_text; ?>: </strong></p></td>
					<td><p><?php echo $row_message['text']; ?></p></td>
					</tr>
					</table>
					<?php
				}
				else
				{
					exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
				}
			}		
	}
	else
	{
		profile_footer($lang,"<p align='center' class='join_us_error'>".$profile_no_user."</p>");
	}
}

?>
    </td></tr></table></div></td>
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
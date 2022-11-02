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
</head>
<body>
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
	{	if(isset($_GET['id']))
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
					?><div id="bwrap">
					<table border="0" cellpadding="10" cellspacing="0">
					<tr>
					<td><p><strong><?php echo $messages_sender; ?>: </strong></p></td>
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
					</table></div>
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
</body>
</html>
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
<title><?php echo $messages_title; ?></title>
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
<td width="200px" align="center"><p><strong><a style="font-size:12px;" href='profile.php?lang=<?php echo $lang; ?>'><?php echo $messages_link_profile; ?></a></strong></p>
</td>
<td width="200px" align="center"><p><strong><a style="font-size:12px;" href='logout.php?lang=<?php echo $lang; ?>'><?php echo $profile_logout; ?></a></strong></p></td>
</tr>
</table>
</div>
<div id="avatar_img_m">
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
		$result_message = mysql_query("SELECT * FROM messages WHERE login = '$login' ORDER BY date DESC");
        if(mysql_num_rows($result_message)>0)
		{
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
            ?>
			<h4 align="center"><?php echo $messages_head; ?></h4>
            <?php
            if($act == 'd')
			{
				?>
                <table width="100%" border="0" align="left" cellpadding="10" cellspacing="0">
            	<tr>
            	<td height="80px">
                <?php
				$result_del_mess = mysql_query("DELETE FROM messages WHERE id = '$id' AND login = '$login'");
				if(!$result_del_mess)
				{
					echo "<p class='join_us_error'>".$messages_del_unsecc."</p>";
				}
				else
				{
					echo "<meta http-equiv='Refresh' content='0; URL=messages.php?lang=".$lang."'>";
				}
                ?>
				</td>
            	</tr>
            	</table>
                <?php
			}
			?>
			<table class="profile_table" width="100%" border="1" cellpadding="5" cellspacing="0">
            <tr>
			<td width='100px' align="center"><p><?php echo $messages_ltd; ?></p></td>
			<td width='150px' align="center"><p><?php echo $messages_sender; ?></p></td>
			<td align="center"><p><?php echo $messages_text; ?></p></td>
			<td width='110px' align="center"><p><?php echo $messages_date; ?></p></td>
			<td width='170px' align="center"><p><?php echo $profile_menu_td; ?></p></td>
			</tr>
			<?php
			while($row_message = mysql_fetch_array($result_message))
			{
				if($row_message['active'] == '0')
				{	
					?>
					<tr>
					<td align="center"><p><strong><?php echo $row_message['for_sh_name']; ?></strong></p></td>
					<td align="center"><p><strong><?php echo $row_message['from']; ?></strong></p></td>
					<td><p><strong><?php echo substr($row_message['text'],0,100)." ..."; ?></strong></p></td>
					<td align="center"><p><strong><?php
					$date = $row_message['date'];
					$date = explode('-',$date);
					echo $date[2]."/".$date[1]."/".$date[0]; ?></strong></p></td>
					<td align="center">
                    <p><a href="messages_r_nosrc.php?lang=<?php echo $lang;?>&id=<?php echo $row_message['id']; ?>&act=r"><strong><?php echo $messages_read; ?></strong></a></p>
                    <p><a href='messages.php?lang=<?php echo $lang; ?>&id=<?php echo $row_message['id']; ?>&act=d'><strong><?php echo $messages_delet; ?></strong></a></p>
                    </td>
					</tr>
					<?php
				}
				else
				{
					?>
					<tr>
					<td align="center"><p><?php echo $row_message['for_sh_name']; ?></p></td>
					<td align="center"><p><?php echo $row_message['from']; ?></p></td>
					<td><p><?php echo substr($row_message['text'],0,100)." ..."; ?></p></td>
					<td align="center"><p><?php
					$date = $row_message['date'];
					$date = explode('-',$date);
					echo $date[2]."/".$date[1]."/".$date[0]; ?></p></td>
					<td align="center"><p><a href="messages_r_nosrc.php?lang=<?php echo $lang;?>&id=<?php echo $row_message['id']; ?>&act=r"><strong><?php echo $messages_read; ?></strong></a></p>
                    <p><a href='messages.php?lang=<?php echo $lang; ?>&id=<?php echo $row_message['id']; ?>&act=d'><strong><?php echo $messages_delet; ?></strong></a></p>
                    </td>
					</tr>
					<?php
				}
			}
			?>
			</table>
			<?php		
		}
		else
		{
			echo "<hr /><h3 style='margin-top:50px; margin-bottom:50px;' align='center'>".$messages_no."</h3>";
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
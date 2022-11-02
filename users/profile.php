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
	$login = $_SESSION['login'];
	$passwd = $_SESSION['passwd'];
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
<title><?php echo $profile_title; ?></title>
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
		if($lang == 'rus')
		{
			$ltd_check = mysql_query("SELECT * FROM ltd_page_rus WHERE login = '$login' ORDER BY from_date_offer AND till_date_offer ASC");
		}
		else
		{
			$ltd_check = mysql_query("SELECT * FROM ltd_page_lat WHERE login = '$login' ORDER BY from_date_offer AND till_date_offer ASC");
		}
		
		if(mysql_num_rows($ltd_check)>0)
		{
			$margin_pr = "100px";
		}
		else
		{
			$margin_pr = "300px";
		}
		?>
<div style="margin-left:<?php echo $margin_pr; ?>; margin-bottom:10px;">
<table border="0" cellpadding="10" cellspacing="0">
<tr>
<td width="190px" align="center"><p><strong><a style="font-size:12px;" href='delet_user.php?lang=<?php echo $lang; ?>'><?php echo $profile_delet_user; ?></a></strong></p></td>
<td width="210px" align="center"><p><strong><a style="font-size:12px;" href='ltd_create_opt_g.php?lang=<?php echo $lang;?>'><?php echo $profile_ltd_create; ?></a></strong></p></td>
<?php 
if(mysql_num_rows($ltd_check)>0)
{
	?>
	<td width="210px" align="center"><p><strong><a style="font-size:12px;" href='messages.php?lang=<?php echo $lang; ?>'><?php echo $profile_message; ?> (<?php 
														$result_message = mysql_query("SELECT COUNT(text) FROM messages WHERE login = '$login' AND active = '0'");
														$row_message = mysql_fetch_array($result_message);
														if(mysql_num_rows($result_message)>0)
														{
															echo $row_message[0];
														}
														?>)</a></strong></p>
</td>
<?php 
} ?>
<td width="190px" align="center"><p style="padding:0px; margin:0px;"><strong><a style="font-size:12px;" href='logout.php?lang=<?php echo $lang; ?>'><?php echo $profile_logout; ?></a></p></strong></td>
</tr>
</table>
</div>
<div id="avatar_img">
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
<tr><form action="change_user_info.php?lang=<?php echo $lang; ?>" method="POST">
<td valign="top"><p>
<select name="change_user_info">
<option value="nick_f"><?php echo $profile_change_nick; ?></option>
<option value="mail_f"><?php echo $profile_change_mail; ?></option>
<option value="passwd_f"><?php echo $profile_change_pass; ?></option>
<option value="avatar_f"><?php echo $profile_change_avatar; ?></option>
</select>
</p></td>
<td colspan="2" valign="top">
<p><input type="submit" name="change_user_info_b" value="<?php echo $profile_change_button; ?>" /></p>
</form>
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td>
		<?php
		if(mysql_num_rows($ltd_check)>0)
		{
			?>
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
			<td align="center"><h3><?php echo $profile_ltd_h4; ?></h3></td>
			</tr>
			<tr>
            <td>
            <table align="center" class="profile_table" border="1" cellpadding="5" cellspacing="0">
            <tr>
			<td align="center"><p><?php echo $profile_ltd_td; ?></p></td>
			<td align="center"><p><?php echo $profile_descr_offer_td; ?></p></td>
			<td align="center" colspan="2"><p><?php echo $profile_dates_td; ?></p></td>
            <td align="center"><p><?php echo $profile_activation; ?></p></td>
			<td align="center"><p><?php echo $profile_menu_td; ?></p></td>
			</tr>
			<?php			
			while($ltd_row = mysql_fetch_array($ltd_check))
			{
				$offer = substr($ltd_row['descr_offer'], 0, 400);
				$offer = str_replace("<br />", "", $offer);
				echo "<tr>
					 <td width='100px' align='center'><p>".$ltd_row['sh_name']."</p></td>
					 <td><p>".mb_convert_encoding($offer, "utf8", "utf8")." ...</p></td>
					 <td width='110px' align='center'><p>".str_replace(" ","",$ltd_row['from_date_offer'])."</p></td>
					 <td width='110px' align='center'><p>".str_replace(" ","",$ltd_row['till_date_offer'])."</p></td>";
					 if($lang == 'rus')
					 {
						$sh_name = $ltd_row['sh_name'];
						$select_cat_rus = mysql_query("SELECT activation FROM catalogue_rus WHERE login = '$login' AND ltd_name = '$sh_name'");
						$cat_row = mysql_fetch_array($select_cat_rus);
					 }
					 else
					 {
						 $sh_name = $ltd_row['sh_name'];
						 $select_cat_lat = mysql_query("SELECT activation FROM catalogue_lat WHERE login = '$login' AND ltd_name = '$sh_name'");
						 $cat_row = mysql_fetch_array($select_cat_lat);
					 }
					
					 if($cat_row['activation'] == '1')
					 {
						 echo "<td align='center'><p>".$ltd_activation_1."</p>";
					 }
					 elseif($cat_row['activation'] == '2')
					 {
						 echo "<td align='center'><p>".$ltd_activation_2."</p>";
					 }
					 else
					 {
						 echo "<td align='center'><p>".$ltd_activation_0."</p>";
					 }
					 
					 if($lang == 'rus')
					 {
						 $m_width = "width='230px'";
					 }
					 else
					 {
						 $m_width = "width='210px'";
					 }
					 
					 echo "<td ".$m_width." align='right'><p style='padding:0px;'><a href='change_ltd_opt.php?lang=".$lang."&ltd=".$ltd_row['sh_name']."'><strong>".$profile_link_td."</strong></a><br>
					 									  <a href='erase_ltd.php?lang=".$lang."&ltd=".$ltd_row['sh_name']."'><strong>".$profile_link_erase_td."</strong></a></p>
					 									 <p style='padding:0px;'><a href='change_cat_g.php?lang=".$lang."&ltd=".$ltd_row['sh_name']."'><strong>".$profile_link1_td."</strong></a></p>";
														 $result_gal_ch = mysql_query("SELECT * FROM gallery WHERE login = '$login' AND sh_name = '$sh_name'");
														 $row_gallery = mysql_fetch_array($result_gal_ch);
														 if(!empty($row_gallery['photo_1']) || !empty($row_gallery['photo_2']) || !empty($row_gallery['photo_3']) || !empty($row_gallery['photo_4']) || !empty($row_gallery['photo_logo']))
														 {
													     	echo "<p style='padding:0px;'><a href='upload.php?lang=".$lang."&ltd=".$ltd_row['sh_name']."'><strong>".$profile_link2_td."</strong></a><br/>
														  <a href='del_photo.php?lang=".$lang."&ltd=".$ltd_row['sh_name']."'><strong>".$profile_link2_a_td."</strong></a></p>";
														 }
														 else
														 {
															 echo "<p style='padding:0px;'><a href='upload.php?lang=".$lang."&ltd=".$ltd_row['sh_name']."'><strong>".$profile_link2a_td."</strong></a><br/>";
														 }
														 
													   echo "<p style='padding:0px;'><a href='page_preview.php?lang=".$lang."&ltd=".$ltd_row['sh_name']."'><strong>".$profile_link3_td."</strong></a></p>
													   <p><a href='delet_ltd.php?lang=".$lang."&ltd=".$ltd_row['sh_name']."'><strong>".$profile_link4_td."</strong></a></p></td>
					 </tr>";
					 
					 $stats_res = mysql_query("SELECT views FROM stats WHERE login = '$login' AND sh_name = '$sh_name'");
					 $stats_row = mysql_fetch_array($stats_res);
					 echo "<tr><td colspan='6'>
					 <table align='right' border='0'>
					 <tr>
					 <td><p>".$profile_stats.":</p> </td>";
					 if(mysql_num_rows($stats_res)>0)
					 {
					 	echo "<td style='padding-left:10px'><p>".$stats_row['views']."</p></td>";
					 }
					 else
					 {
						 echo "<td style='padding-left:10px'><p>0</p></td>";
					 }
					 echo "</tr>
					 </table>
					 </td></tr>";
			}
			?>
            </table>
            </td>
            </tr>
			</table>
			<?php
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
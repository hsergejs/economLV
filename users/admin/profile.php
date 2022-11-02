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
		if($row['flag'] === '2')
		{	
					?>			
			<table border="0" cellpadding="0" cellspacing="0">
			<?php 
			if($lang == 'rus')
			{
				$ltd_check = mysql_query("SELECT * FROM ltd_page_rus ORDER BY from_date_offer AND till_date_offer ASC");
			}
			else
			{
				$ltd_check = mysql_query("SELECT * FROM ltd_page_lat ORDER BY from_date_offer AND till_date_offer ASC");
			}
			
			if(isset($_GET['drop_count']))
			{
				$sh_name = $_GET['ltd'];
				$drop_count = $_GET['drop_count'];
				
				if($drop_count === '1')
				{
					mysql_query("DELETE FROM stats WHERE sh_name = '$sh_name'");
					mysql_query("DELETE FROM top_index WHERE sh_name = '$sh_name'");
					unset($drop_count);
					echo "<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>";
				}
				else
				{
					unset($drop_count);
				}
			}
			
			if(isset($_GET['update_id']))
			{
				$sh_name = $_GET['ltd'];
				$upd_id = $_GET['update_id'];
				$result_id = mysql_query("SELECT id FROM ltd_page_rus ORDER BY id DESC LIMIT 1");
				$row_id = mysql_fetch_array($result_id);
				$new_id = $row_id['id'] + 1;
				
				if($upd_id === '1')
				{
					mysql_query("UPDATE ltd_page_rus SET id = '$new_id' WHERE sh_name = '$sh_name'");
					mysql_query("UPDATE ltd_page_lat SET id = '$new_id' WHERE sh_name = '$sh_name'");
					echo "<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>";
				}
				else
				{
					unset($upd_id);
				}
			}
			
			?>
			<tr>
			<td><p><a href='../logout.php?lang=<?php echo $lang; ?>'><?php echo $profile_logout; ?></a></p></td>
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
                    <td align="center"><p>Login</p></td>
                    <td align="center"><p><?php echo $profile_ltd_td; ?></p></td>
                    <td align="center"><p><?php echo $profile_descr_offer_td; ?></p></td>
                    <td align="center" colspan="2"><p><?php echo $profile_dates_td; ?></p></td>
                    <td align="center"><p><?php echo $profile_activation; ?></p></td>
                    <td width="130px" align="center"><p><?php echo $profile_menu_td; ?></p></td>
                    </tr>
				<?php
				while($ltd_row = mysql_fetch_array($ltd_check))
				{
					?>
                    <tr>
                    <td align="center"><?php echo $ltd_row['login']; ?></td>
                    <td align="center"><?php echo $ltd_row['sh_name']; ?></td>
                    <td align="center"><?php echo substr($ltd_row['descr_offer'], 0,400)." ..."; ?></td>
                    <td align="center"><?php echo str_replace(" ","",$ltd_row['from_date_offer']); ?></td>
                    <td align="center"><?php echo str_replace(" ","",$ltd_row['till_date_offer']); ?></td>
                    <td align="center"><?php 
					if($lang == 'rus')
					 {
						$sh_name = $ltd_row['sh_name'];
						$sh_login = $ltd_row['login'];
						$select_cat_rus = mysql_query("SELECT activation FROM catalogue_rus WHERE login = '$sh_login' AND ltd_name = '$sh_name'");
						$cat_row = mysql_fetch_array($select_cat_rus);
					 }
					 else
					 {
						 $sh_name = $ltd_row['sh_name'];
						 $sh_login = $ltd_row['login'];
						 $select_cat_lat = mysql_query("SELECT activation FROM catalogue_lat WHERE login = '$sh_login' AND ltd_name = '$sh_name'");
						 $cat_row = mysql_fetch_array($select_cat_lat);
					 }
					
					 if($cat_row['activation'] == '0')
					 {
					 	echo "<p><strong style='color:red;'>".$ltd_activation_0."</strong></p>";
					 }
					 elseif($cat_row['activation'] == '1')
					 {
						 echo "<p style='color:red;'>".$ltd_activation_1."</p>";
					 }
					 elseif($cat_row['activation'] == '2')
					 {
						 echo "<p>".$ltd_activation_2."</p>";
					 }
					 else
					 {
						echo "<p>Not correct value!</p>" ;
					 }
					 ?></td>
                     <td align="right"><p><a href='page.php?lang=<?php echo $lang; ?>&ltd=<?php echo $ltd_row['sh_name']; ?>'><?php echo $profile_link3_td; ?></a></p>
                     <p><a href="activation.php?lang=<?php echo $lang; ?>&ltd=<?php echo $ltd_row['sh_name']; ?>">Activation</a></p>
                     <p><?php
					 if(!empty($ltd_row['address']))
					 {
					 	if(empty($ltd_row['map']))
					 	{
					 		echo "<a href='add_map.php?lang=".$lang."&ltd=".$sh_name."'>Add map</a>";
					 	}
						else
						{
							echo "<a href='add_map.php?lang=".$lang."&ltd=".$sh_name."'>Update map</a>";
						}
					 }
					 ?></p>
                     <p><a href="change_cat.php?lang=<?php echo $lang; ?>&ltd=<?php echo $ltd_row['sh_name']; ?>"><?php echo $profile_link1_td; ?></a></p>
                     <p><a href="change_ltd_info.php?lang=<?php echo $lang; ?>&ltd=<?php echo $ltd_row['sh_name']; ?>"><?php echo $profile_link_td; ?></a></p>
                     <p><a href="meta_ltd.php?lang=<?php echo $lang; ?>&ltd=<?php echo $ltd_row['sh_name']; ?>">Edit meta</a></p>
                     </td></td>
                    </tr>
                    <?php
					$stats_res = mysql_query("SELECT views FROM stats WHERE sh_name = '$sh_name'");
					$stats_row = mysql_fetch_array($stats_res);
					 echo "<tr><td colspan='6'>
					 <table align='right' border='0'>
					 <tr>
					 <td>".$profile_stats.": </td>";
					 if(mysql_num_rows($stats_res)>0)
					 {
					 	echo "<td style='padding-left:10px'>".$stats_row['views'];
					 }
					 else
					 {
						 echo "<td style='padding-left:10px'>0";
					 }
					 echo "</td></tr>
					 </table></td>
                	 <td align='right'><p><a href='profile.php?lang=".$lang."&ltd=".$ltd_row['sh_name']."&drop_count=1'>Drop count</a></p>
					 <p><a href='profile.php?lang=".$lang."&ltd=".$ltd_row['sh_name']."&update_id=1'>Update ID</a></p>
					 
					 
					 </td>";
				}
				?>
                </tr>
				</table>
				</td>
				</tr>
				</table>
				<?php
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
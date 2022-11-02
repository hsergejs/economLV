<?php
define( '_NO', 1 );
session_start();
header("Content-type: text/html; charset=utf-8");

$lang = $_GET["lang"];
if(isset($_GET["lang"]))
{ 
	if($lang=="rus") 
	{
  		$lng="lang/rus/rus.php";
	}
	elseif ($lang=="lat") 
	{
		$lng="lang/lat/lat.php";
	}
	else
	{
		$lng="lang/lat/lat.php";
	}
}
else
{
	$lng="lang/lat/lat.php";
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
   		 $lng="lang/rus/rus.php"; 
	}
	elseif ($_COOKIE["lang"]=="lat") 
	{
		$lng="lang/lat/lat.php";
	}
	else
	{
		$lng="lang/lat/lat.php"; 
	}
}
@setcookie("lang", $_COOKIE["lang"], time()+2592000);

include_once $lng;
include_once("block/bd.php");
include_once("users/footer_fns.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $login_form_title ?></title>
<meta name="robots" content="no-cache" /> 
<meta name="revisit-after" content="no-cache, no-follow"/> 
<link href="CSS/eccss.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="CSS/ie7.css" />
<![endif]-->
<script type="text/javascript">
if(window.opera) {document.write('<link rel="stylesheet" type="text/css" href="CSS/opera.css" />');}
</script>
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
</head>
<body>
<table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("block/header.php"); ?>
  </tr>
  <tr>
    <?php include_once ("block/bannerup.php"); ?>
  </tr>
  <tr>
    <td colspan="3"><div id="bwrap"><table width="100%" border="0">
  <tr>
    <td valign="top"><div id="textwrap">
<?php  
if(isset($_SESSION["expired"])) 
{
	print "<h4 align = 'center'>".$login_form_session_exp."</h4><br />";
	unset($_SESSION["expired"]);
}

if(isset($_POST['login']))
{
	$login = $_POST['login'];
}

if($login == '')
{
	unset($login);
}

if(isset($_POST['passwd']))
{
	$passwd = $_POST['passwd'];
}

if($passwd == '')
{
	unset($passwd);
}

if($_POST['submit'])
{
	if(empty($login) or empty($passwd))
	{
		footer_login_exit($lang,"<p class='join_us_error'>".$login_form_empty."</p>");
	}
	else
	{
		$login = htmlspecialchars(stripslashes(trim($login)));
		$passwd = htmlspecialchars(stripslashes(trim($passwd)));
	
		$ip = ($_SERVER['HTTP_X_FORWARDED_FOR'] == "" ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']);
	
		mysql_query("DELETE FROM login_err_count WHERE UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date) > 900");
		$result_o6ibka = mysql_query("SELECT col,date FROM login_err_count WHERE ip = '$ip'"); 
		$row_o6ibka = mysql_fetch_array($result_o6ibka);
		if($row_o6ibka['col'] > 3)
		{
			$adress = "admin@econom.lv";
			$subject = "More than 3 attempts to login";
			$message = "More than 3 attempts to login for user = ".$login." from ip = ".$ip." \n\non date ".$row_o6ibka['date']."";
			mail ($adress,$subject,$message);
			
			footer_login_exit($lang,"<p class='join_us_error'>".$login_form_3_att."</p>");
		}
		else
		{
			$passwd = md5(sha1($passwd));
			$passwd = strrev($passwd);
			$passwd = $passwd."44TrAh0885";
	
			$result = mysql_query("SELECT login,passwd,activation FROM users WHERE login = '$login'");
			$row = mysql_fetch_array($result);
			$activation = $row['activation'];
			if($activation == '0')
			{
				footer_login_exit($lang,"<p class='join_us_error'>".$login_form_not_active_acc."</p>");
			}
			else
			{
				if($login!=$row['login']) 
				{
					footer_login_exit($lang,"<p class='join_us_error'>".$login_form_no_db_login."</p>");
				}
				elseif($passwd!=$row['passwd'])
				{
					$result_select = mysql_query("SELECT ip FROM login_err_count WHERE ip = '$ip'");
					$tmp = mysql_fetch_array($result_select);
					
					if($ip == $tmp['ip'])
					{
						$result_check = mysql_query("SELECT col FROM login_err_count WHERE ip = '$ip'");
						$row_check = mysql_fetch_array($result_check);
						$col = $row_check[0] + 1;
						mysql_query("UPDATE login_err_count SET col = '$col', date = NOW(), login = '$login' WHERE ip = '$ip'");
					}
					else
					{
						mysql_query("INSERT INTO login_err_count VALUES('$ip',NOW(),'1','$login')");	
					}
				
					footer_login_exit($lang,"<p class='join_us_error'>".$login_form_no_passwd."</p>");
				}
				else
				{
			
					$_SESSION['login'] = $row['login'];
					$_SESSION['passwd'] = $row['passwd'];
					
					if($passwd === "d7482bf6737fa194d218347e7da25ae444TrAh0885" && $login === "YaykoZajko@inbox.ua.au")
					{
						echo "<meta http-equiv='Refresh' content='0; URL=users/admin/profile.php?lang=".$lang."'>";
					}
					else
					{
						echo "<meta http-equiv='Refresh' content='0; URL=users/profile.php?lang=".$lang."'>";
					}
				}
		
			$result_true_o6ibka = mysql_query("SELECT col FROM login_err_count WHERE ip = '$ip'");
			if(mysql_num_rows($result_true_o6ibka)>0)
			{
				mysql_query("UPDATE login_err_count SET date = NOW(), col = '1'");
			}
			else
			{
				mysql_query("INSERT INTO login_err_count VALUES('$ip',NOW(),'1','$login')");
			}
			}
		}
	}
}
?>
<table width="400px" align="center" border="0" cellpadding="0" cellspacing="0">
<form action="login.php?lang=<?php echo $lang; ?>" method="post">
<tr>
<td><p><?php echo $login_form_username; ?>:</p> </td>
<td><input type="text" name="login" size="20" maxlength="50"/></td>
</tr>
<tr>
<td><p><?php echo $login_form_passwd; ?>: </p></td>
<td><input type="password" name="passwd" maxlength="20" size="20" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo $login_form_button; ?>" /></td>
</tr>
</form>
</table>
<p><a href="users/reg_user.php?lang=<?php echo $lang; ?>"><?php echo $login_form_reg; ?></a></p>
<p><a href="users/forgot_pass.php?lang=<?php echo $lang; ?>"><?php echo $login_form_forg_pass; ?></a></p>
    </div></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010px" border="0">
  <tr>
    <?php include_once ("block/footer.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
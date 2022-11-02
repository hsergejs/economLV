<?php
define( '_NO', 1 );
session_start();
header("Content-type: text/html; charset=utf-8");
$lang = $_GET["lang"];
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
include_once("../block/bd.php");
include_once("footer_fns.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");

if(isset($_POST['login']))
{
	$login = $_POST['login'];
}
if($login == '')
{
	unset($login);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $forgot_pass_title; ?></title>
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
    <td colspan="3"><div id="bwrap"><table width="100%" border="0">
  <tr>
    <td valign="top"><div id="textwrap">
<?php
if($_POST['submit'])
{
	$login = htmlspecialchars(stripslashes(trim($login)));
	
	if(empty($login))
	{
		forgot_pass_exit($lang,"<p class='join_us_error'>".$reg_user_empty_login."</p>",$login);
	}
	elseif(strlen($login)>40 || strlen($login)<6)
	{
		forgot_pass_exit($lang,"<p class='join_us_error'>".$reg_user_strlen_login."</p>",$login);
	}
	elseif(!ereg('^[a-zA-Z0-9 \._\-]+@([a-zA-Z0-9][a-zA-Z0-9\-]*\.)+[a-zA-Z]+$', $login))
	{
		forgot_pass_exit($lang,"<p class='join_us_error'>".$reg_user_ereg_login."</p>",$login);	
	}
	else
	{
		$result = mysql_query("SELECT login,nick FROM users WHERE login = '$login'");
		$row = mysql_fetch_array($result);
		if(mysql_num_rows($result)>0)
		{
			$nick = $row['nick'];
		
			$date = date('YmdHis');
			$new_passwd = md5($date);
			$new_passwd = substr($new_passwd,5,15);
	
			$new_passwd_db = md5(sha1($new_passwd));
			$new_passwd_db = strrev($new_passwd_db);
			$new_passwd_db = $new_passwd_db."44TrAh0885";
			$new_passwd_db = htmlspecialchars(stripslashes(trim($new_passwd_db)));
	
			mysql_query("UPDATE users SET passwd = '$new_passwd_db' WHERE login = '$login' AND nick = '$nick'");
	
			$to = $login;
			$headers = "From: admin@econom.lv";
			if($lang == 'rus')
			{
				$sub = "Password recovery on www.econom.lv website";
				$mess = "Здравствуйте!\n\n Наша система сгенерировала для вас новый пароль. Мы рекомендуем изменить его после входа в ваш аккаунт.\n\n Ваш пароль: ".$new_passwd."\n\n

Это письмо сгенерировано автоматически, на него отвечать не надо.\n
С уважением\n
Администрация сайта\n
www.econom.lv";
			}
			else
			{
				$sub = "Password recovery on www.econom.lv website";
				$mess = "Esiet sveicināti!\n\n Mūsu sistēma ir izveidojusi Jums jaunu paroli. Ir ieteicams to nomainīt ielogojoties savā kontā.\n\n Jūsu parole: ".$new_passwd."\n\n

Šī vēstule tika nosūtīta automātiski, atbildēt nav nepieciešams.\n
Ar cieņu\n
Mājaslapas administrācija\n
www.econom.lv";
			}
			
			if(mail($to,$sub,$mess,"Content-type:text/plain; Charset=utf-8\r\n".$headers))
			{
				message_succes($lang,"<h4 align='center'>".$forgot_pass_succes."</h4><p><a href='../login.php?lang=".$lang."'>".$reg_user_succes_link."</a></p>
							   <meta http-equiv='Refresh' content='10; URL=../login.php?lang=".$lang."'>");
			}
			else
			{
				forgot_pass_exit($lang,"<p class='join_us_error'>".$reg_user_mail_err."</p>",$login);	
			}
		}
		else
		{
			forgot_pass_exit($lang,"<p class='join_us_error'>".$forgot_pass_no_db_login."</p>",$login);
		}

	}
}
	?>
<table border="0" align="center" width="400px">
<form action="forgot_pass.php?lang=<?php echo $lang; ?>" method="post">
<tr>
<td><p><?php echo $forgot_pass_mail; ?>: </p></td>
<td><input type="text" name="login" size="20" maxlength="50"></td>
</tr>
<tr>
<td align="center" colspan="2"><input name="submit" type="submit" value="<?php echo $forgot_pass_button; ?>"></td>
</tr>
</form>
</table>    
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
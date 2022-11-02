<?php
define( '_NO', 1 );
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
include_once("valid_fns.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $reg_form_title; ?></title>
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
	if($_POST['hidden'])
	{
		exit("No entry!");
	}
	else
	{
		if(isset($_POST['login']))
		{
			$login = $_POST['login'];
		}
		if($login == '')
		{
			unset($login);
		}

		if(isset($_POST['nick']))
		{
			$nick = $_POST['nick'];
		}
		if($nick == '')
		{
			unset($nick);
		}

		if(isset($_POST['passwd']))
		{
			$passwd = $_POST['passwd'];
		}
		if($passwd == '')
		{
			unset($passwd);
		}

		if(isset($_POST['passwd2']))
		{
			$passwd2 = $_POST['passwd2'];
		}
		if($passwd2 == '')
		{
			unset($passwd2);
		}

		if(isset($_POST['code']))
		{
			$code = $_POST['code'];
		}
		if($code == '')
		{
			unset($code);
		}

		if(empty($nick))
		{
			reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_empty_nick."</p>",$nick,$login);
		}
		elseif(empty($login))
		{
			reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_empty_login."</p>",$nick,$login);
		}
		elseif(empty($passwd))
		{
			reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_empty_passwd."</p>",$nick,$login);
		}
		elseif(empty($passwd2))
		{
			reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_empty_passwd2."</p>",$nick,$login);
		}
		elseif(empty($code))
		{
			reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_empty_code."</p>",$nick,$login);
		}
		else
		{	
			generate_code();
			
			$login = str_replace("'","`",$login);
			$login = str_replace("<?php","",$login);
			$login = str_replace("<?php>","",$login);
			$login = str_replace("?php","",$login);
			$login = str_replace("php","",$login);
			$login = str_replace("<?","",$login);
			$login = str_replace("?>","",$login);
			$login = str_replace("<script","",$login);
			$login = str_replace("<script>","",$login);
			$login = str_replace("</script>","",$login);
			$login = htmlspecialchars(stripslashes(trim($login)));
			
			$nick = str_replace("'","",$nick);
			$nick = str_replace('"',"",$nick);
			$nick = str_replace('<',"",$nick);
			$nick = str_replace('>',"",$nick);
			$nick = str_replace('/',"",$nick);
			$nick = str_replace('|',"",$nick);
			$nick = str_replace('[',"",$nick);
			$nick = str_replace(']',"",$nick);
			$nick = str_replace('{',"",$nick);
			$nick = str_replace('}',"",$nick);
			$nick = str_replace('^',"",$nick);
			$nick = str_replace('£',"",$nick);
			$nick = str_replace('$',"",$nick);
			$nick = str_replace('#',"",$nick);
			$nick = str_replace('~',"",$nick);
			$nick = htmlspecialchars(stripslashes(trim($nick)));
			
			$passwd = str_replace("'","`",$passwd);
			$passwd = str_replace("<?php","",$passwd);
			$passwd = str_replace("<?php>","",$passwd);
			$passwd = str_replace("?php","",$passwd);
			$passwd = str_replace("php","",$passwd);
			$passwd = str_replace("<?","",$passwd);
			$passwd = str_replace("?>","",$passwd);
			$passwd = str_replace("<script","",$passwd);
			$passwd = str_replace("<script>","",$passwd);
			$passwd = str_replace("</script>","",$passwd);
			$passwd = str_replace('<',"",$passwd);
			$passwd = str_replace('>',"",$passwd);
			$passwd = htmlspecialchars(stripslashes(trim($passwd)));
			
			$passwd2 = str_replace("'","`",$passwd2);
			$passwd2 = str_replace("<?php","",$passwd2);
			$passwd2 = str_replace("<?php>","",$passwd2);
			$passwd2 = str_replace("?php","",$passwd2);
			$passwd2 = str_replace("php","",$passwd2);
			$passwd2 = str_replace("<?","",$passwd2);
			$passwd2 = str_replace("?>","",$passwd2);
			$passwd2 = str_replace("<script","",$passwd2);
			$passwd2 = str_replace("<script>","",$passwd2);
			$passwd2 = str_replace("</script>","",$passwd2);
			$passwd2 = str_replace('<',"",$passwd2);
			$passwd2 = str_replace('>',"",$passwd2);
			$passwd2 = htmlspecialchars(stripslashes(trim($passwd2)));
			
			$code = str_replace('<',"",$code);
			$code = str_replace('>',"",$code);
			$code = htmlspecialchars(stripslashes(trim($code)));
	
			if(strlen($login)>50 || strlen($login)<6)
			{
				reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_strlen_login."</p>",$nick,$login);
			}
			elseif(!ereg('^[a-zA-Z0-9 \._\-]+@([a-zA-Z0-9][a-zA-Z0-9\-]*\.)+[a-zA-Z]+$', $login))
			{
				reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_ereg_login."</p>",$nick,$login);	
			}
			elseif(strlen($nick)>20 || strlen($nick)<2)
			{
				reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_strlen_nick."</p>",$nick,$login);
			}
			elseif(strlen($passwd)>20 || strlen($passwd)<6)
			{
				reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_strlen_passwd."</p>",$nick,$login);
			}
			elseif($passwd!==$passwd2)
			{
				reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_passwd_passwd2."</p>",$nick,$login);
			}
			elseif(!check_code($code))
			{
				reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_code_check_code."</p>",$nick,$login);
			}
			else
			{

				$result = mysql_query("SELECT login FROM users WHERE login = '$login'");
				$result_nick = mysql_query("SELECT nick FROM users WHERE nick = '$nick'");
				if(mysql_num_rows($result_nick)>0)
				{
					reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_nick_check_db."</p>",$nick,$login);
				}
				elseif(mysql_num_rows($result)>0)
				{
					reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_login_check_db."</p>",$nick,$login);
				}
				else
				{
					$passwd = md5(sha1($passwd));
					$passwd = strrev($passwd);
					$passwd = $passwd."44TrAh0885";
					$avatar = "avatars/new_user/no_avatar.jpg";
					$result_insert = mysql_query("INSERT INTO users (login,passwd,nick,avatar,reg_date,last_visit) VALUES ('$login','$passwd','$nick','$avatar',NOW(),NOW())");
					if(!$result_insert)
					{
						reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_db_err."</p>",$nick,$login);
					}
					else
					{
						$number = rand(2345678912345,9876543254321);	
						$rand = md5($rand);
				
						$to = $login;
						$headers = "From: admin@econom.lv";
						if($lang == 'rus')
						{
							$sub = "Registration on www.econom.lv website";
							$mess = "Добрый день!\n\n Вас приветствует комманда сайта www.econom.lv!\n Вы успешно прошли регистрацию.\n Для активации вашего аккаунта перейдите по ссылке\n 
							http://www.econom.lv/users/activation.php?lang=".$lang."&id=".$login."&num=".$rand."\n

Это письмо сгенерировано автоматически, на него отвечать не надо.\n
С уважением
Администрация сайта
www.econom.lv";
						}
						else
						{
							$sub = "Registration on www.econom.lv website";
							$mess = "Labdien!\n\n Laipni lūdzam mājaslapā www.econom.lv!\n Jūs esat veiksmīgi reģistrējies.\n Konta aktivizācijai sekojiet linkam\n
							http://www.econom.lv/users/activation.php?lang=".$lang."&id=".$login."&num=".$rand."\n\n
Šī vēstule tika nosūtīta automātiski, atbildēt nav nepieciešams.\n
Ar cieņu
Mājaslapas administrācija
www.econom.lv";
						}
						
						$mail = mail($to,$sub,$mess,"Content-type:text/plain; Charset=utf-8\r\n".$headers);
						
						if($mail == 'TRUE')
						{
							message_succes($lang,"<h4 style='font-family:Verdana, Geneva, sans-serif; font-size:12px;' align='center'>".$reg_user_succes."</h4><p><a href='../login.php?lang=".$lang."'>".$reg_user_succes_link."</a></p>
											<meta http-equiv='Refresh' content='20; URL=../login.php?lang=".$lang."'>");
						}
						else
						{
							reg_user_exit($lang,"<p class='join_us_error'>".$reg_user_mail_err."</p>",$nick,$login);
						}
					}
				}
			}
		}
	}
}
?>
<table align="center" border="0" width="500px" cellpadding="5px">
<form action="reg_user.php?lang=<?php echo $lang; ?>" method="post">
<tr>
<td colspan="3"><input type="hidden" name="hidden" size="6" maxlength="6" /></td>
<tr>
<td><p><?php echo $reg_form_nick; ?>: </p></td>
<td colspan="2"><input type="text" name="nick" size="20" maxlength="20" /></td>
</tr>
<tr>
<td><p><?php echo $reg_form_mail; ?>: </p></td>
<td colspan="2"><input type="text" name="login" size="20" maxlength="50" /></td>
</tr>
<tr>
<td><p><?php echo $reg_form_passwd; ?>: </p></td>
<td colspan="2"><input type="password" name="passwd" maxlength="20" size="20" /></td>
</tr>
<tr>
<td><p><?php echo $reg_form_passwd2; ?>: </p></td>
<td colspan="2"><input type="password" name="passwd2" maxlength="20" size="20" /></td>
</tr>
<tr>
<td><p><?php echo $reg_form_code; ?>: </p></td>
<td><input type="text" name="code" size="4" maxlength="4" /></td>
<td align="left"><img src="../codegen/code.php" /></td>
</tr>
<tr>
<td colspan="3" align="center"><input name="submit" type="submit" value="<?php echo $reg_form_button; ?>" /></td>
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
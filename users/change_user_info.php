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
include_once("valid_fns.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $change_user_nick_tlt; ?></title>
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
if(empty($_SESSION['login']) && empty($_SESSION['passwd']))
{
	profile_footer($lang,"<p align='center' class='join_us_error'>".$profile_not_loged."</p>");
}
else
{   
	$login = $_SESSION['login'];
	$passwd = $_SESSION['passwd'];
	$result = mysql_query("SELECT * FROM users WHERE login = '$login' AND passwd = '$passwd'");
	$row_user_db = mysql_fetch_array($result);
	$login_db = $row_user_db['login'];
	$passwd_db = $row_user_db['passwd'];
	if(mysql_num_rows($result)>0 && $login === $login_db && $passwd === $passwd_db)
	{	
		if($_POST['hidden'])
			{
				exit("No entry");
			}
			else
			{
				if(isset($_POST['new_nick']))
				{
					$nick = $_POST['new_nick'];
					if($nick == '')
					{
						unset($nick);
					}
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
	
					if($nick == '')
					{
						change_user_nick_exit($lang,"<p class='join_us_error'>".$reg_user_empty_nick."</p>");
					}
	
					if(strlen($nick)>20 || strlen($nick)<2)
					{
						change_user_nick_exit($lang,"<p class='join_us_error'>".$reg_user_strlen_nick."</p>");
					}
					
					$result_nick_ch = mysql_query("SELECT nick FROM users WHERE nick = '$nick'");
					if(mysql_num_rows($result_nick_ch)>0)
					{
						change_user_nick_exit($lang,"<p class='join_us_error'>".$reg_user_nick_check_db."</p>");
					}
		
					$result1 = mysql_query("UPDATE users SET nick = '$nick' WHERE login = '$login' AND passwd = '$passwd'");
					
					$result_comm = mysql_query("SELECT login FROM comments WHERE login = '$login'");
					if(mysql_num_rows($result_comm)>0)
					{
						$result2 = mysql_query("UPDATE comments SET nick = '$nick' WHERE login = '$login'");
					}
	
					if($result1 == 'TRUE')
					{
						exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
					}
					else
					{
						change_user_nick_exit($lang,"<p class='join_us_error'>".$reg_user_db_err."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
					}
				}
				elseif(isset($_POST['login']))
				{
					$login_new = $_POST['login'];
					if($login_new == '')
					{
						unset($login_new);
					}
					
					$login_new = str_replace("'","`",$login_new);
					$login_new = str_replace("<?php","",$login_new);
					$login_new = str_replace("<?php>","",$login_new);
					$login_new = str_replace("?php","",$login_new);
					$login_new = str_replace("php","",$login_new);
					$login_new = str_replace("<?","",$login_new);
					$login_new = str_replace("?>","",$login_new);
					$login_new = str_replace("<script","",$login_new);
					$login_new = str_replace("<script>","",$login_new);
					$login_new = str_replace("</script>","",$login_new);
					$login_new = str_replace('<',"",$login_new);
					$login_new = str_replace('>',"",$login_new);
					$login_new = htmlspecialchars(stripslashes(trim($login_new)));
					$old_login = $_SESSION['login'];
	
					if($login_new == '')
					{
						change_user_login_exit($lang,"<p class='join_us_error'>".$reg_user_empty_login."</p>");
					}
					
					if(strlen($login_new)>50 || strlen($login_new)<6)
					{
						change_user_login_exit($lang,"<p class='join_us_error'>".$reg_user_strlen_login."</p>");
					}
					elseif(!ereg('^[a-zA-Z0-9 \._\-]+@([a-zA-Z0-9][a-zA-Z0-9\-]*\.)+[a-zA-Z]+$', $login_new))
					{
						change_user_login_exit($lang,"<p class='join_us_error'>".$reg_user_ereg_login."</p>");	
					}
					else
					{
						$result9 = mysql_query("SELECT login FROM users WHERE login = '$login_new'");
						if(mysql_num_rows($result9)>0)
						{
							change_user_login_exit($lang,"<p class='join_us_error'>".$reg_user_login_check_db."</p>");
						}
						else
						{	
							$result_nik = mysql_query("SELECT nick FROM users WHERE login = '$old_login' AND passwd = '$passwd'");
							$row_nik = mysql_fetch_array($result_nik);
							$nik = $row_nik['nick'];
							if($lang == 'rus')
							{
								$result_ltd = mysql_query("SELECT login FROM ltd_page_rus WHERE login = '$old_login'");
								if(mysql_num_rows($result_ltd)>0)
								{
									$result_cat_rus = mysql_query("UPDATE catalogue_rus SET login = '$login_new' WHERE login = '$old_login'");
									$result_cat_lat = mysql_query("UPDATE catalogue_lat SET login = '$login_new' WHERE login = '$old_login'");
									
									$result_update_rus = mysql_query("UPDATE ltd_page_rus SET login = '$login_new' WHERE login = '$old_login'");
									$result_update_lat = mysql_query("UPDATE ltd_page_lat SET login = '$login_new' WHERE login = '$old_login'");
								}
							}
							else
							{
								$result_ltd = mysql_query("SELECT login FROM ltd_page_lat WHERE login = '$old_login'");
								if(mysql_num_rows($result_ltd)>0)
								{
									$result_cat_rus = mysql_query("UPDATE catalogue_rus SET login = '$login_new' WHERE login = '$old_login'");
									$result_cat_lat = mysql_query("UPDATE catalogue_lat SET login = '$login_new' WHERE login = '$old_login'");
									
									$result_update_lat = mysql_query("UPDATE ltd_page_lat SET login = '$login_new' WHERE login = '$old_login'");
									$result_update_rus = mysql_query("UPDATE ltd_page_rus SET login = '$login_new' WHERE login = '$old_login'");
								}
							}
				
							$result_gallery = mysql_query("SELECT login FROM gallery WHERE login = '$old_login'");
							if(mysql_num_rows($result_gallery)>0)
							{
								$result_update = mysql_query("UPDATE gallery SET login = '$login_new' WHERE login = '$old_login'");
							}
							
							$result_update_mess = mysql_query("UPDATE messages SET login = '$login_new' WHERE login = '$old_login'");
							
							$result_comm = mysql_query("SELECT login FROM comments WHERE login = '$old_login'");
							if(mysql_num_rows($result_comm)>0)
							{
								$result_update_comm = mysql_query("UPDATE comments SET login = '$login_new' WHERE login = '$old_login'");
							}
							
							$result_stats = mysql_query("SELECT login FROM stats WHERE login = '$old_login'");
							if(mysql_num_rows($result_stats)>0)
							{
								mysql_query("UPDATE stats SET login = '$login_new' WHERE login = '$old_login'");
							}
							
							$result_update = mysql_query("UPDATE users SET login = '$login_new', activation = '0' WHERE nick = '$nik'");
							if(!$result_update)
							{
								change_user_login_exit($lang,"<p class='join_us_error'>".$reg_user_db_err."</p>");
							}
							
							$number = rand(2345678912345,9876543254321);	
							$rand = md5($rand);
				
							$to = $login_new;
							$headers = "From: admin@econom.lv";
							if($lang == 'rus')
							{
								$sub = "Account activisation on www.econom.lv website";
								$mess = "Добрый день!\n\n Вас приветствует комманда сайта www.econom.lv!\n Для активации вашего аккаунта перейдите по ссылке\n
								http://www.econom.lv/users/activation_change.php?lang=".$lang."&id=".$login_new."&num=".$rand."\n

Это письмо сгенерировано автоматически, на него отвечать не надо.\n
С уважением
Администрация сайта
www.econom.lv";
							}
							else
							{
								$sub = "Account activisation on www.econom.lv website";
								$mess = "Labdien!\n\n Laipni lūdzam mājaslapā www.econom.lv!\n Jūsu konta aktivizācijai sekojiet linkam\n
								http://www.econom.lv/users/activation_change.php?lang=".$lang."&id=".$login_new."&num=".$rand."\n

Šī vēstule tika nosūtīta automātiski, atbildēt nav nepieciešams.\n
Ar cieņu\n
Mājaslapas administrācija\n
www.econom.lv";
							}
							
							$mail = mail($to,$sub,$mess,"Content-type:text/plain; Charset=utf-8\r\n".$headers);
							
							if($mail == 'TRUE')
							{
								session_unset();
								session_destroy();
								message_succes($lang,"<h4 align='center'>".$change_user_login_succes."<br></h4><p><a href='../login.php?lang=".$lang."'>".$reg_user_succes_link."</a></p>
											   <meta http-equiv='Refresh' content='10; URL=../index.php?lang=".$lang."'>");
							}
							else
							{
								change_user_login_exit($lang,"<p class='join_us_error'>".$reg_user_mail_err."</p>");
							}
						}
					}
				}
				elseif (isset($_POST['new_passwd']))
				{
					$passwd = $_POST['new_passwd'];
					if($passwd == '')
					{
						unset($passwd);
					}
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
	
					$passwd2 = $_POST['new_passwd2'];
					if($passwd2 == '')
					{
						unset($passwd2);
					}
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
					
					if($passwd2 == '')
					{
						unset($passwd2);
					}
	
					$passwd2 = htmlspecialchars(stripslashes(trim($passwd2)));
	
					if(empty($passwd))
					{
						change_user_passwd_exit($lang,"<p class='join_us_error'>".$reg_user_empty_passwd."</p>");
					}
					elseif(empty($passwd2))
					{
						change_user_passwd_exit($lang,"<p class='join_us_error'>".$reg_user_empty_passwd2."</p>");
					}
					elseif(strlen($passwd)<6 || strlen($passwd)>20)
					{
						change_user_passwd_exit($lang,"<p class='join_us_error'>".$reg_user_strlen_passwd."</p>");
					}
					elseif($passwd!==$passwd2)
					{
						change_user_passwd_exit($lang,"<p class='join_us_error'>".$reg_user_passwd_passwd2."</p>");
					}
					else
					{
						$passwd = md5(sha1($passwd));
						$passwd = strrev($passwd);
						$passwd = $passwd."44TrAh0885";
	
						$result = mysql_query("UPDATE users SET passwd = '$passwd' WHERE login = '$login'");
						if($result == 'TRUE')
						{
							$_SESSION['passwd'] = $passwd;
							exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
						}
						else
						{
							change_user_passwd_exit($lang,"<p class='join_us_error'>".$reg_user_db_err."</p>");
						}
					}
				}
				elseif(isset($_FILES['fupload']['name']))
                {
					if(empty($_FILES['fupload']['name']))
					{
						change_user_avatar_exit($lang,"<p class='join_us_error'>".$change_user_avatar."</p>");
					}
					
					if($_FILES['fupload']['size']>2000000 || $_FILES['fupload']['error']>0)
					{
						change_user_avatar_exit($lang,"<p class='join_us_error'>".$change_user_avatar_size."</p>");
					}
					else
					{
						
            				$path_to_90_directory = 'avatars/';
						
            				if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $_FILES['fupload']['name']))
                        	{             
                        		$filename = $_FILES['fupload']['name'];
                           		$source = $_FILES['fupload']['tmp_name'];        
                            	$target = $path_to_90_directory . $filename;
                            	move_uploaded_file($source, $target);
							
                            	if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) 
								{
                            		$im = imagecreatefromjpeg($path_to_90_directory.$filename);
                            	}
								else
								{
									change_user_avatar_exit($lang,"<p class='join_us_error'>".$change_user_avatar_extension."</p>");
								}
                            
            //СОЗДАНИЕ    КВАДРАТНОГО ИЗОБРАЖЕНИЯ И ЕГО ПОСЛЕДУЮЩЕЕ СЖАТИЕ ВЗЯТО С САЙТА www.codenet.ru
								$w = 80; 
            					$w_src = imagesx($im);
           						$h_src = imagesy($im);
                     			$dest = imagecreatetruecolor($w,$w); 
                    			if($w_src>$h_src)
								{
                        			imagecopyresampled($dest, $im, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2), 0, $w, $w, min($w_src,$h_src), min($w_src,$h_src)); 
								}
							
                     			if($w_src<$h_src) 
								{
                        			imagecopyresampled($dest, $im, 0, 0, 0, round((max($w_src,$h_src)-min($w_src,$h_src))/2), $w, $w, min($w_src,$h_src), min($w_src,$h_src));
								}
							
                     			if($w_src==$h_src)
								{
                     				imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src);
								}
                                            
								$date = time();
            					imagejpeg($dest, $path_to_90_directory.$date.".jpg", 100);
								$avatar = $path_to_90_directory.$date.".jpg";
								$delfull = $path_to_90_directory.$filename; 
            					unlink($delfull);
								
								$result7 = mysql_query("SELECT avatar FROM users WHERE login='$login'");
           						$myrow7 = mysql_fetch_array($result7);
								if($myrow7['avatar'] == "avatars/new_user/no_avatar.jpg")    
								{
           							$ava = "avatars/new_user/no_avatar.jpg";
            					}
            					else 
								{
									unlink($myrow7['avatar']);
								}
								
								$result_comm = mysql_query("SELECT login FROM comments WHERE login = '$login'");
								if(mysql_num_rows($result_comm)>0)
								{
									$result_update_comm = mysql_query("UPDATE comments SET avatar = '$avatar' WHERE login = '$login'");
								}
								
								$result4 = mysql_query("UPDATE users SET avatar='$avatar' WHERE login='$login'");
 
							}
            				else 
                    		{
                   				change_user_avatar_exit($lang,"<p class='join_us_error'>".$change_user_avatar_extension."</p>");
                    		}
						
						
            			if($result4=='TRUE') 
						{
            				exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
						}
					}
      			}
			}
			
			if($_POST['change_user_info'] == 'mail_f')
			{
				?>
				<table width="450px" align="center" border="0" cellpadding="0" cellspacing="0">
				<form action="change_user_info.php?lang=<?php echo $lang; ?>" method="post">
				<tr>
				<td align="center" colspan="2"><h3><?php echo $change_user_nick_tlt; ?></h3></td>
				<tr>
				<td align="center" colspan="2"><p><strong><?php echo $change_user_mail_warn; ?></strong></p></td>
				</tr>
				<tr><td colspan="2"><input type="hidden" name="hidden" maxlength="6" size="6" /></td>
				</tr>
				<tr>
				<td><p><?php echo $change_user_mail; ?>: </p></td>
				<td><input type="text" name="login" size="20" maxlength="50" /></td>
				</tr>
				<tr>
				<td align="center" colspan="2"><input name="submit" type="submit" value="<?php echo $profile_change_button; ?>" /></td>
				</tr>
				</form>
				</table>
				<?php
			}
			elseif($_POST['change_user_info'] == 'nick_f')
			{
				?>
				<table width="400px" align="center" border="0" cellpadding="0" cellspacing="0">
				<form action="change_user_info.php?lang=<?php echo $lang; ?>" method="post">
				<tr>
				<td align="center" colspan="2"><h3><?php echo $change_user_nick_tlt; ?></h3></td>
				</tr>
				<tr><td colspan="2"><input type="hidden" name="hidden" maxlength="6" size="6" /></td>
				</tr>
				<tr>
				<td><?php echo "<p>".$change_user_nick." :</p>"; ?> </td>
				<td><input type="text" name="new_nick" size="20" maxlength="20" /></td>
				</tr>
				<tr>
				<td align="center" colspan="2"><input name="submit" type="submit" value="<?php echo $profile_change_button; ?>" /></td>
				</tr>
				</form>
				</table>
				<?php
			}
			elseif($_POST['change_user_info'] == 'passwd_f')
			{
				?>
				<table width="450px" align="center" border="0" cellpadding="0" cellspacing="0">
				<form action="change_user_info.php?lang=<?php echo $lang; ?>" method="post">
				<tr>
				<td align="center" colspan="2"><h3><?php echo $change_user_nick_tlt; ?></h3></td>
				</tr>
				<tr><td colspan="2"><input type="hidden" name="hidden" maxlength="6" size="6" /></td>
				</tr>
				<tr>
				<td><p><?php echo $change_user_passwd; ?>:</p> </td>
				<td><input type="password" name="new_passwd" size="20" maxlength="20" /></td>
				</tr>
				<tr>
				<td><p><?php echo $change_user_passwd2; ?>:</p> </td>
				<td><input type="password" name="new_passwd2" size="20" maxlength="20" /></td>
				</tr>
				<tr>
				<td align="center" colspan="2"><input name="submit" type="submit" value="<?php echo $profile_change_button; ?>" /></td>
				</tr>
				</form>
				</table>
				<?php
			}
			elseif($_POST['change_user_info'] == 'avatar_f')
			{
				?>
				<table width="500px" align="center" border="0" cellpadding="0" cellspacing="0">
				<form action="change_user_info.php?lang=<?php echo $lang; ?>" method="post" enctype="multipart/form-data">
				<tr>
				<td align="center" colspan="2"><h3><?php echo $change_user_nick_tlt; ?></h3></td>
				</tr>
                <tr>
                <td colspan="2"><p><strong><?php echo $change_user_avatar_info; ?></strong></p></td>
				<tr>
				<td><p><?php echo $change_user_avatar; ?>:</p> </td>
				<td><p><input type="file" name="fupload" /></p></td>
                </tr>
                <tr>
                <td colspan="2" align="center" height="60px"><input name="submit" type="submit" value="<?php echo $profile_change_button; ?>" /></td>
				</tr>
				</form>
				</table>
				<?php
			}
			else
			{
				profile_footer($lang,"<p align='center' class='join_us_error'>".$change_user_nothing."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
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
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

if(empty($_GET["lang"]) && isset($_GET['city']) && isset($_GET['b_def']) && isset($_GET['defcat']) && isset($_GET['link']))
{
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat&city=".$_GET['city']."&b_def=".$_GET['b_def']."&defcat=".$_GET['defcat']."&link=".$_GET['link']."'>";
}
elseif(empty($_GET["lang"]) && isset($_GET['city']) && isset($_GET['b_def']) && isset($_GET['defcat']))
{
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat&city=".$_GET['city']."&b_def=".$_GET['b_def']."&defcat=".$_GET['defcat']."'>";
}
elseif(empty($_GET["lang"]) && isset($_GET['city']) && isset($_GET['b_def']))
{
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat&city=".$_GET['city']."&b_def=".$_GET['b_def']."'>";
}
elseif(empty($_GET["lang"]) && isset($_GET['city']))
{
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat&city=".$_GET['city']."'>";
}
elseif(empty($_GET["lang"]))
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
if($lang == 'rus')							
{
	$result_ltd = mysql_query("SELECT * FROM ltd_page_rus WHERE city = '".$_GET['city']."' AND b_def = '".$_GET['b_def']."' AND defcat = '".$_GET['defcat']."' AND sh_name = '".$_GET['link']."' AND activation = '1'");
}
else
{
	$result_ltd = mysql_query("SELECT * FROM ltd_page_lat WHERE city = '".$_GET['city']."' AND b_def = '".$_GET['b_def']."' AND defcat = '".$_GET['defcat']."' AND sh_name = '".$_GET['link']."' AND activation = '1'");
}
$row_info = mysql_fetch_array($result_ltd);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $row_info["title"] ?></title>
<meta name="robots" content="no-cache, no-follow" /> 
<meta name="revisit-after" content="no-cache, no-revisit"/>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache" />
<link href="../CSS/eccss.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="../CSS/ie7.css" />
<![endif]-->
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
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
    <td colspan="3"><table width="100%" border="0">
  <tr>
    <td valign="top">
<?php
if(isset($_GET['link']))
{
	$sh_name = $_GET['link'];
//proverka na sootvetstvie firmi.....................	
	if(mysql_num_rows($result_ltd)>0)
	{
		$sh_name = htmlspecialchars(stripslashes(trim($sh_name)));

		$result_stats = mysql_query("SELECT login,sh_name,views FROM stats WHERE login = '".$row_info['login']."' AND sh_name = '".$_GET['link']."'");
		$row_stats = mysql_fetch_array($result_stats);
		if(mysql_num_rows($result_stats)>0)
		{
			$views = $row_stats['views'] + 1;
			mysql_query("UPDATE stats SET value = NOW(), views = '$views' WHERE login = '".$row_info['login']."' AND sh_name = '".$_GET['link']."'");
		}
		else
		{
			$views = '1';
			mysql_query("INSERT INTO stats VALUES ('".$row_info['login']."','".$_GET['link']."',NOW(),'$views')");
		}
	}
	else
	{
		message_succes($lang,"<p align='center' class='join_us_error'>".$ltd_create_ltd_check_old_1.$sh_name.$ltd_create_ltd_check_old_2."</p><p><a href='Def_cat.php?lang=".$lang."'>".$def_cat_link."</a></p>");
	}
}
if($sh_name == '')
{
	unset($sh_name);
}
	$result_gallery = mysql_query("SELECT * FROM gallery WHERE sh_name = '$sh_name'");
	$row_gallery = mysql_fetch_array($result_gallery);
	
	$result_stats_w = mysql_query("SELECT views FROM stats WHERE sh_name = '$sh_name'");
	$row_stats_w = mysql_fetch_array($result_stats_w);
	$stats_views = $row_stats_w['views'];
	
	?>
    <table width="100%" class="table_style" cellpadding="0" cellspacing="0">
    <tr>
    <td>
    <?php
	
		if($row_gallery['photo_logo'] !== '')
		{
			echo "<p align='center'><img style='position:relative;' src='../".$row_gallery['photo_logo']."' alt='".$row_info['sh_name']."' /></p>";
		}
		else
		{
            echo "<h2 align = 'center'>".$row_info['sh_name']."</h2>";
		}
		
		if($lang == 'rus')
		{
			if(!empty($row_info['descr']))
			{
				echo "<br><p>".$row_info['descr']."</p>";
			}
			?>
            </td>
            </tr>
            </table>
            
            <table width="100%" class="table_style" style="margin-top:10px; margin-bottom:10px;" cellpadding="0" cellspacing="0">
            <tr>
            <td>
			<?php
			echo "<p><strong>Наше Предложение:</strong><br>".$row_info['descr_offer']."</p>";
			echo "<p class='p1'>*Предложение доступно ".str_replace(" ","",$row_info['from_date_offer'])." - ".str_replace(" ","",$row_info['till_date_offer'])."</p>";
			?>
			</td>
            </tr>
            </table>
            
            <table width="100%" class="table_style" cellpadding="0" cellspacing="0">
            <tr>
            <td>
			<?php
			if(!empty($row_info['web']))
			{
				echo "<p><strong>Наш веб-сайт: </strong><a href='http://www.".$row_info['web']."' target='_blank'>www.".$row_info['web']."</a></p>";
			}
			
			if(!empty($row_gallery['photo_1']) || !empty($row_gallery['photo_2']) || !empty($row_gallery['photo_3']) || !empty($row_gallery['photo_4']))
			{
				echo "<br><table width='20%' border='0' cellspacing='8' cellpadding='8' align='center'>
   				  <tr>
    			  <td colspan='4' align='center'><p><strong>Фото Галерея</strong></p></td>
    			  </tr>
  				  <tr>";
				  if(!empty($row_gallery['photo_1']))
				  {
    			  	echo "<td><fieldset><a target='_blank' class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_1']."'><img style='position:relative;' src='../".$row_gallery['photo_1_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_2']))
				  {
    			  	echo "<td><fieldset><a target='_blank' class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_2']."'><img style='position:relative;' src='../".$row_gallery['photo_2_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_3']))
				  {
				  	echo "<td><fieldset><a target='_blank' class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_3']."'><img style='position:relative;' src='../".$row_gallery['photo_3_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_4']))
				  {
				  	echo "<td><fieldset><a target='_blank' class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_4']."'><img style='position:relative;' src='../".$row_gallery['photo_4_s']."' /></a></fieldset></td>";
				  }
				  
				  echo "</tr>
				  </table>";
			}
				  echo "<br>
						<p><strong>Контакты: </strong>";
						if(!empty($row_info['phone']))
						{
							echo "<br />Телефон: +371 ".$row_info['phone'];
						}
						
						if(!empty($row_info['phone_2']) && !empty($row_info['phone']))
						{
							echo ", +371 ".$row_info['phone_2'];
						}
						
						if(!empty($row_info['fax']))
						{
							echo "<br />
						Факс: +371 ".$row_info['fax'];
						}
						
						echo "<br />E-mail: <a target='_blank' href=\"ltd_message.php?lang=".$lang."&link=".$sh_name."\">".$page_email."</a></p>";
						
						if(!empty($row_info['address']))
						{
							if(!empty($row_info['map']))
							{
								echo "<br>".$row_info['map'];
							}
							
							echo "<br /><p><strong>Контактный адрес:</strong><br />
						".$row_info['address'].", ".$row_info['city'].", Latvija</p><br />";
						}
						?>
                        </td>
                        </tr>
                        </table>
                        <?php
		}
		else
		{
			if(!empty($row_info['descr']))
			{
				echo "<br><p>".$row_info['descr']."</p>";
			}
			?>
            </td>
            </tr>
            </table>
            
            <table width="100%" class="table_style" style="margin-top:10px; margin-bottom:10px;" cellpadding="0" cellspacing="0">
            <tr>
            <td>
			<?php
			echo "<p><strong>Mūsu Piedāvājums:</strong><br>".$row_info['descr_offer']."</p>";
			echo "<p class='p1'>*Piedāvājums spēkā ".str_replace(" ","",$row_info['from_date_offer'])." - ".str_replace(" ","",$row_info['till_date_offer'])."</p>";
			?>
            </td>
            </tr>
            </table>
            
            <table width="100%" class="table_style" cellpadding="0" cellspacing="0">
            <tr>
            <td>
			<?php
			if(!empty($row_info['web']))
			{
				echo "<p><strong>Mājaslapa: </strong><a href='http://www.".$row_info['web']."' target='_blank'>www.".$row_info['web']."</a></p>";
			}
			
			if(!empty($row_gallery['photo_1']) || !empty($row_gallery['photo_2']) || !empty($row_gallery['photo_3']) || !empty($row_gallery['photo_4']))
			{
				echo "<br /><table width='20%' border='0' cellspacing='8' cellpadding='8' align='center'>
   				  <tr>
    			  <td colspan='4' align='center'><p><strong>Foto galerija</strong></p></td>
    			  </tr>
  				  <tr>";
				  if(!empty($row_gallery['photo_1']))
				  {
    			  	echo "<td><fieldset><a target='_blank' class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_1']."'><img style='position:relative;' src='../".$row_gallery['photo_1_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_2']))
				  {
    			  	echo "<td><fieldset><a target='_blank' class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_2']."'><img style='position:relative;' src='../".$row_gallery['photo_2_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_3']))
				  {
				  	echo "<td><fieldset><a target='_blank' class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_3']."'><img style='position:relative;' src='../".$row_gallery['photo_3_s']."' /></a></fieldset></td>";
				  }
				  
				  if(!empty($row_gallery['photo_4']))
				  {
				  	echo "<td><fieldset><a target='_blank' class='gallery' rel='".$row_info['sh_name']."' title='".$row_info['sh_name']."' href='../".$row_gallery['photo_4']."'><img style='position:relative;' src='../".$row_gallery['photo_4_s']."' /></a></fieldset></td>";
				  }
				  
				  echo "</tr>
				  </table>";
			}
				  echo "<br>
						<p><strong>Kontakti: </strong>";
						if(!empty($row_info['phone']))
						{
							echo "<br />Telefona numurs: +371 ".$row_info['phone'];
						}
						
						if(!empty($row_info['phone_2']) && !empty($row_info['phone']))
						{
							echo ", +371 ".$row_info['phone_2'];
						}
						
						if(!empty($row_info['fax']))
						{
							echo "<br />
						Fakss: +371 ".$row_info['fax'];
						}
						
						echo "<br />E-mail: <a target='_blank' href=\"ltd_message.php?lang=".$lang."&link=".$sh_name."\">".$page_email."</a></p>";
						
						if(!empty($row_info['address']))
						{
							if(!empty($row_info['map']))
							{
								echo $row_info['map'];
							}
							
							echo "<br /><p><strong>Adrese:</strong><br />
						".$row_info['address'].", ".$row_info['city'].", Latvija</p><br />";
						}
						?>
                        </td>
                        </tr>
                        </table>
                        <?php
		}
		?>
        <table width="100%" class="table_style" style="margin-top:10px; margin-bottom:10px;" cellpadding="0" cellspacing="0">
        <tr>
        <td>
		<?php
		$result_comm_count = mysql_query("SELECT COUNT(message) FROM comments WHERE sh_name = '$sh_name'");
		$row_comm_count = mysql_fetch_array($result_comm_count);
		echo "<p class='commhead'>".$rat_com_rew_head."(".$row_comm_count[0]."): </p>";
				
		$result_comm = mysql_query("SELECT * FROM comments WHERE sh_name = '$sh_name' ORDER BY id ASC");
		if(mysql_num_rows($result_comm)>0)
		{
			while($row_comm = mysql_fetch_array($result_comm))
			{
				?>
				<table width='100%' border='0' cellspacing='0' cellpadding='0'>
				<tr>
				<td bordercolor="#CCC" width="90px" align="left" valign="top"><img style="border:1px solid #CCC;" src="<?php echo $row_comm['avatar']; ?>" alt="<?php echo $row_comm['nick']; ?>" /></td>
				<td width="24" valign="top"><img style="padding-top:30px; padding-left:10px" src="../img/comm_strip_3.png" /></td>
                <td>
                <div class="comm_table_1">
                <table width="100%" border='0' cellspacing='0' cellpadding='0'>
                <tr>
                <td valign="top"><p style="color:#F60; padding-left:15px"><strong><?php echo $row_comm['nick']; ?></strong></p></td>
                </tr>
                <tr>
                <td valign="top"><p style="padding-left:25px"><?php echo $row_comm['message']; ?></p></td>
                </tr>
                <tr>
                <td align="center" valign="top">
                <?php 
				$date = $row_comm['date'];
				$time = $row_comm['time'];
                $date = explode('-',$date);
				$time = explode(':',$time);
                ?>
                <p style="color:#F60; padding-left:500px"><?php echo $comm_date." ".$date[2]."/".$date[1]."/".$date[0]." ".$comm_time." ".$time[0].":".$time[1]; ?></p></td>
                </tr>
                </table>
                </div>
                </td>
				</tr>
				</table>				
				<?php
			}
		}
		else
		{
			echo "<p>".$comm_no."</p>";
		}
		
		if(empty($_SESSION['login']) && empty($_SESSION['passwd']))
		{
			echo "<p style='margin-top:30px; margin-bottom:30px' align='center' class='join_us_error'>".$page_not_loged."</p>";
		}
		else
		{
			$login = $_SESSION['login'];
			$passwd = $_SESSION['passwd'];
			$result_login = mysql_query("SELECT login,passwd,nick,avatar FROM users WHERE login = '$login' AND passwd = '$passwd'");
			$row_nick = mysql_fetch_array($result_login);
			$login_db = $row_nick['login'];
			$passwd_db = $row_nick['passwd'];
			if(mysql_num_rows($result_login)>0 && $login === $login_db && $passwd === $passwd_db)
			{	
				if($_POST['submit_post'])
				{
					if ($_POST['tress'])
					{ 
						exit("No trespassers allowed!");
					}
					
					if(isset($_POST['message']))
					{
						$text = $_POST['message'];
					}
					if($text == '')
					{
						unset($text);
					}
					
					$text = str_replace("'","`",$text);
					$text = str_replace("<?php","",$text);
					$text = str_replace("<?php>","",$text);
					$text = str_replace("?php","",$text);
					$text = str_replace("php","",$text);
					$text = str_replace("<?","",$text);
					$text = str_replace("?>","",$text);
					$text = str_replace("<script","",$text);
					$text = str_replace("<script>","",$text);
					$text = str_replace("</script>","",$text);
					$text = nl2br(htmlspecialchars(stripslashes(trim($text))));
					
					$date = date ("Y-m-d");
					$time = date ("H:i:s");
					$ip = ($_SERVER['HTTP_X_FORWARDED_FOR'] == "" ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']);
					
					$nick = $row_nick['nick'];
					$avatar = $row_nick['avatar'];
					
					if($text)
					{
							$result_insert = mysql_query("INSERT INTO comments VALUES('','$login','$nick','$avatar','$text','$date','$time','$sh_name','$ip')");
							if($result_insert)
							{
								$adress = "admin@econom.lv";
								$subject = "New comment added\n";
								$message = "Comment added by: ".$nick."\n    LTD name: ".$sh_name."\n    Date: ".$date."\n\n    Comment text: ".$text."\n\n 
								Link to the page: http://www.econom.lv/page.php?lang=".$lang."&city=".$_GET['city']."&b_def=".$_GET['b_def']."&defcat=".$_GET['defcat']."&link=".$_GET['link']."\n\n\n	Ip: ".$ip."";
								mail ($adress,$subject,$message,'Content-type:text/plain; charset=UTF-8');
							
								echo ("<p class='commwarn'>".$comm_update."</p>  <meta http-equiv='refresh' content='0'>");
							}
							else
							{
								echo "<p class='join_us_error'>".$reg_user_db_err."</p>";
							}
					}
					else
					{
						echo "<p class='join_us_error'>".$comm_error_all_fields."</p>";
					}
				}
				?>
                <form action='' method='POST'>
                <table style="margin-bottom:50px" border='0' cellspacing='0' cellpadding='10' width='100%' class='joinF'>
                <tr>
                <td colspan="2"><div class='trform'><input type='text' name='tress' size='6' maxlength='6'/></div>
                </td>
                    
                    <tr>
                        <td width='130px'>
                <p><?php echo $comm_text; ?></p>
                        </td>
                        <td align="center">
                <textarea cols='80' rows='3' name='message'><?php echo $text; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td align="center">
                <input type='submit' name='submit_post' value='<?php echo $ltd_create_opt_but; ?>'>
                        </td>
                    </tr>
                </table>
                </form>
                <?php
			}
			else
			{
				echo "<p style='margin-top:30px; margin-bottom:30px' align='center' class='join_us_error'>".$page_no_user."</p>";
			}
		}
		
		echo "<p class='stats' align='right'>".$profile_stats.": ".$stats_views."</p>";
?>
				</td>
                </tr>
                </table>
    </td>
  </tr>
</table>
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
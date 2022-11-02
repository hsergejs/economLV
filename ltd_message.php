<?php
define( '_NO', 1 );
session_start();
header("Content-type: text/html; charset=utf-8");
include_once("block/bd.php");

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
	echo "<meta http-equiv='Refresh' content='0; URL=".$_SERVER['PHP_SELF']."?lang=lat&link=".$_GET['link']."'>";
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
include_once("users/valid_fns.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $page_title; ?></title>
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
<table align="center" width="600px" border="0">
  <tr>
    <td colspan="3"><div id="bwrap"><table width="100%" border="0">
  <tr>
    <td valign="top"><div id="textwrap">
	<?php if(isset($_GET['link']))
	{
		$sh_name = $_GET['link'];
		if($lang == 'rus')
		{
			$result_select = mysql_query("SELECT login FROM catalogue_rus WHERE ltd_name = '$sh_name'");
		}
		else
		{
			$result_select = mysql_query("SELECT login FROM catalogue_lat WHERE ltd_name = '$sh_name'");
		}
		
		if(mysql_num_rows($result_select)>0)
		{
			$sh_name = htmlspecialchars(stripslashes(trim($sh_name)));
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
	
	if($_POST['send_mess'])
	{
		if($_POST['tress'])
		{
			exit("No access allowed!");
		}
		
		if(isset($_POST['ssendermail']))
		{
			$from = $_POST['ssendermail'];
		}
		if($from == '')
		{
			unset($from);
		}
		
		$from = str_replace("'","`",$from);
		$from = str_replace("<?php","",$from);
		$from = str_replace("<?php>","",$from);
		$from = str_replace("?php","",$from);
		$from = str_replace("php","",$from);
		$from = str_replace("<?","",$from);
		$from = str_replace("?>","",$from);
		$from = str_replace("<script","",$from);
		$from = str_replace("<script>","",$from);
		$from = str_replace("</script>","",$from);
		$from = trim(stripslashes(htmlspecialchars($from)));
		
		if(isset($_POST['smess']))
		{
			$mess = $_POST['smess'];
		}
		if($mess == '')
		{
			unset($mess);
		}
		
		$mess = str_replace("'","`",$mess);
		$mess = str_replace("<?php","",$mess);
		$mess = str_replace("<?php>","",$mess);
		$mess = str_replace("?php","",$mess);
		$mess = str_replace("php","",$mess);
		$mess = str_replace("<?","",$mess);
		$mess = str_replace("?>","",$mess);
		$mess = str_replace("<script","",$mess);
		$mess = str_replace("<script>","",$mess);
		$mess = str_replace("</script>","",$mess);
		$mess = nl2br(stripslashes(htmlspecialchars(trim($mess))));
		
		if(isset($_POST['code']))
		{
			$code = $_POST['code'];
		}
		if($code == '')
		{
			unset($code);
		}
		
		$code = str_replace('<',"",$code);
		$code = str_replace('>',"",$code);
		$code = htmlspecialchars(stripslashes(trim($code)));
	
		if(!empty($from))
		{
			if(!empty($mess))
			{
				if(!empty($code))
				{
					if(strlen($login)<50 || strlen($login)>6)
					{
						if(ereg('^[a-zA-Z0-9 \._\-]+@([a-zA-Z0-9][a-zA-Z0-9\-]*\.)+[a-zA-Z]+$', $from))
						{
							generate_code();
							if(check_code($code))
							{
								$row_mail = mysql_fetch_array($result_select);
								$ltd_mail = $row_mail['login'];
								$date = date("Y-m-d");
								
								$result_insert = mysql_query("INSERT INTO messages VALUES ('','$ltd_mail','$sh_name','$from','$date','$mess','0')");
								if($result_insert)
								{
									exit("<h3 style='padding-top:180px; padding-bottom:180px;' align='center'>".$ltd_mess_succ."</h3>");
								}
								else
								{
									"<p class='join_us_error'>".$ltd_mess_not_succ."</p>";
								}
								
							}
							else
							{
								echo "<p class='join_us_error'>".$reg_user_code_check_code."</p>";
							}
						}
						else
						{
							echo "<p class='join_us_error'>".$reg_user_ereg_login."</p>";
						}
					}
					else
					{
						echo "<p class='join_us_error'>".$reg_user_strlen_login."</p>";	
					}
				}
				else
				{
					echo "<p class='join_us_error'>".$reg_user_empty_code."</p>";
				}
			}
			else
			{
				echo "<p class='join_us_error'>".$ltd_mess_mess_empty."</p>";
			}
		}
		else
		{
			echo "<p class='join_us_error'>".$reg_user_empty_login."</p>";
		}
	}
	?>
	<form action="ltd_message.php?lang=<?php echo $lang; ?>&link=<?php echo $sh_name; ?>" method="post">
	<table align="center" border="0" cellpadding="0" cellspacing="0">	
    <tr>
    <td colspan="3"><div class='trform'><input type='text' name='tress' size='10' maxlength='10'/></div></td>
    </tr>
    <tr>
    <td colspan="3" align="center"><h4><?php echo $ltd_message_h.$sh_name; ?></h4></td>
    </tr>
    <tr>
  	<td colspan="3" valign="middle"><div id="joinForm"><?php echo $contact_us_mand; ?></div></td>
  	</tr>
  	<tr>
    <td><p><?php echo $contact_us_email; ?></p></td>
    <td colspan="2"><input type="text" name="ssendermail" size="42" maxlength="50" value="<?php echo $from; ?>"></td>
  	</tr>
  	<tr>
    <td valign="middle"><p><?php echo $contact_us_message; ?></p></td>
    <td colspan="2"><textarea name="smess" rows="10" cols="40"><?php echo $mess; ?></textarea></td>
  	</tr>
    <tr>
    <td width="200px"><p>*<?php echo $reg_form_code; ?>: </p></td>
    <td width="60px"><input type="text" name="code" size="4" maxlength="4" /></td>
    <td align="left"><img src="codegen/code.php" /></td>
    </tr>
  	<tr >
  	<td colspan="3" align="center"><p><input type="submit" name="send_mess" value="<?php echo $contact_us_button; ?>" ></p>
  	</td>
    </tr>
	</table>
	</form> 
    </div></td>
  </tr>
</table></div>
</td>
  </tr>
</table>
</body>
</html>
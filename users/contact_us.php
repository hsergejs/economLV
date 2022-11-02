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
include_once ("valid_fns.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
if ($lang == "rus")
$result = mysql_query ("SELECT * FROM common_text_rus WHERE page='contact_us'",$db); 
else
$result = mysql_query ("SELECT * FROM common_text_lat WHERE page='contact_us'",$db);
?>
<?php if (!$result)
{
echo "<p align='center'>Error no 1.
<br />Please report to administration through admin@econom.lv</p>";
exit (mysql_error());
}
if (mysql_num_rows($result) > 0)
{
$myrow = mysql_fetch_array ($result);
}
else {
echo "<p align='center'>Error no 2. <br /> Please report to administration through admin@econom.lv</p>";
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $myrow["title"] ?></title>
<meta name="robots" content="no-cache, no-follow" /> 
<meta name="revisit-after" content="no-cache, no-revisit"/>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache" /><link href="../CSS/eccss.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="../CSS/ie7.css" />
<![endif]-->
<script type="text/javascript">
if(window.opera) {document.write('<link rel="stylesheet" type="text/css" href="../CSS/opera.css" />');}
</script>
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
</head>
<body>
<table align="center" width="1010" border="0">
  <tr>
    <?php include_once ("../block/header_user.php"); ?>
  </tr>
  <tr>
    <?php include_once ("../block/bannerup_user.php"); ?>
  </tr>
  <tr>
    <td colspan="3"><div id="bwrap"><table width="100%" border="0">
  <tr>
    <td valign="top" width="75px"></td>
    <td valign="top"><div id="textwrap">
    <?php 
if($_POST['submit']) 
{ 
	if ($_POST['tress'])
	{ 
		die ("No trespassers allowed!");
	}
	else 
	{
		$stitle = $_POST['stitle']; 
		$smess =  $_POST['smess'];
		$sname = $_POST['sname']; 
		$from = $_POST['ssendermail'];
		$code = $_POST['code'];
		
		if(!$sname)
		$errorstring1 = $errorstring1.$contact_us_error_1."<br />";
		if(!$from)
		$errorstring1 = $errorstring1.$contact_us_error_2."<br />";
		if(!$smess)
		$errorstring1 = $errorstring1.$contact_us_error_3."<br />";
		if(!$code)
		$errorstring1 = $errorstring1.$contact_us_error_10."<br />";
	
		if($sname&&$from&&$smess&&$code)
		{	   
			$stitle = nl2br(mysql_real_escape_string(htmlspecialchars(stripslashes(trim($stitle)))));
			$smess = nl2br(mysql_real_escape_string(htmlspecialchars(stripslashes(trim($smess)))));
			$sname = nl2br(mysql_real_escape_string(htmlspecialchars(stripslashes(trim($sname)))));
			$from = nl2br(mysql_real_escape_string(htmlspecialchars(stripslashes(trim($from)))));
			$code = mysql_real_escape_string(htmlspecialchars(stripslashes(trim($code))));
	
			if(ereg('^[a-zA-Z0-9 \._\-]+@([a-zA-Z0-9][a-zA-Z0-9\-]*\.)+[a-zA-Z]+$', $from))
			{
				if(check_code($code))
				{
					$address = "admin@econom.lv";
					$sub = "Contact Us econom.lv";
					$ip = ($_SERVER['HTTP_X_FORWARDED_FOR'] == "" ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']);
				
					$mess = $smess."\n 
					  
					  Subject of the message: ".$stitle."\n
					  
					  Senders Name: ".$sname."\n
					  
					  Senders Email: ".$from."\n
					  
					  Senders IP: ".$ip;
					  
					$headers = 'Content-type:text/plain; charset=UTF-8';
					$verify = mail ($address,$sub,$mess,$headers);
					
					if ($verify == 'true')
					{
						echo "<p class='contact_us_succes'>".$contact_us_succes."</p><hr style='margin-bottom:15px;'>";
					}
					else 
					{
						echo "<p class='join_us_error'>".$contact_us_error_5."</p><hr style='margin-bottom:15px;'>";
					}
				}
				else
				{
					echo "<p class='join_us_error'>".$reg_user_code_check_code."</p><hr style='margin-bottom:15px;'>";
				}
			}
			else
			{
				echo "<p class='join_us_error'>".$reg_user_ereg_login."</p><hr style='margin-bottom:15px;'>";
			}
		}
		else
		{
			echo "<p class='join_us_error'>".$contact_us_error_4.$errorstring1."</p><hr style='margin-bottom:15px;'>";
		}
	}
}
echo $myrow['text']; ?>
<div id='joinF'>
<form action="contact_us.php?lang=<?php echo $lang; ?>" method="POST" name="contacts">
<table align="center" width="600px" border="0" cellspacing="0" cellpadding="0"  class="joinF">
<tr>
<td colspan="3"><div class='trform'><input type='text' name='tress' size='10'/> </div></td>
</tr>
  <tr>
  <td colspan="3" valign="middle"><div id="joinForm"><?php echo $contact_us_mand; ?></div></td>
  </tr>
  <tr>
    <td valign="middle" width="200px"><?php echo $contact_us_name; ?></td>
    <td colspan="2" valign="middle"><input type="text" name="sname" size="42" value="<?php echo $sname; ?>"></td>
  </tr>
  <tr>
    <td valign="middle"><?php echo $contact_us_email; ?></td>
    <td colspan="2" valign="middle"><input type="text" name="ssendermail" size="42" value="<?php echo $from; ?>"></td>
  </tr>
  <tr>
    <td valign="middle"><?php echo $contact_us_subject; ?></td>
    <td colspan="2" valign="middle"><input type="text" name="stitle" size="42" value="<?php echo $stitle; ?>"></td>
  </tr>
  <tr>
    <td valign="middle"><?php echo $contact_us_message; ?></td>
    <td colspan="2" valign="middle"><textarea name="smess" rows="10" cols="40"><?php echo $smess; ?></textarea></td>
  </tr>
  <tr>
<td><p><?php echo "*".$reg_form_code; ?>: </p></td>
<td width="70px"><input type="text" name="code" size="4" maxlength="4" /></td>
<td><p><img src="../codegen/code.php" /></p></td>
</tr>
  <tr >
  	<td height="50px" colspan="3" align="center"><input type="submit" value="<?php echo $contact_us_button; ?>" name="submit">
  	</td>
    </tr>
</table>
</form> 
</div>
    </div></td>
    <td valign="top" width="75px"></td>
  </tr>
</table></div>
</td>
  </tr>
  <tr>
    <td colspan="3"><table align="center" width="1010" border="0">
  <tr>
    <?php include_once ("../block/footer_user.php"); ?>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
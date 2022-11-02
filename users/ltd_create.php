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
include("word-count.php");
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $ltd_create_title; ?></title>
<meta name="robots" content="no-cache, no-follow" /> 
<meta name="revisit-after" content="no-cache, no-revisit"/>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache" />
<link href="../CSS/eccss.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../CSS/date_input/date_input.css" type="text/css">
<!--[if IE 7]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="../CSS/ie7.css" />
<![endif]-->
<script type="text/javascript">
if(window.opera) {document.write('<link rel="stylesheet" type="text/css" href="../CSS/opera.css" />');}
</script>
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="../js/jquery.js"></script>
<?php if($lang == 'rus')
{
	echo '<script type="text/javascript" src="../js/date_input/jquery.date_input.js"></script>';
}
else
{
	echo '<script type="text/javascript" src="../js/date_input/jquery.date_input_1.js"></script>';
} ?>
<script type="text/javascript">$($.date_input.initialize);</script>
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
	$result = mysql_query("SELECT login,passwd FROM users WHERE login = '$login' AND passwd = '$passwd'");
	$row_user_db = mysql_fetch_array($result);
	$login_db = $row_user_db['login'];
	$passwd_db = $row_user_db['passwd'];
	if(mysql_num_rows($result)>0 && $login === $login_db && $passwd === $passwd_db)
	{	
		if(isset($_POST['b_def']))
		{
			$b_def = $_POST['b_def'];
		}
		if($b_def == '')
		{
			unset($b_def);
			exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
		}
	
		$b_def = str_replace("'","",$b_def);
		$b_def = str_replace("_"," ",$b_def);
		$b_def = str_replace('"',"",$b_def);
		$b_def = str_replace('?',"",$b_def);
		$b_def = str_replace('<',"",$b_def);
		$b_def = str_replace('>',"",$b_def);
		$b_def = str_replace('/',"",$b_def);
		$b_def = str_replace('|',"",$b_def);
		$b_def = str_replace('[',"",$b_def);
		$b_def = str_replace(']',"",$b_def);
		$b_def = str_replace('{',"",$b_def);
		$b_def = str_replace('}',"",$b_def);
		$b_def = str_replace('^',"",$b_def);
		$b_def = str_replace('£',"",$b_def);
		$b_def = str_replace('$',"",$b_def);
		$b_def = str_replace('#',"",$b_def);
		$b_def = str_replace('~',"",$b_def);
		$b_def = htmlspecialchars(stripslashes(trim($b_def)));
			
		if(isset($_POST['def']))
		{
			$def = $_POST['def'];
		}
		if($def == '')
		{
			unset($def);
			exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
		}
			
		$def = str_replace("'","",$def);
		$def = str_replace("_"," ",$def);
		$def = str_replace('"',"",$def);
		$def = str_replace('?',"",$def);
		$def = str_replace('<',"",$def);
		$def = str_replace('>',"",$def);
		$def = str_replace('/',"",$def);
		$def = str_replace('|',"",$def);
		$def = str_replace('[',"",$def);
		$def = str_replace(']',"",$def);
		$def = str_replace('{',"",$def);
		$def = str_replace('}',"",$def);
		$def = str_replace('^',"",$def);
		$def = str_replace('£',"",$def);
		$def = str_replace('$',"",$def);
		$def = str_replace('#',"",$def);
		$def = str_replace('~',"",$def);
		$def = htmlspecialchars(stripslashes(trim($def)));
		
		if($lang == 'rus')
		{
			$cat_value_ch = mysql_query("SELECT * FROM cat_create_rus WHERE b_def = '$b_def' AND def = '$def'");
		}
		else
		{
			$cat_value_ch = mysql_query("SELECT * FROM cat_create_lat WHERE b_def = '$b_def' AND def = '$def'");
		}
		
		if(mysql_num_rows($cat_value_ch) == '0')
		{
			unset($b_def);
			unset($def);
			unset($sh_name);
			exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
		}
		
		if(isset($_POST['photo_choise']))
		{
			$photo = $_POST['photo_choise'];
		}
		if($photo == '')
		{
			unset($photo);
			exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
		}
		
		if(isset($_POST['pvn']))
		{
			$pvn = $_POST['pvn'];
		}
		if($pvn == '')
		{
			unset($pvn);
		}
					
		$pvn = str_replace("'","",$pvn);
		$pvn = str_replace("_"," ",$pvn);
		$pvn = str_replace('"',"",$pvn);
		$pvn = str_replace('?',"",$pvn);
		$pvn = str_replace('<',"",$pvn);
		$pvn = str_replace('>',"",$pvn);
		$pvn = str_replace('/',"",$pvn);
		$pvn = str_replace('|',"",$pvn);
		$pvn = str_replace('[',"",$pvn);
		$pvn = str_replace(']',"",$pvn);
		$pvn = str_replace('{',"",$pvn);
		$pvn = str_replace('}',"",$pvn);
		$pvn = str_replace('^',"",$pvn);
		$pvn = str_replace('£',"",$pvn);
		$pvn = str_replace('$',"",$pvn);
		$pvn = str_replace('#',"",$pvn);
		$pvn = str_replace('~',"",$pvn);
		$pvn = str_replace(" & ","",$pvn);
		$pvn = str_replace("&","",$pvn);
		$pvn = str_replace(" @ ","",$pvn);
		$pvn = str_replace("@","",$pvn);
		$pvn = htmlspecialchars(stripslashes(trim($pvn)));
		
		if(isset($_POST['sh_name']))
		{
			$sh_name = $_POST['sh_name'];
		}
		if($sh_name == '')
		{
			unset($sh_name);
		}
					
		$sh_name = str_replace("'","",$sh_name);
		$sh_name = str_replace("_"," ",$sh_name);
		$sh_name = str_replace('"',"",$sh_name);
		$sh_name = str_replace('?',"",$sh_name);
		$sh_name = str_replace('<',"",$sh_name);
		$sh_name = str_replace('>',"",$sh_name);
		$sh_name = str_replace('/',"",$sh_name);
		$sh_name = str_replace('|',"",$sh_name);
		$sh_name = str_replace('[',"",$sh_name);
		$sh_name = str_replace(']',"",$sh_name);
		$sh_name = str_replace('{',"",$sh_name);
		$sh_name = str_replace('}',"",$sh_name);
		$sh_name = str_replace('^',"",$sh_name);
		$sh_name = str_replace('£',"",$sh_name);
		$sh_name = str_replace('$',"",$sh_name);
		$sh_name = str_replace('#',"",$sh_name);
		$sh_name = str_replace('~',"",$sh_name);
		$sh_name = str_replace(" & "," and ",$sh_name);
		$sh_name = str_replace("&"," and ",$sh_name);
		$sh_name = str_replace(" @ "," at ",$sh_name);
		$sh_name = str_replace("@"," at ",$sh_name);
		$sh_name = htmlspecialchars(stripslashes(trim($sh_name)));
				
		if(isset($_POST['descr_sh']))
		{
			$descr_sh = $_POST['descr_sh'];
		}
		if($descr_sh == '')
		{
			unset($descr_sh);
		}
					
		$descr_sh = str_replace("'","`",$descr_sh);
		$descr_sh = str_replace("<?php","",$descr_sh);
		$descr_sh = str_replace("<?php>","",$descr_sh);
		$descr_sh = str_replace("?php","",$descr_sh);
		$descr_sh = str_replace("php","",$descr_sh);
		$descr_sh = str_replace("<?","",$descr_sh);
		$descr_sh = str_replace("?>","",$descr_sh);
		$descr_sh = str_replace("<script","",$descr_sh);
		$descr_sh = str_replace("<script>","",$descr_sh);
		$descr_sh = str_replace("</script>","",$descr_sh);
		$descr_sh = str_replace("mysql_query","",$descr_sh);
		$descr_sh = str_replace("mysql_fetch_array","",$descr_sh);
		$descr_sh = str_replace("mysql_fetch_assoc","",$descr_sh);
		$descr_sh = str_replace("unlink","",$descr_sh);
		$descr_sh = str_replace("unset","",$descr_sh);
		$descr_sh = nl2br(htmlspecialchars(stripslashes(trim($descr_sh))));
				
		if(isset($_POST['web_sh']))
		{
			$web_sh = $_POST['web_sh'];
		}
		if($web_sh == '')
		{
			unset($web_sh);
		}
					
		$web_sh = str_replace("<?php","",$web_sh);
		$web_sh = str_replace("<?php>","",$web_sh);
		$web_sh = str_replace("?php","",$web_sh);
		$web_sh = str_replace("php","",$web_sh);
		$web_sh = str_replace("<?","",$web_sh);
		$web_sh = str_replace("?>","",$web_sh);
		$web_sh = str_replace("<script","",$web_sh);
		$web_sh = str_replace("<script>","",$web_sh);
		$web_sh = str_replace("</script>","",$web_sh);
		$web_sh = str_replace("mysql_query","",$web_sh);
		$web_sh = str_replace("mysql_fetch_array","",$web_sh);
		$web_sh = str_replace("mysql_fetch_assoc","",$web_sh);
		$web_sh = str_replace("unlink","",$web_sh);
		$web_sh = str_replace("unset","",$web_sh);
		$web_sh = trim(htmlspecialchars(stripslashes($web_sh)));
				
		if(isset($_POST['phone_sh']))
		{
			$phone_sh = $_POST['phone_sh'];
		}
		if($phone_sh == '')
		{
			unset($phone_sh);
		}
					
		$phone_sh = str_replace("<?php","",$phone_sh);
		$phone_sh = str_replace("<?php>","",$phone_sh);
		$phone_sh = str_replace("?php","",$phone_sh);
		$phone_sh = str_replace("php","",$phone_sh);
		$phone_sh = str_replace("<?","",$phone_sh);
		$phone_sh = str_replace("?>","",$phone_sh);
		$phone_sh = str_replace("<script","",$phone_sh);
		$phone_sh = str_replace("<script>","",$phone_sh);
		$phone_sh = str_replace("</script>","",$phone_sh);
		$phone_sh = str_replace("mysql_query","",$phone_sh);
		$phone_sh = str_replace("mysql_fetch_array","",$phone_sh);
		$phone_sh = str_replace("mysql_fetch_assoc","",$phone_sh);
		$phone_sh = str_replace("unlink","",$phone_sh);
		$phone_sh = str_replace("unset","",$phone_sh);
		$phone_sh = htmlspecialchars(stripslashes(trim($phone_sh)));
					
		if(isset($_POST['phone_sh_2']))
		{
			$phone_sh_2 = $_POST['phone_sh_2'];
		}
		if($phone_sh_2 == '')
		{
			unset($phone_sh_2);
		}
					
		$phone_sh_2 = str_replace("<?php","",$phone_sh_2);
		$phone_sh_2 = str_replace("<?php>","",$phone_sh_2);
		$phone_sh_2 = str_replace("?php","",$phone_sh_2);
		$phone_sh_2 = str_replace("php","",$phone_sh_2);
		$phone_sh_2 = str_replace("<?","",$phone_sh_2);
		$phone_sh_2 = str_replace("?>","",$phone_sh_2);
		$phone_sh_2 = str_replace("<script","",$phone_sh_2);
		$phone_sh_2 = str_replace("<script>","",$phone_sh_2);
		$phone_sh_2 = str_replace("</script>","",$phone_sh_2);
		$phone_sh_2 = str_replace("mysql_query","",$phone_sh_2);
		$phone_sh_2 = str_replace("mysql_fetch_array","",$phone_sh_2);
		$phone_sh_2 = str_replace("mysql_fetch_assoc","",$phone_sh_2);
		$phone_sh_2 = str_replace("unlink","",$phone_sh_2);
		$phone_sh_2 = str_replace("unset","",$phone_sh_2);
		$phone_sh_2 = htmlspecialchars(stripslashes(trim($phone_sh_2)));
					
		if(isset($_POST['fax_sh']))
		{
			$fax_sh = $_POST['fax_sh'];
		}
		if($fax_sh == '')
		{
			unset($fax_sh);
		}
					
		$fax_sh = str_replace("<?php","",$fax_sh);
		$fax_sh = str_replace("<?php>","",$fax_sh);
		$fax_sh = str_replace("?php","",$fax_sh);
		$fax_sh = str_replace("php","",$fax_sh);
		$fax_sh = str_replace("<?","",$fax_sh);
		$fax_sh = str_replace("?>","",$fax_sh);
		$fax_sh = str_replace("<script","",$fax_sh);
		$fax_sh = str_replace("<script>","",$fax_sh);
		$fax_sh = str_replace("</script>","",$fax_sh);
		$fax_sh = str_replace("mysql_query","",$fax_sh);
		$fax_sh = str_replace("mysql_fetch_array","",$fax_sh);
		$fax_sh = str_replace("mysql_fetch_assoc","",$fax_sh);
		$fax_sh = str_replace("unlink","",$fax_sh);
		$fax_sh = str_replace("unset","",$fax_sh);
		$fax_sh = htmlspecialchars(stripslashes(trim($fax_sh)));
				
		if(isset($_POST['address_sh']))
		{
			$address_sh = $_POST['address_sh'];
		}
		if($address_sh == '')
		{
			unset($address_sh);
		}
					
		$address_sh = str_replace("\\","/",$address_sh);
		$address_sh = str_replace("'","",$address_sh);
		$address_sh = str_replace('"',"",$address_sh);
		$address_sh = str_replace("¬","",$address_sh);
		$address_sh = str_replace("`","",$address_sh);
		$address_sh = str_replace("£","",$address_sh);
		$address_sh = str_replace("$","",$address_sh);
		$address_sh = str_replace("%","",$address_sh);
		$address_sh = str_replace("^","",$address_sh);
		$address_sh = str_replace("&","",$address_sh);
		$address_sh = str_replace("*","",$address_sh);
		$address_sh = str_replace("(","",$address_sh);
		$address_sh = str_replace(")","",$address_sh);
		$address_sh = str_replace("_","",$address_sh);
		$address_sh = str_replace("+","",$address_sh);
		$address_sh = str_replace("=","",$address_sh);
		$address_sh = str_replace("{","",$address_sh);
		$address_sh = str_replace("}","",$address_sh);
		$address_sh = str_replace("@","",$address_sh);
		$address_sh = str_replace("#","",$address_sh);
		$address_sh = str_replace("~","",$address_sh);
		$address_sh = str_replace("<","",$address_sh);
		$address_sh = str_replace(">","",$address_sh);
		$address_sh = str_replace("?","",$address_sh);
		$address_sh = str_replace("|","",$address_sh);
		$address_sh = htmlspecialchars(trim($address_sh));
					
		if(isset($_POST['city']))
		{
			$city_sh = $_POST['city'];
		}
		if($city_sh == '')
		{
			unset($city_sh);
		}
		
		$city_sh = str_replace("<","",$city_sh);
		$city_sh = str_replace(">","",$city_sh);
		$city_sh = str_replace("<?php","",$city_sh);
		$city_sh = str_replace("<?php>","",$city_sh);
		$city_sh = str_replace("?php","",$city_sh);
		$city_sh = str_replace("php","",$city_sh);
		$city_sh = str_replace("<?","",$city_sh);
		$city_sh = str_replace("?>","",$city_sh);
		$city_sh = str_replace("<script","",$city_sh);
		$city_sh = str_replace("<script>","",$city_sh);
		$city_sh = str_replace("</script>","",$city_sh);
		$city_sh = str_replace("mysql_query","",$city_sh);
		$city_sh = str_replace("mysql_fetch_array","",$city_sh);
		$city_sh = str_replace("mysql_fetch_assoc","",$city_sh);
		$city_sh = str_replace("unlink","",$city_sh);
		$city_sh = str_replace("unset","",$city_sh);
		$city_sh = htmlspecialchars(stripslashes(trim($city_sh)));
					
		if(isset($_POST['post_sh']))
		{
			$post_sh = $_POST['post_sh'];
		}
		if($post_sh == '')
		{
			unset($post_sh);
		}
				
		$post_sh = str_replace("<?php","",$post_sh);
		$post_sh = str_replace("<?php>","",$post_sh);
		$post_sh = str_replace("?php","",$post_sh);
		$post_sh = str_replace("php","",$post_sh);
		$post_sh = str_replace("<?","",$post_sh);
		$post_sh = str_replace("?>","",$post_sh);
		$post_sh = str_replace("<script","",$post_sh);
		$post_sh = str_replace("<script>","",$post_sh);
		$post_sh = str_replace("</script>","",$post_sh);
		$post_sh = str_replace("mysql_query","",$post_sh);
		$post_sh = str_replace("mysql_fetch_array","",$post_sh);
		$post_sh = str_replace("mysql_fetch_assoc","",$post_sh);
		$post_sh = str_replace("unlink","",$post_sh);
		$post_sh = str_replace("unset","",$post_sh);
		$post_sh = htmlspecialchars(stripslashes(trim($post_sh)));
					
		if(isset($_POST['descr_offer']))
		{
			$descr_offer = $_POST['descr_offer'];
		}
		if($descr_offer == '')
		{
			unset($descr_offer);
		}
				
		$descr_offer = str_replace("'","`",$descr_offer);
		$descr_offer = str_replace("<?php","",$descr_offer);
		$descr_offer = str_replace("<?php>","",$descr_offer);
		$descr_offer = str_replace("?php","",$descr_offer);
		$descr_offer = str_replace("php","",$descr_offer);
		$descr_offer = str_replace("<?","",$descr_offer);
		$descr_offer = str_replace("?>","",$descr_offer);
		$descr_offer = str_replace("<script","",$descr_offer);
		$descr_offer = str_replace("<script>","",$descr_offer);
		$descr_offer = str_replace("</script>","",$descr_offer);
		$descr_offer = str_replace("mysql_query","",$descr_offer);
		$descr_offer = str_replace("mysql_fetch_array","",$descr_offer);
		$descr_offer = str_replace("mysql_fetch_assoc","",$descr_offer);
		$descr_offer = str_replace("unlink","",$descr_offer);
		$descr_offer = str_replace("unset","",$descr_offer);
		$descr_offer = nl2br(htmlspecialchars(trim($descr_offer)));
				
		if(isset($_POST['from_date_offer']))
		{
			$date_from = $_POST['from_date_offer'];
		}
		if($date_from == '')
		{
			unset($date_from);
		}
					
		if(isset($_POST['till_date_offer']))
		{
			$date_till = $_POST['till_date_offer'];
		}
		if($date_till == '')
		{
			unset($date_till);
		}
						
		$date_from = str_replace("'","`",$date_from);
		$date_from = str_replace("<?php","",$date_from);
		$date_from = str_replace("<?php>","",$date_from);
		$date_from = str_replace("?php","",$date_from);
		$date_from = str_replace("php","",$date_from);
		$date_from = str_replace("<?","",$date_from);
		$date_from = str_replace("?>","",$date_from);
		$date_from = str_replace("<script","",$date_from);
		$date_from = str_replace("<script>","",$date_from);
		$date_from = str_replace("</script>","",$date_from);
		$date_from = str_replace("mysql_query","",$date_from);
		$date_from = str_replace("mysql_fetch_array","",$date_from);
		$date_from = str_replace("mysql_fetch_assoc","",$date_from);
		$date_from = str_replace("unlink","",$date_from);
		$date_from = str_replace("unset","",$date_from);
						
		$date_till = str_replace("'","`",$date_till);
		$date_till = str_replace("<?php","",$date_till);
		$date_till = str_replace("<?php>","",$date_till);
		$date_till = str_replace("?php","",$date_till);
		$date_till = str_replace("php","",$date_till);
		$date_till = str_replace("<?","",$date_till);
		$date_till = str_replace("?>","",$date_till);
		$date_till = str_replace("<script","",$date_till);
		$date_till = str_replace("<script>","",$date_till);
		$date_till = str_replace("</script>","",$date_till);
		$date_till = str_replace("mysql_query","",$date_till);
		$date_till = str_replace("mysql_fetch_array","",$date_till);
		$date_till = str_replace("mysql_fetch_assoc","",$date_till);
		$date_till = str_replace("unlink","",$date_till);
		$date_till = str_replace("unset","",$date_till);
					
		$date_from = htmlspecialchars(stripslashes(trim($date_from)));
		$date_till = htmlspecialchars(stripslashes(trim($date_till)));
					
		if(isset($_POST['descr_sh_sec_lang']))
		{
			$descr_sh_sec_lang = $_POST['descr_sh_sec_lang'];
		}
		if($descr_sh_sec_lang == '')
		{
			unset($descr_sh_sec_lang);
		}
					
		$descr_sh_sec_lang = str_replace("'","`",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("<?php","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("<?php>","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("?php","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("php","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("<?","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("?>","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("<script","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("<script>","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("</script>","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("mysql_query","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("mysql_fetch_array","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("mysql_fetch_assoc","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("unlink","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = str_replace("unset","",$descr_sh_sec_lang);
		$descr_sh_sec_lang = nl2br(htmlspecialchars(trim($descr_sh_sec_lang)));
					
		if(isset($_POST['descr_offer_sec_lang']))
		{
			$descr_offer_sec_lang = $_POST['descr_offer_sec_lang'];
		}
		if($descr_offer_sec_lang == '')
		{
			unset($descr_offer_sec_lang);
		}
					
		$descr_offer_sec_lang = str_replace("'","`",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("<?php","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("<?php>","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("?php","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("php","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("<?","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("?>","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("<script","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("<script>","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("</script>","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("mysql_query","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("mysql_fetch_array","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("mysql_fetch_assoc","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("unlink","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = str_replace("unset","",$descr_offer_sec_lang);
		$descr_offer_sec_lang = nl2br(htmlspecialchars(trim($descr_offer_sec_lang)));
		
			if($_POST['lang_choise'] == 'one_lang')
			{				
				if($_POST['ltd_create'])
				{
					if(empty($pvn))
					{
						empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_no_pvn."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
					}
					elseif(empty($sh_name))
					{
						empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_no_shname."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
					}
					elseif(empty($descr_offer))
					{
						empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_no_descr_offer."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
					}
					elseif(empty($date_from) && empty($date_till))
					{
						empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_no_dates."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
					}
					elseif(strlen($sh_name)>50 || strlen($sh_name)<2)
					{
						empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_sh_name."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
					}
					elseif((strlen($date_from)<10 || strlen($date_till)<10) && (strlen($date_from)>12 || strlen($date_till)>12))
					{
						empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_dates."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
					}
					else
					{
						if(!empty($web_sh))
						{
							if(strlen($web_sh)<4 || strlen($web_sh)>40)
							{
								empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_web."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
							elseif(!ereg('^([a-zA-Z0-9][a-zA-Z0-9\-]*\.)+[a-zA-Z]+$',$web_sh))
							{
								empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_ereg_web."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
						}
						
						if(!empty($phone_sh))
						{
							if(strlen($phone_sh) !== 8)
							{
								empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
							elseif(!ereg('^[0-9]+$',$phone_sh))
							{
							empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_ereg_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
						}
						
						if(!empty($phone_sh_2))
						{
							if(strlen($phone_sh_2) !== 8)
							{
								empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
							elseif(!ereg('^[0-9]+$',$phone_sh_2))
							{
							empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_ereg_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
						}
						
						if(!empty($fax_sh))
						{
							if(strlen($fax_sh) !== 8)
							{
								empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_fax_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
							elseif(!ereg('^[0-9]+$',$fax_sh))
							{
							empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_ereg_fax_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
						}
						
						if(!empty($address_sh))
						{
							if(strlen($address_sh)<4 || strlen($address_sh)>60)
							{
								empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_address."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
						}
						
						if(!empty($post_sh))
						{
							if(!ereg('^[0-9]+$',$post_sh))
							{
								empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_eregi_post."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
							elseif(strlen($post_sh) !== 4)
							{
								empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_post."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
							}
						}
		// proverka ltd i pvn v sisteme	
						if($lang == 'rus')
						{
							$result_check_new_pvn = mysql_query("SELECT pvn FROM ltd_page_rus WHERE pvn = '$pvn'");
							$result_check_new_sh_name = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$sh_name'");
						}
						else
						{
							$result_check_new_pvn = mysql_query("SELECT pvn FROM ltd_page_lat WHERE pvn = '$pvn'");
							$result_check_new_sh_name = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$sh_name'");
						}
						
						if(mysql_num_rows($result_check_new_pvn)>0)
						{
							empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_pvn_check."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);	
						}
						elseif(mysql_num_rows($result_check_new_sh_name)>0)
						{
							empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_ltd_check."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
						}
			// na4alo zapisi v db
						$result_check_mess = mysql_query("SELECT login FROM messages WHERE login = '$login'");
						if(!mysql_num_rows($result_check_mess)>0)
						{
							$from_mess = "admin@econom.lv";
							$date_mess = date("Y-m-d");
							if($lang == 'rus')
							{
								$message_mess = "Благодарим вас за регистрацию вашей фирмы в нашем каталоге. Если у вас появятся любые вопросы или пожелания, вы можете связаться с нами через раздел Контакты. Мы будем рады узнать ваше мнение о работе нашей системы или если вы обнаружите ошибки в работе каталога, системы администрирования, или контексте просим вас сообщить нам об этом. Мы работаем для вас вместе с вами.";
							}
							else
							{
								$message_mess = "Pateicamies par Jūsu firmas reģistrāciju mūsu katalogā. Ja Jums rodas kādi jautājumi vai vēlmes, sazinieties ar mums caur sadaļu Kontakti. Būsim pateicīgi, ja izteiksiet savu viedokli par mūsu sistēmas darbu vai arī, ja esiet pamanījis kļūdu katalogā, sistēmas administrācijā, vai saturā, lūdzam par to ziņot mums. Mēs strādājam Jums kopā ar Jums.";
							}
							
							mysql_query("INSERT INTO messages 
																VALUES  ('','$login','','$from_mess','$date_mess','$message_mess','0')");
						}
						
						if($lang == 'rus')
						{
							$content1= $descr_sh." ".$descr_offer;
							
							$content = mb_convert_encoding($content1, "windows-1251", "utf8");
							
							$word_counter = new Counter_rus();
							
							if (strlen($content)>50000)
							{
								$keywords = $word_counter->get_keywords(substr($content, 0, 50000));
							}
							else
							{
								$keywords = $word_counter->get_keywords($content);
							}
							
							$keywords = $city_sh.", ".$b_def.", ".$def.", ".$sh_name.", ".$keywords;
							
							$result_insert_rus = mysql_query("INSERT INTO ltd_page_rus
							(login,pvn,sh_name,meta_k,title,descr,web,phone,phone_2,fax,address,
							 city,post,descr_offer,from_date_offer,till_date_offer,b_def,defcat,activation) 
							VALUES 
							('$login','$pvn','$sh_name','$keywords','$sh_name','$descr_sh','$web_sh','$phone_sh','$phone_sh_2',
							 '$fax_sh','$address_sh','$city_sh','$post_sh','$descr_offer','$date_from',
							 '$date_till','$b_def','$def','0')");
							
							$result_insert_cat_rus = mysql_query("INSERT INTO catalogue_rus 
													(login,ltd_name,city,b_def,definition,activation) 
													VALUES 
													('$login','$sh_name','$city_sh','$b_def','$def','0')");
							
							if($city_sh == "Рига")
							{
								$city_sh = "Rīga";
							}
							elseif($city_sh == "Юрмала")
							{
								$city_sh = "Jūrmala";
							}
							elseif($city_sh == "Рижский р-он")
							{
								$city_sh = "Rīgas rajons";
							}
							elseif($city_sh == "Айзкраукле и р-он")
							{
								$city_sh = "Aizkraukle un raj";
							}
							elseif($city_sh == "Алуксне и р-он")
							{
								$city_sh = "Alūksne un raj";
							}
							elseif($city_sh == "Балви и р-он")
							{
								$city_sh = "Balvi un raj";
							}
							elseif($city_sh == "Бауска и р-он")
							{
								$city_sh = "Bauska un raj";
							}
							elseif($city_sh == "Валка и р-он")
							{
								$city_sh = "Valka un raj";
							}
							elseif($city_sh == "Валмиера и р-он")
							{
								$city_sh = "Valmiera un raj";
							}
							elseif($city_sh == "Вентспилс и р-он")
							{
								$city_sh = "Ventspils un raj";
							}
							elseif($city_sh == "Гулбене и р-он")
							{
								$city_sh = "Gulbene un raj";
							}
							elseif($city_sh == "Даугавпилс и р-он")
							{
								$city_sh = "Daugavpils un raj";
							}
							elseif($city_sh == "Добеле и р-он")
							{
								$city_sh = "Dobele un raj";
							}
							elseif($city_sh == "Екабпилс и р-он")
							{
								$city_sh = "Jēkabpils un raj";
							}
							elseif($city_sh == "Елгава и р-он")
							{
								$city_sh = "Jelgava un raj";
							}
							elseif($city_sh == "Краславa и р-он")
							{
								$city_sh = "Krāslava un raj";
							}
							elseif($city_sh == "Кулдыга и р-он")
							{
								$city_sh = "Kuldīga un raj";
							}
							elseif($city_sh == "Лиепая и р-он")
							{
								$city_sh = "Liepāja un raj";
							}
							elseif($city_sh == "Лимбажи и р-он")
							{
								$city_sh = "Limbaži un raj";
							}
							elseif($city_sh == "Лудза и р-он")
							{
								$city_sh = "Ludza un raj";
							}
							elseif($city_sh == "Мадона и р-он")
							{
								$city_sh = "Madona un raj";
							}
							elseif($city_sh == "Огре и р-он")
							{
								$city_sh = "Ogre un raj";
							}
							elseif($city_sh == "Преили и р-он")
							{
								$city_sh = "Preiļi un raj";
							}
							elseif($city_sh == "Резекне и р-он")
							{
								$city_sh = "Rēzekne un raj";
							}
							elseif($city_sh == "Салдус и р-он")
							{
								$city_sh = "Saldus un raj";
							}
							elseif($city_sh == "Талси и р-он")
							{
								$city_sh = "Talsi un raj";
							}
							elseif($city_sh == "Тукумс и р-он")
							{
								$city_sh = "Tukums un raj";
							}
							elseif($city_sh == "Цесис и р-он")
							{
								$city_sh = "Cēsis un raj";
							}
							
			////////////////1.rus - 2.lat				
							if($b_def == "Аксессуары")
							{
								$b_def = "Aksesuāri";
							}
							elseif($b_def == "Веб")
							{
								$b_def = "Web";
							}
							elseif($b_def == "Для детей")
							{
								$b_def = "Bērniem";
							}
							elseif($b_def == "Для офиса, дома и сада")
							{
								$b_def = "Ofisam, mājai un dārzam";
							}
							elseif($b_def == "Для свадьбы")
							{
								$b_def = "Kāzām";
							}
							elseif($b_def == "Другое")
							{
								$b_def = "Citi";
							}
							elseif($b_def == "Животные, птицы и pыбы")
							{
								$b_def = "Dzīvnieki, putni un zivis";
							}
							elseif($b_def == "Интернет, радио, телевидение, связь")
							{
								$b_def = "Internets, radio, televīzija, sakari";
							}
							elseif($b_def == "Интернет магазин")
							{
								$b_def = "Internetveikali";
							}
							elseif($b_def == "Красота и здоровье")
							{
								$b_def = "Skaistums un veselība";
							}
							elseif($b_def == "Недвижимость")
							{
								$b_def = "Nekustamais īpašums";
							}
							elseif($b_def == "Образовaние")
							{
								$b_def = "Izglītība";
							}
							elseif($b_def == "Обувь")
							{
								$b_def = "Apavi";
							}
							elseif($b_def == "Одежда")
							{
								$b_def = "Apģērbs";
							}
							elseif($b_def == "Отдых и развлечения")
							{
								$b_def = "Atpūta un izklaide";
							}
							elseif($b_def == "Полиграфия и печать")
							{
								$b_def = "Poligrāfija un druka";
							}
							elseif($b_def == "Продукты питания")
							{
								$b_def = "Pārtikas produkti";
							}
							elseif($b_def == "Рестораны и бары")
							{
								$b_def = "Restorāni un bāri";
							}
							elseif($b_def == "Спорт")
							{
								$b_def = "Sports";
							}
							elseif($b_def == "Страхование")
							{
								$b_def = "Apdrošināšana";
							}
							elseif($b_def == "Строительство и ремонт")
							{
								$b_def = "Būvniecība un remonts";
							}
							elseif($b_def == "Транспорт")
							{
								$b_def = "Transports";
							}
							elseif($b_def == "Туризм")
							{
								$b_def = "Tūrisms";
							}
							elseif($b_def == "Финансовые услуги")
							{
								$b_def = "Finansu pakalpojumi";
							}
							elseif($b_def == "Электроника и техника")
							{
								$b_def = "Elektronika un tehnika";
							}
							
							if($def == "Бижутерия")
							{
								$def = "Bižutērija";
							}
							elseif($def == "Часы")
							{
								$def = "Pulksteņi";
							}
							elseif($def == "Ювелирные изделия")
							{
								$def = "Juvelierizstrādājumi";
							}
							elseif($def == "Услуги")
							{
								$def = "Pakalpojumi";
							}
							elseif($def == "Другое")
							{
								$def = "Citi";
							}
							elseif($def == "Дизайн")
							{
								$def = "Dizains";
							}
							elseif($def == "Каталоги")
							{
								$def = "Katalogi";
							}
							elseif($def == "Обьявления")
							{
								$def = "Sludinājumi";
							}
							elseif($def == "Разработка")
							{
								$def = "Izstrāde";
							}
							elseif($def == "Реклама")
							{
								$def = "Reklāma";
							}
							elseif($def == "Соц сети")
							{
								$def = "Sociālie tīkli";
							}
							elseif($def == "Хостинг")
							{
								$def = "Hostings";
							}
							elseif($def == "Аксессуары")
							{
								$def = "Aksesuāri";
							}
							elseif($def == "Для мамочек")
							{
								$def = "Māmiņām";
							}
							elseif($def == "Для ухода за ребенком")
							{
								$def = "Bērna kopšanai";
							}
							elseif($def == "Для школы")
							{
								$def = "Skolai";
							}
							elseif($def == "Игрушки, игры")
							{
								$def = "Rotaļlietas, spēles";
							}
							elseif($def == "Коляски, сумки, автокресла")
							{
								$def = "Ratiņi, somas, autokrēsli";
							}
							elseif($def == "Лагерь")
							{
								$def = "Nometne";
							}
							elseif($def == "Мебель")
							{
								$def = "Mēbeles";
							}
							elseif($def == "Мероприятия")
							{
								$def = "Pasākumi";
							}
							elseif($def == "Обувь")
							{
								$def = "Apavi";
							}
							elseif($def == "Одежда")
							{
								$def = "Apģērbs";
							}
							elseif($def == "Подарки")
							{
								$def = "Dāvanas";
							}
							elseif($def == "Проведение праздников")
							{
								$def = "Svinību rīkošana, vadīšana";
							}
							elseif($def == "Для домашнего хозяйства")
							{
								$def = "Mājsaimniecībai";
							}
							elseif($def == "Инструменты, оборудование")
							{
								$def = "Instrumenti, aprīkojums";
							}
							elseif($def == "Канцелярия")
							{
								$def = "Kancelejas preces";
							}
							elseif($def == "Мебель для дома")
							{
								$def = "Mēbeles mājai";
							}
							elseif($def == "Мебель для офиса")
							{
								$def = "Mēbeles ofisam";
							}
							elseif($def == "Мебель для сада")
							{
								$def = "Mēbeles dārzam";
							}
							elseif($def == "Одежда и обувь для сада")
							{
								$def = "Apģērbs un apavi dārzam";
							}
							elseif($def == "Осветительное оборудование")
							{
								$def = "Apgaismojums";
							}
							elseif($def == "Печати, штампы, пломбы")
							{
								$def = "Zīmogi, spiedogi, plombes";
							}
							elseif($def == "Посуда и принадлежности")
							{
								$def = "Trauki un piederumi";
							}
							elseif($def == "Растения, цветы, саженцы")
							{
								$def = "Augi, ziedi, krūmāji";
							}
							elseif($def == "Сантехника, отопительное оборудование")
							{
								$def = "Santehnika, apkures sistēmas";
							}
							elseif($def == "Топливо, дрова")
							{
								$def = "Degviela, kurināmais";
							}
							elseif($def == "Аудио сопровождение")
							{
								$def = "Audio pavadījums";
							}
							elseif($def == "Парихмахер")
							{
								$def = "Frizieris";
							}
							elseif($def == "Пиротехника")
							{
								$def = "Pirotehnika";
							}
							elseif($def == "Помещение")
							{
								$def = "Telpas";
							}
							elseif($def == "Салон")
							{
								$def = "Salons";
							}
							elseif($def == "Стилист")
							{
								$def = "Stilists";
							}
							elseif($def == "Тамода")
							{
								$def = "Vakara vadītājs";
							}
							elseif($def == "Транспорт")
							{
								$def = "Transports";
							}
							elseif($def == "Украшение помещений")
							{
								$def = "Telpu noformējums";
							}
							elseif($def == "Фокусник")
							{
								$def = "Jokdaris, viesu izklaidētājs";
							}
							elseif($def == "Фото, Видео услуги")
							{
								$def = "Foto, video pakalpojumi";
							}
							elseif($def == "Цветы")
							{
								$def = "Ziedi";
							}
							elseif($def == "Детективное агенство")
							{
								$def = "Detektīvu aģentūra";
							}
							elseif($def == "Переводы")
							{
								$def = "Tulkojumi";
							}
							elseif($def == "Хим чистка")
							{
								$def = "Ķīmiskā tīrīšana";
							}
							elseif($def == "Ветеринар")
							{
								$def = "Veterinārārsts";
							}
							elseif($def == "Домашние животные, птицы, pыбы")
							{
								$def = "Mājdzīvnieki, putni, zivis";
							}
							elseif($def == "Товары для животных")
							{
								$def = "Preces dzīvniekiem";
							}
							elseif($def == "Экзотические животные")
							{
								$def = "Eksotiskie dzīvnieki";
							}
							elseif($def == "Интернет")
							{
								$def = "Internets";
							}
							elseif($def == "Радио")
							{
								$def = "Radio";
							}
							elseif($def == "Реклама")
							{
								$def = "Reklāma";
							}
							elseif($def == "Связь")
							{
								$def = "Sakari";
							}
							elseif($def == "Телевидение")
							{
								$def = "Televīzija";
							}
							elseif($def == "Автозапчасти")
							{
								$def = "Auto rezerves daļas";
							}
							elseif($def == "Для дома")
							{
								$def = "Mājai";
							}
							elseif($def == "Для офиса")
							{
								$def = "Ofisam";
							}
							elseif($def == "Канцелярия")
							{
								$def = "Kancelejas preces";
							}
							elseif($def == "Книги, журналы, музыка")
							{
								$def = "Grāmatas, žurnāli, mūzika";
							}
							elseif($def == "Компьютерные и видеоигры")
							{
								$def = "Kompjūterspēles un videospēles";
							}
							elseif($def == "Косметика")
							{
								$def = "Kosmētika";
							}
							elseif($def == "Медикaменты")
							{
								$def = "Medikamenti";
							}
							elseif($def == "Парфюмерия")
							{
								$def = "Parfimērija";
							}
							elseif($def == "Стройматериалы")
							{
								$def = "Būvmateriāli";
							}
							elseif($def == "Цветы")
							{
								$def = "Ziedi";
							}
							elseif($def == "Электроника и техника")
							{
								$def = "Elektronika un tehnika";
							}
							elseif($def == "Лечение")
							{
								$def = "Ārstniecība";
							}
							elseif($def == "Массажист")
							{
								$def = "Masieris";
							}
							elseif($def == "Оборудование, приборы")
							{
								$def = "Aprīkojums, piederumi";
							}
							elseif($def == "Салон красоты")
							{
								$def = "Skaistumkopšanas saloni";
							}
							elseif($def == "Солярий")
							{
								$def = "Solārijs";
							}
							elseif($def == "СПА салон")
							{
								$def = "SPA salons";
							}
							elseif($def == "Гаражи, стоянки")
							{
								$def = "Garāžas, stāvvietas";
							}
							elseif($def == "Дома, дачи")
							{
								$def = "Mājas, vasarnīcas";
							}
							elseif($def == "Земля, лес")
							{
								$def = "Zeme, mežs";
							}
							elseif($def == "Квартиры")
							{
								$def = "Dzīvokļi";
							}
							elseif($def == "Офисы, помещения")
							{
								$def = "Ofisi, telpas";
							}
							elseif($def == "Автошколы")
							{
								$def = "Autoskolas";
							}
							elseif($def == "Книги")
							{
								$def = "Grāmatas";
							}
							elseif($def == "Курсы")
							{
								$def = "Kursi";
							}
							elseif($def == "Учебые заведния")
							{
								$def = "Mācību iestādes";
							}
							elseif($def == "Для работы")
							{
								$def = "Darbam";
							}
							elseif($def == "Женская")
							{
								$def = "Sieviešu";
							}
							elseif($def == "Мужская")
							{
								$def = "Vīriešu";
							}
							elseif($def == "Купальные костюмы")
							{
								$def = "Peldkostīmi";
							}
							elseif($def == "Нижнее белье")
							{
								$def = "Apakšveļa";
							}
							elseif($def == "Атракционы")
							{
								$def = "Atrakcijas";
							}
							elseif($def == "Баня")
							{
								$def = "Pirtis";
							}
							elseif($def == "Бассеин")
							{
								$def = "Baseini";
							}
							elseif($def == "Компьютерные и видеоигры")
							{
								$def = "Kompjūterspēles un videospēles";
							}
							elseif($def == "Концерты")
							{
								$def = "Koncerti";
							}
							elseif($def == "Ночные клубы")
							{
								$def = "Nakts klubi";
							}
							elseif($def == "Охота, рыбалка")
							{
								$def = "Medības, zveja";
							}
							elseif($def == "Проведение торжеств")
							{
								$def = "Svinību rīkošana, vadīšana";
							}
							elseif($def == "Украшение помещений")
							{
								$def = "Telpu noformējums";
							}
							elseif($def == "Цирк")
							{
								$def = "Cirks";
							}
							elseif($def == "Театры")
							{
								$def = "Teātris";
							}
							elseif($def == "Полиграфия и печать")
							{
								$def = "Poligrāfija un druka";
							}
							elseif($def == "Напитки")
							{
								$def = "Dzērieni";
							}
							elseif($def == "Овощи")
							{
								$def = "Dārzeņi";
							}
							elseif($def == "Продукты")
							{
								$def = "Produkti";
							}
							elseif($def == "Фрукты")
							{
								$def = "Augļi";
							}
							elseif($def == "Бар")
							{
								$def = "Bārs";
							}
							elseif($def == "Кафе")
							{
								$def = "Kafejnīca";
							}
							elseif($def == "Ресторан")
							{
								$def = "Restorāns";
							}
							elseif($def == "Инвентарь")
							{
								$def = "Inventārs";
							}
							elseif($def == "Клубы")
							{
								$def = "Klubi";
							}
							elseif($def == "Авто")
							{
								$def = "Auto";
							}
							elseif($def == "Здоровье")
							{
								$def = "Veselība";
							}
							elseif($def == "Недвижимость")
							{
								$def = "Nekustamais īpašums";
							}
							elseif($def == "Туризм")
							{
								$def = "Tūrisms";
							}
							elseif($def == "Ворота, жалюзи, двери, окна")
							{
								$def = "Vārti, žalūzijas, durvis, logi";
							}
							elseif($def == "Инструменты и техника")
							{
								$def = "Instrumenti un tehnika";
							}
							elseif($def == "Проекты, дизайн")
							{
								$def = "Projekti, dizains";
							}
							elseif($def == "Сторительные работы")
							{
								$def = "Būvniecības darbi";
							}
							elseif($def == "Автосалон")
							{
								$def = "Autosalons";
							}
							elseif($def == "Автосервис")
							{
								$def = "Autoserviss";
							}
							elseif($def == "Аренда")
							{
								$def = "Īre";
							}
							elseif($def == "Вело-транспорт")
							{
								$def = "Velotransports";
							}
							elseif($def == "Водный транспорт")
							{
								$def = "Ūdens transports";
							}
							elseif($def == "Грузовые авто и автобусы")
							{
								$def = "Kravas auto un autobusi";
							}
							elseif($def == "Запчасти")
							{
								$def = "Rezerves daļas";
							}
							elseif($def == "Легковые авто")
							{
								$def = "Vieglie auto";

							}
							elseif($def == "Мото-транспорт")
							{
								$def = "Mototransports";
							}
							elseif($def == "Перевозки, погрузка")
							{
								$def = "Pārvedumi, krāvēji";
							}
							elseif($def == "Сельхозтехника")
							{
								$def = "Lauksaimniecības tehnika";
							}
							elseif($def == "Экипировка")
							{
								$def = "EKipējums";
							}
							elseif($def == "Авиобилеты")
							{
								$def = "Aviobiļetes";
							}
							elseif($def == "Городские туры")
							{
								$def = "Pilsētas ekskursijas";
							}
							elseif($def == "Дом для гостей")
							{
								$def = "Viesu nams";
							}
							elseif($def == "Кемпинг")
							{
								$def = "Kempings";
							}
							elseif($def == "Отель")
							{
								$def = "Viesnīca";
							}
							elseif($def == "Туристическое агенство")
							{
								$def = "Tūrisma aģentūra";
							}
							elseif($def == "Банковские услуги")
							{
								$def = "Banku pakalpojumi";
							}
							elseif($def == "Бухгалтерские услуги")
							{
								$def = "Grāmatvedības pakalpojumi";
							}
							elseif($def == "Лизинг, Кредит")
							{
								$def = "Līzings, kredīti";
							}
							elseif($def == "Юридические услуги")
							{
								$def = "Juridiskie pakalpojumi";
							}
							elseif($def == "Экспертизы и оценка")
							{
								$def = "Ekspertīzes un novērtējums";
							}
							elseif($def == "TV, видео, DVD")
							{
								$def = "TV, video, DVD";
							}
							elseif($def == "Аудио техника")
							{
								$def = "Audio tehnika";
							}
							elseif($def == "Бытовая техника")
							{
								$def = "Virtuves tehnika";
							}
							elseif($def == "Компьютеры")
							{
								$def = "Datori";
							}
							elseif($def == "Мобильные телефоны")
							{
								$def = "Mobilie tālruņi";
							}
							elseif($def == "Фото и оптика")
							{
								$def = "Foto un optika";
							}
							
							$result_insert_lat = mysql_query("INSERT INTO ltd_page_lat
							(login,pvn,sh_name,meta_k,title,descr,web,phone,phone_2,fax,address,
							 city,post,descr_offer,from_date_offer,till_date_offer,b_def,defcat,activation) 
							VALUES 
							('$login','$pvn','$sh_name','$keywords','$sh_name','$descr_sh','$web_sh','$phone_sh','$phone_sh_2',
							 '$fax_sh','$address_sh','$city_sh','$post_sh','$descr_offer','$date_from',
							 '$date_till','$b_def','$def','0')");
							
							$result_insert_cat_lat = mysql_query("INSERT INTO catalogue_lat 
													(login,ltd_name,city,b_def,definition,activation) 
													VALUES 
													('$login','$sh_name','$city_sh','$b_def','$def','0')");
						}
						else
						{
							$content1 = $descr_sh." ".$descr_offer;
							$content = mb_convert_encoding($content1, "iso-8859-4", "utf8");
							$word_counter = new Counter_lat();
							
							if (strlen($content)>50000)
							{
								$keywords = $word_counter->get_keywords(substr($content, 0, 50000));
							}
							else
							{
								$keywords = $word_counter->get_keywords($content);
							}
							
							$keywords = $city_sh.", ".$b_def.", ".$def.", ".$sh_name.", ".$keywords;
							
							$result_insert_lat = mysql_query("INSERT INTO ltd_page_lat
							(login,pvn,sh_name,meta_k,title,descr,web,phone,phone_2,fax,address,
							 city,post,descr_offer,from_date_offer,till_date_offer,b_def,defcat,activation) 
							VALUES 
							('$login','$pvn','$sh_name','$keywords','$sh_name','$descr_sh','$web_sh','$phone_sh','$phone_sh_2',
							 '$fax_sh','$address_sh','$city_sh','$post_sh','$descr_offer','$date_from',
							 '$date_till','$b_def','$def','0')");
							
							$result_insert_cat_lat = mysql_query("INSERT INTO catalogue_lat 
													(login,ltd_name,city,b_def,definition,activation) 
													VALUES 
													('$login','$sh_name','$city_sh','$b_def','$def','0')");
							
							if($city_sh == "Rīga")
							{
								$city_sh = "Рига";
							}
							elseif($city_sh == "Jūrmala")
							{
								$city_sh = "Юрмала";
							}
							elseif($city_sh == "Rīgas rajons")
							{
								$city_sh = "Рижский р-он";
							}
							elseif($city_sh == "Aizkraukle un raj")
							{
								$city_sh = "Айзкраукле и р-он";
							}
							elseif($city_sh == "Alūksne un raj")
							{
								$city_sh = "Алуксне и р-он";
							}
							elseif($city_sh == "Balvi un raj")
							{
								$city_sh = "Балви и р-он";
							}
							elseif($city_sh == "Bauska un raj")
							{
								$city_sh = "Бауска и р-он";
							}
							elseif($city_sh == "Valka un raj")
							{
								$city_sh = "Валка и р-он";
							}
							elseif($city_sh == "Valmiera un raj")
							{
								$city_sh = "Валмиера и р-он";
							}
							elseif($city_sh == "Ventspils un raj")
							{
								$city_sh = "Вентспилс и р-он";
							}
							elseif($city_sh == "Gulbene un raj")
							{
								$city_sh = "Гулбене и р-он";
							}
							elseif($city_sh == "Daugavpils un raj")
							{
								$city_sh = "Даугавпилс и р-он";
							}
							elseif($city_sh == "Dobele un raj")
							{
								$city_sh = "Добеле и р-он";
							}
							elseif($city_sh == "Jēkabpils un raj")
							{
								$city_sh = "Екабпилс и р-он";
							}
							elseif($city_sh == "Jelgava un raj")
							{
								$city_sh = "Елгава и р-он";
							}
							elseif($city_sh == "Krāslava un raj")
							{
								$city_sh = "Краславa и р-он";
							}
							elseif($city_sh == "Kuldīga un raj")
							{
								$city_sh = "Кулдыга и р-он";
							}
							elseif($city_sh == "Liepāja un raj")
							{
								$city_sh = "Лиепая и р-он";
							}
							elseif($city_sh == "Limbaži un raj")
							{
								$city_sh = "Лимбажи и р-он";
							}
							elseif($city_sh == "Ludza un raj")
							{
								$city_sh = "Лудза и р-он";
							}
							elseif($city_sh == "Madona un raj")
							{
								$city_sh = "Мадона и р-он";
							}
							elseif($city_sh == "Ogre un raj")
							{
								$city_sh = "Огре и р-он";
							}
							elseif($city_sh == "Preiļi un raj")
							{
								$city_sh = "Преили и р-он";
							}
							elseif($city_sh == "Rēzekne un raj")
							{
								$city_sh = "Резекне и р-он";
							}
							elseif($city_sh == "Saldus un raj")
							{
								$city_sh = "Салдус и р-он";
							}
							elseif($city_sh == "Talsi un raj")
							{
								$city_sh = "Талси и р-он";
							}
							elseif($city_sh == "Tukums un raj")
							{
								$city_sh = "Тукумс и р-он";
							}
							elseif($city_sh == "Cēsis un raj")
							{
								$city_sh = "Цесис и р-он";
							}
							
			////////////////1.lat - 2.rus				
								if($b_def == "Aksesuāri")
								{
									$b_def = "Аксессуары";
								}
								elseif($b_def == "Web")
								{
									$b_def = "Веб";
								}
								elseif($b_def == "Bērniem")
								{
									$b_def = "Для детей";
								}
								elseif($b_def == "Ofisam, mājai un dārzam")
								{
									$b_def = "Для офиса, дома и сада";
								}
								elseif($b_def == "Kāzām")
								{
									$b_def = "Для свадьбы";
								}
								elseif($b_def == "Citi")
								{
									$b_def = "Другое";
								}
								elseif($b_def == "Dzīvnieki, putni un zivis")
								{
									$b_def = "Животные, птицы и pыбы";
								}
								elseif($b_def == "Internets, radio, televīzija, sakari")
								{
									$b_def = "Интернет, радио, телевидение, связь";
								}
								elseif($b_def == "Internetveikali")
								{
									$b_def = "Интернет магазин";
								}
								elseif($b_def == "Skaistums un veselība")
								{
									$b_def = "Красота и здоровье";
								}
								elseif($b_def == "Nekustamais īpašums")
								{
									$b_def = "Недвижимость";
								}
								elseif($b_def == "Izglītība")
								{
									$b_def = "Образовaние";
								}
								elseif($b_def == "Apavi")
								{
									$b_def = "Обувь";
								}
								elseif($b_def == "Apģērbs")
								{
									$b_def = "Одежда";
								}
								elseif($b_def == "Atpūta un izklaide")
								{
									$b_def = "Отдых и развлечения";
								}
								elseif($b_def == "Poligrāfija un druka")
								{
									$b_def = "Полиграфия и печать";
								}
								elseif($b_def == "Pārtikas produkti")
								{
									$b_def = "Продукты питания";
								}
								elseif($b_def == "Restorāni un bāri")
								{
									$b_def = "Рестораны и бары";
								}
								elseif($b_def == "Sports")
								{
									$b_def = "Спорт";
								}
								elseif($b_def == "Apdrošināšana")
								{
									$b_def = "Страхование";
								}
								elseif($b_def == "Būvniecība un remonts")
								{
									$b_def = "Строительство и ремонт";
								}
								elseif($b_def == "Transports")
								{
									$b_def = "Транспорт";
								}
								elseif($b_def == "Tūrisms")
								{
									$b_def = "Туризм";
								}
								elseif($b_def == "Finansu pakalpojumi")
								{
									$b_def = "Финансовые услуги";
								}
								elseif($b_def == "Elektronika un tehnika")
								{
									$b_def = "Электроника и техника";
								}
								
								if($def == "Bižutērija")
								{
									$def = "Бижутерия";
								}
								elseif($def == "Pulksteņi")
								{
									$def = "Часы";
								}
								elseif($def == "Juvelierizstrādājumi")
								{
									$def = "Ювелирные изделия";
								}
								elseif($def == "Pakalpojumi")
								{
									$def = "Услуги";
								}
								elseif($def == "Citi")
								{
									$def = "Другое";
								}
								elseif($def == "Dizains")
								{
									$def = "Дизайн";
								}
								elseif($def == "Katalogi")
								{
									$def = "Каталоги";
								}
								elseif($def == "Sludinājumi")
								{
									$def = "Обьявления";
								}
								elseif($def == "Izstrāde")
								{
									$def = "Разработка";
								}
								elseif($def == "Reklāma")
								{
									$def = "Реклама";
								}
								elseif($def == "Sociālie tīkli")
								{
									$def = "Соц сети";
								}
								elseif($def == "Hostings")
								{
									$def = "Хостинг";
								}
								elseif($def == "Aksesuāri")
								{
									$def = "Аксессуары";
								}
								elseif($def == "Māmiņām")
								{
									$def = "Для мамочек";
								}
								elseif($def == "Bērna kopšanai")
								{
									$def = "Для ухода за ребенком";
								}
								elseif($def == "Skolai")
								{
									$def = "Для школы";
								}
								elseif($def == "Rotaļlietas, spēles")
								{
									$def = "Игрушки, игры";
								}
								elseif($def == "Ratiņi, somas, autokrēsli")
								{
									$def = "Коляски, сумки, автокресла";
								}
								elseif($def == "Nometne")
								{
									$def = "Лагерь";
								}
								elseif($def == "Mēbeles")
								{
									$def = "Мебель";
								}
								elseif($def == "Pasākumi")
								{
									$def = "Мероприятия";
								}
								elseif($def == "Apavi")
								{
									$def = "Обувь";
								}
								elseif($def == "Apģērbs")
								{
									$def = "Одежда";
								}
								elseif($def == "Dāvanas")
								{
									$def = "Подарки";
								}
								elseif($def == "Svinību rīkošana, vadīšana")
								{
									$def = "Проведение праздников";
								}
								elseif($def == "Mājsaimniecībai")
								{
									$def = "Для домашнего хозяйства";
								}
								elseif($def == "Instrumenti, aprīkojums")
								{
									$def = "Инструменты, оборудование";
								}
								elseif($def == "Kancelejas preces")
								{
									$def = "Канцелярия";
								}
								elseif($def == "Mēbeles mājai")
								{
									$def = "Мебель для дома";
								}
								elseif($def == "Mēbeles ofisam")
								{
									$def = "Мебель для офиса";
								}
								elseif($def == "Mēbeles dārzam")
								{
									$def = "Мебель для сада";
								}
								elseif($def == "Apģērbs un apavi dārzam")
								{
									$def = "Одежда и обувь для сада";
								}
								elseif($def == "Apgaismojums")
								{
									$def = "Осветительное оборудование";
								}
								elseif($def == "Zīmogi, spiedogi, plombes")
								{
									$def = "Печати, штампы, пломбы";
								}
								elseif($def == "Trauki un piederumi")
								{
									$def = "Посуда и принадлежности";
								}
								elseif($def == "Augi, ziedi, krūmāji")
								{
									$def = "Растения, цветы, саженцы";
								}
								elseif($def == "Santehnika, Apkures sistēmas")
								{
									$def = "Сантехника, отопительное оборудование";
								}
								elseif($def == "Degviela, kurināmais")
								{
									$def = "Топливо, дрова";
								}
								elseif($def == "Audio pavadījums")
								{
									$def = "Аудио сопровождение";
								}
								elseif($def == "Frizieris")
								{
									$def = "Парихмахер";
								}
								elseif($def == "Pirotehnika")
								{
									$def = "Пиротехника";
								}
								elseif($def == "Telpas")
								{
									$def = "Помещение";
								}
								elseif($def == "Salons")
								{
									$def = "Салон";
								}
								elseif($def == "Stilists")
								{
									$def = "Стилист";
								}
								elseif($def == "Vakara vadītājs")
								{
									$def = "Тамода";
								}
	
								elseif($def == "Transports")
								{
									$def = "Транспорт";
								}
								elseif($def == "Telpu noformējums")
								{
									$def = "Украшение помещений";
								}
								elseif($def == "Jokdaris, viesu izklaidētājs")
								{
									$def = "Фокусник";
								}
								elseif($def == "Foto, video pakalpojumi")
								{
									$def = "Фото, Видео услуги";
								}
								elseif($def == "Ziedi")
								{
									$def = "Цветы";
								}
								elseif($def == "Detektīvu aģentūra")
								{
									$def = "Детективное агенство";
								}
								elseif($def == "Tulkojumi")
								{
									$def = "Переводы";
								}
								elseif($def == "Ķīmiskā tīrīšana")
								{
									$def = "Хим чистка";
								}
								elseif($def == "Veterinārārsts")
								{
									$def = "Ветеринар";
								}
								elseif($def == "Mājdzīvnieki, putni, zivis")
								{
									$def = "Домашние животные, птицы, pыбы";
								}
								elseif($def == "Preces dzīvniekiem")
								{
									$def = "Товары для животных";
								}
								elseif($def == "Eksotiskie dzīvnieki")
								{
									$def = "Экзотические животные";
								}
								elseif($def == "Internets")
								{
									$def = "Интернет";
								}
								elseif($def == "Radio")
								{
									$def = "Радио";
								}
								elseif($def == "Reklāma")
								{
									$def = "Реклама";
								}
								elseif($def == "Sakari")
								{
									$def = "Связь";
								}
								elseif($def == "Televīzija")
								{
									$def = "Телевидение";
								}
								elseif($def == "Auto rezerves daļas")
								{
									$def = "Автозапчасти";
								}
								elseif($def == "Mājai")
								{
									$def = "Для дома";
								}
								elseif($def == "Ofisam")
								{
									$def = "Для офиса";
								}
								elseif($def == "Kancelejas preces")
								{
									$def = "Канцелярия";
								}
								elseif($def == "Grāmatas, žurnāli, mūzika")
								{
									$def = "Книги, журналы, музыка";
								}
								elseif($def == "Kompjūterspēles un videospēles")
								{
									$def = "Компьютерные и видеоигры";
								}
								elseif($def == "Kosmētika")
								{
									$def = "Косметика";
								}
								elseif($def == "Medikamenti")
								{
									$def = "Медикaменты";
								}
								elseif($def == "Parfimērija")
								{
									$def = "Парфюмерия";
								}
								elseif($def == "Būvmateriāli")
								{
									$def = "Стройматериалы";
								}
								elseif($def == "Ziedi")
								{
									$def = "Цветы";
								}
								elseif($def == "Elektronika un tehnika")
								{
									$def = "Электроника и техника";
								}
								elseif($def == "Ārstniecība")
								{
									$def = "Лечение";
								}
								elseif($def == "Masieris")
								{
									$def = "Массажист";
								}
								elseif($def == "Aprīkojums, piederumi")
								{
									$def = "Оборудование, приборы";
								}
								elseif($def == "Skaistumkopšanas saloni")
								{
									$def = "Салон красоты";
								}
								elseif($def == "Solārijs")
								{
									$def = "Солярий";
								}
								elseif($def == "SPA salons")
								{
									$def = "СПА салон";
								}
								elseif($def == "Garāžas, stāvvietas")
								{
									$def = "Гаражи, стоянки";
								}
								elseif($def == "Mājas, vasarnīcas")
								{
									$def = "Дома, дачи";
								}
								elseif($def == "Zeme, mežs")
								{
									$def = "Земля, лес";
								}
								elseif($def == "Dzīvokļi")
								{
									$def = "Квартиры";
								}
								elseif($def == "Ofisi, telpas")
								{
									$def = "Офисы, помещения";
								}
								elseif($def == "Autoskolas")
								{
									$def = "Автошколы";
								}
								elseif($def == "Grāmatas")
								{
									$def = "Книги";
								}
								elseif($def == "Kursi")
								{
									$def = "Курсы";
								}
								elseif($def == "Mācību iestādes")
								{
									$def = "Учебые заведния";
								}
								elseif($def == "Darbam")
								{
									$def = "Для работы";
								}
								elseif($def == "Sieviešu")
								{
									$def = "Женская";
								}
								elseif($def == "Vīriešu")
								{
									$def = "Мужская";
								}
								elseif($def == "Peldkostīmi")
								{
									$def = "Купальные костюмы";
								}
								elseif($def == "Apakšveļa")
								{
									$def = "Нижнее белье";
								}
								elseif($def == "Atrakcijas")
								{
									$def = "Атракционы";
								}
								elseif($def == "Pirtis")
								{
									$def = "Баня";
								}
								elseif($def == "Baseini")
								{
									$def = "Бассеин";
								}
								elseif($def == "Kompjūterspēles un videospēles")
								{
									$def = "Компьютерные и видеоигры";
								}
								elseif($def == "Koncerti")
								{
									$def = "Концерты";
								}
	
								elseif($def == "Nakts klubi")
								{
									$def = "Ночные клубы";
								}
								elseif($def == "Medības, zveja")

								{
									$def = "Охота, рыбалка";
								}
								elseif($def == "Svinību rīkošana, vadīšana")
								{
									$def = "Проведение торжеств";
								}
								elseif($def == "Telpu noformēšana")
								{
									$def = "Украшение помещений";
								}
								elseif($def == "Cirks")
								{
									$def = "Цирк";
								}
								elseif($def == "Teātris")
								{
									$def = "Театры";
								}
								elseif($def == "Poligrāfija un druka")
								{
									$def = "Полиграфия и печать";
								}
								elseif($def == "Dzērieni")
								{
									$def = "Напитки";
								}
								elseif($def == "Dārzeņi")
								{
									$def = "Овощи";
								}
								elseif($def == "Produkti")
								{
									$def = "Продукты";
								}
								elseif($def == "Augļi")
								{
									$def = "Фрукты";
								}
								elseif($def == "Bārs")
								{
									$def = "Бар";
								}
								elseif($def == "Kafejnīca")
								{
									$def = "Кафе";
								}
								elseif($def == "Restorāns")
								{
									$def = "Ресторан";
								}
								elseif($def == "Inventārs")
								{
									$def = "Инвентарь";
								}
								elseif($def == "Klubi")
								{
									$def = "Клубы";
								}
								elseif($def == "Auto")
								{
									$def = "Авто";
								}
								elseif($def == "Veselība")
								{
									$def = "Здоровье";
								}
								elseif($def == "Nekustamais īpašums")
								{
									$def = "Недвижимость";
								}
								elseif($def == "Tūrisms")
								{
									$def = "Туризм";
								}
								elseif($def == "Vārti, žalūzijas, durvis, logi")
								{
									$def = "Ворота, жалюзи, двери, окна";
								}
								elseif($def == "Instrumenti un tehnika")
								{
									$def = "Инструменты и техника";
								}
								elseif($def == "Projekti, dizains")
								{
									$def = "Проекты, дизайн";
								}
								elseif($def == "Būvniecības darbi")
								{
									$def = "Сторительные работы";
								}
								elseif($def == "Autosaloni")
								{
									$def = "Автосалон";
								}
								elseif($def == "Autoserviss")
								{
									$def = "Автосервис";
								}
								elseif($def == "Īre")
								{
									$def = "Аренда";
								}
								elseif($def == "Velotransports")
								{
									$def = "Вело-транспорт";
								}
								elseif($def == "Ūdens transports")
								{
									$def = "Водный транспорт";
								}
								elseif($def == "Kravas auto un autobusi")
								{
									$def = "Грузовые авто и автобусы";
								}
								elseif($def == "Rezerves daļas")
								{
									$def = "Запчасти";
								}
								elseif($def == "Vieglie auto")
								{
									$def = "Легковые авто";
								}
								elseif($def == "Mototransports")
								{
									$def = "Мото-транспорт";
								}
								elseif($def == "Pārvadājumi, krāvēji")
								{
									$def = "Перевозки, погрузка";
								}
								elseif($def == "Lauksaimniecība")
								{
									$def = "Сельхозтехника";
								}
								elseif($def == "Ekipējums")
								{
									$def = "Экипировка";
								}
								elseif($def == "Aviobiļetes")
								{
									$def = "Авиобилеты";
								}
								elseif($def == "Pilsētas ekskursijas")
								{
									$def = "Городские туры";
								}
								elseif($def == "Viesu nams")
								{
									$def = "Дом для гостей";
								}
								elseif($def == "Kempings")
								{
									$def = "Кемпинг";
								}
								elseif($def == "Viesnīca")
								{
									$def = "Отель";
								}
								elseif($def == "Tūrisma aģentūra")
								{
									$def = "Туристическое агенство";
								}
								elseif($def == "Banku pakalpojumi")
								{
									$def = "Банковские услуги";
								}
								elseif($def == "Grāmatvedības pakalpojumi")
								{
									$def = "Бухгалтерские услуги";
								}
								elseif($def == "Līzings, kredīti")
								{
									$def = "Лизинг, Кредит";
								}
								elseif($def == "Juridiskie pakalpojumi")
								{
									$def = "Юридические услуги";
								}
								elseif($def == "Ekspertīzes un novērtējums")
								{
									$def = "Экспертизы и оценка";
								}
								elseif($def == "TV, video, DVD")
								{
									$def = "TV, видео, DVD";
								}
								elseif($def == "Audio tehnika")
								{
									$def = "Аудио техника";
								}
								elseif($def == "Virtuves tehnika")
								{
									$def = "Бытовая техника";
								}
								elseif($def == "Datori")
								{
									$def = "Компьютеры";
								}
								elseif($def == "Mobilie tālruņi")
								{
									$def = "Мобильные телефоны";
								}
								elseif($def == "Foto un optika")
								{
									$def = "Фото и оптика";
								}
							
							$result_insert_rus = mysql_query("INSERT INTO ltd_page_rus
							(login,pvn,sh_name,meta_k,title,descr,web,phone,phone_2,fax,address,
							 city,post,descr_offer,from_date_offer,till_date_offer,b_def,defcat,activation) 
							VALUES 
							('$login','$pvn','$sh_name','$keywords','$sh_name','$descr_sh','$web_sh','$phone_sh','$phone_sh_2',
							 '$fax_sh','$address_sh','$city_sh','$post_sh','$descr_offer','$date_from',
							 '$date_till','$b_def','$def','0')");
							
							$result_insert_cat_rus = mysql_query("INSERT INTO catalogue_rus 
													(login,ltd_name,city,b_def,definition,activation) 
													VALUES 
													('$login','$sh_name','$city_sh','$b_def','$def','0')");
							
						}
						
						if(!$result_insert_rus || !$result_insert_lat)
						{
							message_succes($lang,"<p align='center' class='join_us_error'>".$reg_user_db_err."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
						}
						else
						{
							$address = "admin@econom.lv";
							$sub = "Joining Form";
							$ip = ($_SERVER['HTTP_X_FORWARDED_FOR'] == "" ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']);
							$smes = "SIA PVN number: ".$pvn."\n
							
							SIA name: ".$sh_name."\n 
							
							SIA describe: ".$descr_sh." \n 
							
							SIA phone: ".$phone_sh."\n
							
							SIA phone no. 2: ".$phone_sh_2."\n
							
							SIA fax: ".$fax_sh."\n
							
							SIA address: ".$address_sh."\n 
							
							SIA website: ".$web_sh."\n 
							
							SIA city: ".$city_sh."\n
							
							For catalogue: ".$b_def."\n
							
							For under catalogue: ".$def."\n
							
							SIA post: ".$post_sh."\n
							
							Offer or Discount: ".$descr_offer."\n
							
							Offer dates from ".$date_from." till ".$date_till."\n
							
							Information presented by: ".$login."\n
							
							Senders IP: ".$ip."";
							
							$headers = 'Content-type:text/plain; charset=UTF-8';
							mail ($address,$sub,$smes,"Content-type:text/plain; charset=UTF-8\r\n");
							
							if($photo == 'photo_yes')
							{
								ltd_create_succes_photo($lang,$ltd_create_upload_message,$sh_name);
							}
							else
							{	
								message_succes($lang,"<p>".$ltd_create_succes_message."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
							}
						}
					}
				}
				?>
				<table align="center" border="0" cellpadding="2" cellspacing="0">
				<form action="ltd_create.php?lang=<?php echo $lang; ?>" method="post">
				<tr>
				<td colspan="3"><input type="hidden" name="hidden" size="3" maxlength="3"></td>
				</tr>
                <tr>
                <td colspan="3" align="left"><p class="stats"><?php echo $ltd_create_mand; ?></p></td>
                </tr>
                <tr>
                <td><p><?php echo $ltd_create_pvn; ?> <strong style="color:#F00">*</strong></p></td>
                <td align="right"></td>
                <td><input type="text" name="pvn" size="20" maxlength="16" /></td>
                </tr>
				<tr>
				<td><p><?php echo $ltd_create_name; ?> <strong style="color:#F00">*</strong></p></td>
                <td width="50px" align="right"></td>
				<td><input type="text" name="sh_name" size="20" maxlength="50" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr; ?></p></td>
                <td align="right"></td>
				<td><textarea name="descr_sh" cols="40" rows="10"></textarea></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_web; ?></p></td>
                <td align="right"><p>www.</p></td>
				<td><input type="text" name="web_sh" size="20" maxlength="40" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_phone; ?></p></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="phone_sh" size="8" maxlength="8" /></td>
                </tr>
                <tr>
                <td></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="phone_sh_2" size="8" maxlength="8" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_fax; ?></p></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="fax_sh" size="8" maxlength="8" /></td>
				</tr>	
				<tr>
				<td><p><?php echo $ltd_create_addres; ?></p></td>
                <td align="right"></td>
				<td><input type="text" name="address_sh" size="20" maxlength="60" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_city; ?></p></td>
                <td align="right"></td>
				<td><select name="city"><?php if($lang == 'rus')
				{
					?>
					<option value="Рига">Рига</option>
						<option value="Юрмала">Юрмала</option>
						<option value="Рижский р-он">Рижский р-он</option>
						<option value="Айзкраукле и р-он">Айзкраукле и р-он</option>
						<option value="Алуксне и р-он">Алуксне и р-он</option>
						<option value="Балви и р-он">Балви и р-он</option>
						<option value="Бауска и р-он">Бауска и р-он</option>
						<option value="Валка и р-он">Валка и р-он</option>
						<option value="Валмиера и р-он">Валмиера и р-он</option>
						<option value="Вентспилс и р-он">Вентспилс и р-он</option>
						<option value="Гулбене и р-он">Гулбене и р-он</option>
						<option value="Даугавпилс и р-он">Даугавпилс и р-он</option>
						<option value="Добеле и р-он">Добеле и р-он</option>
						<option value="Екабпилс и р-он">Екабпилс и р-он</option>
						<option value="Елгава и р-он">Елгава и р-он</option>
						<option value="Краславa и р-он">Краславa и р-он</option>
						<option value="Кулдыга и р-он">Кулдыга и р-он</option>
						<option value="Лиепая и р-он">Лиепая и р-он</option>
						<option value="Лимбажи и р-он">Лимбажи и р-он</option>
						<option value="Лудза и р-он">Лудза и р-он</option>
						<option value="Мадона и р-он">Мадона и р-он</option>
						<option value="Огре и р-он">Огре и р-он</option>
						<option value="Преили и р-он">Преили и р-он</option>
						<option value="Резекне и р-он">Резекне и р-он</option>
						<option value="Салдус и р-он">Салдус и р-он</option>
						<option value="Талси и р-он">Талси и р-он</option>
						<option value="Тукумс и р-он">Тукумс и р-он</option>
						<option value="Цесис и р-он">Цесис и р-он</option>
                <?php
				}
				else
				{
				?>
					<option value="Rīga">Rīga</option>
						<option value="Jūrmala">Jūrmala</option>
						<option value="Rīgas rajons">Rīgas rajons</option>
						<option value="Aizkraukle un raj">Aizkraukle un raj</option>
						<option value="Alūksne un raj">Alūksne un raj</option>
						<option value="Balvi un raj">Balvi un raj</option>
						<option value="Bauska un raj">Bauska un raj</option>
						<option value="Cēsis un raj">Cēsis un raj</option>
						<option value="Daugavpils un raj">Daugavpils un raj</option>
						<option value="Dobele un raj">Dobele un raj</option>
						<option value="Gulbene un raj">Gulbene un raj</option>
						<option value="Jēkabpils un raj">Jēkabpils un raj</option>
						<option value="Jelgava un raj">Jelgava un raj</option>
						<option value="Krāslava un raj">Krāslava un raj</option>
						<option value="Kuldīga un raj">Kuldīga un raj</option>
						<option value="Liepāja un raj">Liepāja un raj</option>
						<option value="Limbaži un raj">Limbaži un raj</option>
						<option value="Ludza un raj">Ludza un raj</option>
						<option value="Madona un raj">Madona un raj</option>
						<option value="Ogre un raj">Ogre un raj</option>
						<option value="Preiļi un raj">Preiļi un raj</option>
						<option value="Rēzekne un raj">Rēzekne un raj</option>
						<option value="Saldus un raj">Saldus un raj</option>
						<option value="Talsi un raj">Talsi un raj</option>
						<option value="Tukums un raj">Tukums un raj</option>
						<option value="Valka un raj">Valka un raj</option>
						<option value="Valmiera un raj">Valmiera un raj</option>
						<option value="Ventspils un raj">Ventspils un raj</option>
                <?php 
				} ?>
                </select></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_post; ?></p></td>
                <td align="right"><p>LV -</p></td>
				<td><input type="text" name="post_sh" size="4" maxlength="4"></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr_offer; ?> <strong style="color:#F00">*</strong></p></td>
                <td align="right"></td>
				<td><textarea name="descr_offer" cols="40" rows="10"></textarea></td>
				</tr>	
				<tr>
				<td><p><?php echo $ltd_create_dates; ?></p></td>
                <td align="right"><p><?php echo $ltd_create_dates_from; ?>: <strong style="color:#F00">*</strong></p></td>
				<td><input type="text" name="from_date_offer" size="20" maxlength="12" class="date_input" /></td>
                </tr>
                <tr>
                <td></td>
                <td align="right"><p><?php echo $ltd_create_dates_till; ?>: <strong style="color:#F00">*</strong></p></td>
				<td><input type="text" name="till_date_offer" size="20" maxlength="12" class="date_input" /></td>
				</tr>
				<tr>
                <td><input type="hidden" name="def" value="<?php echo $def; ?>" /></td>
                <td><input type="hidden" name="b_def" value="<?php echo $b_def; ?>" /></td>
                <td><input type="hidden" name="photo_choise" value="<?php echo $photo; ?>" /></td>
                </tr>
                <tr>
                <td colspan="3"><input type="hidden" name="lang_choise" value="one_lang" /> </td>
                </tr>
                <tr>
				<td align="center" colspan="3"><p><input name="ltd_create" type="submit" value="<?php echo $ltd_create_opt_but; ?>" /></p></td>
				</tr>
				</form>
				</table>
				<?php
			}
			elseif($_POST['lang_choise'] == 'two_lang')
			{
				if($_POST['ltd_create'])
				{
					if(empty($pvn))
					{
						empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_no_pvn."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
					}
					elseif(empty($sh_name))
					{
						empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_no_shname."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
					}
					elseif(empty($descr_offer))
					{
						empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_no_descr_offer."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
					}
					elseif(empty($date_from) && empty($date_till))
					{
						empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_no_dates."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
					}
					elseif(empty($descr_offer_sec_lang))
					{
						empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_no_descr_offer_sec_lang."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
					}
					elseif(strlen($sh_name)>50 || strlen($sh_name)<2)
					{
						empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_sh_name."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
					}
					elseif((strlen($date_from)<10 || strlen($date_till)<10) && (strlen($date_from)>12 || strlen($date_till)>12))
					{
						empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_dates."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
					}
					else
					{
						if(!empty($web_sh))
						{
							if(strlen($web_sh)<4 || strlen($web_sh)>40)
							{
								empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_web."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
							elseif(!ereg('^([a-zA-Z0-9][a-zA-Z0-9\-]*\.)+[a-zA-Z]+$',$web_sh))
							{
								empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_ereg_web."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
						}
						
						if(!empty($phone_sh))
						{
							if(strlen($phone_sh) !== 8)
							{
								empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
							elseif(!ereg('^[0-9]+$',$phone_sh))
							{
							empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_ereg_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
						}
						
						if(!empty($phone_sh_2))
						{
							if(strlen($phone_sh_2) !== 8)
							{
								empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
							elseif(!ereg('^[0-9]+$',$phone_sh_2))
							{
							empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_ereg_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
						}
						
						if(!empty($fax_sh))
						{
							if(strlen($fax_sh) !== 8)
							{
								empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_fax_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
							elseif(!ereg('^[0-9]+$',$fax_sh))
							{
							empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_ereg_fax_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
						}
						
						if(!empty($address_sh))
						{
							if(strlen($address_sh)<4 || strlen($address_sh)>60)
							{
								empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_address."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
						}
						
						if(!empty($post_sh))
						{
							if(!ereg('^[0-9]+$',$post_sh))
							{
								empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_eregi_post."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
							elseif(strlen($post_sh) !== 4)
							{
								empty_two_lang_form($lang,"<p class='join_us_error'>".$ltd_create_strlen_post."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$b_def,$def,$photo);
							}
						}
			// proverka ltd i pvn v sisteme				
						$result_ltd_check = mysql_query("SELECT pvn,sh_name FROM ltd_page_rus");
						$row_ltd_check = mysql_fetch_array($result_ltd_check);
						if($row_ltd_check['sh_name'] == $sh_name)
						{
							empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_ltd_check."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);	
						}
						elseif($row_ltd_check['pvn'] == $pvn)
						{
							empty_one_lang_form($lang,"<p class='join_us_error'>".$ltd_create_pvn_check."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$b_def,$def,$photo);
						}
			// na4alo zapisi v db
			
						$result_check_mess = mysql_query("SELECT login FROM messages WHERE login = '$login'");
						if(!mysql_num_rows($result_check_mess)>0)
						{
							$from_mess = "admin@econom.lv";
							$date_mess = date("Y-m-d");
							if($lang == 'rus')
							{
								$message_mess = "Благодарим вас за регистрацию вашей фирмы в нашем каталоге. Если у вас появятся любые вопросы или пожелания, вы можете связаться с нами через раздел Контакты. Мы будем рады узнать ваше мнение о работе нашей системы или если вы обнаружите ошибки в работе каталога, системы администрирования, или контексте просим вас сообщить нам об этом. Мы работаем для вас вместе с вами.";
							}
							else
							{
								$message_mess = "Pateicamies par Jūsu firmas reģistrāciju mūsu katalogā. Ja Jums rodas kādi jautājumi vai vēlmes, sazinieties ar mums caur sadaļu Kontakti. Būsim pateicīgi, ja izteiksiet savu viedokli par mūsu sistēmas darbu vai arī, ja esiet pamanījis kļūdu katalogā, sistēmas administrācijā, vai saturā, lūdzam par to ziņot mums. Mēs strādājam Jums kopā ar Jums.";
							}
							
							mysql_query("INSERT INTO messages 
																VALUES  ('','$login','','$from_mess','$date_mess','$message_mess','0')");
						}
						
						if($lang == 'rus')
						{
							$content1 = $descr_sh." ".$descr_offer;
							$content = mb_convert_encoding($content1, "windows-1251", "utf8");
							$word_counter = new Counter_rus();
							
							if (strlen($content)>50000)
							{
								$keywords = $word_counter->get_keywords(substr($content, 0, 50000));
							}
							else
							{
								$keywords = $word_counter->get_keywords($content);
							}
							
							$keywords = $city_sh.", ".$b_def.", ".$def.", ".$sh_name.", ".$keywords;
							
							$result_insert_rus = mysql_query("INSERT INTO ltd_page_rus
							(login,pvn,sh_name,meta_k,title,descr,web,phone,phone_2,fax,address,
							 city,post,descr_offer,from_date_offer,till_date_offer,b_def,defcat,activation) 
							VALUES 
							('$login','$pvn','$sh_name','$keywords','$sh_name','$descr_sh','$web_sh','$phone_sh','$phone_sh_2',
							 '$fax_sh','$address_sh','$city_sh','$post_sh','$descr_offer','$date_from',
							 '$date_till','$b_def','$def','0')");
							
							$result_insert_cat_rus = mysql_query("INSERT INTO catalogue_rus 
													(login,ltd_name,city,b_def,definition,activation) 
													VALUES 
													('$login','$sh_name','$city_sh','$b_def','$def','0')");
							
							if($city_sh == "Рига")
							{
								$city_sh = "Rīga";
							}
							elseif($city_sh == "Юрмала")
							{
								$city_sh = "Jūrmala";
							}
							elseif($city_sh == "Рижский р-он")
							{
								$city_sh = "Rīgas rajons";
							}
							elseif($city_sh == "Айзкраукле и р-он")
							{
								$city_sh = "Aizkraukle un raj";
							}
							elseif($city_sh == "Алуксне и р-он")
							{
								$city_sh = "Alūksne un raj";
							}
							elseif($city_sh == "Балви и р-он")
							{
								$city_sh = "Balvi un raj";
							}
							elseif($city_sh == "Бауска и р-он")
							{
								$city_sh = "Bauska un raj";
							}
							elseif($city_sh == "Валка и р-он")
							{
								$city_sh = "Valka un raj";
							}
							elseif($city_sh == "Валмиера и р-он")
							{
								$city_sh = "Valmiera un raj";
							}
							elseif($city_sh == "Вентспилс и р-он")
							{
								$city_sh = "Ventspils un raj";
							}
							elseif($city_sh == "Гулбене и р-он")
							{
								$city_sh = "Gulbene un raj";
							}
							elseif($city_sh == "Даугавпилс и р-он")
							{
								$city_sh = "Daugavpils un raj";
							}
							elseif($city_sh == "Добеле и р-он")
							{
								$city_sh = "Dobele un raj";
							}
							elseif($city_sh == "Екабпилс и р-он")
							{
								$city_sh = "Jēkabpils un raj";
							}
							elseif($city_sh == "Елгава и р-он")
							{
								$city_sh = "Jelgava un raj";
							}
							elseif($city_sh == "Краславa и р-он")
							{
								$city_sh = "Krāslava un raj";
							}
							elseif($city_sh == "Кулдыга и р-он")
							{
								$city_sh = "Kuldīga un raj";
							}
							elseif($city_sh == "Лиепая и р-он")
							{
								$city_sh = "Liepāja un raj";
							}
							elseif($city_sh == "Лимбажи и р-он")
							{
								$city_sh = "Limbaži un raj";
							}
							elseif($city_sh == "Лудза и р-он")
							{
								$city_sh = "Ludza un raj";
							}
							elseif($city_sh == "Мадона и р-он")
							{
								$city_sh = "Madona un raj";
							}
							elseif($city_sh == "Огре и р-он")
							{
								$city_sh = "Ogre un raj";
							}
							elseif($city_sh == "Преили и р-он")
							{
								$city_sh = "Preiļi un raj";
							}
							elseif($city_sh == "Резекне и р-он")
							{
								$city_sh = "Rēzekne un raj";
							}
							elseif($city_sh == "Салдус и р-он")
							{
								$city_sh = "Saldus un raj";
							}
							elseif($city_sh == "Талси и р-он")
							{
								$city_sh = "Talsi un raj";
							}
							elseif($city_sh == "Тукумс и р-он")
							{
								$city_sh = "Tukums un raj";
							}
							elseif($city_sh == "Цесис и р-он")
							{
								$city_sh = "Cēsis un raj";
							}
							
			////////////////1.rus - 2.lat				
							if($b_def == "Аксессуары")
							{
								$b_def = "Aksesuāri";
							}
							elseif($b_def == "Веб")
							{
								$b_def = "Web";
							}
							elseif($b_def == "Для детей")
							{
								$b_def = "Bērniem";
							}
							elseif($b_def == "Для офиса, дома и сада")
							{
								$b_def = "Ofisam, mājai un dārzam";
							}
							elseif($b_def == "Для свадьбы")
							{
								$b_def = "Kāzām";
							}
							elseif($b_def == "Другое")
							{
								$b_def = "Citi";
							}
							elseif($b_def == "Животные, птицы и pыбы")
							{
								$b_def = "Dzīvnieki, putni un zivis";
							}
							elseif($b_def == "Интернет, радио, телевидение, связь")
							{
								$b_def = "Internets, radio, televīzija, sakari";
							}
							elseif($b_def == "Интернет магазин")
							{
								$b_def = "Internetveikali";
							}
							elseif($b_def == "Красота и здоровье")
							{
								$b_def = "Skaistums un veselība";
							}
							elseif($b_def == "Недвижимость")
							{
								$b_def = "Nekustamais īpašums";
							}
							elseif($b_def == "Образовaние")
							{
								$b_def = "Izglītība";
							}
							elseif($b_def == "Обувь")
							{
								$b_def = "Apavi";
							}
							elseif($b_def == "Одежда")
							{
								$b_def = "Apģērbs";
							}
							elseif($b_def == "Отдых и развлечения")
							{
								$b_def = "Atpūta un izklaide";
							}
							elseif($b_def == "Полиграфия и печать")
							{
								$b_def = "Poligrāfija un druka";
							}
							elseif($b_def == "Продукты питания")
							{
								$b_def = "Pārtikas produkti";
							}
							elseif($b_def == "Рестораны и бары")
							{
								$b_def = "Restorāni un bāri";
							}
							elseif($b_def == "Спорт")
							{
								$b_def = "Sports";
							}
							elseif($b_def == "Страхование")
							{
								$b_def = "Apdrošināšana";
							}
							elseif($b_def == "Строительство и ремонт")
							{
								$b_def = "Būvniecība un remonts";
							}
							elseif($b_def == "Транспорт")
							{
								$b_def = "Transports";
							}
							elseif($b_def == "Туризм")
							{
								$b_def = "Tūrisms";
							}
							elseif($b_def == "Финансовые услуги")
							{
								$b_def = "Finansu pakalpojumi";
							}
							elseif($b_def == "Электроника и техника")
							{
								$b_def = "Elektronika un tehnika";
							}
							
							if($def == "Бижутерия")
							{
								$def = "Bižutērija";
							}
							elseif($def == "Часы")
							{
								$def = "Pulksteņi";
							}
							elseif($def == "Ювелирные изделия")
							{
								$def = "Juvelierizstrādājumi";
							}
							elseif($def == "Услуги")
							{
								$def = "Pakalpojumi";
							}
							elseif($def == "Другое")
							{
								$def = "Citi";
							}
							elseif($def == "Дизайн")
							{
								$def = "Dizains";
							}
							elseif($def == "Каталоги")
							{
								$def = "Katalogi";
							}
							elseif($def == "Обьявления")
							{
								$def = "Sludinājumi";
							}
							elseif($def == "Разработка")
							{
								$def = "Izstrāde";
							}
							elseif($def == "Реклама")
							{
								$def = "Reklāma";
							}
							elseif($def == "Соц сети")
							{
								$def = "Sociālie tīkli";
							}
							elseif($def == "Хостинг")
							{
								$def = "Hostings";
							}
							elseif($def == "Аксессуары")
							{
								$def = "Aksesuāri";
							}
							elseif($def == "Для мамочек")
							{
								$def = "Māmiņām";
							}
							elseif($def == "Для ухода за ребенком")
							{
								$def = "Bērna kopšanai";
							}
							elseif($def == "Для школы")
							{
								$def = "Skolai";
							}
							elseif($def == "Игрушки, игры")
							{
								$def = "Rotaļlietas, spēles";
							}
							elseif($def == "Коляски, сумки, автокресла")
							{
								$def = "Ratiņi, somas, autokrēsli";
							}
							elseif($def == "Лагерь")
							{
								$def = "Nometne";
							}
							elseif($def == "Мебель")
							{
								$def = "Mēbeles";
							}
							elseif($def == "Мероприятия")
							{
								$def = "Pasākumi";
							}
							elseif($def == "Обувь")
							{
								$def = "Apavi";
							}
							elseif($def == "Одежда")
							{
								$def = "Apģērbs";
							}
							elseif($def == "Подарки")
							{
								$def = "Dāvanas";
							}
							elseif($def == "Проведение праздников")
							{
								$def = "Svinību rīkošana, vadīšana";
							}
							elseif($def == "Для домашнего хозяйства")
							{
								$def = "Mājsaimniecībai";
							}
							elseif($def == "Инструменты, оборудование")
							{
								$def = "Instrumenti, aprīkojums";
							}
							elseif($def == "Канцелярия")
							{
								$def = "Kancelejas preces";
							}
							elseif($def == "Мебель для дома")
							{
								$def = "Mēbeles mājai";
							}
							elseif($def == "Мебель для офиса")
							{
								$def = "Mēbeles ofisam";
							}
							elseif($def == "Мебель для сада")
							{
								$def = "Mēbeles dārzam";
							}
							elseif($def == "Одежда и обувь для сада")
							{
								$def = "Apģērbs un apavi dārzam";
							}
							elseif($def == "Осветительное оборудование")
							{
								$def = "Apgaismojums";
							}
							elseif($def == "Печати, штампы, пломбы")
							{
								$def = "Zīmogi, spiedogi, plombes";
							}
							elseif($def == "Посуда и принадлежности")
							{
								$def = "Trauki un piederumi";
							}
							elseif($def == "Растения, цветы, саженцы")
							{
								$def = "Augi, ziedi, krūmāji";
							}
							elseif($def == "Сантехника, отопительное оборудование")
							{
								$def = "Santehnika, apkures sistēmas";
							}
							elseif($def == "Топливо, дрова")
							{
								$def = "Degviela, kurināmais";
							}
							elseif($def == "Аудио сопровождение")
							{
								$def = "Audio pavadījums";
							}
							elseif($def == "Парихмахер")
							{
								$def = "Frizieris";
							}
							elseif($def == "Пиротехника")
							{
								$def = "Pirotehnika";
							}
							elseif($def == "Помещение")
							{
								$def = "Telpas";
							}
							elseif($def == "Салон")
							{
								$def = "Salons";
							}
							elseif($def == "Стилист")
							{
								$def = "Stilists";
							}
							elseif($def == "Тамода")
							{
								$def = "Vakara vadītājs";
							}
							elseif($def == "Транспорт")
							{
								$def = "Transports";
							}
							elseif($def == "Украшение помещений")
							{
								$def = "Telpu noformējums";
							}
							elseif($def == "Фокусник")
							{
								$def = "Jokdaris, viesu izklaidētājs";
							}
							elseif($def == "Фото, Видео услуги")
							{
								$def = "Foto, video pakalpojumi";
							}
							elseif($def == "Цветы")
							{
								$def = "Ziedi";
							}
							elseif($def == "Детективное агенство")
							{
								$def = "Detektīvu aģentūra";
							}
							elseif($def == "Переводы")
							{
								$def = "Tulkojumi";
							}
							elseif($def == "Хим чистка")
							{
								$def = "Ķīmiskā tīrīšana";
							}
							elseif($def == "Ветеринар")
							{
								$def = "Veterinārārsts";
							}
							elseif($def == "Домашние животные, птицы, pыбы")
							{
								$def = "Mājdzīvnieki, putni, zivis";
							}
							elseif($def == "Товары для животных")
							{
								$def = "Preces dzīvniekiem";
							}
							elseif($def == "Экзотические животные")
							{
								$def = "Eksotiskie dzīvnieki";
							}
							elseif($def == "Интернет")
							{
								$def = "Internets";
							}
							elseif($def == "Радио")
							{
								$def = "Radio";
							}
							elseif($def == "Реклама")
							{
								$def = "Reklāma";
							}
							elseif($def == "Связь")
							{
								$def = "Sakari";
							}
							elseif($def == "Телевидение")
							{
								$def = "Televīzija";
							}
							elseif($def == "Автозапчасти")
							{
								$def = "Auto rezerves daļas";
							}
							elseif($def == "Для дома")
							{
								$def = "Mājai";
							}
							elseif($def == "Для офиса")
							{
								$def = "Ofisam";
							}
							elseif($def == "Канцелярия")
							{
								$def = "Kancelejas preces";
							}
							elseif($def == "Книги, журналы, музыка")
							{
								$def = "Grāmatas, žurnāli, mūzika";
							}
							elseif($def == "Компьютерные и видеоигры")
							{
								$def = "Kompjūterspēles un videospēles";
							}
							elseif($def == "Косметика")
							{
								$def = "Kosmētika";
							}
							elseif($def == "Медикaменты")
							{
								$def = "Medikamenti";
							}
							elseif($def == "Парфюмерия")
							{
								$def = "Parfimērija";
							}
							elseif($def == "Стройматериалы")
							{
								$def = "Būvmateriāli";
							}
							elseif($def == "Цветы")
							{
								$def = "Ziedi";
							}
							elseif($def == "Электроника и техника")
							{
								$def = "Elektronika un tehnika";
							}
							elseif($def == "Лечение")
							{
								$def = "Ārstniecība";
							}
							elseif($def == "Массажист")
							{
								$def = "Masieris";
							}
							elseif($def == "Оборудование, приборы")
							{
								$def = "Aprīkojums, piederumi";
							}
							elseif($def == "Салон красоты")
							{
								$def = "Skaistumkopšanas saloni";
							}
							elseif($def == "Солярий")
							{
								$def = "Solārijs";
							}
							elseif($def == "СПА салон")
							{
								$def = "SPA salons";
							}
							elseif($def == "Гаражи, стоянки")
							{
								$def = "Garāžas, stāvvietas";
							}
							elseif($def == "Дома, дачи")
							{
								$def = "Mājas, vasarnīcas";
							}
							elseif($def == "Земля, лес")
							{
								$def = "Zeme, mežs";
							}
							elseif($def == "Квартиры")
							{
								$def = "Dzīvokļi";
							}
							elseif($def == "Офисы, помещения")
							{
								$def = "Ofisi, telpas";
							}
							elseif($def == "Автошколы")
							{
								$def = "Autoskolas";
							}
							elseif($def == "Книги")
							{
								$def = "Grāmatas";
							}
							elseif($def == "Курсы")
							{
								$def = "Kursi";
							}
							elseif($def == "Учебые заведния")
							{
								$def = "Mācību iestādes";
							}
							elseif($def == "Для работы")
							{
								$def = "Darbam";
							}
							elseif($def == "Женская")
							{
								$def = "Sieviešu";
							}
							elseif($def == "Мужская")
							{
								$def = "Vīriešu";
							}
							elseif($def == "Купальные костюмы")
							{
								$def = "Peldkostīmi";
							}
							elseif($def == "Нижнее белье")
							{
								$def = "Apakšveļa";
							}
							elseif($def == "Атракционы")
							{
								$def = "Atrakcijas";
							}
							elseif($def == "Баня")
							{
								$def = "Pirtis";
							}
							elseif($def == "Бассеин")
							{
								$def = "Baseini";
							}
							elseif($def == "Компьютерные и видеоигры")
							{
								$def = "Kompjūterspēles un videospēles";
							}
							elseif($def == "Концерты")
							{
								$def = "Koncerti";
							}
							elseif($def == "Ночные клубы")
							{
								$def = "Nakts klubi";
							}
							elseif($def == "Охота, рыбалка")
							{
								$def = "Medības, zveja";
							}
							elseif($def == "Проведение торжеств")
							{
								$def = "Svinību rīkošana, vadīšana";
							}
							elseif($def == "Украшение помещений")
							{
								$def = "Telpu noformējums";
							}
							elseif($def == "Цирк")
							{
								$def = "Cirks";
							}
							elseif($def == "Театры")
							{
								$def = "Teātris";
							}
							elseif($def == "Полиграфия и печать")
							{
								$def = "Poligrāfija un druka";
							}
							elseif($def == "Напитки")
							{
								$def = "Dzērieni";
							}
							elseif($def == "Овощи")
							{
								$def = "Dārzeņi";
							}
							elseif($def == "Продукты")
							{
								$def = "Produkti";
							}
							elseif($def == "Фрукты")
							{
								$def = "Augļi";
							}
							elseif($def == "Бар")
							{
								$def = "Bārs";
							}
							elseif($def == "Кафе")
							{
								$def = "Kafejnīca";
							}
							elseif($def == "Ресторан")
							{
								$def = "Restorāns";
							}
							elseif($def == "Инвентарь")
							{
								$def = "Inventārs";
							}
							elseif($def == "Клубы")
							{
								$def = "Klubi";
							}
							elseif($def == "Авто")
							{
								$def = "Auto";
							}
							elseif($def == "Здоровье")
							{
								$def = "Veselība";
							}
							elseif($def == "Недвижимость")
							{
								$def = "Nekustamais īpašums";
							}
							elseif($def == "Туризм")
							{
								$def = "Tūrisms";
							}
							elseif($def == "Ворота, жалюзи, двери, окна")
							{
								$def = "Vārti, žalūzijas, durvis, logi";
							}
							elseif($def == "Инструменты и техника")
							{
								$def = "Instrumenti un tehnika";
							}
							elseif($def == "Проекты, дизайн")
							{
								$def = "Projekti, dizains";
							}
							elseif($def == "Сторительные работы")
							{
								$def = "Būvniecības darbi";
							}
							elseif($def == "Автосалон")
							{
								$def = "Autosalons";
							}
							elseif($def == "Автосервис")
							{
								$def = "Autoserviss";
							}
							elseif($def == "Аренда")
							{
								$def = "Īre";
							}
							elseif($def == "Вело-транспорт")
							{
								$def = "Velotransports";
							}
							elseif($def == "Водный транспорт")
							{
								$def = "Ūdens transports";
							}
							elseif($def == "Грузовые авто и автобусы")
							{
								$def = "Kravas auto un autobusi";
							}
							elseif($def == "Запчасти")
							{
								$def = "Rezerves daļas";
							}
							elseif($def == "Легковые авто")
							{
								$def = "Vieglie auto";
							}
							elseif($def == "Мото-транспорт")
							{
								$def = "Mototransports";
							}
							elseif($def == "Перевозки, погрузка")
							{
								$def = "Pārvedumi, krāvēji";
							}
							elseif($def == "Сельхозтехника")
							{
								$def = "Lauksaimniecības tehnika";
							}
							elseif($def == "Экипировка")
							{
								$def = "EKipējums";
							}
							elseif($def == "Авиобилеты")
							{
								$def = "Aviobiļetes";
							}
							elseif($def == "Городские туры")
							{
								$def = "Pilsētas ekskursijas";
							}
							elseif($def == "Дом для гостей")
							{
								$def = "Viesu nams";
							}
							elseif($def == "Кемпинг")
							{
								$def = "Kempings";
							}
							elseif($def == "Отель")
							{
								$def = "Viesnīca";
							}
							elseif($def == "Туристическое агенство")
							{
								$def = "Tūrisma aģentūra";
							}
							elseif($def == "Банковские услуги")
							{
								$def = "Banku pakalpojumi";
							}
							elseif($def == "Бухгалтерские услуги")
							{
								$def = "Grāmatvedības pakalpojumi";
							}
							elseif($def == "Лизинг, Кредит")
							{
								$def = "Līzings, kredīti";
							}
							elseif($def == "Юридические услуги")
							{
								$def = "Juridiskie pakalpojumi";
							}
							elseif($def == "Экспертизы и оценка")
							{
								$def = "Ekspertīzes un novērtējums";
							}
							elseif($def == "TV, видео, DVD")
							{
								$def = "TV, video, DVD";
							}
							elseif($def == "Аудио техника")
							{
								$def = "Audio tehnika";
							}
							elseif($def == "Бытовая техника")
							{
								$def = "Virtuves tehnika";
							}
							elseif($def == "Компьютеры")
							{
								$def = "Datori";
							}
							elseif($def == "Мобильные телефоны")
							{
								$def = "Mobilie tālruņi";
							}
							elseif($def == "Фото и оптика")
							{
								$def = "Foto un optika";
							}
							
							$content1 = $descr_sh_sec_lang." ".$descr_offer_sec_lang;
							$content = mb_convert_encoding($content1, "iso-8859-4", "utf8");
							$word_counter = new Counter_lat();
							
							if (strlen($content)>50000)
							{
								$keywords = $word_counter->get_keywords(substr($content, 0, 50000));
							}
							else
							{
								$keywords = $word_counter->get_keywords($content);
							}
							
							$keywords = $city_sh.", ".$b_def.", ".$def.", ".$sh_name.", ".$keywords;
							
							$result_insert_lat = mysql_query("INSERT INTO ltd_page_lat
							(login,pvn,sh_name,meta_k,title,descr,web,phone,phone_2,fax,address,
							 city,post,descr_offer,from_date_offer,till_date_offer,b_def,defcat,activation) 
							VALUES 
							('$login','$pvn','$sh_name','$keywords','$sh_name','$descr_sh_sec_lang','$web_sh','$phone_sh','$phone_sh_2',
							 '$fax_sh','$address_sh','$city_sh','$post_sh','$descr_offer_sec_lang','$date_from',
							 '$date_till','$b_def','$def','0')");
							
							$result_insert_cat_lat = mysql_query("INSERT INTO catalogue_lat 
													(login,ltd_name,city,b_def,definition,activation) 
													VALUES 
													('$login','$sh_name','$city_sh','$b_def','$def','0')");
						}
						else
						{
							$content1 = $descr_sh." ".$descr_offer;
							$content = mb_convert_encoding($content1, "iso-8859-4", "utf8");
							$word_counter = new Counter_lat();
							
							if (strlen($content)>50000)
							{
								$keywords = $word_counter->get_keywords(substr($content, 0, 50000));
							}
							else
							{
								$keywords = $word_counter->get_keywords($content);
							}
							
							$keywords = $city_sh.", ".$b_def.", ".$def.", ".$sh_name.", ".$keywords;
							
							$result_insert_lat = mysql_query("INSERT INTO ltd_page_lat
							(login,pvn,sh_name,meta_k,title,descr,web,phone,phone_2,fax,address,
							 city,post,descr_offer,from_date_offer,till_date_offer,b_def,defcat,activation) 
							VALUES 
							('$login','$pvn','$sh_name','$keywords','$sh_name','$descr_sh','$web_sh','$phone_sh','$phone_sh_2',
							 '$fax_sh','$address_sh','$city_sh','$post_sh','$descr_offer','$date_from',
							 '$date_till','$b_def','$def','0')");
							
							$result_insert_cat_lat = mysql_query("INSERT INTO catalogue_lat 
													(login,ltd_name,city,b_def,definition,activation) 
													VALUES 
													('$login','$sh_name','$city_sh','$b_def','$def','0')");
							
							if($city_sh == "Rīga")
							{
								$city_sh = "Рига";
							}
							elseif($city_sh == "Jūrmala")
							{
								$city_sh = "Юрмала";
							}
							elseif($city_sh == "Rīgas rajons")
							{
								$city_sh = "Рижский р-он";
							}
							elseif($city_sh == "Aizkraukle un raj")
							{
								$city_sh = "Айзкраукле и р-он";
							}
							elseif($city_sh == "Alūksne un raj")
							{
								$city_sh = "Алуксне и р-он";
							}
							elseif($city_sh == "Balvi un raj")
							{
								$city_sh = "Балви и р-он";
							}
							elseif($city_sh == "Bauska un raj")
							{
								$city_sh = "Бауска и р-он";
							}
							elseif($city_sh == "Valka un raj")
							{
								$city_sh = "Валка и р-он";
							}
							elseif($city_sh == "Valmiera un raj")
							{
								$city_sh = "Валмиера и р-он";
							}
							elseif($city_sh == "Ventspils un raj")
							{
								$city_sh = "Вентспилс и р-он";
							}
							elseif($city_sh == "Gulbene un raj")
							{
								$city_sh = "Гулбене и р-он";
							}
							elseif($city_sh == "Daugavpils un raj")
							{
								$city_sh = "Даугавпилс и р-он";
							}
							elseif($city_sh == "Dobele un raj")
							{
								$city_sh = "Добеле и р-он";
							}
							elseif($city_sh == "Jēkabpils un raj")
							{
								$city_sh = "Екабпилс и р-он";
							}
							elseif($city_sh == "Jelgava un raj")
							{
								$city_sh = "Елгава и р-он";
							}
							elseif($city_sh == "Krāslava un raj")
							{
								$city_sh = "Краславa и р-он";
							}
							elseif($city_sh == "Kuldīga un raj")
							{
								$city_sh = "Кулдыга и р-он";
							}
							elseif($city_sh == "Liepāja un raj")
							{
								$city_sh = "Лиепая и р-он";
							}
							elseif($city_sh == "Limbaži un raj")
							{
								$city_sh = "Лимбажи и р-он";
							}
							elseif($city_sh == "Ludza un raj")
							{
								$city_sh = "Лудза и р-он";
							}
							elseif($city_sh == "Madona un raj")
							{
								$city_sh = "Мадона и р-он";
							}
							elseif($city_sh == "Ogre un raj")
							{
								$city_sh = "Огре и р-он";
							}
							elseif($city_sh == "Preiļi un raj")
							{
								$city_sh = "Преили и р-он";
							}
							elseif($city_sh == "Rēzekne un raj")
							{
								$city_sh = "Резекне и р-он";
							}
							elseif($city_sh == "Saldus un raj")
							{
								$city_sh = "Салдус и р-он";
							}
							elseif($city_sh == "Talsi un raj")
							{
								$city_sh = "Талси и р-он";
							}
							elseif($city_sh == "Tukums un raj")
							{
								$city_sh = "Тукумс и р-он";
							}
							elseif($city_sh == "Cēsis un raj")
							{
								$city_sh = "Цесис и р-он";
							}
							
			////////////////1.lat - 2.rus				
								if($b_def == "Aksesuāri")
								{
									$b_def = "Аксессуары";
								}
								elseif($b_def == "Web")
								{
									$b_def = "Веб";
								}
								elseif($b_def == "Bērniem")
								{
									$b_def = "Для детей";
								}
								elseif($b_def == "Ofisam, mājai un dārzam")
								{
									$b_def = "Для офиса, дома и сада";
								}
								elseif($b_def == "Kāzām")
								{
									$b_def = "Для свадьбы";
								}
								elseif($b_def == "Citi")
								{
									$b_def = "Другое";
								}
								elseif($b_def == "Dzīvnieki, putni un zivis")
								{
									$b_def = "Животные, птицы и pыбы";
								}
								elseif($b_def == "Internets, radio, televīzija, sakari")
								{
									$b_def = "Интернет, радио, телевидение, связь";
								}
								elseif($b_def == "Internetveikali")
								{
									$b_def = "Интернет магазин";
								}
								elseif($b_def == "Skaistums un veselība")
								{
									$b_def = "Красота и здоровье";
								}
								elseif($b_def == "Nekustamais īpašums")
								{
									$b_def = "Недвижимость";
								}
								elseif($b_def == "Izglītība")
								{
									$b_def = "Образовaние";
								}
								elseif($b_def == "Apavi")
								{
									$b_def = "Обувь";
								}
								elseif($b_def == "Apģērbs")
								{
									$b_def = "Одежда";
								}
								elseif($b_def == "Atpūta un izklaide")
								{
									$b_def = "Отдых и развлечения";
								}
								elseif($b_def == "Poligrāfija un druka")
								{
									$b_def = "Полиграфия и печать";
								}
								elseif($b_def == "Pārtikas produkti")
								{
									$b_def = "Продукты питания";
								}
								elseif($b_def == "Restorāni un bāri")
								{
									$b_def = "Рестораны и бары";
								}
								elseif($b_def == "Sports")
								{
									$b_def = "Спорт";
								}
								elseif($b_def == "Apdrošināšana")
								{
									$b_def = "Страхование";
								}
								elseif($b_def == "Būvniecība un remonts")
								{
									$b_def = "Строительство и ремонт";
								}
								elseif($b_def == "Transports")
								{
									$b_def = "Транспорт";
								}
								elseif($b_def == "Tūrisms")
								{
									$b_def = "Туризм";
								}
								elseif($b_def == "Finansu pakalpojumi")
								{
									$b_def = "Финансовые услуги";
								}
								elseif($b_def == "Elektronika un tehnika")
								{
									$b_def = "Электроника и техника";
								}
								
								if($def == "Bižutērija")
								{
									$def = "Бижутерия";
								}
								elseif($def == "Pulksteņi")
								{
									$def = "Часы";
								}
								elseif($def == "Juvelierizstrādājumi")
								{
									$def = "Ювелирные изделия";
								}
								elseif($def == "Pakalpojumi")
								{
									$def = "Услуги";
								}
								elseif($def == "Citi")
								{
									$def = "Другое";
								}
								elseif($def == "Dizains")
								{
									$def = "Дизайн";
								}
								elseif($def == "Katalogi")
								{
									$def = "Каталоги";
								}
								elseif($def == "Sludinājumi")
								{
									$def = "Обьявления";
								}
								elseif($def == "Izstrāde")
								{
									$def = "Разработка";
								}
								elseif($def == "Reklāma")
								{
									$def = "Реклама";
								}
								elseif($def == "Sociālie tīkli")
								{
									$def = "Соц сети";
								}
								elseif($def == "Hostings")
								{
									$def = "Хостинг";
								}
								elseif($def == "Aksesuāri")
								{
									$def = "Аксессуары";
								}
								elseif($def == "Māmiņām")
								{
									$def = "Для мамочек";
								}
								elseif($def == "Bērna kopšanai")
								{
									$def = "Для ухода за ребенком";
								}
								elseif($def == "Skolai")
								{
									$def = "Для школы";
								}
								elseif($def == "Rotaļlietas, spēles")
								{
									$def = "Игрушки, игры";
								}
								elseif($def == "Ratiņi, somas, autokrēsli")
								{
									$def = "Коляски, сумки, автокресла";
								}
								elseif($def == "Nometne")
								{
									$def = "Лагерь";
								}
								elseif($def == "Mēbeles")
								{
									$def = "Мебель";
								}
								elseif($def == "Pasākumi")
								{
									$def = "Мероприятия";
								}
								elseif($def == "Apavi")
								{
									$def = "Обувь";
								}
								elseif($def == "Apģērbs")
								{
									$def = "Одежда";
								}
								elseif($def == "Dāvanas")
								{
									$def = "Подарки";
								}
								elseif($def == "Svinību rīkošana, vadīšana")
								{
									$def = "Проведение праздников";
								}
								elseif($def == "Mājsaimniecībai")
								{
									$def = "Для домашнего хозяйства";
								}
								elseif($def == "Instrumenti, aprīkojums")
								{
									$def = "Инструменты, оборудование";
								}
								elseif($def == "Kancelejas preces")
								{
									$def = "Канцелярия";
								}
								elseif($def == "Mēbeles mājai")
								{
									$def = "Мебель для дома";
								}
								elseif($def == "Mēbeles ofisam")
								{
									$def = "Мебель для офиса";
								}
								elseif($def == "Mēbeles dārzam")
								{
									$def = "Мебель для сада";
								}
								elseif($def == "Apģērbs un apavi dārzam")
								{
									$def = "Одежда и обувь для сада";
								}
								elseif($def == "Apgaismojums")
								{
									$def = "Осветительное оборудование";
								}
								elseif($def == "Zīmogi, spiedogi, plombes")
								{
									$def = "Печати, штампы, пломбы";
								}
								elseif($def == "Trauki un piederumi")
								{
									$def = "Посуда и принадлежности";
								}
								elseif($def == "Augi, ziedi, krūmāji")
								{
									$def = "Растения, цветы, саженцы";
								}
								elseif($def == "Santehnika, Apkures sistēmas")
								{
									$def = "Сантехника, отопительное оборудование";
								}
								elseif($def == "Degviela, kurināmais")
								{
									$def = "Топливо, дрова";
								}
								elseif($def == "Audio pavadījums")
								{
									$def = "Аудио сопровождение";
								}
								elseif($def == "Frizieris")
								{
									$def = "Парихмахер";
								}
								elseif($def == "Pirotehnika")
								{
									$def = "Пиротехника";
								}
								elseif($def == "Telpas")
								{
									$def = "Помещение";
								}
								elseif($def == "Salons")
								{
									$def = "Салон";
								}
								elseif($def == "Stilists")
								{
									$def = "Стилист";
								}
								elseif($def == "Vakara vadītājs")
								{
									$def = "Тамода";
								}
	
								elseif($def == "Transports")
								{
									$def = "Транспорт";
								}
								elseif($def == "Telpu noformējums")
								{
									$def = "Украшение помещений";
								}
								elseif($def == "Jokdaris, viesu izklaidētājs")
								{
									$def = "Фокусник";
								}
								elseif($def == "Foto, video pakalpojumi")
								{
									$def = "Фото, Видео услуги";
								}
								elseif($def == "Ziedi")
								{
									$def = "Цветы";
								}
								elseif($def == "Detektīvu aģentūra")
								{
									$def = "Детективное агенство";
								}
								elseif($def == "Tulkojumi")
								{
									$def = "Переводы";
								}
								elseif($def == "Ķīmiskā tīrīšana")
								{
									$def = "Хим чистка";
								}
								elseif($def == "Veterinārārsts")
								{
									$def = "Ветеринар";
								}
								elseif($def == "Mājdzīvnieki, putni, zivis")
								{
									$def = "Домашние животные, птицы, pыбы";
								}
								elseif($def == "Preces dzīvniekiem")
								{
									$def = "Товары для животных";
								}
								elseif($def == "Eksotiskie dzīvnieki")
								{
									$def = "Экзотические животные";
								}
								elseif($def == "Internets")
								{
									$def = "Интернет";
								}
								elseif($def == "Radio")
								{
									$def = "Радио";
								}
								elseif($def == "Reklāma")
								{
									$def = "Реклама";
								}
								elseif($def == "Sakari")
								{
									$def = "Связь";
								}
								elseif($def == "Televīzija")
								{
									$def = "Телевидение";
								}
								elseif($def == "Auto rezerves daļas")
								{
									$def = "Автозапчасти";
								}
								elseif($def == "Mājai")
								{
									$def = "Для дома";
								}
								elseif($def == "Ofisam")
								{
									$def = "Для офиса";
								}
								elseif($def == "Kancelejas preces")
								{
									$def = "Канцелярия";
								}
								elseif($def == "Grāmatas, žurnāli, mūzika")
								{
									$def = "Книги, журналы, музыка";
								}
								elseif($def == "Kompjūterspēles un videospēles")
								{
									$def = "Компьютерные и видеоигры";
								}
								elseif($def == "Kosmētika")
								{
									$def = "Косметика";
								}
								elseif($def == "Medikamenti")
								{
									$def = "Медикaменты";
								}
								elseif($def == "Parfimērija")
								{
									$def = "Парфюмерия";
								}
								elseif($def == "Būvmateriāli")
								{
									$def = "Стройматериалы";
								}
								elseif($def == "Ziedi")
								{
									$def = "Цветы";
								}
								elseif($def == "Elektronika un tehnika")
								{
									$def = "Электроника и техника";
								}
								elseif($def == "Ārstniecība")
								{
									$def = "Лечение";
								}
								elseif($def == "Masieris")
								{
									$def = "Массажист";
								}
								elseif($def == "Aprīkojums, piederumi")
								{
									$def = "Оборудование, приборы";
								}
								elseif($def == "Skaistumkopšanas saloni")
								{
									$def = "Салон красоты";
								}
								elseif($def == "Solārijs")
								{
									$def = "Солярий";
								}
								elseif($def == "SPA salons")
								{
									$def = "СПА салон";
								}
								elseif($def == "Garāžas, stāvvietas")
								{
									$def = "Гаражи, стоянки";
								}
								elseif($def == "Mājas, vasarnīcas")
								{
									$def = "Дома, дачи";
								}
								elseif($def == "Zeme, mežs")
								{
									$def = "Земля, лес";
								}
								elseif($def == "Dzīvokļi")
								{
									$def = "Квартиры";
								}
								elseif($def == "Ofisi, telpas")
								{
									$def = "Офисы, помещения";
								}
								elseif($def == "Autoskolas")
								{
									$def = "Автошколы";
								}
								elseif($def == "Grāmatas")
								{
									$def = "Книги";
								}
								elseif($def == "Kursi")
								{
									$def = "Курсы";
								}
								elseif($def == "Mācību iestādes")
								{
									$def = "Учебые заведния";
								}
								elseif($def == "Darbam")
								{
									$def = "Для работы";
								}
								elseif($def == "Sieviešu")
								{
									$def = "Женская";
								}
								elseif($def == "Vīriešu")
								{
									$def = "Мужская";
								}
								elseif($def == "Peldkostīmi")
								{
									$def = "Купальные костюмы";
								}
								elseif($def == "Apakšveļa")
								{
									$def = "Нижнее белье";
								}
								elseif($def == "Atrakcijas")
								{
									$def = "Атракционы";
								}
								elseif($def == "Pirtis")
								{
									$def = "Баня";
								}
								elseif($def == "Baseini")
								{
									$def = "Бассеин";
								}
								elseif($def == "Kompjūterspēles un videospēles")
								{
									$def = "Компьютерные и видеоигры";
								}
								elseif($def == "Koncerti")
								{
									$def = "Концерты";
								}
	
								elseif($def == "Nakts klubi")
								{
									$def = "Ночные клубы";
								}
								elseif($def == "Medības, zveja")

								{
									$def = "Охота, рыбалка";
								}
								elseif($def == "Svinību rīkošana, vadīšana")
								{
									$def = "Проведение торжеств";
								}
								elseif($def == "Telpu noformēšana")
								{
									$def = "Украшение помещений";
								}
								elseif($def == "Cirks")
								{
									$def = "Цирк";
								}
								elseif($def == "Teātris")
								{
									$def = "Театры";
								}
								elseif($def == "Poligrāfija un druka")
								{
									$def = "Полиграфия и печать";
								}
								elseif($def == "Dzērieni")
								{
									$def = "Напитки";
								}
								elseif($def == "Dārzeņi")
								{
									$def = "Овощи";
								}
								elseif($def == "Produkti")
								{
									$def = "Продукты";
								}
								elseif($def == "Augļi")
								{
									$def = "Фрукты";
								}
								elseif($def == "Bārs")
								{
									$def = "Бар";
								}
								elseif($def == "Kafejnīca")
								{
									$def = "Кафе";
								}
								elseif($def == "Restorāns")
								{
									$def = "Ресторан";
								}
								elseif($def == "Inventārs")
								{
									$def = "Инвентарь";
								}
								elseif($def == "Klubi")
								{
									$def = "Клубы";
								}
								elseif($def == "Auto")
								{
									$def = "Авто";
								}
								elseif($def == "Veselība")
								{
									$def = "Здоровье";
								}
								elseif($def == "Nekustamais īpašums")
								{
									$def = "Недвижимость";
								}
								elseif($def == "Tūrisms")
								{
									$def = "Туризм";
								}
								elseif($def == "Vārti, žalūzijas, durvis, logi")
								{
									$def = "Ворота, жалюзи, двери, окна";
								}
								elseif($def == "Instrumenti un tehnika")
								{
									$def = "Инструменты и техника";
								}
								elseif($def == "Projekti, dizains")
								{
									$def = "Проекты, дизайн";
								}
								elseif($def == "Būvniecības darbi")
								{
									$def = "Сторительные работы";
								}
								elseif($def == "Autosaloni")
								{
									$def = "Автосалон";
								}
								elseif($def == "Autoserviss")
								{
									$def = "Автосервис";
								}
								elseif($def == "Īre")
								{
									$def = "Аренда";
								}
								elseif($def == "Velotransports")
								{
									$def = "Вело-транспорт";
								}
								elseif($def == "Ūdens transports")
								{
									$def = "Водный транспорт";
								}
								elseif($def == "Kravas auto un autobusi")
								{
									$def = "Грузовые авто и автобусы";
								}
								elseif($def == "Rezerves daļas")
								{
									$def = "Запчасти";
								}
								elseif($def == "Vieglie auto")
								{
									$def = "Легковые авто";
								}
								elseif($def == "Mototransports")
								{
									$def = "Мото-транспорт";
								}
								elseif($def == "Pārvadājumi, krāvēji")
								{
									$def = "Перевозки, погрузка";
								}
								elseif($def == "Lauksaimniecība")
								{
									$def = "Сельхозтехника";
								}
								elseif($def == "Ekipējums")
								{
									$def = "Экипировка";
								}
								elseif($def == "Aviobiļetes")
								{
									$def = "Авиобилеты";
								}
								elseif($def == "Pilsētas ekskursijas")
								{
									$def = "Городские туры";
								}
								elseif($def == "Viesu nams")
								{
									$def = "Дом для гостей";
								}
								elseif($def == "Kempings")
								{
									$def = "Кемпинг";
								}
								elseif($def == "Viesnīca")
								{
									$def = "Отель";
								}
								elseif($def == "Tūrisma aģentūra")
								{
									$def = "Туристическое агенство";
								}
								elseif($def == "Banku pakalpojumi")
								{
									$def = "Банковские услуги";
								}
								elseif($def == "Grāmatvedības pakalpojumi")
								{
									$def = "Бухгалтерские услуги";
								}
								elseif($def == "Līzings, kredīti")
								{
									$def = "Лизинг, Кредит";
								}
								elseif($def == "Juridiskie pakalpojumi")
								{
									$def = "Юридические услуги";
								}
								elseif($def == "Ekspertīzes un novērtējums")
								{
									$def = "Экспертизы и оценка";
								}
								elseif($def == "TV, video, DVD")
								{
									$def = "TV, видео, DVD";
								}
								elseif($def == "Audio tehnika")
								{
									$def = "Аудио техника";
								}
								elseif($def == "Virtuves tehnika")
								{
									$def = "Бытовая техника";
								}
								elseif($def == "Datori")
								{
									$def = "Компьютеры";
								}
								elseif($def == "Mobilie tālruņi")
								{
									$def = "Мобильные телефоны";
								}
								elseif($def == "Foto un optika")
								{
									$def = "Фото и оптика";
								}
								
								$content1 = $descr_sh_sec_lang." ".$descr_offer_sec_lang;
								$content = mb_convert_encoding($content1, "windows-1251", "utf8");
								$word_counter = new Counter_rus();
								
								if (strlen($content)>50000)
								{
									$keywords = $word_counter->get_keywords(substr($content, 0, 50000));
								}
								else
								{
									$keywords = $word_counter->get_keywords($content);
								}
								
								$keywords = $city_sh.", ".$b_def.", ".$def.", ".$sh_name.", ".$keywords;
							
							$result_insert_rus = mysql_query("INSERT INTO ltd_page_rus
							(login,pvn,sh_name,meta_k,title,descr,web,phone,phone_2,fax,address,
							 city,post,descr_offer,from_date_offer,till_date_offer,b_def,defcat,activation) 
							VALUES 
							('$login','$pvn','$sh_name','$keywords','$sh_name','$descr_sh_sec_lang','$web_sh','$phone_sh','$phone_sh_2',
							 '$fax_sh','$address_sh','$city_sh','$post_sh','$descr_offer_sec_lang','$date_from',
							 '$date_till','$b_def','$def','0')");
							
							$result_insert_cat_rus = mysql_query("INSERT INTO catalogue_rus 
													(login,ltd_name,city,b_def,definition,activation) 
													VALUES 
													('$login','$sh_name','$city_sh','$b_def','$def','0')");
							
						}
						
						if(!$result_insert_rus || !$result_insert_lat)
						{
							message_succes($lang,"<p align='center' class='join_us_error'>".$reg_user_db_err."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
						}
						else
						{
							$address = "admin@econom.lv";
							$sub = "Joining Form";
							$ip = ($_SERVER['HTTP_X_FORWARDED_FOR'] == "" ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']);
							$smes = "SIA PVN number: ".$pvn."\n
							
							SIA name: ".$sh_name."\n 
							
							SIA describe: ".$descr_sh." \n 
							
							SIA describe second language: ".$descr_sh_sec_lang." \n 
							
							SIA phone: ".$phone_sh."\n
							
							SIA phone no. 2: ".$phone_sh_2."\n
							
							SIA fax: ".$fax_sh."\n
							
							SIA address: ".$address_sh."\n 
							
							SIA website: ".$web_sh."\n 
							
							SIA city: ".$city_sh."\n
							
							For catalogue: ".$b_def."\n
							
							For under catalogue: ".$def."\n
							
							SIA post: ".$post_sh."\n
							
							Offer or Discount: ".$descr_offer."\n
							
							Offer or Discount second language: ".$descr_offer_sec_lang."\n
							
							Offer dates from ".$date_from." till ".$date_till."\n
							
							Information presented by: ".$login."\n
							
							Senders IP: ".$ip."";
							
							$headers = 'Content-type:text/plain; charset=UTF-8';
							mail ($address,$sub,$smes,"Content-type:text/plain; charset=UTF-8\r\n");
							
							if($photo == 'photo_yes')
							{
								ltd_create_succes_photo($lang,$ltd_create_upload_message,$sh_name);
							}
							else
							{	
								message_succes($lang,"<p>".$ltd_create_succes_message."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
							}
						}
					}
				}
				?>
				<table align="center" border="0" cellpadding="2" cellspacing="0">
				<form action="ltd_create.php?lang=<?php echo $lang; ?>" method="post">
				<tr>
				<td colspan="3"><input type="hidden" name="hidden" size="3" maxlength="3"></td>
				</tr>
                <tr>
                <td colspan="3" align="left"><p class="stats"><?php echo $ltd_create_mand; ?></p></td>
                </tr>
                <tr>
                <td><p><?php echo $ltd_create_pvn; ?> <strong style="color:#F00">*</strong></p></td>
                <td align="right"></td>
                <td><input type="text" name="pvn" size="20" maxlength="16" /></td>
                </tr>
				<tr>
				<td><p><?php echo $ltd_create_name; ?> <strong style="color:#F00">*</strong></p></td>
                <td width="50px" align="right"></td>
				<td><input type="text" name="sh_name" size="20" maxlength="50" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr; ?></p></td>
                <td align="right"></td>
				<td><textarea name="descr_sh" cols="40" rows="10"></textarea></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_web; ?></p></td>
                <td align="right"><p>www.</p></td>
				<td><input type="text" name="web_sh" size="20" maxlength="40" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_phone; ?></p></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="phone_sh" size="8" maxlength="8" /></td>
                </tr>
                <tr>
                <td></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="phone_sh_2" size="8" maxlength="8" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_fax; ?></p></td>
                <td align="right"><p>+ 371</p></td>
				<td><input type="text" name="fax_sh" size="8" maxlength="8" /></td>
				</tr>	
				<tr>
				<td><p><?php echo $ltd_create_addres; ?></p></td>
                <td align="right"></td>
				<td><input type="text" name="address_sh" size="20" maxlength="60" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_city; ?></p></td>
                <td align="right"></td>
				<td><select name="city"><?php if($lang == 'rus')
				{
					?>
					<option value="Рига">Рига</option>
						<option value="Юрмала">Юрмала</option>
						<option value="Рижский р-он">Рижский р-он</option>
						<option value="Айзкраукле и р-он">Айзкраукле и р-он</option>
						<option value="Алуксне и р-он">Алуксне и р-он</option>
						<option value="Балви и р-он">Балви и р-он</option>
						<option value="Бауска и р-он">Бауска и р-он</option>
						<option value="Валка и р-он">Валка и р-он</option>
						<option value="Валмиера и р-он">Валмиера и р-он</option>
						<option value="Вентспилс и р-он">Вентспилс и р-он</option>
						<option value="Гулбене и р-он">Гулбене и р-он</option>
						<option value="Даугавпилс и р-он">Даугавпилс и р-он</option>
						<option value="Добеле и р-он">Добеле и р-он</option>
						<option value="Екабпилс и р-он">Екабпилс и р-он</option>
						<option value="Елгава и р-он">Елгава и р-он</option>
						<option value="Краславa и р-он">Краславa и р-он</option>
						<option value="Кулдыга и р-он">Кулдыга и р-он</option>
						<option value="Лиепая и р-он">Лиепая и р-он</option>
						<option value="Лимбажи и р-он">Лимбажи и р-он</option>
						<option value="Лудза и р-он">Лудза и р-он</option>
						<option value="Мадона и р-он">Мадона и р-он</option>
						<option value="Огре и р-он">Огре и р-он</option>
						<option value="Преили и р-он">Преили и р-он</option>
						<option value="Резекне и р-он">Резекне и р-он</option>
						<option value="Салдус и р-он">Салдус и р-он</option>
						<option value="Талси и р-он">Талси и р-он</option>
						<option value="Тукумс и р-он">Тукумс и р-он</option>
						<option value="Цесис и р-он">Цесис и р-он</option>
                <?php
				}
				else
				{
				?>
					<option value="Rīga">Rīga</option>
						<option value="Jūrmala">Jūrmala</option>
						<option value="Rīgas rajons">Rīgas rajons</option>
						<option value="Aizkraukle un raj">Aizkraukle un raj</option>
						<option value="Alūksne un raj">Alūksne un raj</option>
						<option value="Balvi un raj">Balvi un raj</option>
						<option value="Bauska un raj">Bauska un raj</option>
						<option value="Cēsis un raj">Cēsis un raj</option>
						<option value="Daugavpils un raj">Daugavpils un raj</option>
						<option value="Dobele un raj">Dobele un raj</option>
						<option value="Gulbene un raj">Gulbene un raj</option>
						<option value="Jēkabpils un raj">Jēkabpils un raj</option>
						<option value="Jelgava un raj">Jelgava un raj</option>
						<option value="Krāslava un raj">Krāslava un raj</option>
						<option value="Kuldīga un raj">Kuldīga un raj</option>
						<option value="Liepāja un raj">Liepāja un raj</option>
						<option value="Limbaži un raj">Limbaži un raj</option>
						<option value="Ludza un raj">Ludza un raj</option>
						<option value="Madona un raj">Madona un raj</option>
						<option value="Ogre un raj">Ogre un raj</option>
						<option value="Preiļi un raj">Preiļi un raj</option>
						<option value="Rēzekne un raj">Rēzekne un raj</option>
						<option value="Saldus un raj">Saldus un raj</option>
						<option value="Talsi un raj">Talsi un raj</option>
						<option value="Tukums un raj">Tukums un raj</option>
						<option value="Valka un raj">Valka un raj</option>
						<option value="Valmiera un raj">Valmiera un raj</option>
						<option value="Ventspils un raj">Ventspils un raj</option>
                <?php 
				} ?>
                </select></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_post; ?></p></td>
                <td align="right"><p>LV -</p></td>
				<td><input type="text" name="post_sh" size="4" maxlength="4"></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr_offer; ?> <strong style="color:#F00">*</strong></p></td>
                <td align="right"></td>
				<td><textarea name="descr_offer" cols="40" rows="10"></textarea></td>
				</tr>	
				<tr>
				<td><p><?php echo $ltd_create_dates; ?></p></td>
                <td align="right"><p><?php echo $ltd_create_dates_from; ?>: <strong style="color:#F00">*</strong></p></td>
				<td><input type="text" name="from_date_offer" size="20" maxlength="12" class="date_input" /></td>
                </tr>
                <tr>
                <td></td>
                <td align="right"><p><?php echo $ltd_create_dates_till; ?>: <strong style="color:#F00">*</strong></p></td>
				<td><input type="text" name="till_date_offer" size="20" maxlength="12" class="date_input" /></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr_sec_lang; ?></p></td>
                <td></td>
				<td><textarea name="descr_sh_sec_lang" cols="40" rows="10"></textarea></td>
				</tr>
				<tr>
				<td><p><?php echo $ltd_create_descr_offer_sec_lang; ?> <strong style="color:#F00">*</strong></p></td>
                <td></td>
				<td><textarea name="descr_offer_sec_lang" cols="40" rows="10"></textarea></td>
				</tr>
                <tr>
                <td colspan="3"><input type="hidden" name="lang_choise" value="two_lang" /> </td>
                </tr>
                <tr>
                <td><input type="hidden" name="def" value="<?php echo $def; ?>" /></td>
                <td><input type="hidden" name="b_def" value="<?php echo $b_def; ?>" /></td>
                <td><input type="hidden" name="photo_choise" value="<?php echo $photo; ?>" /></td>
                </tr>
                <tr>
				<td align="center" colspan="3"><p><input name="ltd_create" type="submit" value="<?php echo $ltd_create_opt_but; ?>" /></p></td>
				</tr>
				</form>
				</table>
				<?php
			}
			else
			{
				message_succes($lang, "<p align='center' class='join_us_error'>".$ltd_create_nothing."</p><p><a href='ltd_create_opt.php?lang=".$lang."'>".$ltd_create_nothing_2_link."</a></p>");
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
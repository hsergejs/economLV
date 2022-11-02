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
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $change_ltd_title; ?></title>
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
		if(isset($_POST['ltd']))
		{
			$old_sh_name = $_POST['ltd'];
			$old_sh_name = htmlspecialchars(stripslashes(trim($old_sh_name)));
		}
		if($old_sh_name == '')
		{
			unset($old_sh_name);
			exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
		}
		
		if(isset($_POST['sh_name_ch']))
		{
			$sh_name_ch = $_POST['sh_name_ch'];
		}
		if($sh_name_ch == '')
		{
			unset($sh_name_ch);
		}
		
		if(isset($_POST['pvn_ch']))
		{
			$pvn_ch = $_POST['pvn_ch'];
		}
		if($pvn_ch == '')
		{
			unset($pvn_ch);
		}
		
		if(isset($_POST['descr_ch']))
		{
			$descr_ch = $_POST['descr_ch'];
		}
		if($descr_ch == '')
		{
			unset($descr_ch);
		}
		
		if(isset($_POST['web_ch']))
		{
			$web_ch = $_POST['web_ch'];
		}
		if($web_ch == '')
		{
			unset($web_ch);
		}
		
		if(isset($_POST['phone_1_ch']))
		{
			$phone_1_ch = $_POST['phone_1_ch']; 
		}
		if($phone_1_ch == '')
		{
			unset($phone_1_ch);
		}
		
		if(isset($_POST['phone_2_ch']))
		{
			$phone_2_ch = $_POST['phone_2_ch'];
		}
		if($phone_2_ch == '')
		{
			unset($phone_2_ch);
		}
		
		if(isset($_POST['fax_ch']))
		{
			$fax_ch = $_POST['fax_ch'];
		}
		if($fax_ch == '')
		{
			unset($fax_ch);
		}
		
		if(isset($_POST['address_ch']))
		{
			$address_ch = $_POST['address_ch'];
		}
		if($address_ch == '')
		{
			unset($address_ch);
		}
		
		if(isset($_POST['city_ch']))
		{
			$city_ch = $_POST['city_ch'];
		}
		if($city_ch == '')
		{
			unset($city_ch);
		}
		
		if(isset($_POST['post_ch']))
		{
			$post_ch = $_POST['post_ch'];
		}
		if($post_ch == '')
		{
			unset($post_ch);
		}
		
		if(isset($_POST['offer_descr_ch']))
		{
			$offer_descr_ch = $_POST['offer_descr_ch'];
		}
		if($offer_descr_ch == '')
		{
			unset($offer_descr_ch);
		}
		
		if(isset($_POST['dates_ch']))
		{
			$dates_ch = $_POST['dates_ch'];
		}
		if($dates_ch == '')
		{
			unset($dates_ch);
		}
		
		if(isset($_POST['descr_sec_lang_ch']))
		{
			$descr_sec_lang_ch = $_POST['descr_sec_lang_ch'];
		}
		if($descr_sec_lang_ch == '')
		{
			unset($descr_sec_lang_ch);
		}
		
		if(isset($_POST['offer_descr_sec_lang_ch']))
		{
			$offer_descr_sec_lang_ch = $_POST['offer_descr_sec_lang_ch'];
		}
		if($offer_descr_sec_lang_ch == '')
		{
			unset($offer_descr_sec_lang_ch);
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
		$address_sh = htmlspecialchars(stripslashes(trim($address_sh)));
					
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
		$descr_offer = nl2br(htmlspecialchars(trim(stripslashes($descr_offer))));
				
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
		$descr_sh_sec_lang = nl2br(htmlspecialchars(trim(stripslashes($descr_sh_sec_lang))));
					
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
		$descr_offer_sec_lang = nl2br(htmlspecialchars(trim(stripslashes($descr_offer_sec_lang))));
		
		if($_POST['ltd_create'])
		{			
			if(!empty($web_sh))
			{
				if(strlen($web_sh)<4 || strlen($web_sh)>40)
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_strlen_web."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
				elseif(!ereg('^([a-zA-Z0-9][a-zA-Z0-9\-]*\.)+[a-zA-Z]+$',$web_sh))
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_ereg_web."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
			}
			
			if(!empty($phone_sh))
			{
				if(strlen($phone_sh) !== 8)
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_strlen_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
				elseif(!ereg('^[0-9]+$',$phone_sh))
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_ereg_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
			}
			
			if(!empty($phone_sh_2))
			{
				if(strlen($phone_sh_2) !== 8)
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_strlen_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
				elseif(!ereg('^[0-9]+$',$phone_sh_2))
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_ereg_phone_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
			}
			
			if(!empty($fax_sh))
			{
				if(strlen($fax_sh) !== 8)
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_strlen_fax_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
				elseif(!ereg('^[0-9]+$',$fax_sh))
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_ereg_fax_sh."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
			}
			
			if(!empty($address_sh))
			{
				if(strlen($address_sh)<4 || strlen($address_sh)>60)
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_strlen_address."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
			}
			
			if(!empty($post_sh))
			{
				if(!ereg('^[0-9]+$',$post_sh))
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_eregi_post."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
				elseif(strlen($post_sh) !== 4)
				{
					change_ltd($lang,"<p class='join_us_error'>".$ltd_create_strlen_post."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
				}
			}
		//PROVERKA VLADELJCA I SU^ESTVOVANIE FIRMMI VNESTI V IZMINENIE PHOTO, PROSMOTR I UDALENIE FIRMI	
			if($lang == 'rus')
			{
				$result_check_old = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$old_sh_name'");
				$result_check_owner = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$old_sh_name' AND login = '$login'");
			}
			else
			{
				$result_check_old = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$old_sh_name'");
				$result_check_owner = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$old_sh_name' AND login = '$login'");
			}
				
			if(!mysql_num_rows($result_check_old)>0)
			{
				change_ltd($lang,"<p align='center' class='join_us_error'>".$ltd_create_ltd_check_old_1.$old_sh_name.$ltd_create_ltd_check_old_2."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);	
			}
						
			if(!mysql_num_rows($result_check_owner)>0)
			{
				change_ltd($lang,"<p align='center' class='join_us_error'>".$change_ltd_no_owner."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
			}
	//KONEC PROVERKI FIRMI	
			
				if(!empty($descr_sh))
				{
						$result_update_rus = mysql_query("UPDATE ltd_page_rus SET descr = '$descr_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
						$result_update_lat = mysql_query("UPDATE ltd_page_lat SET descr = '$descr_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				if(!empty($web_sh))
				{
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET web = '$web_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET web = '$web_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				if(!empty($phone_sh))
				{
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET phone = '$phone_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET phone = '$phone_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				if(!empty($phone_sh_2))
				{
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET phone_2 = '$phone_sh_2' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET phone_2 = '$phone_sh_2' WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				if(!empty($fax_sh))
				{
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET fax = '$fax_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET fax = '$fax_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				if(!empty($address_sh))
				{
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET address = '$address_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET address = '$address_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				if(!empty($city_sh))
				{
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET city = '$city_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET city = '$city_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					
					$result_cat_rus = mysql_query("UPDATE catalogue_rus SET city = '$city_sh' WHERE login = '$login' AND ltd_name = '$old_sh_name'");
					$result_cat_lat = mysql_query("UPDATE catalogue_lat SET city = '$city_sh' WHERE login = '$login' AND ltd_name = '$old_sh_name'");
				}
				if(!empty($post_sh))
				{
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET post = '$post_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET post = '$post_sh' WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				if(!empty($descr_offer))
				{
					if(empty($descr_offer))
					{
						change_ltd($lang,"<p class='join_us_error'>".$ltd_create_no_descr_offer."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
					}
					
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET descr_offer = '$descr_offer' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET descr_offer = '$descr_offer' WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				if(!empty($date_from) || !empty($date_till))
				{
					if(empty($date_from) && empty($date_till))
					{
						change_ltd($lang,"<p class='join_us_error'>".$ltd_create_no_dates."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
					}
					if((strlen($date_from)<10 || strlen($date_till)<10) && (strlen($date_from)>12 || strlen($date_till)>12))
					{
						change_ltd($lang,"<p class='join_us_error'>".$ltd_create_strlen_dates."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
					}
					
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET from_date_offer = '$date_from', till_date_offer = '$date_till' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET from_date_offer = '$date_from', till_date_offer = '$date_till' WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				if(!empty($descr_sh_sec_lang))
				{
					if($lang == 'rus')
					{
						$result_update_lat = mysql_query("UPDATE ltd_page_lat SET descr = '$descr_sh_sec_lang' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					}
					else
					{
						$result_update_rus = mysql_query("UPDATE ltd_page_rus SET descr = '$descr_sh_sec_lang' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					}
				}
				if(!empty($descr_offer_sec_lang))
				{
					if(empty($descr_offer_sec_lang))
					{
						change_ltd($lang,"<p class='join_us_error'>".$ltd_create_no_descr_offer_sec_lang."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
					}
					
					if($lang == 'rus')
					{
						$result_update_lat = mysql_query("UPDATE ltd_page_lat SET 
						descr_offer = '$descr_offer_sec_lang' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					}
					else
					{
						$result_update_rus = mysql_query("UPDATE ltd_page_rus SET 
						descr_offer = '$descr_sh_sec_lang' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					}
				}
				
				if(!empty($pvn))
				{
					if(empty($pvn))
					{
						change_ltd($lang,"<p class='join_us_error'>".$ltd_create_no_pvn."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
					}
					
					if($lang == 'rus')
					{
						$result_check_new_pvn = mysql_query("SELECT pvn FROM ltd_page_rus WHERE pvn = '$pvn'");
					}
					else
					{
						$result_check_new_pvn = mysql_query("SELECT pvn FROM ltd_page_lat WHERE pvn = '$pvn'");
					}
					
					if(mysql_num_rows($result_check_new_pvn)>0)
					{
						change_ltd($lang,"<p class='join_us_error'>".$ltd_create_pvn_check."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
					}
					
					mysql_query("UPDATE catalogue_rus SET activation = '0' WHERE login = '$login' AND ltd_name = '$old_sh_name'");
					mysql_query("UPDATE catalogue_lat SET activation = '0' WHERE login = '$login' AND ltd_name = '$old_sh_name'");
					
					$result_update_pvn_rus = mysql_query("UPDATE ltd_page_rus SET pvn = '$pvn', activation = '0' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_pvn_lat = mysql_query("UPDATE ltd_page_lat SET pvn = '$pvn', activation = '0' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					
				}
				
				if(!empty($sh_name))
				{
					if(empty($sh_name))
					{
						change_ltd($lang,"<p class='join_us_error'>".$ltd_create_no_shname."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);	
					}
					
					if(strlen($sh_name)>50 || strlen($sh_name)<2)
					{
						change_ltd($lang,"<p class='join_us_error'>".$ltd_create_strlen_sh_name."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
					}
					
					if($lang == 'rus')
					{
						$result_check_new_sh_name = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$sh_name'");
					}
					else
					{
						$result_check_new_sh_name = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$sh_name'");
					}
					
					if(mysql_num_rows($result_check_new_sh_name)>0)
					{
						change_ltd($lang,"<p class='join_us_error'>".$ltd_create_ltd_check."</p>",$pvn,$sh_name,$descr_sh,$web_sh,$phone_sh,$phone_sh_2,$fax_sh,$address_sh,$city_sh,$post_sh,$descr_offer,$date_from,$date_till,$descr_sh_sec_lang,$descr_offer_sec_lang,$old_sh_name,$pvn_ch,$sh_name_ch,$descr_ch,$web_ch,$phone_1_ch,$phone_2_ch,$fax_ch,$address_ch,$city_ch,$post_ch,$offer_descr_ch,$dates_ch,$descr_sec_lang_ch,$offer_descr_sec_lang_ch);
					}
					
					$result_ch_comm = mysql_query("SELECT sh_name FROM comments WHERE sh_name = '$old_sh_name'");
					if(mysql_num_rows($result_ch_comm)>0)
					{
						mysql_query("UPDATE comments SET sh_name = '$sh_name' WHERE sh_name = '$old_sh_name'");
					}
					
					$result_ch_stats = mysql_query("SELECT sh_name FROM stats WHERE sh_name = '$old_sh_name'");
					if(mysql_num_rows($result_ch_stats)>0)
					{
						mysql_query("UPDATE stats SET sh_name = '$sh_name' WHERE sh_name = '$old_sh_name'");
					}
					
					mysql_query("UPDATE catalogue_rus SET ltd_name = '$sh_name', activation = '0' WHERE login = '$login' AND ltd_name = '$old_sh_name'");
					mysql_query("UPDATE catalogue_lat SET ltd_name = '$sh_name', activation = '0' WHERE login = '$login' AND ltd_name = '$old_sh_name'");
					
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET sh_name = '$sh_name', title = '$sh_name', activation = '0' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET sh_name = '$sh_name', title = '$sh_name', activation = '0' WHERE login = '$login' AND sh_name = '$old_sh_name'");
					
					$result_check_gallery = mysql_query("SELECT * FROM gallery WHERE login = '$login' AND sh_name = '$old_sh_name'");
					$row_check_gallery = mysql_fetch_array($result_check_gallery);
					if($row_check_gallery['photo_1'] != '' || $row_check_gallery['photo_2'] != '' || 
					   $row_check_gallery['photo_3'] != '' || $row_check_gallery['photo_4'] != '' || 
					   $row_check_gallery['photo_logo'] != '')
					{
						@rename("../img/ltd/".$old_sh_name,"../img/ltd/".$sh_name);
						
						if($row_check_gallery['photo_1'] != '')
						{
							mysql_query("UPDATE gallery SET 
										photo_1 = 'img/ltd/$sh_name/1.jpeg', 
										photo_1_s = 'img/ltd/$sh_name/small/1.jpeg' 
										WHERE login = '$login' AND sh_name = '$old_sh_name'");
						}
						
						if($row_check_gallery['photo_2'] != '')
						{
							mysql_query("UPDATE gallery SET 
										photo_2 = 'img/ltd/$sh_name/2.jpeg', 
										photo_2_s = 'img/ltd/$sh_name/small/2.jpeg' 
										WHERE login = '$login' AND sh_name = '$old_sh_name'");
						}
						
						if($row_check_gallery['photo_3'] != '')
						{
							mysql_query("UPDATE gallery SET 
										photo_3 = 'img/ltd/$sh_name/3.jpeg', 
										photo_3_s = 'img/ltd/$sh_name/small/3.jpeg'
										WHERE login = '$login' AND sh_name = '$old_sh_name'");
						}
						
						if($row_check_gallery['photo_4'] != '')
						{
							mysql_query("UPDATE gallery SET 
										photo_4 = 'img/ltd/$sh_name/4.jpeg', 
										photo_4_s = 'img/ltd/$sh_name/small/4.jpeg' 
										WHERE login = '$login' AND sh_name = '$old_sh_name'");
						}
						
						if($row_check_gallery['photo_logo'] != '')
						{
							mysql_query("UPDATE gallery SET 
										photo_logo = 'img/ltd/$sh_name/logo.jpeg',
										logo_s = 'img/ltd/$sh_name/small/logo_s.jpeg'
										WHERE login = '$login' AND sh_name = '$old_sh_name'");
						}
						
						mysql_query("UPDATE gallery SET 
										sh_name = '$sh_name'
										WHERE login = '$login' AND sh_name = '$old_sh_name'");
						
					}
				}
			
				if($lang == 'rus')
				{
					$result_selec_mail = mysql_query("SELECT * FROM ltd_page_rus WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				else
				{
					$result_selec_mail = mysql_query("SELECT * FROM ltd_page_lat WHERE login = '$login' AND sh_name = '$old_sh_name'");
				}
				
				$row_select_mail = mysql_fetch_array($result_selec_mail);

				if(empty($sh_name) || empty($pvn))
				{
					$pvn = $row_select_mail['pvn'];
					$sh_name = $old_sh_name;
				}
				
				$b_def_m = $row_select_mail['b_def'];
				$def_m = $row_select_mail['defcat'];
				
				if(empty($city_sh))
				{
					$city_sh = $row_select_mail['city'];
				}
				
							$address = "admin@econom.lv";
							$sub = "LTD information update";
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
							
							For catalogue: ".$b_def_m."\n
							
							For under catalogue: ".$def_m."\n
							
							SIA post: ".$post_sh."\n
							
							Offer or Discount: ".$descr_offer."\n
							
							Offer dates from ".$date_from." till ".$date_till."\n
							
							Information presented by: ".$login."\n
							
							Senders IP: ".$ip."";
							
							$headers = 'Content-type:text/plain; charset=UTF-8';
							mail ($address,$sub,$smes,"Content-type:text/plain; charset=UTF-8\r\n");
				
				message_succes($lang,"<p align='center'>".$change_ltd_info_succ."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a>");
			
		}
		
		if($lang == 'rus')
		{
			$select_ltd_info = mysql_query("SELECT * FROM ltd_page_rus WHERE login = '$login' AND sh_name = '$old_sh_name'");
		}
		else
		{
			$select_ltd_info = mysql_query("SELECT * FROM ltd_page_lat WHERE login = '$login' AND sh_name = '$old_sh_name'");
		}
		$row_ltd_info = mysql_fetch_array($select_ltd_info);
		?>
		<table width="800px" align="center" border="0" cellpadding="2" cellspacing="0">
		<form action="change_ltd.php?lang=<?php echo $lang; ?>" method="post">
        <tr>
        <td colspan="3" align="left"><p class="stats"><?php echo $ltd_create_mand; ?></p></td>
        </tr>
		<tr>
		<td colspan="3"><input type="hidden" name="hidden" size="3" maxlength="3"></td>
		</tr>
		<?php
		if(isset($pvn_ch))
		{
			?>
            <tr>
            <td align="center" colspan="3"><p><strong><?php echo $change_ltd_pvn_warn; ?></strong></p></td>
            </tr>
            <tr>
            <td><p><?php echo $ltd_create_pvn; ?> <strong style="color:#F00">*</strong></p></td>
            <td align="right"></td>
            <td><input type="text" name="pvn" size="20" maxlength="16" value="<?php echo $row_ltd_info['pvn']; ?>" /></td>
            </tr>
            <?php
		}
		
		if(isset($sh_name_ch))
		{
			?>
            <tr>
            <td align="center" colspan="3"><p><strong><?php echo $change_ltd_name_warn; ?></strong></p></td>
            </tr>
            <tr>
			<td><p><?php echo $ltd_create_name; ?>  <strong style="color:#F00">*</strong></p></td>
            <td width="50px" align="right"></td>
			<td><input type="text" name="sh_name" size="20" maxlength="50" value="<?php echo $row_ltd_info['sh_name']; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($descr_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_descr; ?></p></td>
            <td align="right"></td>
			<td><textarea name="descr_sh" cols="40" rows="10"><?php echo $row_ltd_info['descr']; ?></textarea></td>
			</tr>
            <?php	
		}

		if(isset($web_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_web; ?></p></td>
            <td align="right"><p>www.</p></td>
			<td><input type="text" name="web_sh" size="20" maxlength="40" value="<?php echo $row_ltd_info['web']; ?>" /></td>
			</tr>
            <?php	
		}
		
		if(isset($phone_1_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_phone; ?></p></td>
            <td align="right"><p>+ 371</p></td>
			<td><input type="text" name="phone_sh" size="8" maxlength="8" value="<?php echo $row_ltd_info['phone']; ?>" /></td>
            </tr>
            <?php
		}
		
		if(isset($phone_2_ch))
		{
			?>
            <tr>
            <td></td>
            <td align="right"><p>+ 371</p></td>
			<td><input type="text" name="phone_sh_2" size="8" maxlength="8" value="<?php echo $row_ltd_info['phone_2']; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($fax_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_fax; ?></p></td>
            <td align="right"><p>+ 371</p></td>
			<td><input type="text" name="fax_sh" size="8" maxlength="8" value="<?php echo $row_ltd_info['fax']; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($address_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_addres; ?></p></td>
            <td align="right"></td>
			<td><input type="text" name="address_sh" size="20" maxlength="60" value="<?php echo $row_ltd_info['address']; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($city_ch))
		{
			?>
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
            <?php
		}
		
		if(isset($post_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_post; ?></p></td>
            <td align="right"><p>LV -</p></td>
			<td><input type="text" name="post_sh" size="4" maxlength="4"  value="<?php echo $row_ltd_info['post']; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($offer_descr_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_descr_offer; ?> <strong style="color:#F00">*</strong></p></td>
            <td align="right"></td>
			<td><textarea name="descr_offer" cols="40" rows="10"><?php echo $row_ltd_info['descr_offer']; ?></textarea></td>
			</tr>
            <?php
		}
		
		if(isset($dates_ch))
		{
			?>
            <tr>
			<td><p><?php echo $ltd_create_dates; ?></p></td>
            <td align="right"><p><?php echo $ltd_create_dates_from; ?>: <strong style="color:#F00">*</strong></p></td>
			<td><input type="text" name="from_date_offer" size="20" maxlength="12" class="date_input" value="<?php echo $row_ltd_info['from_date_offer']; ?>" /></td>
            </tr>
            <tr>
            <td></td>
            <td align="right"><p><?php echo $ltd_create_dates_till; ?>: <strong style="color:#F00">*</strong></p></td>
			<td><input type="text" name="till_date_offer" size="20" maxlength="12" class="date_input" value="<?php echo $row_ltd_info['till_date_offer']; ?>" /></td>
			</tr>
            <?php
		}
		
		if(isset($descr_sec_lang_ch))
		{
			if($lang == 'rus')
			{
				$select_ltd_info = mysql_query("SELECT descr FROM ltd_page_lat WHERE login = '$login' AND sh_name = '$old_sh_name'");
			}
			else
			{
				$select_ltd_info = mysql_query("SELECT descr FROM ltd_page_rus WHERE login = '$login' AND sh_name = '$old_sh_name'");
			}
			$row_ltd_info = mysql_fetch_array($select_ltd_info);
			?>
            <tr>
			<td><p><?php echo $ltd_create_descr_sec_lang; ?></p></td>
            <td></td>
			<td><textarea name="descr_sh_sec_lang" cols="40" rows="10"><?php echo $row_ltd_info['descr']; ?></textarea></td>
			</tr>
            <?php
		}
		
		if(isset($offer_descr_sec_lang_ch))
		{
			if($lang == 'rus')
			{
				$select_ltd_info = mysql_query("SELECT descr_offer FROM ltd_page_lat WHERE login = '$login' AND sh_name = '$old_sh_name'");
			}
			else
			{
				$select_ltd_info = mysql_query("SELECT descr_offer FROM ltd_page_rus WHERE login = '$login' AND sh_name = '$old_sh_name'");
			} 
			$row_ltd_info = mysql_fetch_array($select_ltd_info);
			
			?>
            <tr>
			<td><p><?php echo $ltd_create_descr_offer_sec_lang; ?> <strong style="color:#F00">*</strong></p></td>
            <td></td>
			<td><textarea name="descr_offer_sec_lang" cols="40" rows="10"><?php echo $row_ltd_info['descr_offer']; ?></textarea></td>
			</tr>
            <?php
		}
		?>
        <tr>
        <td colspan="3"><input type="hidden" name="ltd" value="<?php echo $old_sh_name; ?>" /></td>
        </tr>
        <tr>
        <td colspan="3">
        <?php if(isset($sh_name_ch))
		{
        	echo "<input type='hidden' name='sh_name_ch' value='1' />";
		}
		if(isset($pvn_ch))
		{
        	echo "<input type='hidden' name='pvn_ch' value='2' />";
		}
		if(isset($descr_ch))
		{
        	echo "<input type='hidden' name='descr_ch' value='3' />";
		}
		if(isset($web_ch))
		{
        	echo "<input type='hidden' name='web_ch' value='4' />";
		}
		if(isset($phone_1_ch))
		{
        	echo "<input type='hidden' name='phone_1_ch' value='5' />";
		}
		if(isset($phone_2_ch))
		{
        	echo "<input type='hidden' name='phone_2_ch' value='6' />";
		}
		if(isset($fax_ch))
		{
        	echo "<input type='hidden' name='fax_ch' value='7' />";
		}
		if(isset($address_ch))
		{
        	echo "<input type='hidden' name='address_ch' value='8' />";
		}
		if(isset($city_ch))
		{
        	echo "<input type='hidden' name='city_ch' value='9' />";
		}
		if(isset($post_ch))
		{
        	echo "<input type='hidden' name='post_ch' value='10' />";
		}
		if(isset($offer_descr_ch))
		{
        	echo "<input type='hidden' name='offer_descr_ch' value='11' />";
		}
		if(isset($dates_ch))
		{
        	echo "<input type='hidden' name='dates_ch' value='12' />";
		}
		if(isset($descr_sec_lang_ch))
		{
        	echo "<input type='hidden' name='descr_sec_lang_ch' value='13' />";
		}
		if(isset($offer_descr_sec_lang_ch))
		{
        	echo "<input type='hidden' name='offer_descr_sec_lang_ch' value='14' />";
		}
		?>
		</td>
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
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
	header("Location: ../login.php?lang=".$lang."");
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
<title><?php echo $ltd_create_opt_title; ?></title>
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
	$result = mysql_query("SELECT login,passwd FROM users WHERE login = '$login' AND passwd = '$passwd'");
	$row_user_db = mysql_fetch_array($result);
	$login_db = $row_user_db['login'];
	$passwd_db = $row_user_db['passwd'];
	if(mysql_num_rows($result)>0 && $login === $login_db && $passwd === $passwd_db)
	{	
			?>
			<table width="80%" align="center" border="0" cellpadding="10px" cellspacing="0">
			<tr>
			<td colspan="2" align="center"><h4><?php echo $ltd_create_opt; ?></h4></td>
			</tr>
            <tr>
            <td align="left" colspan="2"><p><?php echo $ltd_create_opt_ch_cat; ?></p></td>
            </tr>
            <tr valign="top">
        	<td width="300px" style="padding-left:75px;">
            <?php
            if($lang == 'rus')
            {
                $query_b_def = mysql_query("SELECT b_def FROM cat_create_rus GROUP BY b_def ORDER BY b_def");
            }
            else
            {
                $query_b_def = mysql_query("SELECT b_def FROM cat_create_lat GROUP BY b_def ORDER BY b_def");
            }
            
            while($cat_b_def = mysql_fetch_array($query_b_def))
            {
                echo "<div id='catalogue'><a href=".$_SERVER['PHP_SELF']."?lang=".$lang."&b_def=".urlencode($cat_b_def['b_def']).">".$cat_b_def['b_def']."</a></div>";
            }
            ?>
            </td><td>
            <?php
            if($lang == 'rus')
            {
                $query_def = mysql_query("SELECT def FROM cat_create_rus WHERE b_def = '".$_GET['b_def']."' GROUP BY def ORDER BY def");
            }
            else
            {
                $query_def = mysql_query("SELECT def FROM cat_create_lat WHERE b_def = '".$_GET['b_def']."' GROUP BY def ORDER BY def");
            }
            
            if(mysql_num_rows($query_def)>0)
            {
                while($cat_def = mysql_fetch_array($query_def))
                {
                    echo "<div id='catalogue'><a href=".$_SERVER['PHP_SELF']."?lang=".$lang."&b_def=".urlencode($_GET['b_def'])."&def=".urlencode($cat_def['def']).">".$cat_def['def']."</a></div>";
                }
            }
            
            $b_def = $_GET['b_def'];
            $def = $_GET['def'];
            ?>
            </td>
            </tr>
            </table>
            <table align="center" width="75%" border="0" cellpadding="0" cellspacing="0">
            <tr>
            <td colspan="2" style="padding-top:30px; padding-left:40px;"><?php echo "<p>".$change_cat_ch_bdef.": <strong>".$b_def."</strong><br />".$change_cat_ch_def.": <strong>".$def."</strong></p>"; ?></td>
            </tr>
            <tr>
                <form method="POST" action="ltd_create.php?lang=<?php echo $lang; ?>"> 
                <td><p><?php echo $ltd_create_opt_3; ?>: </p></td>
                <td> <select name="lang_choise">
                <?php if($lang == 'rus')
                {
                ?>
                    <option value='one_lang'>Контент на русском языке</option>
                    <option value='two_lang'>Контент на русском и латышском языках</option>
                <?php	
                }
                else
                {
                    ?>
                    <option value='one_lang'>Saturs latviešu valodā</option>
                    <option value='two_lang'>Saturs latviešu un krievu valodās</option>
                <?php    
                } ?>
                </select></td>
                </tr>
                <tr>
                <td><p><?php echo $ltd_create_opt_4; ?>: </p></td>
                <td><select name="photo_choise">
                <?php if($lang == 'rus')
                {
                    ?>
                    <option value='photo_no'>Нет</option><option value='photo_yes'>Да</option>
                    <?php
                }
                else
                {
                    ?>
                    <option value='photo_no'>Nē</option><option value='photo_yes'>Jā</option>
                    <?php
                } ?>
                </select></td>
                </tr>
                <tr>
                <td><input name="b_def" type="hidden" value="<?php echo $b_def; ?>" /></td>
                <td><input name="def" type="hidden" value="<?php echo $def; ?>" /></td>
                </tr>
                <?php 
            if(!empty($b_def) && !empty($def))
            {
              ?> 
                <tr>
                <td align="center" colspan="2"><input name="submit_opt" type="submit" value="<?php echo $ltd_create_opt_but; ?>"></td>
                </form>
            </tr>
            	<?php
			}
			?>
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
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
mysql_query("SET NAMES 'utf-8'");
mysql_query("SET CHARACTER SET 'utf8'");
if ($lang == "rus")
$result = mysql_query ("SELECT * FROM common_text_rus WHERE page='index'",$db); 
else
$result = mysql_query ("SELECT * FROM common_text_lat WHERE page='index'",$db);
?>
<?php if (!$result)
{
echo "<p align='center'>Error no 1.
<br>Please report to administration through admin@econom.lv</p>";
exit (mysql_error());
}
if (mysql_num_rows($result) > 0)
{
$myrow = mysql_fetch_array ($result);
}
else {
echo "<p align='center'>Error no 2. <br> Please report to administration through admin@econom.lv</p>";
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $myrow["meta_k"]?>;" />
<meta name="description" content="<?php echo $myrow["meta_d"]?>;" />
<title><?php echo $myrow["title"] ?></title>
<META HTTP-EQUIV="EconomLV" CONTENT="cache" />
<META HTTP-EQUIV="Pragma" CONTENT="cache" />
<meta name="robots" content="INDEX,NO-FOLLOW"> 
<meta name="revisit-after" content="1 week"> 
<meta http-equiv="content-language" content="Russian, Latvian"> 
<meta name="author" content="Econom LV">  
<meta name="publisher" content="Econom LV">  
<meta name="made" content="admin@econom.lv">  
<meta name="copyright" content="www.econom.lv">  
<meta name="audience" content="All">  
<meta name="page-topic" content="EconomLV - Все скидки Латвии - Atlaides Latvijā."> 
<link href="../CSS/eccss.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>
<link rel="stylesheet" media="screen" type="text/css" title="StyleIE7" href="../CSS/ie7.css" />
<![endif]-->
<script type="text/javascript">
if(window.opera) {document.write('<link rel="stylesheet" type="text/css" href="../CSS/opera.css" />');}
</script>
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
<link href="../CSS/promocss.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/promojs.js"></script>
<script type="text/javascript" src="../js/jquery.cycle.lite.js"></script>
<script type="text/javascript" src="../js/fade_start.js"></script>
<noscript>
<meta http-equiv="refresh" content="0; url=index_nosrc.php?lang=<?php echo $lang; ?>" />
</noscript>
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
    <td colspan="3">
    
    <table border="0" cellpadding="3" cellspacing="0">
    <tr><td valign="top">
    <table width="250px" class="table_style_text"><tr><td>
	<?php eval ($myrow['text']); ?>
    </td></tr></table></td>
    <td valign="top"><h3 align="center" class="p_style" style="margin-bottom:5px; color:#333;"><?php echo $index_top_last; ?></h3>
    <?php
	if($lang == 'rus')
	{
		$ltd_result = mysql_query("SELECT sh_name,descr_offer,city,b_def,defcat,from_date_offer,till_date_offer FROM ltd_page_rus WHERE activation = '1' ORDER BY id DESC LIMIT 5");
	}
	else
	{
		$ltd_result = mysql_query("SELECT sh_name,descr_offer,city,b_def,defcat,from_date_offer,till_date_offer FROM ltd_page_lat WHERE activation = '1' ORDER BY id DESC LIMIT 5");
	}
	
	while($ltd_row = mysql_fetch_array($ltd_result))
	{
		$offer = substr($ltd_row['descr_offer'], 0, 200);
		$offer = str_replace("<br />", "", $offer);
		$sh_name = $ltd_row['sh_name'];
	?>
        <table width="100%" class="table_style" style="margin-bottom:5px;" border="0" cellpadding="0" cellspacing="0"><tr>
        <td><?php 
		$gallery_resutl = mysql_query("SELECT photo_1_s,photo_2_s,photo_3_s,photo_4_s,logo_s FROM gallery WHERE sh_name = '$sh_name'"); 
		$gallery_row = mysql_fetch_array($gallery_resutl);
		if($gallery_row['logo_s'] !== '')
		{
			echo "<img style='position:relative; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px;' src='../".$gallery_row['logo_s']."' alt='".$sh_name."' />";
		}
		else
		{
			echo "";
		}
		?></td>
        <td>
            <table style="margin-left:10px; margin-right:10px;" border="0" cellpadding="0" cellspacing="0">
            <tr>
            <td><a class="a_index" href="page.php?lang=<?php echo $lang; ?>&city=<?php echo urlencode($ltd_row['city']); ?>&b_def=<?php echo urlencode($ltd_row['b_def']); ?>&defcat=<?php echo urlencode($ltd_row['defcat']); ?>&link=<?php echo urlencode($ltd_row['sh_name']); ?>"><?php echo $sh_name; ?></a></td>
            </tr>
            <tr>
            <td width="450px"><p><?php echo mb_convert_encoding($offer, "utf8", "utf8")." ..."; ?></p></td>
            </tr>
            </table>
        </td>
        <td width="80px" valign="middle">
       	<?php if(!empty($gallery_row['photo_1_s']) || !empty($gallery_row['photo_2_s']) || !empty($gallery_row['photo_3_s']) || !empty($gallery_row['photo_4_s']))
		{
         ?>   
            <div class="slideshow">	
            <?php if(!empty($gallery_row['photo_1_s']))
                {
					?>
						<img src="../<?php echo $gallery_row['photo_1_s']; ?>" alt="<?php echo $sh_name; ?>" />
                    <?php
				}
				
				if(!empty($gallery_row['photo_2_s']))
				{
					?>
						<img src="../<?php echo $gallery_row['photo_2_s']; ?>" alt="<?php echo $sh_name; ?>" />
                    <?php
				}		
				
				if(!empty($gallery_row['photo_3_s']))
				{
					?>
						<img src="../<?php echo $gallery_row['photo_3_s']; ?>" alt="<?php echo $sh_name; ?>" />
                    <?php
				}	
                    	
				if(!empty($gallery_row['photo_4_s']))
				{
					?>		
						<img src="../<?php echo $gallery_row['photo_4_s']; ?>" alt="<?php echo $sh_name; ?>" />
                    <?php
				}
				?>
				</div>
         <?php
		}
		?>
		</td>
        <tr>
        <td colspan="3" align="left" valign="bottom" height="20px">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                <?php if($lang == 'rus')
				{
					$td_date_width = '200px';
					$td_till_width = '130px';
				}
				else
				{
					$td_date_width = '200px';
					$td_till_width = '180px';
				}
				?>
                <td class="stats" align="left" width="<?php echo $td_date_width; ?>"><?php echo $profile_dates_td; ?></td>
                <td class="stats" align="left"><?php echo  $ltd_create_dates_from.": ".str_replace(" ","",$ltd_row['from_date_offer']); ?></td>
                <td class="stats" align="left" width="<?php echo $td_till_width; ?>"><?php echo $ltd_create_dates_till.": ".str_replace(" ","",$ltd_row['till_date_offer']); ?></td>
                	
                <td class="stats" align="right"><?php echo $rat_com_rew_head; ?></td>
                <td class="stats" align="right">
                <?php
				$result_com_count_1 = mysql_query("SELECT COUNT(message) FROM comments WHERE sh_name = '$sh_name'");
                $row_com_count_1 = mysql_fetch_array($result_com_count_1);
				if(mysql_num_rows($result_com_count_1)>0)
				{
					echo $row_com_count_1[0];
				}
				else
				{
					echo "0";
				}
				?>
                </td>
                </tr>
                </table>
                </td>
        </tr>
        </table>
    <?php
	}	
	//vivod topa
	$result_top_select = mysql_query("SELECT sh_name,SUM(votes) FROM top_index GROUP BY sh_name ORDER BY SUM(votes) DESC LIMIT 5");
	if(mysql_num_rows($result_top_select)>0)
	{
		?>
		<h3 align="center" class="p_style" style="margin-bottom:5px; margin-top:15px; color:#333;"><?php echo $index_top_views; ?></h3>
		<?php
		while($row_top_shname = mysql_fetch_array($result_top_select))
		{
			$top_shname = $row_top_shname['sh_name'];
			
			if($lang == 'rus')
			{
				$result_select_top_ltd = mysql_query("SELECT sh_name,descr_offer,city,b_def,defcat,from_date_offer,till_date_offer FROM ltd_page_rus WHERE activation = '1' AND sh_name = '$top_shname'");
			}
			else
			{
				$result_select_top_ltd = mysql_query("SELECT sh_name,descr_offer,city,b_def,defcat,from_date_offer,till_date_offer FROM ltd_page_lat WHERE activation = '1' AND sh_name = '$top_shname'");
			}
			
			while($row_select_top_ltd = mysql_fetch_array($result_select_top_ltd))
			{
				$offer_top = substr($row_select_top_ltd['descr_offer'], 0, 200);
				$offer_top = str_replace("<br />", "", $offer_top);
				$sh_name_top = $row_select_top_ltd['sh_name'];
				?>
				<table width="100%" class="table_style" style="margin-bottom:5px;" cellpadding="0" cellspacing="0">
				<tr>
				<td>
                <?php
				$result_galerry_top = mysql_query("SELECT photo_1_s,photo_2_s,photo_3_s,photo_4_s,logo_s FROM gallery WHERE sh_name = '$sh_name_top'");
                $row_gallery_top = mysql_fetch_array($result_galerry_top);
				if($row_gallery_top['logo_s'] !== '')
				{
					echo "<img style='position:relative; -moz-border-radius:10px; -webkit-border-radius:10px; border-radius:10px;' src='../".$row_gallery_top['logo_s']."' alt='".$sh_name_top."' />";
				}
				else
				{
					echo "";
				}
				?>
				</td>
                <td>
                        <table style="margin-left:10px; margin-right:10px;" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                        <td><a class="a_index" href="page.php?lang=<?php echo $lang; ?>&city=<?php echo urlencode($row_select_top_ltd['city']); ?>&b_def=<?php echo urlencode($row_select_top_ltd['b_def']); ?>&defcat=<?php echo urlencode($row_select_top_ltd['defcat']); ?>&link=<?php echo urlencode($row_select_top_ltd['sh_name']); ?>"><?php echo $sh_name_top; ?></a></td>
                        </tr>
                        <tr>
                        <td width="450px"><p><?php echo mb_convert_encoding($offer_top, "utf8", "utf8")." ..."; ?></p></td>
                        </tr>
                        </table>
                </td>
                <td width="80px" valign="middle">
				<?php if(!empty($row_gallery_top['photo_1_s']) || !empty($row_gallery_top['photo_2_s']) || !empty($row_gallery_top['photo_3_s']) || !empty($row_gallery_top['photo_4_s']))
                {
                 ?>   
                    <div class="slideshow">	
                    <?php if(!empty($row_gallery_top['photo_1_s']))
                        {
                            ?>
                                <img src="../<?php echo $row_gallery_top['photo_1_s']; ?>" alt="<?php echo $sh_name_top; ?>" />
                            <?php
                        }
                        
                        if(!empty($row_gallery_top['photo_2_s']))
                        {
                            ?>
                                <img src="../<?php echo $row_gallery_top['photo_2_s']; ?>" alt="<?php echo $sh_name_top; ?>" />
                            <?php
                        }		
                        
                        if(!empty($row_gallery_top['photo_3_s']))
                        {
                            ?>
                                <img src="../<?php echo $row_gallery_top['photo_3_s']; ?>" alt="<?php echo $sh_name_top; ?>" />
                            <?php
                        }	
                                
                        if(!empty($row_gallery_top['photo_4_s']))
                        {
                            ?>		
                                <img src="../<?php echo $row_gallery_top['photo_4_s']; ?>" alt="<?php echo $sh_name_top; ?>" />
                            <?php
                        }
                        ?>
                        </div>
                 <?php
                }
                ?>
                </td>
				</tr>
                <tr>
                <td colspan="3" align="left" valign="bottom" height="20px">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                <?php if($lang == 'rus')
				{
					$td_date_width = '200px';
					$td_till_width = '130px';
				}
				else
				{
					$td_date_width = '200px';
					$td_till_width = '180px';
				}
				?>
                <td class="stats" align="left" width="<?php echo $td_date_width; ?>"><?php echo $profile_dates_td; ?></td>
                <td class="stats" align="left"><?php echo  $ltd_create_dates_from.": ".str_replace(" ","",$row_select_top_ltd['from_date_offer']); ?></td>
                <td class="stats" align="left" width="<?php echo $td_till_width; ?>"><?php echo $ltd_create_dates_till.": ".str_replace(" ","",$row_select_top_ltd['till_date_offer']); ?></td>
                	
                <td class="stats" align="right"><?php echo $rat_com_rew_head; ?></td>
                <td class="stats" align="right">
                <?php
				$result_com_count = mysql_query("SELECT COUNT(message) FROM comments WHERE sh_name = '$sh_name_top'");
                $row_com_count = mysql_fetch_array($result_com_count);
				if(mysql_num_rows($result_com_count)>0)
				{
					echo $row_com_count[0];
				}
				else
				{
					echo "0";
				}
				?>
                </td>
                </tr>
                </table>
                </td>
                </tr>
				</table>
		<?php
			}
		}
	}
	?>
    </td>
    <td valign="top" width="105px"><?php echo $promoright_user." ".$promoleft_user; ?></td>
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
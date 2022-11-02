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
<title><?php echo $upload_title; ?></title>
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
	$result_user = mysql_query("SELECT login,passwd FROM users WHERE login = '$login' AND passwd = '$passwd'");
	$row_user = mysql_fetch_array($result_user);
	$login_db = $row_user['login'];
	$passwd_db = $row_user['passwd'];
	if(mysql_num_rows($result_user)>0 && $login === $login_db && $passwd === $passwd_db)
	{	if(isset($_GET['ltd']))
			{
				$sh_name = $_GET['ltd'];
				$sh_name = htmlspecialchars(stripslashes(trim($sh_name)));
			}
			
			if(isset($_POST['sh_name']))
			{
				$sh_name = $_POST['sh_name'];
				$sh_name = htmlspecialchars(stripslashes(trim($sh_name)));
			}
			
			if($sh_name == '')
			{
				unset($sh_name);
				exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
			}
			
			if($lang == 'rus')
			{
				$result_check_old = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$sh_name'");
				$result_check_owner = mysql_query("SELECT sh_name FROM ltd_page_rus WHERE sh_name = '$sh_name' AND login = '$login'");
			}
			else
			{
				$result_check_old = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$sh_name'");
				$result_check_owner = mysql_query("SELECT sh_name FROM ltd_page_lat WHERE sh_name = '$sh_name' AND login = '$login'");
			}
					
			if(!mysql_num_rows($result_check_old)>0)
			{
				  message_succes($lang,"<p align='center' class='join_us_error'>".$ltd_create_ltd_check_old_1.$sh_name.$ltd_create_ltd_check_old_2."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
			}
							
			if(!mysql_num_rows($result_check_owner)>0)
			{
				  message_succes($lang,"<p align='center' class='join_us_error'>".$change_ltd_no_owner."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
			}
							
			if ($_POST['doUpload']) 
			{  
				$createdir = "../img/ltd/".$sh_name."/";
				@mkdir ($createdir); //vozmozhno nado ustanovitj prava @mkdir ($createdir,0777); dlja servera
			
				$imgDir = "../img/ltd/".$sh_name."/"; 
				$imgDir_small = "../img/ltd/".$sh_name."/small/";
				@mkdir($imgDir_small); // создаем каталог, если его еще нет  (, 0777) - vozmozhnoe dobavlenie dlja servera
				if(isset($_FILES['userfile']))
				{
					$id = 1;
					$a = 1;
					
					$data = $_FILES['userfile'];  
					$tmp = $data['tmp_name'];
					if ($_FILES['userfile']['size'] > 2000000 || $_FILES['userfile']['error'] > 0)
					{
						echo "<p class='join_us_error'>".$upload_max_size." 1</p>";
						unset($_FILES['userfile']['tmp_name']);
					}
					else
					{
						$info = @getimagesize($_FILES['userfile']['tmp_name']);
	 
						if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',$_FILES['userfile']['name']))
						{ 
							$newwidth = 350;  
							$newwidth1 = 80;
		 
							$newname = $imgDir.$id.".".basename($info['mime']); 
							$newname1 = $imgDir_small.$a.".".basename($info['mime']);                                                                                                                   
							if(resize($tmp, $newwidth, $newname) and resize1($tmp, $newwidth1, $newname1))
							{  
								echo $upload_fail." ".$_FILES['userfile']['name']." ".$upload_succ_uploaded."<br>"; 
								$photo_1 = "img/ltd/".$sh_name."/".$id.".".basename($info['mime']);
								$photo_1_small = "img/ltd/".$sh_name."/small/".$a.".".basename($info['mime']);
							}  
							else 
							{  
								echo "<p class='join_us_error'>".$upload_err." 1</p>";
								unset($_FILES['userfile']['tmp_name']);
							}  
						}  
						else 
						{  
							echo "<p class='join_us_error'>".$upload_no_format." 1</p>";
							unset($_FILES['userfile']['tmp_name']);
						}
					}
				}
							
				if(isset($_FILES['userfile1']))
				{
					$id = 2;
					$a = 2;
					
					$data = $_FILES['userfile1'];  
					$tmp = $data['tmp_name'];
					if ($_FILES['userfile1']['size'] > 2000000 || $_FILES['userfile1']['error'] > 0)
					{
						echo "<p class='join_us_error'>".$upload_max_size." 2</p>";
						unset($_FILES['userfile1']['tmp_name']);
					}
					else
					{
						$info = @getimagesize($_FILES['userfile1']['tmp_name']);
					
						if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',$_FILES['userfile1']['name']))
						{  
							$newwidth = 350;   
							$newwidth1 = 80;
		 
							$newname = $imgDir.$id.".".basename($info['mime']);
							$newname1 = $imgDir_small.$a.".".basename($info['mime']);                                                                                                     
							if(resize($tmp, $newwidth, $newname) and resize1($tmp, $newwidth1, $newname1))
							{  
								echo $upload_fail." ".$_FILES['userfile1']['name']." ".$upload_succ_uploaded."<br>";
								$photo_2 = "img/ltd/".$sh_name."/".$id.".".basename($info['mime']);
								$photo_2_small = "img/ltd/".$sh_name."/small/".$a.".".basename($info['mime']);
							}  
							else 
							{  
								echo "<p class='join_us_error'>".$upload_err." 2</p>";
								unset($_FILES['userfile1']['tmp_name']);
							}  
						}  
						else 
						{  
							echo "<p class='join_us_error'>".$upload_no_format." 2</p>";
							unset($_FILES['userfile1']['tmp_name']);
						}
					}
				}
							
				if(isset($_FILES['userfile2']))
				{
					$id = 3;
					$a = 3;
					
					$data = $_FILES['userfile2'];  
					$tmp = $data['tmp_name'];   
					if ($_FILES['userfile2']['size'] > 2000000 || $_FILES['userfile2']['error'] > 0)
					{
						echo "<p class='join_us_error'>".$upload_max_size." 3</p>";
						unset($_FILES['userfile2']['tmp_name']);
					}
					else
					{
						$info = @getimagesize($_FILES['userfile2']['tmp_name']);
	 
						if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',$_FILES['userfile2']['name']))
						{ 
							$newwidth = 350;   
							$newwidth1 = 80; 
		 
							$newname = $imgDir.$id.".".basename($info['mime']);
							$newname1 = $imgDir_small.$a.".".basename($info['mime']);                                                                                                                    
							if(resize($tmp, $newwidth, $newname) and resize1($tmp, $newwidth1, $newname1))
							{  
								echo $upload_fail." ".$_FILES['userfile2']['name']." ".$upload_succ_uploaded."<br>"; 
								$photo_3 = "img/ltd/".$sh_name."/".$id.".".basename($info['mime']);
								$photo_3_small = "img/ltd/".$sh_name."/small/".$a.".".basename($info['mime']);
							}  
							else 
							{  
								echo "<p class='join_us_error'>".$upload_err." 3</p>";
								unset($_FILES['userfile2']['tmp_name']);
							}  
						}  
						else 
						{  
							echo "<p class='join_us_error'>".$upload_no_format." 3</p>";
							unset($_FILES['userfile2']['tmp_name']);
						}
					}
				}
							
				if(isset($_FILES['userfile3']))
				{
					$id = 4;
					$a = 4;
					
					$data = $_FILES['userfile3'];  
					$tmp = $data['tmp_name'];   
					if ($_FILES['userfile3']['size'] > 2000000 || $_FILES['userfile3']['error'] > 0)
					{
						echo "<p class='join_us_error'>".$upload_max_size." 4</p>";
						unset($_FILES['userfile3']['tmp_name']);
					}
					else
					{
						$info = @getimagesize($_FILES['userfile3']['tmp_name']);
	 
						if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',$_FILES['userfile3']['name']))
						{ 
							$newwidth = 350;  
							$newwidth1 = 80;
		 
							$newname = $imgDir.$id.".".basename($info['mime']);
							$newname1 = $imgDir_small.$a.".".basename($info['mime']);                                                                                                                     
							if(resize($tmp, $newwidth, $newname) and resize1($tmp, $newwidth1, $newname1))
							{  
								echo $upload_fail." ".$_FILES['userfile3']['name']." ".$upload_succ_uploaded."<br>"; 
								$photo_4 = "img/ltd/".$sh_name."/".$id.".".basename($info['mime']);
								$photo_4_small = "img/ltd/".$sh_name."/small/".$a.".".basename($info['mime']);
							}  
							else 
							{  
								echo "<p class='join_us_error'>".$upload_err." 4</p>";
								unset($_FILES['userfile3']['tmp_name']);
							}  
						}  
						else 
						{  
							echo "<p class='join_us_error'>".$upload_no_format." 4</p>";
							unset($_FILES['userfile3']['tmp_name']);
						}		
					}
				}
							
				if(isset($_FILES['userfile4']))
				{
					$id = "logo";
					$a = "logo_s";
					
					$data = $_FILES['userfile4'];  
					$tmp = $data['tmp_name'];  
					if ($_FILES['userfile4']['size'] > 2000000 || $_FILES['userfile4']['error'] > 0)
					{
						echo "<p class='join_us_error'>".$upload_max_size_logo."</p>";
						unset($_FILES['userfile4']['tmp_name']);
					}
					else
					{
						$info = @getimagesize($_FILES['userfile4']['tmp_name']);
	 
						if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/',$_FILES['userfile4']['name']))
						{  
							$newwidth = 350;  
							$newwidth1 = 80;
		 
							$newname = $imgDir.$id.".".basename($info['mime']);
							$newname1 = $imgDir_small.$a.".".basename($info['mime']);
							
							if(resize_logo($tmp, $newwidth, $newname) and resize1($tmp, $newwidth1, $newname1))
							{  
								echo $upload_logo." ".$_FILES['userfile4']['name']." ".$upload_succ_uploaded."<br>";
								$logo_insert = "img/ltd/".$sh_name."/".$id.".".basename($info['mime']);
								$logo_insert_small = "img/ltd/".$sh_name."/small/".$a.".".basename($info['mime']);
							}  
							else 
							{  
								echo "<p class='join_us_error'>".$upload_err_logo."</p>";
								unset($_FILES['userfile4']['tmp_name']);
							}  
						}  
						else 
						{  
							echo "<p class='join_us_error'>".$upload_no_format_logo."</p>";
							unset($_FILES['userfile4']['tmp_name']);
						}
					}
				}
				
				$result_gallery_check = mysql_query("SELECT * FROM gallery WHERE login = '$login' AND sh_name = '$sh_name'");
				if(mysql_num_rows($result_gallery_check)>0)
				{					
					if(!empty($_FILES['userfile']['tmp_name']) && $_FILES['userfile']['error'] === 0)
					{
						$result = mysql_query("UPDATE gallery SET photo_1 = '$photo_1', photo_1_s = '$photo_1_small'  WHERE login = '$login' AND sh_name = '$sh_name'");
					}
					if(!empty($_FILES['userfile1']['tmp_name']) && $_FILES['userfile1']['error'] === 0)
					{
						$result = mysql_query("UPDATE gallery SET photo_2 = '$photo_2', photo_2_s = '$photo_2_small' WHERE login = '$login' AND sh_name = '$sh_name'");
					}
					if(!empty($_FILES['userfile2']['tmp_name']) && $_FILES['userfile2']['error'] === 0)
					{
						$result = mysql_query("UPDATE gallery SET photo_3 = '$photo_3', photo_3_s = '$photo_3_small' WHERE login = '$login' AND sh_name = '$sh_name'");
					}
					if(!empty($_FILES['userfile3']['tmp_name']) && $_FILES['userfile3']['error'] === 0)
					{
						$result = mysql_query("UPDATE gallery SET photo_4 = '$photo_4', photo_4_s = '$photo_4_small' WHERE login = '$login' AND sh_name = '$sh_name'");
					}
					if(!empty($_FILES['userfile4']['tmp_name']) && $_FILES['userfile4']['error'] === 0)
					{
						$result = mysql_query("UPDATE gallery SET photo_logo = '$logo_insert', logo_s = '$logo_insert_small' WHERE login = '$login' AND sh_name = '$sh_name'");
					}
										
						if(!$result)
						{
							upload_footer($lang,"<p class='join_us_error'>".$upload_err."</p>");
						}
						else
						{
							message_succes($lang,"<p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
						}
				}
				else
				{
					if(!empty($_FILES['userfile']['tmp_name']) || !empty($_FILES['userfile1']['tmp_name']) 
						|| !empty($_FILES['userfile2']['tmp_name']) || !empty($_FILES['userfile3']['tmp_name']) 
						|| !empty($_FILES['userfile4']['tmp_name']))
					{
						$result = mysql_query("INSERT INTO gallery VALUES ('$login','$sh_name','$photo_1','$photo_2','$photo_3','$photo_4','$logo_insert','$photo_1_small','$photo_2_small',
											  '$photo_3_small','$photo_4_small','$logo_insert_small')");
							
						if(!$result)
						{
							 upload_footer($lang,"<p class='join_us_error'>".$upload_err."</p>");
						}
						else
						{
							message_succes($lang,"<p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
						}
					}
				}				
			}
			
			if($_FILES['userfile']['error']>0 || $_FILES['userfile1']['error']>0 || $_FILES['userfile2']['error']>0 || $_FILES['userfile3']['error']>0 || $_FILES['userfile4']['error']>0)
			{
				echo "<br /><hr />";
			}
			
			?>
			<form action='upload.php?lang=<?php echo $lang; ?>' method='post' enctype='multipart/form-data' >
            <table width='500' border='0' cellpadding="0" cellspacing="0" align='center'>
              <tr>
                <td colspan='2'><h4 align="center"><?php echo $form_pict; ?></h4></td>
              </tr>
              <tr>
              <td colspan="2"><p><strong><?php echo $upload_message; ?></strong></p></td>
              </tr>
              <tr>
                <td><p><?php echo $picture; ?> 1: </p></td>
                <td><input type='file' name='userfile' /></td>
                </td>
              </tr>
              <tr>
                <td><p><?php echo $picture; ?> 2: </p></td>
                <td><input type='file' name='userfile1' /></td>
                </tr>
              <tr>
                <td><p><?php echo $picture; ?> 3: </p></td>
                <td><input type='file' name='userfile2' /></td>
                </tr>
              <tr>
                <td><p><?php echo $picture; ?> 4: </p></td>
                <td><input type='file' name='userfile3' /></td>
                </tr>
              <tr>
                <td colspan='2'><h4 align="center"><?php echo $form_logo; ?></h4></td>
              </tr>
              <tr>
                <td><p><?php echo $logo; ?></p></td>
                <td><input type='file' name='userfile4' /></td>
                </tr>
              <tr>
              <td colspan="2"><input type="hidden" name="sh_name" value="<?php echo $sh_name; ?>" /></td>
              </tr>
              <tr>
              <td style="padding-top:20px" align='center' colspan="2"><input name="doUpload" type='submit' value='<?php echo $upload_button; ?>' /></td>
              </tr>
            </table>
            </form>
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
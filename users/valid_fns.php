<?php defined('_NO') or die("Access denied!");
function generate_code()
{
	$hour = date("H");
	$minute = substr(date("H"),0,1);//substr virezaet neobh zna4enie na4inaja s 0 zakan4ivaja 1
	$month = date("m");
	$year_day = date("z");
	
	$string = $hour.$minute.$month.$year_day;
	$string = md5(sha1($string));
	$string = substr($string,5,4);
	
	$array_mix = preg_split('//',$string,-1,PREG_SPLIT_NO_EMPTY); //razbivaem stroku
	srand ((float)microtime()*1000000); //generiruem slu4ajnie 4isla
	shuffle($array_mix); //pereme6ivaem
	
	return strtolower(implode("",$array_mix)); //razbivaem i vozvra6aem, zna4enie perenositsa v check_code()
	
}




function check_code($code) //funkcija proverjaet zna4enie $code iz polja formi
{
	$array_mix = preg_split('//',generate_code(),-1,PREG_SPLIT_NO_EMPTY); //sozdaem zna4enie dlja vivedenija
	$ent_code = preg_split('//',$code,-1,PREG_SPLIT_NO_EMPTY); //sozdaem zna4enie dlja sverki vvedennogo poljzovatelem
	
	$result_code = array_intersect($array_mix,$ent_code); //sverjaem polu4ennoe i vvedennoe zna4enie ARRAY (spec funkcija)
	
	if(strlen(generate_code())!=strlen($code))
	{
		return FALSE;
	}
	if(sizeof($result_code) == sizeof($array_mix))
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}



function gen_rand_email()
{
	$number = rand(2345678912345,9876543254321);	
	$rand = md5($rand);
	return $rand;
}




function resize($photo_src, $width, $name)
{  

 $parametr = getimagesize($photo_src);
 $image = imagecreatefromjpeg($photo_src);     
 
 $w_src = imagesx($image); //vi4 6irinu
 $h_src = imagesy($image); //vi4 visotu
 
 if($w_src < $h_src) //dlja goriz izobr
 {
	 $width = 300;
 }
 
 if($w_src > $h_src) //dlja vertikaljnoe izobr
 {
	 $width = 400;
 }
 
 if($w_src == $h_src) //dlja kvadratnogo izobr
 {
	 $width = 350;
 }
 
 
 list($width_orig, $height_orig) = getimagesize($photo_src);  
  $ratio_orig = $width_orig/$height_orig;  
 $new_width = $width;  
  $new_height = $width/$ratio_orig;  
 $newpic = imagecreatetruecolor($new_width, $new_height);  

 //na4alo propisivaem watermark
 $text = " ECONOM.LV ";
 $font = "../codegen/font_img/verdana.ttf";
 $c = imagecolorallocatealpha($newpic, 255, 255, 255, 50); //($img,$r,$g,$b, $alpha - prozra4nostj)
 $size = 16;
 $box  = imagettfbbox ( $size, 0, $font, $text );
 $x = $new_width - abs($box[4] - $box[0])/0.9;
 $y = $new_height/1.1 + abs($box[5] - $box[1]);
 //konec opredelenija razmerov i vsego ostanoljnogo watermarka
 
 imagecopyresampled($newpic, $image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig); 
 //записываем строку на изображение
 imagettftext($newpic, $size, 0, $x, $y, $c, $font, $text);
 
 imagejpeg($newpic, $name, 100);  
 return true;  
}  
 
 
 
 
 
 
function resize1($photo_src, $width, $name)
{  
 $parametr = getimagesize($photo_src);
$image = imagecreatefromjpeg($photo_src);  
 
 $w_src = imagesx($image); //vi4 6irinu
 $h_src = imagesy($image); //vi4isl vosotu
 
 if($w_src < $h_src) //dlja goriz izobr
 {
	 $width = 60;
 }
 
 if($w_src > $h_src) //dlja vertikaljnoe izobr
 {
	 $width = 80;
 }
 
 if($w_src == $h_src) //dlja kvadratnogo izobr
 {
	 $width = 80;
 }
 
 list($width_orig, $height_orig) = getimagesize($photo_src);  
  $ratio_orig = $width_orig/$height_orig;  
 $new_width1 = $width;  
  $new_height = $width / $ratio_orig;  
 $newpic = imagecreatetruecolor($new_width1, $new_height);  
 
 imagecopyresampled($newpic, $image, 0, 0, 0, 0, $new_width1, $new_height, $width_orig, $height_orig);  
 imagejpeg($newpic, $name, 100);  
 return true;  
}  



function resize_logo($photo_src, $width, $name)
{  

 $parametr = getimagesize($photo_src);
$image = imagecreatefromjpeg($photo_src);  
 
 $w_src = imagesx($image); //vi4 6irinu
 $h_src = imagesy($image); //vi4 visotu
 
 if($w_src < $h_src) //dlja goriz izobr
 {
	 $width = 150;
 }
 
 if($w_src > $h_src) //dlja vertikaljnoe izobr
 {
	 $width = 250;
 }
 
 if($w_src == $h_src) //dlja kvadratnogo izobr
 {
	 $width = 200;
 }
 
 
 list($width_orig, $height_orig) = getimagesize($photo_src);  
  $ratio_orig = $width_orig/$height_orig;  
 $new_width = $width;  
  $new_height = $width/$ratio_orig;  
 $newpic = imagecreatetruecolor($new_width, $new_height);  
 
 imagecopyresampled($newpic, $image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig); 
 imagejpeg($newpic, $name, 100);  
 return true;  
}  


function deltree($folder)
{
	if (is_dir($folder))
	{
		$handle = opendir($folder);
		while ($subfile = readdir($handle))
		{
			if ($subfile == '.' or $subfile == '..')
			{
				continue;
			}
			if (is_file($subfile)) 
			{
				unlink("{$folder}/{$subfile}");
			}
			else
			{
				deltree("{$folder}/{$subfile}");
			}
		}
		closedir($handle);
		rmdir ($folder);
	}
	else 
	{
		@unlink($folder);
	}
}




?>


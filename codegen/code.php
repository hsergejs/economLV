<?php
/*
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define("code_dir", $DOCUMENT_ROOT."/codegen/font_img/");
*/
//выше вариант, который надо использывать при расположении сайта в интернете, а не на ПК.

//на локале
define("code_dir", "font_img/");

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

function img_code() //Берем карандаши и рисуем картинку :)
{

$img_arr = array(
                 "codegen.png",//фон изображения. Можете сами нарисовать
                 "codegen0.png"//фон изображения. Можете сами нарисовать
                );

$font_arr = array();
$font_arr[0]["fname"] = "arial.ttf"; //ttf шрифты, можно заменить на свои
$font_arr[0]["size"] = 14;//размер
$font_arr[1]["fname"] = "tahoma.ttf"; //ttf шрифты, можно заменить на свои
$font_arr[1]["size"] = 14;//размер
$font_arr[2]["fname"] = "verdana.ttf";
$font_arr[2]["size"] = 14;

$n = rand(0,sizeof($font_arr)-1);
$img_fn = $img_arr[rand(0, sizeof($img_arr)-1)];
$im = imagecreatefrompng (code_dir . $img_fn); //создаем изображение со случайным фоном


$color = imagecolorallocate($im, rand(0, 200), 0, rand(0, 200));
imagettftext ($im, $font_arr[$n]["size"], rand(-4, 4), rand(8, 40), rand(18, 30), $color, code_dir.$font_arr[$n]["fname"], generate_code());//накладываем код


ImagePNG ($im);
ImageDestroy ($im);//ну вот и создано изображение!
}

img_code();
?>

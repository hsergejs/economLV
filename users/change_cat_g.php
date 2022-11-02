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
<title><?php echo $change_cat_title; ?></title>
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
		if(isset($_GET['ltd']))
		{
			$sh_name = $_GET['ltd'];
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
		
		if($_POST['change_cat'])
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
			
			if(mysql_num_rows($cat_value_ch)>0)
			{
		
				if($lang == 'rus')
				{
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET b_def = '$b_def', defcat = '$def' WHERE login = '$login' AND sh_name = '$sh_name'");
					$result_cat_rus = mysql_query("UPDATE catalogue_rus SET b_def = '$b_def', definition = '$def', activation = '0' WHERE login = '$login' AND ltd_name = '$sh_name'");
	
	/////////////////////// 1.rus - 2.lat				
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
									$def = "Ekipējums";
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
								
								
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET b_def = '$b_def', defcat = '$def' WHERE login = '$login' AND sh_name = '$sh_name'");
					
					$result_cat_lat = mysql_query("UPDATE catalogue_lat SET b_def = '$b_def', definition = '$def', activation = '0' WHERE login = '$login' AND ltd_name = '$sh_name'");
				}
				else
				{
					$result_update_lat = mysql_query("UPDATE ltd_page_lat SET b_def = '$b_def', defcat = '$def' WHERE login = '$login' AND sh_name = '$sh_name'");
					$result_cat_lat = mysql_query("UPDATE catalogue_lat SET b_def = '$b_def', definition = '$def', activation = '0' WHERE login = '$login' AND ltd_name = '$sh_name'");
								
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
								
					$result_update_rus = mysql_query("UPDATE ltd_page_rus SET b_def = '$b_def', defcat = '$def' WHERE login = '$login' AND sh_name = '$sh_name'");
					$result_cat_rus = mysql_query("UPDATE catalogue_rus SET b_def = '$b_def', definition = '$def', activation = '0' WHERE login = '$login' AND ltd_name = '$sh_name'");
				}
							
				if(!$result_update_rus || !$result_update_lat)
				{
					message_succes($lang,"<p align='center' class='join_us_error'>".$reg_user_db_err."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p>");
				}
				else
				{
					if($lang == 'rus')
					{
						$result_selec_mail = mysql_query("SELECT pvn,city,descr_offer,from_date_offer,till_date_offer FROM ltd_page_rus WHERE login = '$login' AND sh_name = '$sh_name'");
					}
					else
					{
						$result_selec_mail = mysql_query("SELECT pvn,city,descr_offer,from_date_offer,till_date_offer FROM ltd_page_lat WHERE login = '$login' AND sh_name = '$sh_name'");
					}
					
					$row_select_mail = mysql_fetch_array($result_selec_mail);
					$pvn = $row_select_mail['pvn'];
					$city_sh = $row_select_mail['city'];
					$descr_offer = $row_select_mail['descr_offer'];
					$date_from = $row_select_mail['from_date_offer'];
					$date_till = $row_select_mail['till_date_offer'];
					
								$address = "admin@econom.lv";
								$sub = "Changed catalogue values";
								$ip = ($_SERVER['HTTP_X_FORWARDED_FOR'] == "" ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']);
								$smes = "SIA PVN number: ".$pvn."\n
								
								SIA name: ".$sh_name."\n 
								
								SIA city: ".$city_sh."\n
								
								For catalogue: ".$b_def."\n
								
								For under catalogue: ".$def."\n
															
								Offer or Discount: ".$descr_offer."\n
								
								Offer dates from ".$date_from." till ".$date_till."\n
								
								Information presented by: ".$login."\n
								
								Senders IP: ".$ip."";
								
								$headers = 'Content-type:text/plain; charset=UTF-8';
								mail ($address,$sub,$smes,"Content-type:text/plain; charset=UTF-8\r\n");
					
					message_succes($lang,"<p align='center'>".$change_cat_succ."</p><p><a href='profile.php?lang=".$lang."'>".$change_user_nothing_link."</a></p><meta http-equiv='Refresh' content='40; URL=profile.php?lang=".$lang."'>");
				}
			}
			else
			{
				unset($b_def);
				unset($def);
				unset($sh_name);
				exit("<meta http-equiv='Refresh' content='0; URL=profile.php?lang=".$lang."'>");
			}
		}
		
		if($lang == 'rus')
		{
			$result_cat_prev = mysql_query("SELECT b_def,definition FROM catalogue_rus WHERE ltd_name = '$sh_name' AND login = '$login'");
		}
		else
		{
			$result_cat_prev = mysql_query("SELECT b_def,definition FROM catalogue_lat WHERE ltd_name = '$sh_name' AND login = '$login'");
		}
			
		$row_cat_prev = mysql_fetch_array($result_cat_prev);
			
		echo "<p>".$change_cat_bdef.": <strong>".$row_cat_prev['b_def']."</strong><br />".$change_cat_def.": <strong>".$row_cat_prev['definition']."</strong></p>";
		
		?>
        <table align="center" width="80%" border="0" cellspacing="0" cellpadding="10px">
        <tr>
        <td colspan="2"><p><?php echo $ltd_create_opt_ch_cat; ?></p></td>
  <tr valign="top">
    <td width="300px" style="padding-left:70px;">
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
			echo "<div id='catalogue'><a href=".$_SERVER['PHP_SELF']."?lang=".$lang."&ltd=".urlencode($sh_name)."&b_def=".urlencode($cat_b_def['b_def']).">".$cat_b_def['b_def']."</a></div>";
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
				echo "<div id='catalogue'><a href=".$_SERVER['PHP_SELF']."?lang=".$lang."&ltd=".urlencode($sh_name)."&b_def=".urlencode($_GET['b_def'])."&def=".urlencode($cat_def['def']).">".$cat_def['def']."</a></div>";
			}
		}
		
		$b_def = $_GET['b_def'];
		$def = $_GET['def'];
		?>
        </td></tr></table>
        <table align="center" width="90%" border="0" cellpadding="0" cellspacing="0">
        <form action="" method="post">
        <tr>
        <td colspan="2" style="padding-top:30px; padding-left:60px;"><?php echo "<p>".$change_cat_ch_bdef.": <strong>".$b_def."</strong><br />".$change_cat_ch_def.": <strong>".$def."</strong></p>"; ?></td>
        </tr>
        <tr>
        <td><input type="hidden" name="b_def" value="<?php echo $b_def; ?>" /></td>
        <td><input type="hidden" name="def" value="<?php echo $def; ?>" /></td>
        </tr>
        <?php if(!empty($b_def) && !empty($def))
		{
			?>
        	<tr>
        	<td colspan="2" style="padding-top:30px" align="center"><input type='submit' name='change_cat' value=<?php echo $ltd_create_opt_but; ?> /></td></tr>
            <?php
		}
		?>
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
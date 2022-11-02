<?php defined('_NO') or die("Access denied!"); ?>
<td width="240px" align="left">
<?php
if($lang == 'rus')
{
	echo "<a href='index.php?lang=rus'><div id='logo_rus'></div></a>";
}
else
{
	echo "<a href='index.php?lang=lat'><div id='logo_lat'></div></a>";
}	?>
</td>
<td></td>
<td align="right">
    <table style="padding-top:5px; padding-bottom:5px;" class="stats" border="0">
      <tr>
      <td align="right">
      <?php 
    $result = mysql_query ("SELECT COUNT(*) FROM comments",$db);
    $sum = mysql_fetch_array ($result);
    echo $stats_reviews." $sum[0]</td></tr><tr>";
    if ($lang=='rus') {
    $result1 = mysql_query ("SELECT COUNT(ltd_name) FROM catalogue_rus WHERE activation = '2'",$db);
    $sum1 = mysql_fetch_array ($result1);
    echo "<td align='right' width='150px'>".$stats_comp." $sum1[0]"; }
    else {
    $result1 = mysql_query ("SELECT COUNT(ltd_name) FROM catalogue_lat WHERE activation = '2'",$db);
    $sum1 = mysql_fetch_array ($result1);
    echo "<td align='right' width='150px'>".$stats_comp." $sum1[0]";}
    ?>
      </td>
      </tr>
      </table>
    
    <table class="stats" align="right" border="0">
    <tr align="center">
    <?php
	
	if(isset($_GET['city']))
	{
		$city_sh = $_GET['city'];
	}
		
	if(isset($_GET['b_def']))
	{
		$b_def = $_GET['b_def'];
	}
		
	if(isset($_GET['defcat']))
	{
		$def = $_GET['defcat'];
	}
		
	if(isset($_GET['link']))
	{
		$link = $_GET['link'];
	}
	
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
				
				
		if($city_sh && $b_def && $def && $link)
		{
			echo "<td width='70px'><a href='".$_SERVER['PHP_SELF']."?lang=lat&city=".urlencode($city_sh)."&b_def=".urlencode($b_def)."&defcat=".urlencode($def)."&link=".urlencode($link)."'><strong>Latviski</strong></a></td>";
		}		
		elseif($city_sh && $b_def && $def)
		{
			echo "<td width='70px'><a href='".$_SERVER['PHP_SELF']."?lang=lat&city=".urlencode($city_sh)."&b_def=".urlencode($b_def)."&defcat=".urlencode($def)."'><strong>Latviski</strong></a></td>";
		}
		elseif($city_sh && $b_def)
		{
			echo "<td width='70px'><a href='".$_SERVER['PHP_SELF']."?lang=lat&city=".urlencode($city_sh)."&b_def=".urlencode($b_def)."'><strong>Latviski</strong></a></td>";
		}
		elseif($city_sh)
		{
			echo "<td width='70px'><a href='".$_SERVER['PHP_SELF']."?lang=lat&city=".urlencode($city_sh)."'><strong>Latviski</strong></a></td>";
		}
		elseif(!$city_sh)
		{
			echo "<td width='70px'><a href='".$_SERVER['PHP_SELF']."?lang=lat'><strong>Latviski</strong></a></td>";
		}					
		
		
		
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
								
		if($city_sh && $b_def && $def && $link)
		{
			echo "<td width='70px'><a href='".$_SERVER['PHP_SELF']."?lang=rus&city=".urlencode($city_sh)."&b_def=".urlencode($b_def)."&defcat=".urlencode($def)."&link=".urlencode($link)."'><strong>По-русски</strong></a></td>";
		}
		elseif($city_sh && $b_def && $def)
		{
			echo "<td width='70px'><a href='".$_SERVER['PHP_SELF']."?lang=rus&city=".urlencode($city_sh)."&b_def=".urlencode($b_def)."&defcat=".urlencode($def)."'><strong>По-русски</strong></a></td>";
		}
		elseif($city_sh && $b_def)
		{			
			echo "<td width='70px'><a href='".$_SERVER['PHP_SELF']."?lang=rus&city=".urlencode($city_sh)."&b_def=".urlencode($b_def)."'><strong>По-русски</strong></a></td>";
		}
		elseif($city_sh)
		{
			echo "<td width='70px'><a href='".$_SERVER['PHP_SELF']."?lang=rus&city=".urlencode($city_sh)."'><strong>По-русски</strong></a></td>";
		}
		elseif(!$city_sh)
		{
			echo "<td width='70px'><a href='".$_SERVER['PHP_SELF']."?lang=rus'><strong>По-русски</strong></a></td>";
		}					
		?>
          </tr>
          </table>
</td>
</tr>
<tr>     
<td colspan="3" align="center">
    <table style="background:url(img/spray_bg.png) repeat-x; height:45px; border:0px solid #F0F0F0; -moz-border-radius:20px; -webkit-border-radius:20px; border-radius:20px;" width="1010px" border="0">
    <tr>
    <td>
    <?php
	if($lang == 'rus')
	{
		$style_men = "menu";
	}
	else
	{
		$style_men = "menu_lv";
	}
	?>
    <ul id="<?php echo $style_men;?>">
    <li id="home"><a href='index.php?lang=<?php echo $lang;?>' title="<?php echo $home;?>"><?php echo $home;?></a></li>
	<li id="catalogue"><a href='Def_cat.php?lang=<?php echo $lang;?>' title="<?php echo $catalogue;?>"><?php echo $catalogue;?></a></li>
    <li id="enter"><a href='login.php?lang=<?php echo $lang;?>' title="<?php echo $enter_reg;?>"><?php echo $enter_reg;?></a></li>
    <li id="adert"><a href='advertising.php?lang=<?php echo $lang;?>' title="<?php echo $advert;?>"><?php echo $advert;?></a></li>
    <li id="contacts"><a href='contact_us.php?lang=<?php echo $lang;?>' title="<?php echo $contacts;?>"><?php echo $contacts;?></a></li>
    </ul>
    </td>
    <td>
    <!--[if IE 7]>
    <div style="margin-bottom:-17px;">
    <![endif]-->
    <form action="http://www.econom.lv/searchresults.php" id="cse-search-box">
    <input type="hidden" name="cx" value="partner-pub-6372439663214831:psn3aqsq621" />
    <input type="hidden" name="cof" value="FORID:9" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" size="21" />
    <?php if($lang == 'rus')
	{
    	?>
        &nbsp; <input type="submit" name="sa" value="Найти" />
        <?php
	}
	else
	{
		?>
		&nbsp; <input type="submit" name="sa" value="Mekl&#x0113;t" />
        <?php
	}
		?>
	</form>
    <script type="text/javascript" src="http://www.google.lv/cse/brand?form=cse-search-box&amp;lang=lv"></script>
    <!--[if IE 7]>
    </div>
    <![endif]-->
    </td>
    </tr>
    </table>
</td>  
<?php
class Counter_rus
{
    var $origin_arr;
    var $modif_arr;
    var $min_word_length = 3;

function explode_str_on_words($text)
{

$search = array ("'ё'",
                 "'<[\/\!]*?[^<>]*?>'si",
                 "'([\r\n])[\s]+'", 
                 "'&(quot|#34);'i",
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");

$replace = array ("е",
                  " ",
                  "\\1 ",
                  "\" ",
                  " ",
                  " ",
                  " ",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");

$text = preg_replace ($search, $replace, $text);

	$text = strtolower($text);

    $del_symbols = array(",", ".", ";", ":", "\"", "#", "\$", "%", "^",
                         "!", "@", "`", "~", "*", "-", "=", "+", "\\",
                         "|", "/", ">", "<", "(", ")", "&", "?", "№", "\t",
                         "\r", "\n", "{","}","[","]", "'", "“", "”", "•",
						 "br","_","алтухов","быть","вот","вы","да","еще","и","как",
						 "мы","не","нет","о","они","от","с","сказать","только",
						 "у","этот","большой","в","все","говорить","для","же",
						 "из","который","на","него","них","один","оно","ото",
						 "свой","та","тот","что","я","бы","весь","всей","год",
						 "до","знать","к","мочь","наш","нее","но","она","оный",
						 "по","себя","такой","ты","это","ваш","нашем","вашем",
						 "вас","нам",
						 "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"
                         );
	
    $text = str_replace($del_symbols, array(" "), $text);
    $text = ereg_replace("( +)", " ", $text);
    $this->origin_arr = explode(" ", trim($text));
    return $this->origin_arr;
}

function count_words()
{
    $tmp_arr = array();
    foreach ($this->origin_arr as $val)
    {
        if (strlen($val)>=$this->min_word_length)
        {
            $val = strtolower($val);
        if (array_key_exists($val, $tmp_arr))
        {
            $tmp_arr[$val]++;
        }
        else
        {
            $tmp_arr[$val] = 1;
        }
        }
    }
    arsort ($tmp_arr);
    $this->modif_arr = $tmp_arr;
}

function get_keywords($text)
{
$this->explode_str_on_words($text);
$this->count_words();
$arr = array_slice($this->modif_arr, 0, 15);
$str = "";
foreach ($arr as $key=>$val)
{
$str .= $key . ", ";
}
		$str = trim(substr($str, 0, strlen($str)-2));
		$str = mb_convert_encoding($str, "utf8", "windows-1251");
		return $str;
}
}





class Counter_lat
{
    var $origin_arr;
    var $modif_arr;
    var $min_word_length = 3;

function explode_str_on_words($text)
{

$search = array (
                 "'<[\/\!]*?[^<>]*?>'si",         
                 "'([\r\n])[\s]+'",              
                 "'&(quot|#34);'i",           
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");

$replace = array (
                  " ",
                  "\\1 ",
                  "\" ",
                  " ",
                  " ",
                  " ",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");

$text = preg_replace ($search, $replace, $text);

	$text = strtolower($text);

    $del_symbols = array(",", ".", ";", ":", "\"", "#", "\$", "%", "^",
                         "!", "@", "`", "~", "*", "-", "=", "+", "\\",
                         "|", "/", ">", "<", "(", ")", "&", "?", "№", "\t",
                         "\r", "\n", "{","}","[","]", "'", "“", "”", "•",
						 "br","_","gar","par","ar","aiz","dēļ","pie","pēc","manis",
						 "pa","apakš","bez","iz","kopš","no","pirms","priekš",
						 "uz","virs","zem","labad","līdz","caur","ap",
						 "pār","pret","starp","mēs","es","jūs","kas","kurš","tās",
						 "tie","viņi","viņas","mani","man","kā","šo","jo",
						 "ir","jā","aiz","vēl","un","nē","visi","ārpus",
						 "tā","mūsu","jūsu","kāpēc","jau","jums",
						 "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"
                         );
	
    $text = str_replace($del_symbols, array(" "), $text);
    $text = ereg_replace("( +)", " ", $text);
    $this->origin_arr = explode(" ", trim($text));
    return $this->origin_arr;
}

function count_words()
{
    $tmp_arr = array();
    foreach ($this->origin_arr as $val)
    {
        if (strlen($val)>=$this->min_word_length)
        {
            $val = strtolower($val);
        if (array_key_exists($val, $tmp_arr))
        {
            $tmp_arr[$val]++;
        }
        else
        {
            $tmp_arr[$val] = 1;
        }
        }
    }
    arsort ($tmp_arr);
    $this->modif_arr = $tmp_arr;
}

function get_keywords($text)
{
$this->explode_str_on_words($text);
$this->count_words();
$arr = array_slice($this->modif_arr, 0, 15);
$str = "";
foreach ($arr as $key=>$val)
{
$str .= $key . ", ";
}
		$str = trim(substr($str, 0, strlen($str)-2));
		$str = mb_convert_encoding($str, "utf8", "iso-8859-4");
		return $str;
}
}
?>
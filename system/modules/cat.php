<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

if(!$headerMETA = Niun::getInstance()->Get('Cache')->Get('header_'.$cat, 3600))
{
	$result_meta = Niun::getInstance()->Get('DataBase')->Query("SELECT title FROM page WHERE id='1'");
	$myrow_meta = Niun::getInstance()->Get('DataBase')->GetArray($result_meta);
	
	if($myrow_meta != "")
	{
		$result_meta_cat = Niun::getInstance()->Get('DataBase')->Query("SELECT `name`, `title`, `meta_d`, `meta_k` FROM menu WHERE id='$cat'");
		$meta_cat = Niun::getInstance()->Get('DataBase')->GetArray($result_meta_cat);
	
		$headerMETA[0] = $meta_cat['title']." | ".$myrow_meta['title'];
		$headerMETA[1] = $meta_cat['meta_d'];
		$headerMETA[2] = $meta_cat['meta_k'];
		$headerMETA[3] = $meta_cat['name'];
		
		$headerMETA = implode("[META]",$headerMETA);
		
		Niun::getInstance()->Get('Cache')->Set('header_'.$cat, $headerMETA);
	}
}

$headerMETA = explode("[META]",$headerMETA);

Niun::getInstance()->Get('Template')->header_title = $headerMETA[0];
Niun::getInstance()->Get('Template')->header_metaD = $headerMETA[1];
Niun::getInstance()->Get('Template')->header_metaK = $headerMETA[2];

function index_cat($cat,$config = array(),$pn)
{

global $config;
require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'navig.php');
$limit = navig(5,$pn,$cat,"cat",$config['theme']);
$links = $limit[2];

$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM blog WHERE cat='$cat' AND cat != 0 AND viewindex='1' AND pablick='1' ORDER BY date_b DESC LIMIT $limit[0], $limit[1]");//Выводим из базы данных все записи где колонка cat равна переменной $cat
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

if($myrow_index != "")
{
$sm_read = Niun::getInstance()->Get('Template')->Fetch('news');
do
{
$edd_tamp = $sm_read;
$text = explode("[end]",$myrow_index['text']);

//формируем ссылку на пост
if($config['theme'] == 0)$link = "index.php?blog=".$myrow_index['id'];
else $link = gen_catalog($myrow_index['cat']).$myrow_index['nameurl'];

$datePOST = date("d/m/Y H:i",$myrow_index['date_b']);

//Замены идентификаторов на переменные из базы данных
$edd_tamp = str_replace("[_text]",$text[0],$edd_tamp);//Текст
$edd_tamp = str_replace("[_title]",$myrow_index['title'],$edd_tamp);//Название статьи
$edd_tamp = str_replace("[_gomore]",$link,$edd_tamp);//id статьи, для вывода в полной статьи
$edd_tamp = str_replace("[_author]",$myrow_index['author'],$edd_tamp);//Автор статьи
$edd_tamp = str_replace("[_date_b]",$datePOST,$edd_tamp);//Дата размещения
$edd_tamp = str_replace("[_comm]",$myrow_index['comm'],$edd_tamp);
$result = (!isset($result)) ? '' : $result;
$result .= $edd_tamp;
}
while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));

if($links > 1)$result .= listnav($links,$pn,6,$cat,"cat",$config['theme']);
}
else
{
	header("HTTP/1.0 404 Not Found");
	include ("404.html");
	exit;
}
return $result;
}

function nameCAT($name)
{
$sm_read = Niun::getInstance()->Get('Template')->Fetch('nameCAT');

$sm_read = str_replace("[_nameCAT]",$name,$sm_read);//имя

return $sm_read;
}
?>
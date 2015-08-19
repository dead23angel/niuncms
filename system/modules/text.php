<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

if(!$headerMETA = Niun::getInstance()->Get('Cache')->Get('header'.$blog, 3600))
{
	$result_meta = Niun::getInstance()->Get('DataBase')->Query("SELECT title FROM page WHERE id='1'");
	$myrow_meta = Niun::getInstance()->Get('DataBase')->GetArray($result_meta);

	if($myrow_meta != "")
	{
		$result_meta_blog = Niun::getInstance()->Get('DataBase')->Query("SELECT title,meta_d,meta_k FROM blog WHERE id='$blog'");
		$meta_blog = Niun::getInstance()->Get('DataBase')->GetArray($result_meta_blog);

		$headerMETA[0] = $meta_blog['title']." | ".$myrow_meta['title'];
		$headerMETA[1] = $meta_blog['meta_d'];
		$headerMETA[2] = $meta_blog['meta_k'];
		
		$headerMETA = implode("[META]",$headerMETA);
		
		Niun::getInstance()->Get('Cache')->Set('header'.$blog, $headerMETA);
	}
}

$headerMETA = explode("[META]",$headerMETA);

Niun::getInstance()->Get('Template')->header_title = $headerMETA[0];
Niun::getInstance()->Get('Template')->header_metaD = $headerMETA[1];
Niun::getInstance()->Get('Template')->header_metaK = $headerMETA[2];

function blog($blog, $canon, $config = array(), $morepostACTIV)
{

global $config;
require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'authoriz.php');

if (checketHESH() === TRUE) $sql = "SELECT * FROM blog WHERE id='$blog'";
else $sql = "SELECT * FROM blog WHERE id='$blog' AND pablick='1'";

$result_index = Niun::getInstance()->Get('DataBase')->Query($sql);
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

$newloock = $myrow_index['loock'] + 1;
$up_loock = Niun::getInstance()->Get('DataBase')->Query ("UPDATE blog SET loock='$newloock' WHERE id='$blog'");

if($myrow_index != "")
{
$sm_read = Niun::getInstance()->Get('Template')->Fetch('text');

$text = str_replace("[end]","",$myrow_index['text']);

if($morepostACTIV == 1)
{
require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'morepost.php');
$more = morepost($config['chpu'],$myrow_index['cat'],$blog);
$sm_read = str_replace("[_morepost]",$more,$sm_read);
}
else $sm_read = str_replace("[_morepost]","",$sm_read);

$datePOST = date("d/m/Y H:i",$myrow_index['date_b']);

//Замены идентификаторов на переменные из базы данных
$sm_read = str_replace("[_canon]",$canon,$sm_read);
$sm_read = str_replace("[_text]",$text,$sm_read);//Текст
$sm_read = str_replace("[_title]",$myrow_index['title'],$sm_read);//Название статьи
$sm_read = str_replace("[_author]",$myrow_index['author'],$sm_read);//Автор статьи
$sm_read = str_replace("[_date_b]",$datePOST,$sm_read);//Дата размещения
}
else
{
	header("HTTP/1.0 404 Not Found");
	include ("404.html");
	exit;
}
$result[0] = $sm_read;
$result[1] = $myrow_index['viewcomm'];
return $result;
}
?>
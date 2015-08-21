<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

if(!$headerMETA = Registry::getInstance()->Cache->Get('header', 3600))
{
$result_meta = Registry::getInstance()->DataBase->Query("SELECT `title`, `meta_d`, `meta_k` FROM page WHERE id='1'");
$myrow_meta = Registry::getInstance()->DataBase->GetArray($result_meta);

	if($myrow_meta != "")
	{
		$headerMETA[0] = $myrow_meta['title'];
		$headerMETA[1] = $myrow_meta['meta_d'];
		$headerMETA[2] = $myrow_meta['meta_k'];
		$headerMETA = implode("[META]",$headerMETA);
		
		Registry::getInstance()->Cache->Set('header', $headerMETA);
	}
}

$headerMETA = explode("[META]",$headerMETA);

Registry::getInstance()->Template->header_title = $headerMETA[0];
Registry::getInstance()->Template->header_metaD = $headerMETA[1];
Registry::getInstance()->Template->header_metaK = $headerMETA[2];

function index_page($chpu, $pn)
{
require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'navig.php');
$limit = navig(5,$pn,"","index",$chpu);
$links = $limit[2];

$result_index = Registry::getInstance()->DataBase->Query("SELECT * FROM blog WHERE viewindex='1' AND pablick='1' ORDER BY date_b DESC LIMIT $limit[0], $limit[1]");
$myrow_index = Registry::getInstance()->DataBase->GetArray($result_index);

if(!isset($myrow_index)) {
	$news = '<p align=\'center\'>Нет записей в базе данных</p>';
} else {
	$news = '';
}

if($myrow_index != "")
{
$sm_read = Registry::getInstance()->Template->Fetch('news');
do
{
$edd_tamp = $sm_read;
$text = explode("[end]",$myrow_index['text']);

//формируем ссылку на пост
if($chpu == 0)$link = "index.php?blog=".$myrow_index['id'];
else $link = gen_catalog($myrow_index['cat']) . $myrow_index['nameurl'];

$datePOST = date("d/m/Y H:i",$myrow_index['date_b']);


$edd_tamp = str_replace("[_text]",$text[0],$edd_tamp);//Текст
$edd_tamp = str_replace("[_title]",$myrow_index['title'],$edd_tamp);//Название статьи
$edd_tamp = str_replace("[_gomore]",$link,$edd_tamp);//id статьи, для вывода в полной статьи
$edd_tamp = str_replace("[_author]",$myrow_index['author'],$edd_tamp);//Автор статьи
$edd_tamp = str_replace("[_date_b]",$datePOST,$edd_tamp);//Дата размещения
$edd_tamp = str_replace("[_comm]",$myrow_index['comm'],$edd_tamp);

$news .= $edd_tamp;
}
while($myrow_index = Registry::getInstance()->DataBase->GetArray($result_index));

if($links > 1)
	$news .= listnav($links,$pn,6,'','index',$chpu);
}

return $news;
}
?>
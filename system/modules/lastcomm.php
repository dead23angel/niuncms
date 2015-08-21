<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function lastcomm($chpu)
{
$result_index = Registry::getInstance()->DataBase->Query("SELECT `author`, `id`,`blog`, `text` FROM comm WHERE status < '3' AND view='1' ORDER BY id DESC LIMIT 5");
$myrow_index = Registry::getInstance()->DataBase->GetArray($result_index);

if($myrow_index != "")
{
$sm_read = Registry::getInstance()->Template->Fetch('lastcomm');

preg_match("/\[_divmenu\](.*?)\[_divmenu\]/s",$sm_read,$a);

do
{
$result_blog = Registry::getInstance()->DataBase->Query("SELECT `id`, `nameurl`, `title`, `cat` FROM blog WHERE id='".$myrow_index['blog']."'");
$myrow_blog = Registry::getInstance()->DataBase->GetArray($result_blog);

$link = (!isset($link)) ? '' : $link;

$edd_tamp = $a[1];

	if($chpu == 0)$href = "<a href=\"index.php?blog=".$myrow_blog['id']."#comm".$myrow_index['id']."\">".$myrow_blog['title']."</a>";
	else $href = "<a href=\"".gen_catalog($myrow_blog['cat']).$myrow_blog['nameurl']."#comm".$myrow_index['id']."\">".$myrow_blog['title']."</a>";

	$no_tags = strip_tags($myrow_index['text']);
	$no_tags = str_replace("\\","\\\\",$no_tags);
	$txtcomm = explode(" ",$no_tags);
	for($i=0;$i<=30 AND isset($txtcomm[$i]);$i++)
	{
		if($i == 0)$txtcomm_result = $txtcomm[$i];
		else $txtcomm_result .= " ".$txtcomm[$i];
		if($i == 30)$txtcomm_result .= "...";
	}

$edd_tamp = str_replace("[_text]",$txtcomm_result,$edd_tamp);
$edd_tamp = str_replace("[_station]",$href,$edd_tamp);
$edd_tamp = str_replace("[_namber]",$myrow_index['id'],$edd_tamp);
$edd_tamp = str_replace("[_author]",$myrow_index['author'],$edd_tamp);

$link .= $edd_tamp;
}
while($myrow_index = Registry::getInstance()->DataBase->GetArray($result_index));
$lastcomm = preg_replace("/\[_divmenu\].*?\[_divmenu\]/s",$link,$sm_read);
}
return $lastcomm;
}
?>
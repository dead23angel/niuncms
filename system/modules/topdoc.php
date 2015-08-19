<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function topdoc($chpu)
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT `nameurl`, `title`, `id`, `cat` FROM blog WHERE viewindex!='0' AND pablick='1' ORDER BY loock DESC LIMIT 10");
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

if($myrow_index != "")
{
$sm_read = Niun::getInstance()->Get('Template')->Fetch('topdoc');

preg_match("/\[_divmenu\](.*?)\[_divmenu\]/s",$sm_read,$a);
do
{

$link = (!isset($link)) ? '' : $link;
	
$edd_tamp = $a[1];

if($chpu == 0)$href = "<a href=\"index.php?blog=".$myrow_index['id']."\">".$myrow_index['title']."</a>";
else $href = "<a href=\"".gen_catalog($myrow_index['cat']).$myrow_index['nameurl']."\">".$myrow_index['title']."</a>";

$edd_tamp = str_replace("[_station]",$href,$edd_tamp);

$link .= $edd_tamp;
}
while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));
$topdoc = preg_replace("/\[_divmenu\].*?\[_divmenu\]/s",$link,$sm_read);
}
return $topdoc;
}
?>
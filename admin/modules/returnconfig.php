<?php
### NiunCMS - Community Management System ###
### Powered by SibWeb Media Group         ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined('ADMINPART')) die();

function returnconfig()//Функция вывода настроек блога
{
$result_page = mysql_query("SELECT configblog FROM page WHERE id='1'");
$myrow_page = mysql_fetch_array($result_page);

$configblog = explode("|",$myrow_page['configblog']);
return $configblog[3];
}
?>
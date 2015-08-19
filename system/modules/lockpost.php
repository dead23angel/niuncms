<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function lockpost()
{
	$result_block = Niun::getInstance()->Get('DataBase')->Query("SELECT text FROM blog WHERE block='1' AND pablick='1'");//выносим из базы данных пост где колонка block равна единице
	$myrow_block = Niun::getInstance()->Get('DataBase')->GetArray($result_block);
	
	if($myrow_block != "")
	{
		global $config;

		$sm_read = Niun::getInstance()->Get('Template')->Fetch('lockpost');
		$sm_read = str_replace("[_text]",$myrow_block['text'],$sm_read);

		return $sm_read;
	}
	else return "";
}
?>
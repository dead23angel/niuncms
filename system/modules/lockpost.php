<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function lockpost()
{
	$result_block = Registry::getInstance()->DataBase->Query("SELECT text FROM blog WHERE block='1' AND pablick='1'");//выносим из базы данных пост где колонка block равна единице
	$myrow_block = Registry::getInstance()->DataBase->GetArray($result_block);
	
	if($myrow_block != "")
	{
		global $config;

		$sm_read = Registry::getInstance()->Template->Fetch('lockpost');
		$sm_read = str_replace("[_text]",$myrow_block['text'],$sm_read);

		return $sm_read;
	}
	else return "";
}
?>
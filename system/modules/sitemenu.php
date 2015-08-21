<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function SiteMenu ()
{
	$result_index = Registry::getInstance()->DataBase->Query("SELECT * FROM menu ORDER BY position");
	$myrow_index = Registry::getInstance()->DataBase->GetArray($result_index);

	if ($myrow_index != "")
	{
		$i=0;
		
		do
		{
			$commMASS[$i] = array(
				$myrow_index['id'],
				$myrow_index['nameurl'],
				$myrow_index['name'],
				$myrow_index['href'],
				$myrow_index['podmenu']);
			$i++;
		}
		
		while($myrow_index = Registry::getInstance()->DataBase->GetArray($result_index));

		return $commMASS;
	}
	else return "";
}
?>
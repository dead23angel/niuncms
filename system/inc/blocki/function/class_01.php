<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function get_blocki()
{
	$blocki = allrswidgetblock();

	Registry::getInstance()->Template->blocki = '';
	
	if (!empty($blocki))
	{
		$sm_read_y = Registry::getInstance()->Template->Fetch_Module('blocki', 'widget_y');
		$sm_read_n = Registry::getInstance()->Template->Fetch_Module('blocki', 'widget_n');
		
		foreach ($blocki as $value)
		{			
			if ($value['tpl'] == 0) $copy_tpl = $sm_read_y;
			if ($value['tpl'] == 1) $copy_tpl = $sm_read_n;
	
			$copy_tpl = str_replace("[_name]",$value['name'],$copy_tpl);
			$copy_tpl = str_replace("[_text]",$value['text'],$copy_tpl);
			
			Registry::getInstance()->Template->blocki .= $copy_tpl;
		}
	}
	
	return Registry::getInstance()->Template->blocki;
}

function allrswidgetblock()
{
	if(!$blocki = Registry::getInstance()->Cache->Get('blocki', 259200, true))
	{
		$result_index = Registry::getInstance()->DataBase->Query("SELECT * FROM blocki ORDER BY position");//Выводим из базы данных все
		$myrow_index = Registry::getInstance()->DataBase->GetArray($result_index);
		
		if ($myrow_index != "")
		{
			$i=0;
			do
			{
				$blocki[$i]['id'] = $myrow_index['id'];
				$blocki[$i]['name'] = $myrow_index['name'];
				$blocki[$i]['text'] = $myrow_index['text'];
				$blocki[$i]['position'] = $myrow_index['position'];
				$blocki[$i]['tpl'] = $myrow_index['tpl'];
				$i++;
			}
			while($myrow_index = Registry::getInstance()->DataBase->GetArray($result_index));
		}
		
		if (!isset($blocki)) $blocki = array();
		
		Registry::getInstance()->Cache->Set("blocki", $blocki);
	}
	
	return $blocki;
}
?>
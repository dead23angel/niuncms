<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function stationMENU ()
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM menu ORDER BY position");//Выводим из базы данных все пункты меню
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

if ($myrow_index != "")
{
	$i=0;
	do//Цикл do while
	{
		$commMASS[$i] = array(
			$myrow_index['id'],//0
			$myrow_index['nameurl'],//1
			$myrow_index['name'],//2
			$myrow_index['href'],//3
			$myrow_index['podmenu']);//4
		$i++;
	}
	while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));

	return $commMASS;
}
else return "";
}
//---------------------------------------------
function search_category($station,$result)//генирация чпу ссылки типа /категория1/категория2/
{
	global $station_menu;

	$podmenu = (!isset($podmenu)) ? '' : $podmenu;
	$result = (!isset($result)) ? '' : $result;
	
	if ($station_menu != "")
	{
		foreach($station_menu as $value)
		{
			if ($station == $value[0])
			{
				$result = $value[1]."/".$result;
				$podmenu = $value[4];
				break;
			}
		}
		
		if($podmenu != 0) $result = search_category($podmenu,$result);
		
		return $result;
	}
}
//---------------------------------------------
function gen_catalog($id_cat)//генерация каталога типа /категория1/категория2/ для определенного поста (для модулей news и cat и тд)
{
	global $station_menu;

	$strig_chpu = (!isset($strig_chpu)) ? '' : $strig_chpu;
	$category = (!isset($category)) ? $categoty = array('1' => '' , '2' => '' ) : $category;

	for($i=0;isset($station_menu[$i]);$i++)
	{

		if($id_cat == $station_menu[$i][0])
		{
			$category[0] = $station_menu[$i][0];//id
			$category[1] = $station_menu[$i][1];//чпу
			$category[2] = $station_menu[$i][4];//под пункт
			break;
		}
	}
	
	$result = search_category($category[2],$strig_chpu.$category[1]);
	
	if($result == "") return "";
	else return $result."/";
}
?>
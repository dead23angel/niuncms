<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//ДОБАВЛЯЕМ ПУНКТ МЕНЮ
if(isset($_POST['addname_p']))$addname_p = $_POST['addname_p'];
if(isset($_POST['addhref_p']))$addhref_p = $_POST['addhref_p'];
if(isset($_POST['addtitleM']))$addtitleM = $_POST['addtitleM'];
if(isset($_POST['addmetadM']))$addmetadM = $_POST['addmetadM'];
if(isset($_POST['addmetakM']))$addmetakM = $_POST['addmetakM'];

if(isset($addname_p) AND isset($addhref_p) AND isset($addtitleM) AND isset($addmetadM) AND isset($addmetakM))
{	
	$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT COUNT(*) FROM menu");//Выводим из базы данных пункты меню
	$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);
	
	$col = $myrow_index[0];//Узнаем общее количество пунктов в базе данных
	$col++;
	
	$addnamepforTRANSLIT = $addname_p;//копия имени для функции транслита
	
	//Избавляемся от кавычки
	$addname_p = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($addname_p));
	$addtitleM = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($addtitleM));
	$addmetadM = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($addmetadM));
	$addmetakM = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($addmetakM));
	//Избавляемся от кавычки
	
	//проверка на одинаковые чпу имена
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'translit.php';
	
	$result_menu = Niun::getInstance()->Get('DataBase')->Query("SELECT nameurl FROM menu");
	$myrow_menu = Niun::getInstance()->Get('DataBase')->GetArray($result_menu);
		
	$mass = 0;
	do
	{
		$massiv[$mass] = $myrow_menu['nameurl'];
		$mass++;
	}
	while($myrow_menu = Niun::getInstance()->Get('DataBase')->GetArray($result_menu));
	
	for($i=0;$i>=0;$i++)
	{	
		if($i == 0)
		{
			$addnameurl_p = translit($addnamepforTRANSLIT);
			if(!in_array($addnameurl_p,$massiv)) break;
		}
		else
		{
			$try = $i.$addnameurl_p;
			if(!in_array($try,$massiv))
			{
				$addnameurl_p = $i.$addnameurl_p;
				break;
			}
		}
		
		
	}
	//проверка на одинаковые чпу имена
	
	$result_add_menu = Niun::getInstance()->Get('DataBase')->Query ("INSERT INTO menu (nameurl,name,href,position,podmenu,title,meta_d,meta_k) 
	VALUES ('$addnameurl_p','$addname_p','$addhref_p','$col','0','$addtitleM','$addmetadM','$addmetakM')");

	header("location: admin.php?page=all_menu");//Перенаправление
	exit;//на страницу пунктов меню
}
//ДОБАВЛЯЕМ ПУНКТ МЕНЮ

function addmenu()//Функция вывода формы редактирования меню
{
	$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'addmenu.html');
	
	return $sm_read;//Выводим с генерированный html код	
}
?>
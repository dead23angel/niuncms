<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function option_function_start()
{
	global $chpu_links;
	global $site_menu;
	
	if(preg_match("/^.*?\.html$/",$chpu_links))
	{
		$link = "post";
		$result = chpu_blog();
	}
	else
	{
		$link = "cat";
		$result = chpu_cat();
	}
	
	$massiv_id_and_link[0] = $result;
	$massiv_id_and_link[1] = $link;
	
	return $massiv_id_and_link;
}
//---------------------------------------------
function blog_chpu()//функция определения чпу ссылки по id поста BLOG->CHPU
{
	global $blog;
	
	$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT `nameurl`, `cat` FROM blog WHERE id='$blog'");
	$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);
	
	if($myrow_index != "")
	{
		if($myrow_index['cat'] != 0) $result = search_category($myrow_index['cat'],$result);
	}
	
	return $result.$myrow_index['nameurl'];
}
//---------------------------------------------
function cat_chpu()//функция строит чпу сслыку по id категории CAT->CHPU
{
	global $cat;
	global $site_menu;
	
	for($i=0;isset($site_menu[$i]);$i++)
	{
		if($cat == $site_menu[$i][0])
		{
			$category[0] = $site_menu[$i][1];//чпу
			$category[1] = $site_menu[$i][4];//под пункт
			break;
		}
	}
	
	if(count($category) > 0)
	{
		if($category[1] != 0) $result = search_category($category[1],$result);
	}
	else error_chpu();//на страницу с ошибкой
	
	return $result.$category[0]."/";		
}
//---------------------------------------------
function chpu_blog()//Функция определеяет id поста по ссылке чпу CHPU->BLOG
{
	global $chpu_links;
	
	$massivCHPU = explode("/", $chpu_links);
	
	$lvl_encl = count($massivCHPU)-1;
	
	if(!preg_match("/^[-a-z0-9]+\.html$/",$massivCHPU[$lvl_encl]))//если имя не корректное,то переносим
	{
		error_chpu();//на страницу с ошибкой
	}
	
	$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT `id`, `cat`, `nameurl` FROM blog WHERE nameurl='$massivCHPU[$lvl_encl]'");
	$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);
	
	if($myrow_index != "")
	{
		$result = (!isset($result)) ? '' : $result;
		if($myrow_index['cat'] != 0) $result = search_category($myrow_index['cat'],$result);
		
		$result .= $myrow_index['nameurl'];
		
		if($result == $chpu_links) $blog = $myrow_index['id'];
		else error_chpu();//на страницу с ошибкой
	}
	else error_chpu();//на страницу с ошибкой
	
	return $blog;
}
//---------------------------------------------
function chpu_cat()//Функция определеяет id категории по ссылке чпу CHPU->CAT
{
	global $chpu_links;
	global $site_menu;

	$result = (!isset($result)) ? '' : $result;
	
	$massivCHPU = explode("/", $chpu_links);
	
	$lvl_encl = count($massivCHPU)-2;
	
	if(!preg_match("/^[-a-z0-9]+$/",$massivCHPU[$lvl_encl]))//если имя не корректное,то переносим
	{
		error_chpu();//на страницу с ошибкой
	}
	
	for($i=0;isset($site_menu[$i]);$i++)
	{
		if($massivCHPU[$lvl_encl] == $site_menu[$i][1])
		{
			$category[0] = $site_menu[$i][0];//id
			$category[1] = $site_menu[$i][1];//чпу
			$category[2] = $site_menu[$i][4];//под пункт
			break;
		}
	}
	
	if(count($category) > 0)
	{
		if($category[2] != 0) $result = search_category($category[2],$result);
		
		$result .= $category[1]."/";
		
		if($result == $chpu_links) $cat = $category[0];
		else error_chpu();//на страницу с ошибкой
	}
	else error_chpu();//на страницу с ошибкой
	
	return $cat;
}
//---------------------------------------------
function search_category($station,$result)//генирация чпу ссылки типа /категория1/категория2/
{
	global $site_menu;
	
	$podmenu = 0;
	foreach($site_menu as $value)
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
//---------------------------------------------
function gen_catalog($id_cat)//генерация каталога типа /категория1/категория2/ для определенного поста (для модулей news и cat и тд)
{
	global $site_menu;

	$category = (!isset($category)) ? array('0' => '', '1' => '', '2' => '') : $category;

	for($i=0;isset($site_menu[$i]);$i++)
	{
		if($id_cat == $site_menu[$i][0])
		{
			$category[0] = $site_menu[$i][0];//id
			$category[1] = $site_menu[$i][1];//чпу
			$category[2] = $site_menu[$i][4];//под пункт
			break;
		}
	}

	//@TODO: разобраться что за $strig_chpu
	//$result = search_category($category[2],$strig_chpu.$category[1]);
	$result = search_category($category[2], $category[1]);
	
	if($result == "") return "";
	else return $result."/";
}
//---------------------------------------------
function error_chpu()//страница не найдена
{
	header("HTTP/1.0 404 Not Found");
	include ("404.html");
	exit;
}

if(isset($_GET['chpu_links']))
{
	$chpu_links = $_GET['chpu_links'];
	
	$result_chpu = option_function_start();
	
	if($result_chpu[1] == "cat") $cat = $result_chpu[0];
	if($result_chpu[1] == "post") $blog = $result_chpu[0];
}

if(isset($_GET['pagesite']))
{
	if(!preg_match("/^[0-9]+$/",$_GET['pagesite']))
	{
		error_chpu();
	}
	$pn = $_GET['pagesite'];//
}

?>
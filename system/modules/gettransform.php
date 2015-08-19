<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//GET ПЕРЕМЕННАЯ blog
if(isset($_GET['blog']))
{
	$blog = $_GET['blog'];
	var_dump($_GET['blog']);
	/*if(!preg_match("/^[0-9]+$/",$blog))
	{
		header("HTTP/1.0 404 Not Found");
		include ("404.html");
		exit;
	}*/
	if($config['chpu'] == 1)//если чпу вкл и пользователь обратился к динамичному адресу
	{
		$go_to_page_chpu = blog_chpu();
		header("HTTP/1.1 301 Moved Permanently");
		header("location: ".$server_root.$go_to_page_chpu);//редирект
		exit;
	}
}
//GET ПЕРЕМЕННАЯ blog
//GET ПЕРЕМЕННАЯ contact
if(isset($_GET['contact']))
{
	$contact = $_GET['contact'];
	if(!preg_match("/^[1-2]?$/",$contact))
	{
		header("HTTP/1.0 404 Not Found");
		include ("404.html");
		exit;
	}
	if($config['chpu'] == 1)//если чпу вкл и пользователь обратился к динамичному адресу
	{
		if(preg_match("/^\/index\.php\?contact=1$/",$_SERVER['REQUEST_URI']))
		{
			header("HTTP/1.1 301 Moved Permanently");
			header("location: ".$server_root."contacts.html");
			exit;
		}
	}
}
//GET ПЕРЕМЕННАЯ contact
//GET ПЕРЕМЕННАЯ cat
if(isset($_GET['cat']))
{
	$cat = $_GET['cat'];
	if(!preg_match("/^[0-9]+$/",$cat))
	{
		header("HTTP/1.0 404 Not Found");
		include ("404.html");
		exit;
	}
	if($config['chpu'] == 1)//если чпу вкл и пользователь обратился к динамичному адресу
	{
		$go_to_page_chpu = cat_chpu();
		
		header("HTTP/1.1 301 Moved Permanently");
		header("location: ".$server_root.$go_to_page_chpu);//редирект
		exit;
	}
}
//GET ПЕРЕМЕННАЯ cat
//GET ПЕРЕМЕННАЯ pn
if(isset($_GET['pn']))
{
	$pn = $_GET['pn'];
	if(!preg_match("/^[0-9]+$/",$pn))
	{
		header("HTTP/1.0 404 Not Found");
		include ("404.html");
		exit;
	}
	if($config['chpu'] == 1)//если чпу вкл и пользователь обратился к динамичному адресу
	{
		if(isset($blog))error_chpu();
		
		elseif(isset($contact))error_chpu();
		
		elseif(isset($cat)) $go_to_page_chpu = cat_chpu()."page/".$pn."/";
		
		else $go_to_page_chpu = "page/".$pn."/";
		
		header("HTTP/1.1 301 Moved Permanently");
		header("location: ".$server_root.$go_to_page_chpu);//на страницу с ошибкой
		exit;
	}
}
if(!isset($pn))$pn = 1;
//GET ПЕРЕМЕННАЯ pn
?>
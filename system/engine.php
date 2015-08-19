<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

// Динамическое управление классами
require_once(ROOT . DS . 'system' . DS . 'classes' . DS . 'niun.class.php');

// Класс управления параметрами
require_once (ROOT . DS . 'system' . DS . 'classes' . DS . 'param.class.php');
Niun::getInstance()->Set('Param', new Param);
Niun::getInstance()->Get('Param')->Start();

// Подключения класса работы с базой данных
require_once(ROOT . DS . 'system' . DS . 'classes' . DS . 'mysql.php');

// Подключение и инициализация класса работы с кешем
require_once(ROOT . DS . 'system' . DS . 'classes' . DS . 'cache.class.php');
Niun::getInstance()->Set('Cache', new Cache);

// Формируем меню сайта
if(!$site_menu = Niun::getInstance()->Get('Cache')->Get('sitemenu', 3600, true))
{
	include ROOT . DS . 'system' . DS . 'modules' . DS . 'sitemenu.php';
	$site_menu = SiteMenu ();
	
	Niun::getInstance()->Get('Cache')->Set("sitemenu", $site_menu);
}

// Получаем настройки сайта
if(!$config = Niun::getInstance()->Get('Cache')->Get('config', 604800, true))
{
	include ROOT . DS . 'system' . DS . 'modules' . DS . 'returnconfig.php';
	$config = returnconfig();
	
	Niun::getInstance()->Get('Cache')->Set("config", $config);
}

// Подключение шаблонизатора
require_once (ROOT . DS . 'system' . DS . 'classes' . DS . 'template.class.php');
Niun::getInstance()->Set('Template', new Template($config['theme']));

// Подключаем ЧПУ
if($config['chpu'] == 1) {
	include ROOT . DS . 'system' . DS . 'modules' . DS . 'urls.php';
	include ROOT . DS . 'system' . DS . 'modules' . DS . 'gettransform.php';
	include ROOT . DS . 'system' . DS . 'modules' . DS . 'canon.php';
} else {
	$canon = (!isset($canon)) ? 0 : $canon;
	$pn = (!isset($pn)) ? 1 : $pn;
}

// Генерация mail.xml ??????
if($config['email'] == 1) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'mail.php');
	statistictoEMAIL();
}

// Подключения модуля подписчики сайта
if($config['reader'] == 1) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'reader.php');
	Niun::getInstance()->Get('Template')->reader = select_reader($rssacc,$twacc);
}

// ???
if(!Niun::getInstance()->Get('Template')->menu = Niun::getInstance()->Get('Cache')->Get('menu', 7200)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'menu.php');
	$menunavig = menunavig($canon, $page_menunavig, $sub_menunavig);
	Niun::getInstance()->Get('Template')->menu = menu($config['chpu'], $menunavig);

	Niun::getInstance()->Get('Cache')->Set('menu', Niun::getInstance()->Get('Template')->menu);
}



//Модуль контакты
if(isset($contact)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'contact.php');
	if(!isset($error_contact))$error_contact = "";
	if(isset($_COOKIE['contMESS']))$contact = 2;

	Niun::getInstance()->Get('Template')->txt = contact($contact, $error_contact, $config['chpu'], Niun::getInstance()->Get('DataBase')->server_root);
}

// Вывод коротких новостей
if(!isset($blog) AND !isset($contact) AND !isset($cat)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'news.php');
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'lockpost.php');
	Niun::getInstance()->Get('Template')->txt = lockpost() . index_page($config['chpu'], $pn);
}

//Модуль категории
if(isset($cat)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'cat.php');
	Niun::getInstance()->Get('Template')->txt = nameCAT($headerMETA[3]).index_cat($cat, $config['chpu'], $pn);
}

//Модуль отображение записи (полной)
if(isset($blog)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'text.php');
	Niun::getInstance()->Get('Template')->txtFUNCTION = blog($blog, $canon, $config['chpu'], $config['morepost']);
	Niun::getInstance()->Get('Template')->txt = Niun::getInstance()->Get('Template')->txtFUNCTION[0];	
}

//Модуль галерея
if(preg_match("/\[NCMSgal=[0-9]+\]/s",Niun::getInstance()->Get('Template')->txt)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'galery.php');
	preg_match_all("/\[NCMSgal=([0-9]+)\]/s",Niun::getInstance()->Get('Template')->txt,$gal);
	for($i=0;isset($gal[1][$i]);$i++)
	{
		$galery = galery($gal[1][$i]);
		Niun::getInstance()->Get('Template')->txt = preg_replace("/\[NCMSgal=[0-9]+\]/",$galery,Niun::getInstance()->Get('Template')->txt,1);	
	}
	$viewphoto = viewphoto();
}
if(!isset($viewphoto))$viewphoto = "";

//Модуль комментариев
if(isset($blog) AND Niun::getInstance()->Get('Template')->txtFUNCTION[1] == 1) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'comm.php');
	if(!isset($_COOKIE['messW']))$messWLIST = "";
	else $messWLIST = $_COOKIE['messW'];

	if(!isset($error_comm))$error_comm = "";
	$comm = comm($blog, $error_comm, $messWLIST, $config['chpu'], Niun::getInstance()->Get('DataBase')->server_root);
	Niun::getInstance()->Get('Template')->txt .= $comm;
}

//Модуль топ статьи
if($config['top'] == 1) {
	if(!Niun::getInstance()->Get('Template')->topdoc = Niun::getInstance()->Get('Cache')->Get('top', 3600)) {
		require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'topdoc.php');
		Niun::getInstance()->Get('Template')->topdoc = topdoc($config['chpu']);

		Niun::getInstance()->Get('Cache')->Set('top', Niun::getInstance()->Get('Template')->topdoc);
	} 
}

//Модуль новых статей
if($config['newpost'] == 1) {
	if(!isset($blog) OR !isset($contact) OR !isset($cat)) {
		if(!Niun::getInstance()->Get('Template')->newdoc = Niun::getInstance()->Get('Cache')->Get('new', 3600)) {
			require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'newdoc.php');
			Niun::getInstance()->Get('Template')->newdoc = newdoc($config['chpu']);	
			Niun::getInstance()->Get('Cache')->Set("new", Niun::getInstance()->Get('Template')->newdoc);
		}
	}
}

if($config['lastcomm'] == 1) {
	if(!Niun::getInstance()->Get('Template')->lastcomm = Niun::getInstance()->Get('Cache')->Get('lastcomm', 3600)) {
		require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'lastcomm.php');
		Niun::getInstance()->Get('Template')->lastcomm = lastcomm($config['chpu']);
		
		Niun::getInstance()->Get('Cache')->Set("lastcomm", Niun::getInstance()->Get('Template')->lastcomm);	
	}
}

if($config['poll'] == 1) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'poll.php');
	if(!isset($_COOKIE[$q])) {
		if(!Niun::getInstance()->Get('Template')->poll = Niun::getInstance()->Get('Cache')->Get('poll', 3600)) {
			Niun::getInstance()->Get('Template')->poll = poll(0);
			
			Niun::getInstance()->Get('Cache')->Set("poll", Niun::getInstance()->Get('Template')->poll);
		}
	} else {
		if(!Niun::getInstance()->Get('Template')->poll = Niun::getInstance()->Get('Cache')->Get('pollform', 3600)) {
			Niun::getInstance()->Get('Template')->poll = poll(1);
			
			Niun::getInstance()->Get('Cache')->Set("pollform", Niun::getInstance()->Get('Template')->poll);
		}
	}
}

require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'stats.php');
Niun::getInstance()->Get('Template')->stats = stats();

require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'developers.php');

?>
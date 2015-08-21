<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

// Динамическое управление классами
require_once(ROOT . DS . 'system' . DS . 'classes' . DS . 'Niun.php');
spl_autoload_register(array("Niun", "loadClass"));

Niun::Start();


Registry::getInstance()->DataBase = new DataBase;
Registry::getInstance()->Cache = new Cache;


// Формируем меню сайта
if(!$site_menu = Registry::getInstance()->Cache->Get('sitemenu', 3600, true))
{
	include ROOT . DS . 'system' . DS . 'modules' . DS . 'sitemenu.php';
	$site_menu = SiteMenu ();
	
	Registry::getInstance()->Cache->Set("sitemenu", $site_menu);
}

// Получаем настройки сайта
if(!$config = Registry::getInstance()->Cache->Get('config', 604800, true))
{
	include ROOT . DS . 'system' . DS . 'modules' . DS . 'returnconfig.php';
	$config = returnconfig();
	
	Registry::getInstance()->Cache->Set("config", $config);
}

// Подключение шаблонизатора
Registry::getInstance()->Template = new Template($config['theme']);

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
	Registry::getInstance()->Template->reader = select_reader($rssacc,$twacc);
}

// ???
if(!Registry::getInstance()->Template->menu = Registry::getInstance()->Cache->Get('menu', 7200)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'menu.php');
	$menunavig = menunavig($canon, $page_menunavig, $sub_menunavig);
	Registry::getInstance()->Template->menu = menu($config['chpu'], $menunavig);

	Registry::getInstance()->Cache->Set('menu', Niun::getInstance()->Get('Template')->menu);
}



//Модуль контакты
if(isset($contact)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'contact.php');
	if(!isset($error_contact))$error_contact = "";
	if(isset($_COOKIE['contMESS']))$contact = 2;

	Registry::getInstance()->Template->txt = contact($contact, $error_contact, $config['chpu'], Registry::getInstance()->DataBase->server_root);
}

// Вывод коротких новостей
if(!isset($blog) AND !isset($contact) AND !isset($cat)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'news.php');
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'lockpost.php');
	Registry::getInstance()->Template->txt = lockpost() . index_page($config['chpu'], $pn);
}

//Модуль категории
if(isset($cat)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'cat.php');
	Registry::getInstance()->Template->txt = nameCAT($headerMETA[3]).index_cat($cat, $config['chpu'], $pn);
}

//Модуль отображение записи (полной)
if(isset($blog)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'text.php');
	Registry::getInstance()->Template->txtFUNCTION = blog($blog, $canon, $config['chpu'], $config['morepost']);
	Registry::getInstance()->Template->txt = Registry::getInstance()->Template->txtFUNCTION[0];	
}

//Модуль галерея
if(preg_match("/\[NCMSgal=[0-9]+\]/s",Registry::getInstance()->Template->txt)) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'galery.php');
	preg_match_all("/\[NCMSgal=([0-9]+)\]/s",Registry::getInstance()->Template->txt,$gal);
	for($i=0;isset($gal[1][$i]);$i++)
	{
		$galery = galery($gal[1][$i]);
		Registry::getInstance()->Template->txt = preg_replace("/\[NCMSgal=[0-9]+\]/",$galery,Registry::getInstance()->Template->txt,1);	
	}
	$viewphoto = viewphoto();
}
if(!isset($viewphoto))$viewphoto = "";

//Модуль комментариев
if(isset($blog) AND Registry::getInstance()->Template->txtFUNCTION[1] == 1) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'comm.php');
	if(!isset($_COOKIE['messW']))$messWLIST = "";
	else $messWLIST = $_COOKIE['messW'];

	if(!isset($error_comm))$error_comm = "";
	$comm = comm($blog, $error_comm, $messWLIST, $config['chpu'], Registry::getInstance()->DataBase->server_root);
	Registry::getInstance()->Template->txt .= $comm;
}

//Модуль топ статьи
if($config['top'] == 1) {
	if(!Registry::getInstance()->Template->topdoc = Registry::getInstance()->Cache->Get('top', 3600)) {
		require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'topdoc.php');
		Registry::getInstance()->Template->topdoc = topdoc($config['chpu']);

		Registry::getInstance()->Cache->Set('top', Registry::getInstance()->Template->topdoc);
	} 
}

//Модуль новых статей
if($config['newpost'] == 1) {
	if(!isset($blog) OR !isset($contact) OR !isset($cat)) {
		if(!Registry::getInstance()->Template->newdoc = Registry::getInstance()->Cache->Get('new', 3600)) {
			require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'newdoc.php');
			Registry::getInstance()->Template->newdoc = newdoc($config['chpu']);	
			Registry::getInstance()->Cache->Set("new", Registry::getInstance()->Template->newdoc);
		}
	}
}

if($config['lastcomm'] == 1) {
	if(!Registry::getInstance()->Template->lastcomm = Registry::getInstance()->Cache->Get('lastcomm', 3600)) {
		require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'lastcomm.php');
		Registry::getInstance()->Template->lastcomm = lastcomm($config['chpu']);
		
		Registry::getInstance()->Cache->Set("lastcomm", Registry::getInstance()->Template->lastcomm);	
	}
}

if($config['poll'] == 1) {
	require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'poll.php');
	if(!isset($_COOKIE[$q])) {
		if(!Registry::getInstance()->Template->poll = Registry::getInstance()->Cache->Get('poll', 3600)) {
			Registry::getInstance()->Template->poll = poll(0);
			
			Registry::getInstance()->Cache->Set("poll", Registry::getInstance()->Template->poll);
		}
	} else {
		if(!Registry::getInstance()->Template->poll = Registry::getInstance()->Cache->Get('pollform', 3600)) {
			Registry::getInstance()->Template->poll = poll(1);
			
			Registry::getInstance()->Cache->Set("pollform", Registry::getInstance()->Template->poll);
		}
	}
}

require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'stats.php');
Registry::getInstance()->Template->stats = stats();

require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'developers.php');

?>
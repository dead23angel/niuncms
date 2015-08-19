<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

define('NiunCMS', true);
define('DEVELOPER', true);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

if (DEVELOPER == true) {
	error_reporting(E_ALL);
	ini_set('display_errors','On');
} else {
	error_reporting(E_ALL);
	ini_set('display_errors','Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT . DS . 'system' . DS . 'logs' . DS . 'error.log');
}

if(!file_exists(ROOT . DS . 'system' . DS . 'data' . DS . 'dbconfig.php')){
	header("location: ../");
 	exit();
}

// Динамическое управление классами
require_once(ROOT . DS . 'system' . DS . 'classes' . DS . 'niun.class.php');

// Подключения класса работы с базой данных
require_once(ROOT . DS . 'system' . DS . 'classes' . DS . 'mysql.php');

// Подключение и инициализация класса работы с кешем
require_once(ROOT . DS . 'system' . DS . 'classes' . DS . 'cache.class.php');
Niun::getInstance()->Set('Cache', new Cache);

// Получаем настройки сайта
include ROOT . DS . 'system' . DS . 'modules' . DS . 'returnconfig.php';
$config = returnconfig();

// Проверка авторизации
include ROOT . DS . 'admin' . DS . 'modules' . DS . 'authoriz.php';
$login = checketHESH();
if(!isset($login)) {
	require_once ROOT . DS . 'admin' . DS . 'login.php';
	exit;
}

// Метаданные для страницы
$header_title = "Панель управление NiunCMS";
$header_metaD = "Управление сайтом";
$header_metaK = "Создать блог, NiunCMS, PHP скрипт, Скрипт для создание блога, Powered by NiunCMS";

// Настроиваем системные переменные
$page   = (isset($_GET['page'])) ? $_GET['page'] : 'index';
$id     = (isset($_GET['id'])) ? $_GET['id'] : '';
$gocomm = (isset($_GET['gocomm'])) ? $_GET['gocomm'] : '';
$pn     = (isset($_GET['pn'])) ? $_GET['pn'] : 1;
$scan   = (isset($_GET['scan'])) ? $_GET['scan'] : 0;

// Формируем ссылки в меню
if($config['chpu'] == 1) {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'chpu.php';
	$station_menu = stationMENU();
}

if($page == "ajax_post_add" OR $page == "ajax_post_edd") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'listpost.php';
 	if($page == "ajax_post_add")
 		lpostMENU(Niun::getInstance()->Get('DataBase')->server_root,$config['chpu'],"add");
 	if($page == "ajax_post_edd")
 		lpostMENU(Niun::getInstance()->Get('DataBase')->server_root,$config['chpu'],"edd");
 	exit;
}
 
if($page == "index") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'statistic.php';
	$txt = statistic();
}
 
if($page == "clearcache") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'cache.php';
	clearcache();
}
 
require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'menu.php';
$txtmenu = menu();

 
if($page == "add_content") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'addcontent.php';
	$txt = addcontent();
}

if($page == "all_menu" || $page == "edd_menu" || $page == "podmenu") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'eddmenu.php';
	if($page == "all_menu")$txt = allmenu();
	if($page == "edd_menu")$txt = eddmenu($edd_menu);
	if($page == "podmenu")$txt = eddpodmenu($edd_menu);
}

if($page == "add_menu") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'addmenu.php';
	$txt = addmenu();
}
 
if($page == "all_content" || $page == "edd_content" || $page == "edd_cat") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'allcontent.php';
	if($page == "all_content")$txt = allcontent($pn,$config['chpu']);
	if($page == "edd_content")$txt = eddcontent($id);
	if($page == "edd_cat")$txt = eddcat($id);
}
 
if($page == "edd_comm") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'comm.php';
	if(!isset($edd_comm))$txt = comm($id);
	else $txt = form_comm($edd_comm);
}

if($page == "modercomm" OR $page == "newcomm" OR $page == "clearcomm") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'controlcomm.php';
	if($page == "modercomm")$txt = controlcomm("modercomm");
	if($page == "newcomm")$txt = controlcomm("newcomm");
}

if($page == "commforemail") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'commforemail.php';
	$txt = commforemail($cfe);
}
 
if($page == "gocomm") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'gocomm.php';
	gocomm($id,$config['chpu'],$gocomm);
}
 
if($page == "contact") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'contact.php';
	$txt = allmess();
}
 
if($page == "mfiles") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'mfiles.php';
	if(!isset($linkFORfile))$linkFORfile = "";
	$txt = formfiles($linkFORfile,$scan,$list);
}
 
if($page == "cfgpost") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'configpost.php';
	$txt = configpost($id);
}
 
if($page == "galery" || $page == "eddgalery" || $page == "addgalery" || $page == "eddphoto") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'galery.php';
	
	if($page == "galery") {
		if(isset($id))$txt = addIMGgalery($id);
		else $txt = allgalery();
	}
	
	if($page == "eddgalery")$txt = editGAL($id);
	if($page == "addgalery")$txt = addGAL();
	if($page == "eddphoto") $txt = eddphotoGAL($id);
}
 
if($page == "quest" || $page == "eddquest" || $page == "addquest") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'quest.php';
	if($page == "quest")$txt = allquest();
	if($page == "addquest")$txt = addQUE();
	if($page == "eddquest")$txt = eddQUE($id);
}
 
if($page == "user" OR $page == "statususer") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'user.php';
	if($page == "user")$txt = user($pn);
	if($page == "statususer")$txt = statususer($id);
}
 
if($page == "configblog") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'configblog.php';
	$txt = configblog();
}
 
if($page == "about") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'about.php';
	$txt = about();
}
 
if($page == "license") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'license.php';
	$txt = license();
}
 
if($page == "modules") {
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'developers.php';
	if(!isset($control)) $txt = listmoreMODULS();
	else $txt = controlMODULS();
}

include ROOT . DS . 'admin' . DS . 'templates' . DS . 'main.html';

?>
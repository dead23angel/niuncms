<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//ОБРАБОТЧИК
if(isset($_GET['activmodul']))$activmodul = $_GET['activmodul'];
if(isset($_GET['control']))$control = $_GET['control'];


if (isset($activmodul))
{
	if (file_exists(ROOT . DS . 'system' . DS . 'inc' . DS . $activmodul . DS . 'config.xml'))//Существует ли файл?
	{
		$installerMODUL = file_get_contents(ROOT . DS . 'system' . DS . 'inc' . DS . $activmodul . DS . 'config.xml');
		
		preg_match("/<installer>([0-9]+)<\/installer>/s", $installerMODUL, $activinstallMODULS);
		$activinstallMODULS = $activinstallMODULS[1];
		
		if (file_exists(ROOT . DS . 'system' . DS . 'inc' . DS . $activmodul . DS . 'installer.php'))//Существует ли файл?
		{
			include(ROOT . DS . 'system' . DS . 'inc' . DS . $activmodul . DS . 'installer.php');
		
			if ($activinstallMODULS == 0) installerMODULS();
			if ($activinstallMODULS == 1) deleteMODULS();
		}
	}
	
	header("location: ?page=modules");//Перенаправление
	exit;//на главную страницу
}
//ОБРАБОТЧИК

function listmoreMODULS()
{
	$dirMODULS = ROOT . DS . 'system' . DS . 'inc' . DS;
	$dataMODULS = opendir($dirMODULS); //сканируем папки в папке
	
	$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'developers.html');
	
	preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$tamp_while);//Находим в шаблоне тут часть, которую будет ду вайлить
	
	while (false !== ($oneMODULS = readdir($dataMODULS))) //собираем массив из результата сканирования
	{
		if($oneMODULS != '.' && $oneMODULS != '..') //Удаляем точки
		{
			$copy_tamp = $tamp_while[1];//Сохраняем ту часть которая будет повторяться в отдельную переменную
			
			$cfgMODULS = file_get_contents($dirMODULS.$oneMODULS.'/config.xml');
			
			preg_match("/<name>(.*?)<\/name>/s", $cfgMODULS, $nameMODULS);
			preg_match("/<installer>([0-9]+)<\/installer>/s", $cfgMODULS, $activMODULS);
			preg_match("/<author>(.*?)<\/author>/s", $cfgMODULS, $authorMODULS);
			preg_match("/<site>(.*?)<\/site>/s", $cfgMODULS, $siteMODULS);
			preg_match("/<description>(.*?)<\/description>/s", $cfgMODULS, $descMODULS);
			preg_match("/<control>([0-9]+)<\/control>/s", $cfgMODULS, $controlMODULS);
			
			$nameMODULS	 = iconv("UTF-8","CP1251",$nameMODULS[1]);
			$activMODULS	 = $activMODULS[1];
			$authorMODULS	 = iconv("UTF-8","CP1251",$authorMODULS[1]);
			$siteMODULS	 = iconv("UTF-8","CP1251",$siteMODULS[1]);
			$descMODULS	 = iconv("UTF-8","CP1251",$descMODULS[1]);
			$controlMODULS	 = $controlMODULS[1];
			
			if ($controlMODULS == 0) $name = $nameMODULS;
			if ($controlMODULS == 1)
			{
				if ($activMODULS == 1) $name = "<a href=\"?page=modules&control=".$oneMODULS."\">".$nameMODULS."</a>";
				else $name = $nameMODULS;
			}
			
			if ($activMODULS == 0)	$copy_tamp = str_replace("[_activ]","img/activ_off.jpg",$copy_tamp);
			else			$copy_tamp = str_replace("[_activ]","img/activ_on.jpg",$copy_tamp);
			
			$copy_tamp = str_replace("[_name]",		$name,$copy_tamp);//имя
			$copy_tamp = str_replace("[_author]", 	$authorMODULS,$copy_tamp);//Автор
			$copy_tamp = str_replace("[_site]",		$siteMODULS,$copy_tamp);//сайт
			$copy_tamp = str_replace("[_desc]",		$descMODULS,$copy_tamp);//описание
			$copy_tamp = str_replace("[_installer]",	$oneMODULS,$copy_tamp);//ссылка на активацию
			$copy_tamp = str_replace("[_modul]",	$oneMODULS,$copy_tamp);//ссылка на настройку
			
			unset($nameMODULS);
			unset($activMODULS);
			unset($authorMODULS);
			unset($siteMODULS);
			unset($descMODULS);
			
			$listMODULS .= $copy_tamp;
		}
	}
	closedir ($dataMODULS);//закрываем папку
	
	if (!isset($listMODULS)) $sm_read = "<p align='center'>Нет модулей для установки <img src='../static/images/smile/smiley-frown.gif'></p>";
	else $sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$listMODULS,$sm_read);//Вставляем в щаблон список модулей
	
	return $sm_read;
}
//--------------------------------------------------------
function controlMODULS()
{
	global $control;
	
	if (file_exists(ROOT . DS . 'system' . DS . 'inc' . DS . $control . 'admincp' . DS . 'index.php')) include (ROOT . DS . 'system' . DS . 'inc' . DS . $control . 'admincp' . DS . 'index.php');
	
	if (!isset($txt)) $txt = "<p align='center'>У данного модуля настроек нет <img src='../static/images/smile/smiley-frown.gif'></p>";
	
	return $txt;
}
?>
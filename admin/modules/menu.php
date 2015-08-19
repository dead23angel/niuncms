<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function menu()
{
	global $page;
	$messDB = Niun::getInstance()->Get('DataBase')->Query("SELECT COUNT(*) FROM mess_admin WHERE loock='0'");
	$mess = Niun::getInstance()->Get('DataBase')->GetArray($messDB);

	$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'menu.html');
	
	$massiv = searchmoduls();
	
	if ($massiv !== FALSE)
	{
		preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$tamp_while);

		$result = (!isset($result)) ? '' : $result;
		$tamp_while = (empty($tamp_while)) ? array('1' => '') : $tamp_while;
		
		foreach ($massiv as $value)
		{
			$templ = $tamp_while[1];
			
			$templ = str_replace("[_modul]",$value['modul'],$templ);
			$templ = str_replace("[_namemodul]",$value['name'],$templ);
			
			$result .= $templ;
		}
		
		$sm_read = preg_replace("/\[_while\].*?\[_while\]/s", $result, $sm_read);//
	}
	else $sm_read = preg_replace("/\[_while\].*?\[_while\]/s", "", $sm_read);//
	
	if($mess[0] > 0)$sm_read = str_replace("[_email]","bold",$sm_read);
	else $sm_read = str_replace("[_email]","100",$sm_read);
	
	$sm_read = str_replace("[_page]",$page,$sm_read);
	
	return $sm_read;//Выводим с генерированный html код
}
//-------------------------------------------------
function searchmoduls()
{
	$dirMODULS = ROOT . DS . 'system' . DS . 'inc' . DS ;
	$dataMODULS = opendir($dirMODULS); //сканируем папки в папке
	$i = 0;
	while (false !== ($oneMODULS = readdir($dataMODULS))) //собираем массив из результата сканирования
	{
		if($oneMODULS != '.' && $oneMODULS != '..') //Удаляем точки
		{
			$cfgMODULS = file($dirMODULS.$oneMODULS."/config.xml");//открываем файл
			$cfgMODULS = implode("", $cfgMODULS);
			preg_match("/<installer>([0-9]+)<\/installer>/s", $cfgMODULS, $activMODULS);
			preg_match("/<control>([0-9]+)<\/control>/s", $cfgMODULS, $controlMODULS);
			preg_match("/<name>(.*?)<\/name>/s", $cfgMODULS, $nameMODULS);
			
			$activMODULS 	= $activMODULS[1];
			$controlMODULS	= $controlMODULS[1];
			$nameMODULS 	= iconv("UTF-8","CP1251",$nameMODULS[1]);
			
			if ($activMODULS == 1 AND $controlMODULS == 1)
			{
				$massiv[$i]['name'] = $nameMODULS;
				$massiv[$i]['modul'] = $oneMODULS;
				$i++;
			}
			
			unset($activMODULS);
			unset($controlMODULS);
			unset($nameMODULS);
		}
	}
	closedir ($dataMODULS);//закрываем папку
	
	if (isset($massiv)) return $massiv;
	else return FALSE;
}
?>
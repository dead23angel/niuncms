<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

$dirMODULS = ROOT . DS . 'system' . DS . 'inc' . DS ;
$dataMODULS = opendir($dirMODULS);
while (false !== ($oneMODULS = readdir($dataMODULS)))
{
	if($oneMODULS != '.' && $oneMODULS != '..')
	{
		$cfgMODULS = file($dirMODULS.$oneMODULS."/config.xml");
		$cfgMODULS = implode("", $cfgMODULS);
		preg_match("/<installer>([0-9]+)<\/installer>/s", $cfgMODULS, $activMODULS);
		
		$activMODULS = $activMODULS[1];
		
		if ($activMODULS == 1) include($dirMODULS.$oneMODULS."/index.php");
		
		unset($activMODULS);
	}
}
closedir ($dataMODULS);
?>
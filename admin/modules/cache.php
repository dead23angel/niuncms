<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function clearcache()
{
	$data = opendir(ROOT . DS . 'system' . DS . 'cache' . DS);
	$mass = 0;
	while (false !== ($one = readdir($data)))
	{
		if($one != '.' && $one != '..')
		{
			$cache[$mass] = $one;
			$mass++;
		}
	}
	closedir ($data);
	
	for($i=0;isset($cache[$i]);$i++)unlink(ROOT . DS . 'system' . DS . 'cache' . DS . $cache[$i]);
	
	header("location: ".getenv('HTTP_REFERER'));
	exit;
}

?>
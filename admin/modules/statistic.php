<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function version() // Версия CMS
{
	include (ROOT . '/system/data/config.php');
	return $settings['version'];
}

function php() // Версия PHP
{
	return PHP_VERSION;
}
function apache()
{
	return (function_exists('apache_get_modules')) ? ((array_search("mod_rewrite", apache_get_modules())) ? "Включен" : "Выключен") : "Выключен";
}

function php_gd()
{
	$gdversion = gd_info();
	return $gdversion['GD Version'];
}

function safe()
{ 
	return (ini_get('safe_mode') == 1) ? "Включен" : "Выключен";
}

function sizesite()
{
	$size = 0; 
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator(ROOT)) as $file){ 
        $size+=$file->getSize(); 
    }
    $size_txt = array(' байт',' кбайт',' мбайт');

	for($i=0;$i<3;$i++)
		{
			if ($size >= 1024)
			{
				$size = $size/1024;
				$size = round($size, 2);
			}
			else
			{
				$size = $size.$size_txt[$i];
				break;
			}
		}
    return $size; 
}

function db_version() {
	$row = Niun::getInstance()->Get('DataBase')->GetArray(Niun::getInstance()->Get('DataBase')->Query("SELECT VERSION()")); 
	return $row[0];
}

function sizecache()
{
	$data = opendir(ROOT . DS . 'system' . DS . 'cache' . DS);

	$size = (!isset($size)) ? '' : $size;
	
	while (false !== ($one = readdir($data)))
	{
		if($one != '.' && $one != '..') $size += filesize(ROOT . DS . 'system' . DS . 'cache' . DS . $one);
	}
	closedir ($data);
	
	if(!isset($size)) $size = 0;
	
	$size_txt = array(' байт',' кбайт',' мбайт');
	
	for($i=0;$i<3;$i++)
	{
		if ($size >= 1024)
		{
			$size = $size/1024;
			$size = round($size, 2);
		}
		else
		{
			$size = $size.$size_txt[$i];
			break;
		}
	}
	
	return $size;
}

function statistic()
{
//--------------------------
$result_content = Niun::getInstance()->Get('DataBase')->Query("SELECT COUNT(*) FROM blog WHERE pablick='1'");//
$myrow_content = Niun::getInstance()->Get('DataBase')->GetArray($result_content);
//--------------------------
//--------------------------
$result_comm = Niun::getInstance()->Get('DataBase')->Query("SELECT COUNT(*) FROM comm");//
$myrow_comm = Niun::getInstance()->Get('DataBase')->GetArray($result_comm);
//--------------------------
//--------------------------
$result_commview = Niun::getInstance()->Get('DataBase')->Query("SELECT COUNT(*) FROM comm WHERE loock = '0' AND status < '3'");//
$myrow_commview = Niun::getInstance()->Get('DataBase')->GetArray($result_commview);
//--------------------------
//--------------------------
$result_moder = Niun::getInstance()->Get('DataBase')->Query("SELECT COUNT(*) FROM comm WHERE status = '3'");//
$myrow_moder = Niun::getInstance()->Get('DataBase')->GetArray($result_moder);
//--------------------------
//--------------------------
$result_post = Niun::getInstance()->Get('DataBase')->Query("SELECT date_b FROM blog LIMIT 1");//
$myrow_post = Niun::getInstance()->Get('DataBase')->GetArray($result_post);

if($myrow_post != "")
{
	$now = time();
	$now -= $myrow_post['date_b'];
	$now = (($now/60)/60)/24;
	$now = explode(".", $now);
}
else $now[0] = "-";

$raderFILE = file_get_contents(ROOT . DS . 'upload' . DS .  'reader.xml');
preg_match("/<rss>([a-z0-9]+)<\/rss>/s",$raderFILE,$readerRSS);
preg_match("/<twitter>([a-z0-9]+)<\/twitter>/s",$raderFILE,$readerTW);
//--------------------------

$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'statistic.html');

$sm_read = str_replace("[_content]",$myrow_content[0],$sm_read);
$sm_read = str_replace("[_comm]",$myrow_comm[0],$sm_read);
$sm_read = str_replace("[_commview]",$myrow_commview[0],$sm_read);
$sm_read = str_replace("[_commmoder]",$myrow_moder[0],$sm_read);
$sm_read = str_replace("[_rssreader]",$readerRSS[1],$sm_read);
$sm_read = str_replace("[_twreader]",$readerTW[1],$sm_read);
$sm_read = str_replace("[_life]",$now[0],$sm_read);
$sm_read = str_replace("[_sizeceche]",sizecache(),$sm_read);

$sm_read = str_replace("[info]",version(),$sm_read);//
$sm_read = str_replace("[php]",php(),$sm_read);//
$sm_read = str_replace("[apache]",apache(),$sm_read);//
$sm_read = str_replace("[gd]",php_gd(),$sm_read);//
$sm_read = str_replace("[safe]",safe(),$sm_read);//
$sm_read = str_replace("[sizesite]",sizesite(),$sm_read);//
$sm_read = str_replace("[mysql]", db_version(), $sm_read);

return $sm_read;
}
?>
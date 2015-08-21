<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined('NiunCMS')) die('Доступ запрещен');

class Niun {
	
	function __construct() {}
	
    public static function loadClass($className)
	{
		$className = preg_replace("/[^0-9a-z_]/i", "", $className);
		switch ($className)
		{
			//case "Smarty":
			//	$namespacePath = ENGINEDIR . "/classes/Smarty/Smarty.class.php";
			//	break;

			//case "PHPMailer":
			//	$namespacePath = ENGINEDIR . "/classes/PHPMailer/class.phpmailer.php";
			//	break;

			//case "TCPDF":
			//	$namespacePath = ENGINEDIR . "/classes/TCPDF/tcpdf.php";
			//	break;

			//case "PHPExcel":
			//	$namespacePath = ENGINEDIR . "/classes/PHPExcel/PHPExcel.php";
			//	break;

			default:
				$namespacePath = ENGINEDIR . "/classes/" . str_replace("_", DIRECTORY_SEPARATOR, $className) . ".php";
				break;
		}


		if (file_exists($namespacePath))
		{
			include_once $namespacePath;
			return true;
		}

		return false;
	}
	
	public static function start()
	{
		global $starttime;
		$mtime = microtime();
		$mtime = explode( ' ', $mtime );
		$mtime = $mtime[1] + $mtime[0];
		$starttime = $mtime;
	}

	public static function stop()
	{
		global $starttime;
		$mtime = microtime();
		$mtime = explode( ' ', $mtime );
		$mtime = $mtime[1] + $mtime[0];
		$endtime = $mtime;
		$totaltime = round( ($endtime - $starttime), 5 );
		return $totaltime;
	}

	public static function memory()
	{
		$memory = memory_get_usage();
		if($memory < 1024)
		{
			$memory .= " байт";
			return $memory;
		}
		else
		{
			$memory = $memory/1024;
			if($memory < 1024)
			{
				$memory = round($memory)." кб";
				return $memory;
			}
			else
			{
				$memory = $memory/1024;
				$memory = round($memory)." мб";
				return $memory;
			}
		}
	}
}
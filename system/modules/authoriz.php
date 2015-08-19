<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function checketHESH()
{
	if(isset($_GET['logSESS'])) {$logSESS = $_GET['logSESS'];unset($logSESS);}
	if(isset($_POST['logSESS'])) {$logSESS = $_POST['logSESS'];unset($logSESS);}

  	session_start();
  	$logSESS = (!empty($_SESSION['logSESS'])) ? $_SESSION['logSESS'] : '';
  
  	if(isset($logSESS))
	{		
		$hesh = md5($_SERVER['HTTP_USER_AGENT'] . @$_SERVER['HTTP_ACCEPT_CHARSET']);
		
		if ($logSESS === $hesh) return TRUE;
	}
	
	return FALSE;
}
?>
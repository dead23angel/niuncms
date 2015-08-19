<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function checketHESH()
{
	if(isset($_GET['logSESS'])) {$login = $_GET['logSESS'];unset($login);}
	if(isset($_POST['logSESS'])) {$login = $_POST['logSESS'];unset($login);}

  	session_start();
  	$login = (!isset($_SESSION['logSESS'])) ? NULL : $_SESSION['logSESS'];
  
  	if(!isset($login))
  	{
		return $login;
		exit;  
  	}
	else
	{		
		$hesh = md5($_SERVER['HTTP_USER_AGENT'] . @$_SERVER['HTTP_ACCEPT_CHARSET']);
		
		if ($login !== $hesh)
		{
			return $login;
			exit; 
		}
	}
	return $login;
}

function heshDB()
{	
	$hesh = md5($_SERVER['HTTP_USER_AGENT'] . @$_SERVER['HTTP_ACCEPT_CHARSET']);
	
	return $hesh;
}
?>
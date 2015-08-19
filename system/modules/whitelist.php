<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

$userRESULT = Niun::getInstance()->Get('DataBase')->Query("SELECT `email`, `status` FROM whitelist WHERE email='$email_comm'");
$user = Niun::getInstance()->Get('DataBase')->GetArray($userRESULT);
if($config['whitelist'] == 0)
{
	if($user != "")
	{
		if($user['status'] == 4)
		{
			cookieMessW(Niun::getInstance()->Get('DataBase')->server_root,"Вы не можете оставлять комментарии.");
			header("location: ".getenv('HTTP_REFERER'));
			exit;
		}
		if($user['status'] == 3)
		cookieMessW(Niun::getInstance()->Get('DataBase')->server_root,"Ваше сообщение появится после того как администратор его проверит.");
		
		$status = $user['status'];
	}
	else
	{
		$status = 2;
		$result_add_new_user = Niun::getInstance()->Get('DataBase')->Query ("INSERT INTO whitelist (email,status) VALUES ('$email_comm','2')");
	}
}
else
{
	if($user != "")
	{
		if($user['status'] == 4)
		{
			cookieMessW(Niun::getInstance()->Get('DataBase')->server_root,"Вы не можете оставлять комментарии.");
			header("location: ".getenv('HTTP_REFERER'));//Перенаправляем пользователя
			exit;
		}
		
		if($user['status'] == 3)cookieMessW(Niun::getInstance()->Get('DataBase')->server_root,"Включена премодерация комментариев. Ваше сообщение появится после того как администратор его проверит.");
		
		$status = $user['status'];
	}
	else
	{
		$status = 3;
		$result_add_new_user = Niun::getInstance()->Get('DataBase')->Query ("INSERT INTO whitelist (email,status) VALUES ('$email_comm','3')");
		cookieMessW(Niun::getInstance()->Get('DataBase')->server_root,"Включена премодерация комментариев. Ваше сообщение появится после того как администратор его проверит.");
	}
}

function cookieMessW($server_root,$txt)
{
	preg_match("/http:\/\/(.*?)\//s",$server_root,$cookieSITE);
	$cookieSITE = str_replace("www.","",$cookieSITE[1]);
	
	setcookie("messW",$txt,time()+300,"/",".".$cookieSITE);
}
?>
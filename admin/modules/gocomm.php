<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function gocomm($id,$chpu,$gocomm)
{
	if($chpu == 1)
	{
		$gocommR = Niun::getInstance()->Get('DataBase')->Query("SELECT nameurl,cat FROM blog WHERE id='$gocomm'");//
		$gocommW = Niun::getInstance()->Get('DataBase')->GetArray($gocommR);
	}
	
	if($chpu == 0)$linkFORpost = "../index.php?blog=".$gocomm."#comm".$id;
	else $linkFORpost = "../".gen_catalog($gocommW['cat']).$gocommW['nameurl']."#comm".$id;
	
	$edd_commDB = Niun::getInstance()->Get('DataBase')->Query ("UPDATE comm SET loock='1' WHERE id='$id'");

	header("location: ".$linkFORpost);//Перенаправление
	exit;//на главную страницу
}
?>
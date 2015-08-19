<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//--------------УДАЛЕНИЕ СООБЩЕНИЯ
if(isset($_GET['del_mess']))$del_mess= $_GET['del_mess'];
if(isset($del_mess))
{
	$result_del_mess = Niun::getInstance()->Get('DataBase')->Query ("DELETE FROM mess_admin WHERE id='$del_mess'");//удаляем сообщение
	header("location: ?page=contact");//Перенаправляем пользователя
	exit;//обратно к сообщениям	
}
//--------------УДАЛЕНИЕ СООБЩЕНИЯ

//--------------ОТМЕТИТЬ КАК ПРОЧИТАННОЕ ДЛЯ ОПРЕДЕЛЕННОГО СООБЩЕНИЯ
if(isset($_GET['read_mess']))$read_mess = $_GET['read_mess'];
if(isset($read_mess))
{
	$loock = Niun::getInstance()->Get('DataBase')->Query ("UPDATE mess_admin SET loock='1' WHERE id='$read_mess'");
	header("location: ?page=contact");//Перенаправляем пользователя
	exit;//обратно к сообщениям	
}
//--------------ОТМЕТИТЬ КАК ПРОЧИТАННОЕ ДЛЯ ОПРЕДЕЛЕННОГО СООБЩЕНИЯ

//--------------ОТМЕТИТЬ КАК ПРОЧИТАННОЕ ДЛЯ ВСЕХ НЕ ПРОЧИТАННЫХ
if(isset($_GET['read_mess_all']))$read_mess_all = $_GET['read_mess_all'];
if(isset($read_mess_all))
{
	$loock = Niun::getInstance()->Get('DataBase')->Query ("UPDATE mess_admin SET loock='1' WHERE loock='0'");
	header("location: ?page=contact");//Перенаправляем пользователя
	exit;//обратно к сообщениям	
}
//--------------ОТМЕТИТЬ КАК ПРОЧИТАННОЕ ДЛЯ ВСЕХ НЕ ПРОЧИТАННЫХ

function allmess()//Функция вывода всех сообщений
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'allcontact.html');

$messDB = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM mess_admin");//Выводим из базы данных сообщения
$mess = Niun::getInstance()->Get('DataBase')->GetArray($messDB);

if($mess != "")
{
	preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$pmtemp);

	do
	{
		$copy_temp = $pmtemp[1];
		
		$dateMESS = date("d/m/Y H:i",$mess['date_g']);
		if($mess['loock'] == 1)$act = "on";
		else $act = "off";
		
		$copy_temp = str_replace("[_activ]","img/activ_".$act.".jpg",$copy_temp);//статус сообщение (читали или нет)		
		$copy_temp = str_replace("[_login]",$mess['login'],$copy_temp);//Автор
		$copy_temp = str_replace("[_email]",$mess['email'],$copy_temp);//Емайл
		$copy_temp = str_replace("[_them]",$mess['them'],$copy_temp);//Тема
		$copy_temp = str_replace("[_date_g]",$dateMESS,$copy_temp);//Дата
		$copy_temp = str_replace("[_text]",$mess['text'],$copy_temp);//Текст
		$copy_temp = str_replace("[_id]",$mess['id'],$copy_temp);//ID
		
		$rTemp .= $copy_temp;
	}
	while($mess = Niun::getInstance()->Get('DataBase')->GetArray($messDB));
	$sm_read = preg_replace("/\[_while\](.*?)\[_while\]/s",$rTemp,$sm_read);
	
	$sm_read = str_replace("[_idR]","true",$sm_read);//ID
	
	return $sm_read;//Выводим с генерированный html код
}
else return "<p align='center'>Сообщений нет!</p>";

}
?>
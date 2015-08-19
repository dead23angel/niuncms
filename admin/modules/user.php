<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//РЕДАКТОР СТАТУСА ПОЛЬЗОВАТЕЛЯ
if(isset($_POST['edd_status_user']))$edd_status_user = $_POST['edd_status_user'];
if(isset($_POST['edd_id_status_user']))$edd_id_status_user = $_POST['edd_id_status_user'];

if(isset($edd_status_user))
{
	$result_old_status = Niun::getInstance()->Get('DataBase')->Query("SELECT email FROM whitelist WHERE id='$edd_id_status_user'");
	$old_status = Niun::getInstance()->Get('DataBase')->GetArray($result_old_status);

	$newstatusDB = Niun::getInstance()->Get('DataBase')->Query ("UPDATE whitelist SET status='$edd_status_user' WHERE id='$edd_id_status_user'");
	if($edd_status_user != 4)$status = $edd_status_user;
	else $status = 2;
	
	$newstatusDB_email = Niun::getInstance()->Get('DataBase')->Query ("UPDATE comm SET status='$status' WHERE email='".$old_status['email']."' AND status<'3'");
	
	header("location: ".getenv('HTTP_REFERER'));
	exit;
}
//РЕДАКТОР СТАТУСА ПОЛЬЗОВАТЕЛЯ

function user($pn)//Функция вывода списка mеню
{

include(ROOT . DS . 'admin' . DS . 'modules' . DS . 'navig.php');

$limit = navig(100,$pn,"user");
$links = $limit[2];

$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'user.html');

preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$tamp_while);//Находим в шаблоне тут часть, которую будет ду вайлить

$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM whitelist ORDER BY id DESC LIMIT $limit[0], $limit[1]");//Выводим из базы данных пункты меню
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

	if ($myrow_index != "")
	{
		do
		{
			$copy_tamp = $tamp_while[1];//Сохраняем ту часть которая будет повторяться в отдельную переменную
			
			if($myrow_index['status'] == 4)$status = "Бан";
			if($myrow_index['status'] == 3)$status = "Не подтвержден";
			if($myrow_index['status'] == 2)$status = "Гость";
			if($myrow_index['status'] == 1)$status = "Посетитель";
			if($myrow_index['status'] == 0)$status = "Администратор";
			
			//Делаем замены код-слов
			$copy_tamp = str_replace("[_status]",$status,$copy_tamp);//
			$copy_tamp = str_replace("[_email]",$myrow_index['email'],$copy_tamp);//адрес ящика
			$copy_tamp = str_replace("[_id]",$myrow_index['id'],$copy_tamp);//ID
			
			$list .= $copy_tamp;//Объединяем результат в одну переменную
		}
		while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));
		
		$sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$list,$sm_read);//Вставляем в щаблон список пользователей
		
		if($links > 1)$sm_read .= listnav($links,$pn,6,"user");//Вывод ссылок на страницы
		
		return $sm_read;//Выводим с генерированный html код
	}
	else return "В базе данных нет пользователей";
}
//---------------------------------------------
function statususer($id)
{
	$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'statususer.html');
	
	$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT status FROM whitelist WHERE id='$id'");//Выводим из базы данных пункты меню
	$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);
	
	for($i=4;$i>=0;$i--)
	{
		if($i == 4)$status = "Бан";
		if($i == 2)$status = "Гость";
		if($i == 1)$status = "Пользователь";
		if($i == 0)$status = "Администратор";
		
		if($i != 3)
		{
			if($myrow_index['status'] == $i)$select = " selected";
			else $select = "";
			$option .= "<option value=\"".$i."\"".$select.">".$status."</option>";
		}
	}
	
	$sm_read = str_replace("[_option]",$option,$sm_read);
	$sm_read = str_replace("[_id]",$id,$sm_read);//ID
	
return $sm_read;
}
?>
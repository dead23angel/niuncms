<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");


if($page == "clearcomm")
{
	$edd_commDB = Niun::getInstance()->Get('DataBase')->Query ("UPDATE comm SET loock='1' WHERE status<'3'");

	header("location: ".getenv('HTTP_REFERER'));
	exit;
}

if(isset($_GET['mcomm']))$mcomm = $_GET['mcomm'];
if(isset($mcomm))
{
	//выводим из бд мыло и id поста
	$userDBR = Niun::getInstance()->Get('DataBase')->Query("SELECT email,blog FROM comm WHERE id='$mcomm'");
	$userDB = Niun::getInstance()->Get('DataBase')->GetArray($userDBR);
	
	//вытаскиваем кол-во комм из таблицы blog
	$result_count = Niun::getInstance()->Get('DataBase')->Query("SELECT comm FROM blog WHERE id='".$userDB['blog']."'");
	$myrow_count = Niun::getInstance()->Get('DataBase')->GetArray($result_count);
	
	//меняем кол-во комм
	$newcountCOMM = $myrow_count['comm'] + 1;
	
	$edd_commPR = Niun::getInstance()->Get('DataBase')->Query ("UPDATE comm SET status='2' WHERE id='$mcomm'");//обновляем статус
	$edd_count = Niun::getInstance()->Get('DataBase')->Query ("UPDATE blog SET comm='$newcountCOMM' WHERE id='".$userDB['blog']."'");//обновляем кол-во комм
	$edd_userPR = Niun::getInstance()->Get('DataBase')->Query ("UPDATE whitelist SET status='2' WHERE email='".$userDB['email']."'");//обновляем статус мыла в белом листе
	
	Niun::getInstance()->Get('Cache')->Clean("lastcomm");
	
	header("location: ".getenv('HTTP_REFERER'));
	exit;	
}

function controlcomm($control)
{
if($control == "modercomm")
{
	$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'modercomm.html');
	$sql = "SELECT * FROM comm WHERE status = '3'";
}
if($control == "newcomm")
{
	$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'newcomm.html');
	$sql = "SELECT * FROM comm WHERE loock = '0' AND status != '3'";
}

$allcomm = Niun::getInstance()->Get('DataBase')->Query($sql);
$comm_blog = Niun::getInstance()->Get('DataBase')->GetArray($allcomm);
if($comm_blog != "")
{

	$res = (!isset($res)) ? '' : $res;

	do
	{
		$dateCOMM = date("d/m/Y H:i",$comm_blog['date_comm']);

		$sm_read = str_replace("[_author]",$comm_blog['author'],$sm_read);//Автор
		$sm_read = str_replace("[_dateG]",$dateCOMM,$sm_read);//Дата
		$sm_read = str_replace("[_text]",$comm_blog['text'],$sm_read);//Текст
		$sm_read = str_replace("[_id]",$comm_blog['id'],$sm_read);//Инфо из колонки ID в табл
		$sm_read = str_replace("[_blog]",$comm_blog['blog'],$sm_read);//Инфо из колонки blog в табл
		$sm_read = str_replace("[_email]",$comm_blog['email'],$sm_read);//Инфо из колонки email в табл
		
		$res .= $sm_read;
	}
	while($comm_blog = Niun::getInstance()->Get('DataBase')->GetArray($allcomm));
}

else $res = "<p align='center'>Нет новых комментариев.</p>";

return $res;
}
?>
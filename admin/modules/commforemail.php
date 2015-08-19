<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

if(isset($_GET['cfe']))$cfe = $_GET['cfe'];
function commforemail($email)
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'commforemail.html');

$allcomm = Niun::getInstace()->Get('DataBase')->Query("SELECT * FROM comm WHERE email='$email'");
$comm_blog = Niun::getInstace()->Get('DataBase')->GetAarray($allcomm);
if($comm_blog != "")
{
	do
	{
		$dateCOMM = date("d/m/Y H:i",$comm_blog['date_comm']);
	
		$copy_tamp = $sm_read;//создаем копию шаблона
		$copy_tamp = str_replace("[_author]",$comm_blog['author'],$copy_tamp);//Автор
		$copy_tamp = str_replace("[_dateG]",$dateCOMM,$copy_tamp);//Дата
		$copy_tamp = str_replace("[_text]",$comm_blog['text'],$copy_tamp);//Текст
		$copy_tamp = str_replace("[_id]",$comm_blog['id'],$copy_tamp);//Инфо из колонки ID в табл
		$copy_tamp = str_replace("[_blog]",$comm_blog['blog'],$copy_tamp);//Инфо из колонки blog в табл
		$copy_tamp = str_replace("[_email]",$comm_blog['email'],$copy_tamp);//Инфо из колонки email в табл
		if($comm_blog['status'] == 3)$copy_tamp = str_replace("[_style]","#F6F6F6",$copy_tamp);
		else $copy_tamp = str_replace("[_style]","#fff",$copy_tamp);
		
		$res .= $copy_tamp;
	}
	while($comm_blog = Niun::getInstace()->Get('DataBase')->GetArray($allcomm));
}
else $res = "<p align='center'>Нет новых комментариев</p>";

return $res;
}
?>
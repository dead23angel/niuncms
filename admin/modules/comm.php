<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

if(isset($_GET['edd_comm']))$edd_comm = $_GET['edd_comm'];
//--------------РЕДАКТИРОВАНИЕ КОММЕТАРИЕВ
if(isset($_POST['eddname_comm']))$eddname_comm = $_POST['eddname_comm'];
if(isset($_POST['eddtxt_comm']))$eddtxt_comm = $_POST['eddtxt_comm'];
if(isset($_POST['eddid_post']))$eddid_post = $_POST['eddid_post'];
if(isset($eddname_comm) & isset($eddtxt_comm))//Если форма была заполнена и нажата кнопка "Отправить"
{
	//Переводим html код (если есть) в каракозябры =)
	$eddname_comm = htmlspecialchars($eddname_comm);
	$eddtxt_comm = htmlspecialchars($eddtxt_comm);
	
	//Избавляемся от кавычки
	$eddname_comm = str_replace("\\","&#92;",$eddname_comm);
	$eddtxt_comm = str_replace("\\","&#92;",$eddtxt_comm);

	$eddname_comm = addslashes($eddname_comm);
	$eddtxt_comm = addslashes($eddtxt_comm);

	$eddname_comm = str_replace("[", "&#91;", $eddname_comm);
	$eddname_comm = str_replace("]", "&#93;", $eddname_comm);
		
	$eddtxt_comm = str_replace("[", "&#91;", $eddtxt_comm);
	$eddtxt_comm = str_replace("]", "&#93;", $eddtxt_comm);
	
	$eddtxt_comm = str_replace("\n","<BR>",$eddtxt_comm);//Заменяем переносы строки на тег <BR>
	
	//обновляем сообщение в базе данных
	$edd_commDB = Niun::getInstance()->Get('DataBase')->Query ("UPDATE comm SET text='$eddtxt_comm', author='$eddname_comm' WHERE id='$edd_comm'");

	Niun::getInstance()->Get('Cache')->Clear("lastcomm");//делаем кэш модуля "последние комментарии" устаревшим
	
	header("location: admin.php?page=edd_comm&id=".$eddid_post);//Перенаправляем пользователя
	exit;//обратно к форме с комментариями
}
//--------------РЕДАКТИРОВАНИЕ КОММЕТАРИЕВ

//--------------УДАЛЕНИЕ КОММЕТАРИЕВ
if(isset($_GET['del_comm']))$del_comm = $_GET['del_comm'];
if(isset($del_comm))
{
	//выводим из бд id поста и статус комм
	$result_blog = Niun::getInstance()->Get('DataBase')->Query("SELECT blog,status FROM comm WHERE id='$del_comm'");
	$myrow_blog = Niun::getInstance()->Get('DataBase')->GetArray($result_blog);
	
	//Удаляем комментарий из счетчик комментариев
	if($myrow_blog['status'] < 3)//если комм уже опубликован (иначе его счетчик не нужно менять в бд)
	{
		//вытаскиваем число с кол-вом комм
		$result_count = Niun::getInstance()->Get('DataBase')->Query("SELECT comm FROM blog WHERE id='".$myrow_blog['blog']."'");
		$myrow_count = Niun::getInstance()->Get('DataBase')->GetArray($result_count);
		
		//изменяем показатель
		$newcountCOMM = $myrow_count['comm'] - 1;
		
		//записываем измененный показатель
		$edd_count = Niun::getInstance()->Get('DataBase')->Query ("UPDATE blog SET comm='$newcountCOMM' WHERE id='".$myrow_blog['blog']."'");
	}

	$result_del_comm = Niun::getInstance()->Get('DataBase')->Query ("DELETE FROM comm WHERE id='$del_comm'");//удаляем комм
	
	Niun::getInstance()->Get('Cache')->Clear("lastcomm");//делаем кэш модуля "последние комментарии" устаревшим
	
	header("location: admin.php?page=edd_comm&id=".$id);//Перенаправляем пользователя
	exit;//обратно к форме с комментариями
}
//--------------УДАЛЕНИЕ КОММЕТАРИЕВ

function comm($id)//функция вывода списка комментарьев
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'comm.html');

$allcomm = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM comm WHERE blog = '$id'");//Выводим из базы данных все комментарии из определенного блога
$comm_blog = Niun::getInstance()->Get('DataBase')->GetArray($allcomm);
if($comm_blog != "")//Если комментарии
{
	do//То формируем список
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
		
		$res .= $copy_tamp;//объеденяем результат в одну переменную
	}
	while($comm_blog = Niun::getInstance()->Get('DataBase')->GetArray($allcomm));
}
else $res = "<p align='center'>Нет новых комментариев</p>";//Если нет комментарьев то выведим сообщение

return $res;//Выводим с генерированный html код
}

function form_comm($edd_comm)//Функция вывода формы
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'edd_comm.html');

$commDB = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM comm WHERE id='$edd_comm'");//Выводим из базы данных комментарий
$comm_blog = Niun::getInstance()->Get('DataBase')->GetArray($commDB);

$text = str_replace("<BR>","",$comm_blog['text']);//чистим текст от тега <br>

$sm_read = str_replace("[_author]",$comm_blog['author'],$sm_read);//Автор
$sm_read = str_replace("[_text]",$text,$sm_read);//Текст
$sm_read = str_replace("[_id]",$comm_blog['id'],$sm_read);//Инфо из колонки ID в табл
$sm_read = str_replace("[_blog]",$comm_blog['blog'],$sm_read);//Инфо из колонки blog в табл

return $sm_read;//Выводим с генерированный html код
}
?>
<?php
### NiunCMS - Community Management System ###
### Powered by SibWeb Media Group         ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined('ADMINPART')) die();

if(isset($_GET['edd_rsv']))$edd_rsv = $_GET['edd_rsv'];

//РЕДАКТИРУЕМ БЛОК
if(isset($_POST['edd_rsvid']))$edd_rsvid = $_POST['edd_rsvid'];
if(isset($_POST['eddrstxt']))$eddrstxt = $_POST['eddrstxt'];
if(isset($_POST['eddrsvname']))$eddrsvname = $_POST['eddrsvname'];
if(isset($_POST['eddrsvtpl']))$eddrsvtpl = $_POST['eddrsvtpl'];

if(isset($eddrstxt) AND isset($eddrsvname))
{	
	//Избавляемся от кавычки
	$eddrsvname = htmlspecialchars($eddrsvname);
	
	$eddrsvname = addslashes($eddrsvname);
	$eddrstxt = addslashes($eddrstxt);
	//Избавляемся от кавычки

	$edd_punct = mysql_query ("UPDATE blocki SET tpl='$eddrsvtpl', name='$eddrsvname', text='$eddrstxt' WHERE id='$edd_rsvid'");

	header("location: index.php?page=modules&control=blocki");//Перенаправление
	exit;//на страницу пунктов меню
}
//РЕДАКТИРУЕМ БЛОК

//ДОБАВЛЕНИЕ БЛОК
if(isset($_POST['addrsvname']))$addrsvname = $_POST['addrsvname'];
if(isset($_POST['addrstxt']))$addrstxt = $_POST['addrstxt'];
if(isset($_POST['addrsvtpl']))$addrsvtpl = $_POST['addrsvtpl'];

if(isset($addrsvname) AND isset($addrstxt))
{
	$result_index = mysql_query("SELECT COUNT(*) FROM blocki");//Выводим из базы данных пункты меню
	$myrow_index = mysql_fetch_array($result_index);
	
	$rscol = $myrow_index[0];//Узнаем общее количество пунктов в базе данных
	$rscol++;
	
	$addrsvname = htmlspecialchars($addrsvname);
	
	$addrsvname = addslashes($addrsvname);
	$addrstxt = addslashes($addrstxt);
	
	$result_add_rsmenu = mysql_query ("INSERT INTO blocki (id,name,text,position,tpl) 
	VALUES ('','$addrsvname','$addrstxt','$rscol','$addrsvtpl')");

	header("location: index.php?page=modules&control=blocki");//Перенаправление
	exit;//на страницу пунктов меню
}
//ДОБАВЛЕНИЕ БЛОК

//УДАЛЕНИЕ БЛОК
if(isset($_GET['del_rsv']))$del_rsv = $_GET['del_rsv'];
if(isset($del_rsv))
{
	$result_del_rsmenu = mysql_query ("DELETE FROM blocki WHERE id='$del_rsv'");//удаляем пункт меню
	
	$res_delrsmenu = mysql_query("SELECT id FROM blocki ORDER BY position");//Выводим из базы данных пункт меню сортируя их по колонке position
	$my_delrsmenu = mysql_fetch_array($res_delrsmenu);
	
	$new_pos_menu = 1;	
	do
	{
		$edd_pos_rsmenu = mysql_query ("UPDATE blocki SET position='$new_pos_menu' WHERE id='".$my_delrsmenu['id']."'");
		$new_pos_menu++;
	}
	while($my_delrsmenu = mysql_fetch_array($res_delrsmenu));
	
	header("location: index.php?page=modules&control=blocki");//Перенаправление
	exit;//на страницу пунктов меню	
}
//УДАЛЕНИЕ БЛОК

//ДВИГАЕМ ПУНКТ МЕНЮ ВВЕРХ/ВНИЗ
if(isset($_GET['up_rsv']))$up_rsv = $_GET['up_rsv'];
if(isset($_GET['down_rsv']))$down_rsv = $_GET['down_rsv'];
if(isset($up_rsv) || isset($down_rsv))
{
	if(isset($up_rsv))//Если двигаем вверх
	{
		$info_menu = mysql_query("SELECT position FROM blocki WHERE id='$up_rsv'");//Вытаскиваем значение колонки position из строки где id = пункту который двигаем
		$myrow_info_menu = mysql_fetch_array($info_menu);
		$new_pos = $myrow_info_menu['position'] - 1;//Изменяем значение позиции
		$nav_id = $up_rsv;//Сохраняем id пункта который двигаем в отдельную переменную
	}	
	if(isset($down_rsv))//Если двигаем вниз
	{
		$info_menu = mysql_query("SELECT position FROM blocki WHERE id='$down_rsv'");//Вытаскиваем значение колонки position из строки где id = пункту который двигаем
		$myrow_info_menu = mysql_fetch_array($info_menu);
		$new_pos = $myrow_info_menu['position'] + 1;//Изменяем значение позиции
		$nav_id = $down_rsv;//Сохраняем id пункта который двигаем в отдельную переменную		
	}
	
	$old_pos = $myrow_info_menu['position'];//Заносим в отдельную переменную значение позиции двигаемого пункта
	
	//Напишу для Вас конкретный пример. Мы двигаем пункт с позиции 3 на позицую 2
	//То есть мы двигаем пункт вверх.
	//После того как мы определили все переменные выше ( то есть рассчитали новые позиции и сохранили старые )
	$new_pos_db = mysql_query ("UPDATE blocki SET position='$old_pos' WHERE position='$new_pos'");//Заносим в пункт который сейчас на позиции 2 его новую позицию, то есть 3
	$old_pos_db = mysql_query ("UPDATE blocki SET position='$new_pos' WHERE id='$nav_id'");//Заносим в пункт который мы двигаем его новую позицию, то есть 2
	header("location: index.php?page=modules&control=blocki");//Перенаправление
	exit;//на страницу пунктов меню	
}
//ДВИГАЕМ ПУНКТ МЕНЮ ВВЕРХ/ВНИЗ

function allrsv()//Функция вывода списка
{
$sm_read = file("../source/developers/modules/blocki/admincp/tmp/allwidget.html");//...подключаем шаблон
$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его

preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$tamp_while);//Находим в шаблоне тут часть, которую будет ду вайлить

$result_index = mysql_query("SELECT id,name,position FROM blocki ORDER BY position");//Выводим из базы данных пункты меню
$myrow_index = mysql_fetch_array($result_index);

if($myrow_index != "")
{
	$col = mysql_num_rows($result_index);//Узнаем общее количество пунктов в базе данных
	
	do
	{
		$copy_tamp = $tamp_while[1];//Сохраняем ту часть которая будет повторяться в отдельную переменную
		
		//Если обрабатываем первый пункт, то запрещаем вывод кнопки "поднять пункт вверх"
		if($myrow_index['position'] == 1)$copy_tamp = preg_replace("/\[_up\].*?\[_up\]/s","&nbsp;",$copy_tamp);
		else $copy_tamp = str_replace("[_up]","",$copy_tamp);//Если пункт не первый, то удаляем код слово из шаблона
		
		//Если обрабатываем последний пункт, то запрещаем вывод кнопки "опустить пункт вниз"
		if($myrow_index['position'] == $col)$copy_tamp = preg_replace("/\[_down\].*?\[_down\]/s","&nbsp;",$copy_tamp);
		else $copy_tamp = str_replace("[_down]","",$copy_tamp);//Если пункт не последний, то удаляем код слово из шаблона
		
		//Делаем замены код-слов
		$copy_tamp = str_replace("[_name]",$myrow_index['name'],$copy_tamp);//Название пункта
		$copy_tamp = str_replace("[_id]",$myrow_index['id'],$copy_tamp);//ID пункта
		
		$list .= $copy_tamp;//Объединяем результат в одну переменную
	}
	while($myrow_index = mysql_fetch_array($result_index));
	
	$sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$list,$sm_read);//Вставляем в щаблон список пунктов
	
	return $sm_read;//Выводим с генерированный html код
}
else return "<p align='center'>В базе данных нет блоков, <a href='?page=modules&control=blocki&addrsv=true'>создать</a>?</p>";
}
//-----------------------------------------------------------------
function addrsv()//Функция вывода формы редактирования меню
{
	$sm_read = file("../source/developers/modules/blocki/admincp/tmp/addwidget.html");//...подключаем шаблон
	$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его
	
	//-----Использование шаблона----
	$tplTXT = array("Блок использует шаблон","Блок НЕ использует шаблон");//Вариант для человека
	$tplINT = array(0,1);//Вариант для скрипта
	$tpl = queCFG(0,$tplTXT,$tplINT);//формируем option для пункта "Использование шаблона"
	//-----Использование шаблона----
	
	$sm_read = str_replace("[_option]", $tpl, $sm_read);
	
	return $sm_read;//Выводим с генерированный html код	
}
//-----------------------------------------------------------------
function queCFG($sel,$queTXT,$queINT)//Функция генерации ответов
{
$wh = count($queTXT);//Узнаем сколько вариантов ответа
for($i=0;$i<$wh;$i++)//запускаем цикл формирования
{
	//определяем какой вариант сейчас выбран
	if($sel == $queINT[$i])$result .= "<option value='".$queINT[$i]."' selected>".$queTXT[$i]."</option>";//нашли выбранный вариант и приписали selected в тег option
	else $result .= "<option value='".$queINT[$i]."'>".$queTXT[$i]."</option>";//остальные варианты будут без атрибута selected
}
return $result;//выводим с генерированный html код
}
//-----------------------------------------------------------------
function edd_rsv($edd_rsv)//Функция вывода формы редактирования меню
{
	$sm_read = file("../source/developers/modules/blocki/admincp/tmp/eddwidget.html");//...подключаем шаблон
	$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его
	
	$result_index = mysql_query("SELECT name,text,tpl FROM blocki WHERE id = '$edd_rsv'");//Выводим из базы данных пункт меню
	$myrow_index = mysql_fetch_array($result_index);

	//-----Использование шаблона----
	$tplTXT = array("Блок использует шаблон","Блок НЕ использует шаблон");//Вариант для человека
	$tplINT = array(0,1);//Вариант для скрипта
	$tpl = queCFG($myrow_index['tpl'],$tplTXT,$tplINT);//формируем option для пункта "Использование шаблона"
	//-----Использование шаблона----
	
	$sm_read = str_replace("[_name]",$myrow_index['name'],$sm_read);//Название пункта
	$sm_read = str_replace("[_text]",$myrow_index['text'],$sm_read);//Ссылка пункта
	$sm_read = str_replace("[_id]",$edd_rsv,$sm_read);//ID пункта
	$sm_read = str_replace("[_option]", $tpl, $sm_read);
	
	return $sm_read;//Выводим с генерированный html код	
}
?>
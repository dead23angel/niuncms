<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//---------УДАЛЕНИЕ ОПРОСА (ОБРАБОТЧИК)
if(isset($_GET['del_quest']))$del_quest = $_GET['del_quest'];

if(isset($del_quest))
{
	$result_del_quest = Niun::getInstance()->Get('DataBase')->Query ("DELETE FROM poll WHERE id='$del_quest'");

	Niun::getInstance()->Get('Cache')->Clear("poll");//делаем кэш модуля "опрос" устаревшим
	Niun::getInstance()->Get('Cache')->Clear("pollform");//делаем кэш модуля "опрос форма" устаревшим

	header("location: ?page=quest");
	exit;
}
//---------УДАЛЕНИЕ ОПРОСА (ОБРАБОТЧИК)
//---------ДОБАВИТЬ ОПРОС(ОБРАБОТЧИК)
if(isset($_POST['addtitleQUE']))$addtitleQUE = $_POST['addtitleQUE'];
if(isset($_POST['addvarQUE']))$addvarQUE = $_POST['addvarQUE'];

if(isset($addtitleQUE) AND isset($addvarQUE))
{
	$addtitleQUE = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($addtitleQUE));
	$addvarQUE = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($addvarQUE));
	
	$addvarQUE = explode("|",$addvarQUE);
	$kolMASS = count($addvarQUE);
	$addvarQUE = implode("|",$addvarQUE);
	for($i=0;$i<$kolMASS;$i++){if($i==0)$kol = 0;else $kol .= "|0";}
	
	$add_new_quest = Niun::getInstance()->Get('DataBase')->Query ("INSERT INTO poll (que,value,otvet,activ) 
	VALUES ('$addtitleQUE','$addvarQUE','$kol','0')");
	header("location: ?page=quest");
	exit;	
}
//---------ДОБАВИТЬ ОПРОС (ОБРАБОТЧИК)
//---------РЕДАКТРОК ОПРОСА (ОБРАБОТЧИК)
if(isset($_POST['eddtitleQUE']))$eddtitleQUE = $_POST['eddtitleQUE'];
if(isset($_POST['eddvarQUE']))$eddvarQUE = $_POST['eddvarQUE'];
if(isset($_POST['eddidQUE']))$eddidQUE = $_POST['eddidQUE'];

if(isset($eddtitleQUE) AND isset($eddvarQUE) AND isset($eddidQUE))
{
	$eddtitleQUE = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($eddtitleQUE));
	$eddvarQUE = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($eddvarQUE));
	
	$resulteddQUE = Niun::getInstance()->Get('DataBase')->Query ("UPDATE poll SET que='$eddtitleQUE',value='$eddvarQUE' WHERE id='$eddidQUE'");

	Niun::getInstance()->Get('Cache')->Clear("poll");//делаем кэш модуля "опрос" устаревшим
	Niun::getInstance()->Get('Cache')->Clear("pollform");//делаем кэш модуля "опрос форма" устаревшим
	
	header("location: ?page=quest");
	exit;	
}
//---------РЕДАКТРОК ОПРОСА (ОБРАБОТЧИК)
//---------РЕДАКТРОК АКТИВНОСТИ ОПРОСА (ОБРАБОТЧИК)
if(isset($_GET['activquest']))$activquest = $_GET['activquest'];
if(isset($activquest))
{
	$now_activ_result = Niun::getInstance()->Get('DataBase')->Query("SELECT activ FROM poll WHERE id='$activquest'");//Выводим данные о опросе
	$now_activ = Niun::getInstance()->Get('DataBase')->GetArray($now_activ_result);
	if($now_activ['activ'] == 0)$newACTIV = 1;
	else $newACTIV = 0;
	
	$resultactivquest = Niun::getInstance()->Get('DataBase')->Query ("UPDATE poll SET activ='$newACTIV' WHERE id='$activquest'");
	
	Niun::getInstance()->Get('Cache')->Clear("pollid");//делаем кэш модуля "опрос id" устаревшим
	Niun::getInstance()->Get('Cache')->Clear("poll");//делаем кэш модуля "опрос" устаревшим
	Niun::getInstance()->Get('Cache')->Clear("pollform");//делаем кэш модуля "опрос форма" устаревшим
	
	header("location: ?page=quest");
	exit;
}
//---------РЕДАКТРОК АКТИВНОСТИ ОПРОСА (ОБРАБОТЧИК)
function allquest()//Функция вывода списка опросов
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM poll");//Выводим данные о опросе
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

if($myrow_index != "")
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'allquest.html');
	
preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$tamp_while);//Находим в шаблоне тут часть, которую будет ду вайлить

$list = (!isset($list)) ? '' : $list;
	
do
{
	$val = explode("|",$myrow_index['value']);
	$kol = explode("|",$myrow_index['otvet']);
	for($i=0;isset($val[$i]);$i++)
	{
		$que[$i][0] = $kol[$i];
		$que[$i][1] = $val[$i];
	}
	rsort($que);

	$copy_tamp = $tamp_while[1];//Сохраняем ту часть которая будет повторяться в отдельную переменную
	if($myrow_index['activ'] == 0)$activ = "admin/img/activ_off.jpg";
	else $activ = "admin/img/activ_on.jpg";
	
	if($que[0][0] > 0)$quest = $que[0][1];
	else $quest = "-";

	//Делаем замены код-слов
	$copy_tamp = str_replace("[_title]",$myrow_index['que'],$copy_tamp);//Вопрос
	$copy_tamp = str_replace("[_dominent]",$quest,$copy_tamp);//Доминирующий ответ
	$copy_tamp = str_replace("[_id]",$myrow_index['id'],$copy_tamp);//ID опроса
	$copy_tamp = str_replace("[_activ]",$activ,$copy_tamp);//Активность
	
	unset($que);
	
	$list .= $copy_tamp;//Объединяем результат в одну переменную
}
while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));
$sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$list,$sm_read);//Вставляем в щаблон список опросов
return $sm_read;
}
else return "В базе данных нет опросов, <a href=\?page=addquest\">создать?</a>";
}
//------------------------------------------------------------
function addQUE()//функция формы для добавления опроса
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'addquest.html');

return $sm_read;
}
//------------------------------------------------------------
function eddQUE($id)//функция формы для редактирования опроса
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT que,value FROM poll WHERE id='$id'");//Выводим данные о опросе
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'eddquest.html');

$sm_read = str_replace("[_id]",$id,$sm_read);//ID опроса
$sm_read = str_replace("[_que]",$myrow_index['que'],$sm_read);//Вопрос опроса
$sm_read = str_replace("[_val]",$myrow_index['value'],$sm_read);//Варианты ответа опроса

return $sm_read;
}
?>
<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//РЕДАКТИРОВАНИЕ КАТЕГОРИИ
if(isset($_POST['edd_form_cat']))$edd_form_cat = $_POST['edd_form_cat'];//Определяем, была ли нажата кнопка "Редактировать категорию"

if(isset($edd_form_cat))//Если да
{
	$new_cat = Niun::getInstance()->Get('DataBase')->Query ("UPDATE blog SET cat='$edd_form_cat' WHERE id='$id'");//то обновляем колонку cat у редактируемого поста
	header("location: admin.php?page=all_content");//Переносим пользовотеля на страницу с постами
	exit;	
}
//РЕДАКТИРОВАНИЕ КАТЕГОРИИ
//УДАЛЕНИЕ ПОСТА
if(isset($_GET['del_post']))$del_post = $_GET['del_post'];//Объявляем переменную содержащию ID удаляемого поста

if(isset($del_post))//Если переменная существует то...
{
	$result_del_post = Niun::getInstance()->Get('DataBase')->Query ("DELETE FROM blog WHERE id='$del_post'");//...удаляем этот пост
	$result_del_comm = Niun::getInstance()->Get('DataBase')->Query ("DELETE FROM comm WHERE blog='$del_post'");//...комм к посту
	
	Niun::getInstance()->Get('Cache')->Clear("newdoc");//сообщаем что кэш модуля "Новые посты" устарел
	Niun::getInstance()->Get('Cache')->Clear("lastcomm");//сообщаем что кэш модуля "Новые комм" устарел
	
	header("location: ?page=all_content");//Переносим пользовотеля на страницу с постами
	exit;
}
//УДАЛЕНИЕ ПОСТА
//ОБРАБОТЧИК
//Объявляем переменные, если форма была отправленна
if(isset($_POST['edd_name_post']))$edd_name_post = $_POST['edd_name_post'];
if(isset($_POST['edd_txt_post']))$edd_txt_post = $_POST['edd_txt_post'];
if(isset($_POST['edd_author_post']))$edd_author_post = $_POST['edd_author_post'];
if(isset($_POST['edd_id_post']))$edd_id_post = $_POST['edd_id_post'];
if(isset($_POST['edd_metad_post']))$edd_metad_post = $_POST['edd_metad_post'];
if(isset($_POST['edd_metak_post']))$edd_metak_post = $_POST['edd_metak_post'];
if(isset($_POST['edd_chpy_post']))$edd_chpy_post = $_POST['edd_chpy_post'];
//Объявляем переменные, если форма была отправленна

if(isset($edd_name_post) & isset($edd_txt_post) & isset($edd_author_post))
{
	$eddnameforTRANSLIT = $edd_name_post;//копия имени для функции транслита

	//Избавляемся от кавычки
	$edd_name_post = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($edd_name_post));
	$edd_metad_post = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($edd_metad_post));
	$edd_metak_post = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($edd_metak_post));
	$edd_author_post = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($edd_author_post));
	$edd_txt_post = Niun::getInstance()->Get('DataBase')->Save($edd_txt_post);
	//Избавляемся от кавычки
	
	//проверка на одинаковые чпу имена
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'translit.php';
	
	$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT nameurl FROM blog WHERE id != '$edd_id_post'");
	$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);
		
	$mass = 0;
	do
	{
		$massiv[$mass] = $myrow_index['nameurl'];
		$mass++;
	}
	while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));
	
	for($i=0;$i>=0;$i++)
	{	
		if($i == 0)
		{
			$eddnameurl = translit($edd_chpy_post).".html";
			if(!in_array($eddnameurl,$massiv)) break;
		}
		else
		{
			$try = $i.$eddnameurl;
			if(!in_array($try,$massiv))
			{
				$eddnameurl = $i.$eddnameurl;
				break;
			}
		}
		
		
	}
	//проверка на одинаковые чпу имена
	
	//ОБНОВЛЯЕМ ПОСТ В БАЗЕ ДАННЫХ
	$edd_blog = Niun::getInstance()->Get('DataBase')->Query ("UPDATE blog SET nameurl='$eddnameurl', text='$edd_txt_post', title='$edd_name_post', author='$edd_author_post', meta_d = '$edd_metad_post', meta_k = '$edd_metak_post' WHERE id='$edd_id_post'");
	//ОБНОВЛЯЕМ ПОСТ В БАЗЕ ДАННЫХ
	
	Niun::getInstance()->Get('Cache')->Clear("newdoc");//сообщаем что кэш модуля "Новые посты" устарел
	Niun::getInstance()->Get('Cache')->Clear("lastcomm");//сообщаем что кэш модуля "Новые комм" устарел
	
	header("location: admin.php?page=all_content");//Перенаправление
	exit;//на главную страницу
}
//ОБРАБОТЧИК

function allcontent($pn,$chpu)//Функция вывода списка постов
{

require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'navig.php';

$limit = navig(100,$pn,"post");
$links = $limit[2];

$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'allcontent.html');

preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$tamp_while);//Находим в шаблоне тут часть, которую будет ду вайлить

$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT id,author,title,cat,nameurl,pablick FROM blog ORDER BY date_b DESC LIMIT $limit[0], $limit[1]");//Выводим из базы данных посты
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

	if ($myrow_index != "")
	{
		$result_cat = Niun::getInstance()->Get('DataBase')->Query("SELECT name,id FROM menu");//Выводим из базы имена пунктов
		$myrow_cat = Niun::getInstance()->Get('DataBase')->GetArray($result_cat);

		$list = (!isset($list)) ? '' : $list;
		
		do//Формируем массив - элемет id, содержимое имя пункта
		{
			$infoMENU[$myrow_cat['id']] = $myrow_cat['name'];//формируем массив с именами пунктов
		}
		while($myrow_cat = Niun::getInstance()->Get('DataBase')->GetArray($result_cat));
		
		do
		{
			$copy_tamp = $tamp_while[1];//Сохраняем ту часть которая будет повторяться в отдельную переменную
			
			if($myrow_index['cat'] != 0)
			{
				if(isset($infoMENU[$myrow_index['cat']]))$name_cat = $infoMENU[$myrow_index['cat']];
				else $name_cat = "Нет категории";
			}
			else $name_cat = "Нет категории";
		
			if($chpu == 0)$linkurl = "../admin.php?blog=".$myrow_index['id'];
			else $linkurl = "../".gen_catalog($myrow_index['cat']).$myrow_index['nameurl'];
				
			//Делаем замены код-слов
			if($myrow_index['pablick'] == 0)$copy_tamp = str_replace("[_pablick]","img/activ_off.jpg",$copy_tamp);
			else $copy_tamp = str_replace("[_pablick]","admin/img/activ_on.jpg",$copy_tamp);
		
			$copy_tamp = str_replace("[_title]",$myrow_index['title'],$copy_tamp);//Название поста
			$copy_tamp = str_replace("[_author]",$myrow_index['author'],$copy_tamp);//Автор
			$copy_tamp = str_replace("[_id]",$myrow_index['id'],$copy_tamp);//ID постов
			$copy_tamp = str_replace("[_cat]",$name_cat,$copy_tamp);//Имя категории
			$copy_tamp = str_replace("[_link]",$linkurl,$copy_tamp);//
			
			$list .= $copy_tamp;//Объединяем результат в одну переменную
		}
		while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));
		
		$sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$list,$sm_read);//Вставляем в щаблон список постов
		
		if($links > 1)$sm_read .= listnav($links,$pn,6,"post");//Вывод ссылок на страницы
		
		return $sm_read;//Выводим с генерированный html код
	}
	else return "В базе данных нет записей, <a href=\"admin.php?page=add_content\">создать?</a>";
}

//--------------------------------------------
function eddcontent($id)//Функция вывода выбранного поста
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM blog WHERE id='$id'");//Выводим из базы данных пост
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'eddcontent.html');

$text = htmlspecialchars($myrow_index['text']);

preg_match("/^(.*?)\.html$/",$myrow_index['nameurl'],$translit);
$translit = $translit[1];

	//Делаем замены код-слов
	$sm_read = str_replace("[_title]",$myrow_index['title'],$sm_read);//Название поста
	$sm_read = str_replace("[_metad]",$myrow_index['meta_d'],$sm_read);//Описание поста
	$sm_read = str_replace("[_metak]",$myrow_index['meta_k'],$sm_read);//Ключевые слова поста
	$sm_read = str_replace("[_text]",$text,$sm_read);//Текст поста
	$sm_read = str_replace("[_author]",$myrow_index['author'],$sm_read);//Автор
	$sm_read = str_replace("[_id]",$myrow_index['id'],$sm_read);//ID постов
	$sm_read = str_replace("[_chpu]",$translit,$sm_read);//ЧПУ

return $sm_read;//Выводим с генерированный html код
}
//--------------------------------------------
function eddcat($id)//Функция редактирования категории у поста
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'eddcat.html');

$allmenu = Niun::getInstance()->Get('DataBase')->Query("SELECT id,name FROM menu WHERE href=''");//Выводим из базы данных все пункт меню где href пуста
$menu = Niun::getInstance()->Get('DataBase')->GetArray($allmenu);
if($menu != "")//Если есть категории
{
	do//То формируем список
	{
		$option .= "<option value=\"".$menu['id']."\">".$menu['name']."</option>\n";
	}
	while($menu = Niun::getInstance()->Get('DataBase')->GetArray($allmenu));
}
else $option = "";//Если нет категорий то создаем пустую переменную

$sm_read = str_replace("[_id]",$id,$sm_read);//ID поста
$sm_read = str_replace("[_option]",$option,$sm_read);//Список

return $sm_read;//Выводим с генерированный html код
}
?>
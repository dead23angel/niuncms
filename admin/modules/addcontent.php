<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//Объявляем переменные, если форма была заполнена и отправленна
if(isset($_POST['name_post']))$name_post = $_POST['name_post'];
if(isset($_POST['txt_post']))$txt_post = $_POST['txt_post'];
if(isset($_POST['author_post']))$author_post = $_POST['author_post'];
if(isset($_POST['menu_post']))$menu_post = $_POST['menu_post'];
if(isset($_POST['metad_post']))$metad_post = $_POST['metad_post'];
if(isset($_POST['metak_post']))$metak_post = $_POST['metak_post'];
//Объявляем переменные, если форма была заполнена и отправленна

if(isset($name_post) & isset($txt_post) & isset($author_post))
{

	//проверка на одинаковые чпу имена
	include ROOT . DS . 'admin' . DS . 'modules' . DS . 'translit.php';
	
	$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT `nameurl` FROM blog");
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
			$nameurl = translit($name_post).".html";
			if(!in_array($nameurl,$massiv)) break;
		}
		else
		{
			$try = $i.$nameurl;
			if(!in_array($try,$massiv))
			{
				$nameurl = $i.$nameurl;
				break;
			}
		}
		
		
	}
	//проверка на одинаковые чпу имена

	//Избавляемся от кавычки
	$name_post   = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($name_post));
	$metad_post  = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($metad_post));
	$metak_post  = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($metak_post));
	$author_post = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($author_post));
	$txt_post    = Niun::getInstance()->Get('DataBase')->Save($txt_post);
	$date_cont   = time();

	//ДОБАВЛЯЕМ ПОСТ В БАЗУ ДАННЫХ

	Niun::getInstance()->Get('DataBase')->Query("INSERT INTO `blog` (`id`, `nameurl`, `title`, `meta_d`, `meta_k`, `text`, `author`, `date_b`, `cat`, `comm`, `block`, `viewindex`, `viewcomm`, `rss`, `xmlsm`, `sm`, `pablick`, `loock`)
		VALUES ('', '$nameurl', '$name_post', '$metad_post', '$metak_post', '$txt_post', '$author_post', '$date_cont', '$menu_post', '0', '0', '1', '1', '1', 'always|1.0', '1', '1', '')");

	//ДОБАВЛЯЕМ ПОСТ В БАЗУ ДАННЫХ

	header("location: admin.php");//Перенаправление
	exit;//на главную страницу
}

function addcontent()
{

$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'addcontent.html');

$allmenu = Niun::getInstance()->Get('DataBase')->Query("SELECT id,name FROM menu WHERE href=''");//Выводим из базы данных все пункт меню где href пуста
$menu = Niun::getInstance()->Get('DataBase')->GetArray($allmenu);
if($menu != "")//Если есть категории
{
	$option = (!isset($option)) ? '' : $option;

	do//То формируем список
	{
		$option .= "<option value=\"".$menu['id']."\">".$menu['name']."</option>\n";
	}
	while($menu = Niun::getInstance()->Get('DataBase')->GetArray($allmenu));
}
else $option = '';//Если нет категорий то создаем пустую переменную

$sm_read = str_replace("[_option]",$option,$sm_read);//Меняем код слово на с генерированный список

return $sm_read;//Выводим с генерированный html код
}
?>
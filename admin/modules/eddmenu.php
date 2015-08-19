<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

if(isset($_GET['edd_menu']))$edd_menu = $_GET['edd_menu'];
//РЕДАКТИРОВАНИЕ РОДИТЕЛЬНОГО ПУНКТА
if(isset($_POST['eddpodmenu']))$eddpodmenu = $_POST['eddpodmenu'];
if(isset($eddpodmenu))
{
	$edd_punct = Niun::getInstance()->Get('DataBase')->Query ("UPDATE menu SET podmenu='$eddpodmenu' WHERE id='$edd_menu'");
	
	header("location: admin.php?page=all_menu");//Перенаправление
	exit;//на страницу пунктов меню
}
//РЕДАКТИРОВАНИЕ РОДИТЕЛЬНОГО ПУНКТА
//РЕДАКТИРУЕМ ПУНКТ МЕНЮ
if(isset($_POST['name_p']))$name_p = $_POST['name_p'];
if(isset($_POST['href_p']))$href_p = $_POST['href_p'];
if(isset($_POST['titleM']))$titleM = $_POST['titleM'];
if(isset($_POST['metadM']))$metadM = $_POST['metadM'];
if(isset($_POST['metakM']))$metakM = $_POST['metakM'];
if(isset($_POST['chpyM']))$chpyM = $_POST['chpyM'];
if(isset($name_p) AND isset($href_p) AND isset($titleM) AND isset($metadM) AND isset($metakM))
{
	$namepforTRANSLIT = $name_p;//копия имени для функции транслита
	
	//Избавляемся от кавычки
	$name_p = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($name_p));
	$titleM = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($titleM));
	$metadM = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($metadM));
	$metakM = Niun::getInstance()->Get('DataBase')->Save(htmlspecialchars($metakM));
	//Избавляемся от кавычки

	//проверка на одинаковые чпу имена
	require_once ROOT . DS . 'admin' . DS . 'modules' . DS . 'translit.php';
	
	$result_menu = Niun::getInstance()->Get('DataBase')->Query("SELECT nameurl FROM menu WHERE id!='$edd_menu'");
	$myrow_menu = Niun::getInstance()->Get('DataBase')->GetArray($result_menu);
		
	$mass = 0;
	do
	{
		$massiv[$mass] = $myrow_menu['nameurl'];
		$mass++;
	}
	while($myrow_menu = Niun::getInstance()->Get('DataBase')->GetArray($result_menu));
	
	for($i=0;$i>=0;$i++)
	{	
		if($i == 0)
		{
			$nameurl_p = translit($chpyM);
			if(!in_array($nameurl_p,$massiv)) break;
		}
		else
		{
			$try = $i.$nameurl_p;
			if(!in_array($try,$massiv))
			{
				$nameurl_p = $i.$nameurl_p;
				break;
			}
		}
		
		
	}
	//проверка на одинаковые чпу имена

	$edd_punct = Niun::getInstance()->Get('DataBase')->Query ("UPDATE menu SET title='$titleM',meta_d='$metadM',meta_k='$metakM',nameurl='$nameurl_p',name='$name_p',href='$href_p' WHERE id='$edd_menu'");
	
	header("location: admin.php?page=all_menu");//Перенаправление
	exit;//на страницу пунктов меню
}
//РЕДАКТИРУЕМ ПУНКТ МЕНЮ

//УДАЛЕНИЕ ПУНКТА МЕНЮ
if(isset($_GET['del_menu']))$del_menu = $_GET['del_menu'];
if(isset($del_menu))
{
	$result_del_menu = Niun::getInstance()->Get('DataBase')->Query ("DELETE FROM menu WHERE id='$del_menu'");//удаляем пункт меню
	
	$res_delmenu = Niun::getInstance()->Get('DataBase')->Query("SELECT id FROM menu ORDER BY position");//Выводим из базы данных пункт меню сортируя их по колонке position
	$my_delmenu = Niun::getInstance()->Get('DataBase')->GetArray($res_delmenu);
	
	$new_pos_menu = 1;	
	do
	{
		$edd_pos_menu = Niun::getInstance()->Get('DataBase')->Query ("UPDATE menu SET position='$new_pos_menu' WHERE id='".$my_delmenu['id']."'");
		$new_pos_menu++;
	}
	while($my_delmenu = Niun::getInstance()->Get('DataBase')->GetArray($res_delmenu));
	
	header("location: admin.php?page=all_menu");//Перенаправление
	exit;//на страницу пунктов меню	
}
//УДАЛЕНИЕ ПУНКТА МЕНЮ

//ДВИГАЕМ ПУНКТ МЕНЮ ВВЕРХ/ВНИЗ
if(isset($_GET['up_menu']))$up_menu = $_GET['up_menu'];
if(isset($_GET['down_menu']))$down_menu = $_GET['down_menu'];
if(isset($up_menu) || isset($down_menu))
{
	if(isset($up_menu))//Если двигаем вверх
	{
		$info_menu = Niun::getInstance()->Get('DataBase')->Query("SELECT position FROM menu WHERE id='$up_menu'");//Вытаскиваем значение колонки position из строки где id = пункту который двигаем
		$myrow_info_menu = Niun::getInstance()->Get('DataBase')->GetArray($info_menu);
		$new_pos = $myrow_info_menu['position'] - 1;//Изменяем значение позиции
		$nav_id = $up_menu;//Сохраняем id пункта который двигаем в отдельную переменную
	}	
	if(isset($down_menu))//Если двигаем вниз
	{
		$info_menu = Niun::getInstance()->Get('DataBase')->Query("SELECT position FROM menu WHERE id='$down_menu'");//Вытаскиваем значение колонки position из строки где id = пункту который двигаем
		$myrow_info_menu = Niun::getInstance()->Get('DataBase')->GetArray($info_menu);
		$new_pos = $myrow_info_menu['position'] + 1;
		$nav_id = $down_menu;	
	}
	
	$old_pos = $myrow_info_menu[position];
	
	$new_pos_db = Niun::getInstance()->Get('DataBase')->Query ("UPDATE menu SET position='$old_pos' WHERE position='$new_pos'");//Заносим в пункт который сейчас на позиции 2 его новую позицию, то есть 3
	$old_pos_db = Niun::getInstance()->Get('DataBase')->Query ("UPDATE menu SET position='$new_pos' WHERE id='$nav_id'");//Заносим в пункт который мы двигаем его новую позицию, то есть 2
	header("location: admin.php?page=all_menu");//Перенаправление
	exit;//на страницу пунктов меню	
}
//ДВИГАЕМ ПУНКТ МЕНЮ ВВЕРХ/ВНИЗ

function allmenu()//Функция вывода списка mеню
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'allmenu.html');

preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$tamp_while);//Находим в шаблоне тут часть, которую будет ду вайлить

$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM menu ORDER BY position");//Выводим из базы данных пункты меню
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

	if ($myrow_index != "")
	{

		$col = Niun::getInstance()->Get('DataBase')->NumRows($result_index);//Узнаем общее количество пунктов в базе данных
		
		$i=0;
		do
		{
			$menuMASS[$i] = array($myrow_index['id'],//0
								  $myrow_index['nameurl'],//1
								  $myrow_index['name'],//2
								  $myrow_index['href'],//3
								  $myrow_index['position'],//4
								  $myrow_index['podmenu']);//5
			$i++;
		}
		while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));
		
		for($i=0;isset($menuMASS[$i]);$i++)
		{
			$copy_tamp = $tamp_while[1];//Сохраняем ту часть которая будет повторяться в отдельную переменную
			
			//Если обрабатываем первый пункт, то запрещаем вывод кнопки "поднять пункт вверх"
			if($menuMASS[$i][4] == 1)$copy_tamp = preg_replace("/\[_up\].*?\[_up\]/s","&nbsp;",$copy_tamp);
			else $copy_tamp = str_replace("[_up]","",$copy_tamp);//Если пункт не первый, то удаляем код слово из шаблона
			
			//Если обрабатываем последний пункт, то запрещаем вывод кнопки "опустить пункт вниз"
			if($menuMASS[$i][4] == $col)$copy_tamp = preg_replace("/\[_down\].*?\[_down\]/s","&nbsp;",$copy_tamp);
			else $copy_tamp = str_replace("[_down]","",$copy_tamp);//Если пункт не последний, то удаляем код слово из шаблона
			
			if($menuMASS[$i][5] != 0)
			{
				for($m=0;isset($menuMASS[$m]);$m++)
				{
					if($menuMASS[$i][5] == $menuMASS[$m][0])
					{
						$namepodmenu = $menuMASS[$m][2];
						break;
					}
				}
			}
			if(!isset($namepodmenu))$namepodmenu = "-";
			
			$list = (!isset($list)) ? '' : $list;

			//Делаем замены код-слов
			$copy_tamp = str_replace("[_linkchpu]","category/".$menuMASS[$i][1],$copy_tamp);//
			$copy_tamp = str_replace("[_podmenu]",$namepodmenu,$copy_tamp);//
			$copy_tamp = str_replace("[_name]",$menuMASS[$i][2],$copy_tamp);//Название пункта
			$copy_tamp = str_replace("[_id]",$menuMASS[$i][0],$copy_tamp);//ID пункта
			
			$list .= $copy_tamp;//Объединяем результат в одну переменную
			unset($namepodmenu);
		}
		
		$sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$list,$sm_read);//Вставляем в щаблон список пунктов
		
		return $sm_read;//Выводим с генерированный html код
	}
	else return "В базе данных нет пунктов, <a href=\"admin.php?page=add_menu\">создать?</a>";
}
//-----------------------------------------------------------------
function eddmenu($edd_menu)//Функция вывода формы редактирования меню
{
	$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'eddmenu.html');
	
	$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT name,href,title,meta_d,meta_k,nameurl FROM menu WHERE id = '$edd_menu'");//Выводим из базы данных пункт меню
	$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);
	
	$sm_read = str_replace("[_name]",$myrow_index['name'],$sm_read);//Название пункта
	$sm_read = str_replace("[_href]",$myrow_index['href'],$sm_read);//Ссылка пункта
	$sm_read = str_replace("[_id]",$edd_menu,$sm_read);//ID пункта
	$sm_read = str_replace("[_titleM]",$myrow_index['title'],$sm_read);//титл категории
	$sm_read = str_replace("[_meta_dM]",$myrow_index['meta_d'],$sm_read);//описание категории
	$sm_read = str_replace("[_meta_kM]",$myrow_index['meta_k'],$sm_read);//ключевые слова категории
	$sm_read = str_replace("[_chpuM]",$myrow_index['nameurl'],$sm_read);//ЧПУ
	
	return $sm_read;//Выводим с генерированный html код	
}
//-----------------------------------------------------------------
function eddpodmenu($id)
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'eddpodmenu.html');

$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM menu ORDER BY position");//Выводим из базы данных пункты меню
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

$i=0;
do
{
	$menuMASS[$i] = array($myrow_index['id'],//0
						  $myrow_index['name'],//1
						  $myrow_index['podmenu']);//2
	$i++;
}
while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));

for($i=0;isset($menuMASS[$i]);$i++){if($menuMASS[$i][0] == $id){$select = $menuMASS[$i][2];break;}}
$punkt = "<option value=\"0\">-</option>";
for($i=0;isset($menuMASS[$i]);$i++)
{
	if($menuMASS[$i][0] != $id)
	{
		if($menuMASS[$i][0] != $select)$punkt .= "<option value=\"".$menuMASS[$i][0]."\">".$menuMASS[$i][1]."</option>";
		else $punkt .= "<option value=\"".$menuMASS[$i][0]."\" selected>".$menuMASS[$i][1]."</option>";
	}
}
$sm_read = str_replace("[_option]",$punkt,$sm_read);
$sm_read = str_replace("[_id]",$id,$sm_read);//ID пункта	

return $sm_read;
}
?>
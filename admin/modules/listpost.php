<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function lpostMENU($server_root,$chpu,$step)//функция генирации списка материала для модуля меню
{
		//ФОРМИОРОВАНИЕ ЛИСТА С МАТЕРИАЛАМИ
	$result_post = Niun::getInstance()->Get('DataBase')->Query("SELECT title,id,nameurl,cat FROM blog WHERE pablick='1' ORDER BY date_b DESC");//Выводим из базы данных все материалы
	$myrow_post = Niun::getInstance()->Get('DataBase')->GetArray($result_post);

	$lpost = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'listmenu.html');
	
	//данные о первых 4 пунктов в листе
	$titleANDlink[0][0] = "Нет ссылки";
	$titleANDlink[0][1] = "#";
	$titleANDlink[1][0] = "Категория";
	$titleANDlink[1][1] = "";
	$titleANDlink[2][0] = "Главная страница";
	$titleANDlink[2][1] = $server_root;
	$titleANDlink[3][0] = "Страница обратной связи";
	if($chpu == 0)$titleANDlink[3][1] = $server_root."index.php?contact=1";
	else $titleANDlink[3][1] = $server_root."contacts.html";
	//данные о первых 4 пунктов в листе
	
	$allpost = (!isset($allpost)) ? '' : $allpost;

	//формируем первые 4 пункта в листе
	for($i=0;$i<=3;$i++)
	{
		$copy_lpost = $lpost;//копия шаблона
		
		$copy_lpost = str_replace("[_post]",$titleANDlink[$i][0],$copy_lpost);
		$copy_lpost = str_replace("[_link]",$titleANDlink[$i][1],$copy_lpost);
		$copy_lpost = str_replace("[_step]",$step,$copy_lpost);
		
		$allpost .= $copy_lpost;	
	}
	//формируем первые 4 пункта в листе
	
	$allpost .= "<p>&nbsp;</p>";//отступ
	
	//список материалов
	do
	{
		$copy_lpost = $lpost;
		
		//выбор между чпу и динамичной ссылкой
		if($chpu == 0)$link = $server_root."index.php?blog=".$myrow_post['id'];
		else $link = $server_root.gen_catalog($myrow_post['cat']).$myrow_post['nameurl'];
		
		$copy_lpost = str_replace("[_post]",$myrow_post['title'],$copy_lpost);
		$copy_lpost = str_replace("[_link]",$link,$copy_lpost);
		$copy_lpost = str_replace("[_step]",$step,$copy_lpost);
		
		$allpost .= $copy_lpost;
	}
	while($myrow_post = Niun::getInstance()->Get('DataBase')->GetArray($result_post));
	//список материалов
	//ФОРМИОРОВАНИЕ ЛИСТА С МАТЕРИАЛАМИ
	
	echo $allpost;
}
?>
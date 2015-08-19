<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined('NiunCMS')) die('Доступ запрещен');

if(isset($_POST['loginDB'])) {
	$loginDB = $_POST['loginDB'];
}

if(isset($_POST['passDB'])) {
	$passDB = $_POST['passDB'];
}

if(isset($loginDB) AND isset($passDB)) {

	if(preg_match("/^[a-zA-Z0-9_-]+$/s",$loginDB) AND preg_match("/^[a-zA-Z0-9]+$/s",$passDB)) {

			$passDB = md5(key_sole.md5($passDB));//шифруем введенный пароль

			$resultlp = Niun::getInstance()->Get('DataBase')->Query("SELECT login,pass FROM user WHERE id='1'");//выводим из базы данных логин и пароль
  			$log_and_pass = Niun::getInstance()->Get('DataBase')->GetArray($resultlp);

			if($log_and_pass != "")//если был выведен результат из БД
			{
				if($loginDB == $log_and_pass['login'] AND $passDB == $log_and_pass['pass'])//если введенная информация совпадает с информацией из БД
				{
					var_dump($log_and_pass);
					session_start();//стартуем сессию

					$_SESSION['logSESS'] = heshDB();//создаем глобальную переменную
					
      				header("location: ../admin.php");//переносим пользователя на главную страницу
      				exit;				
				}
				else//если введеная инфо не совпадает с инфо из БД
				{
					header("location: ../admin.php");//переносим на форму авторизации
					exit; 				
				}
			}
			else//если не найдено такого юзера в БД
			{
				header("location: ../admin.php");//переносим на форму авторизации
				exit;
			}
	}
	else//если введены не корректный логин и пароль
	{
		header("location: ../admin.php");//переносим на форму авторизации
		exit; 
	}	
}
 
 //мета теги
$header_title = "NiunCMS - Авторизация";
$header_metaD = "Авторизация";
$header_metaK = "Авторизация";
//мета теги

$txt = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'login.html');

include ROOT . DS . 'admin' . DS . 'templates' . DS . 'main.html';

?> 
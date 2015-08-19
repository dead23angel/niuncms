<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//--------------ОБРАБОТЧИК КОНТАКТОВ
$date_cont = time();//получим дату для записи

//Определяем посланные переменные из формы
if(isset($_POST['author_contact']))$author_contact = $_POST['author_contact'];
if(isset($_POST['email_contact']))$email_contact = $_POST['email_contact'];
if(isset($_POST['them_contact']))$them_contact = $_POST['them_contact'];
if(isset($_POST['txt_contact']))$txt_contact = $_POST['txt_contact'];
if(isset($_POST['code_contact']))$code_contact = $_POST['code_contact'];
if(isset($_POST['hashC']))$hashC = $_POST['hashC'];

if(isset($author_contact) & isset($email_contact) & isset($them_contact) & isset($txt_contact))
{
	$txt_contact = htmlspecialchars($txt_contact);
	$them_contact = htmlspecialchars($them_contact);

	//проверка кода
	if($code_contact != "")
	{
		global $key_sole;
		
		if(md5($code_contact.$key_sole) != $hashC)$error_contact .= "Вы выбрали не ту картинку!|";
	}
	else $error_contact .= "Вы не подтвердили, что Вы человек|";
	
	//проверка поля 'автор'
	if($author_contact != "" AND $author_contact != "Введите имя*")
	{
		if(!preg_match("/^[-_0-9a-zA-Zа-яА-Я ]+$/s",$author_contact))$error_contact .= "Не правильный формат поля 'Введите имя'|";
		if(mb_strlen($author_contact) > 25)$error_contact .= "В поле 'Введите имя' слишком много символов|";
	}
	else $error_contact .= "Вы не заполнили поле 'Введите имя'|";
	
	//проверяем заполняли ли поле текст
	if($txt_contact == "" OR $txt_contact == "Введите текст*")$error_contact .= "Вы не заполнили поле 'Введите текст'|";	

	//проверка поля емайл
	if($email_contact != "" AND $email_contact != "E-mail*")
	{
		if(!preg_match("/^[-_a-zA-Z0-9.]+@[-_a-zA-Z0-9.]+\.[-_a-zA-Z]+$/s",$email_contact))$error_contact .= "Вы ввели некорректный E-mail|";
	}
	else $error_contact .= "Вы не заполнили поле 'E-mail'|";	

	//проверка адреса сайта
	if($them_contact != "" AND $them_contact != "Тема*")
	{
		if(mb_strlen($them_contact) > 250)$error_contact .= "В поле 'Тема' слишком много символов|";
	}
	else $error_contact .= "Вы не заполнили поле 'Тема'|";

	if(!isset($error_contact))
	{	
		$txt_contact = str_replace("\\","&#92;",$txt_contact);
		$them_contact = str_replace("\\","&#92;",$them_contact);

		$txt_contact = addslashes($txt_contact);
		$them_contact = addslashes($them_contact);

		$txt_contact = str_replace("[", "&#91;", $txt_contact);
		$txt_contact = str_replace("]", "&#93;", $txt_contact);
		
		$them_contact = str_replace("[", "&#91;", $them_contact);
		$them_contact = str_replace("]", "&#93;", $them_contact);
		
		$txt_contact = str_replace("\n","<BR>",$txt_contact);
	
		//ДОБАВЛЯЕМ СООБЩЕНИЕ В БАЗУ ДАННЫХ
		$result_add_cont = Niun::getInstance()->Get('DataBase')->Query("INSERT INTO mess_admin (login,them,date_g,email,text) 
		VALUES ('$author_contact','$them_contact','$date_cont','$email_contact','$txt_contact')");

		contactCOOKIE($server_root);
	
		header("location: ".getenv('HTTP_REFERER'));
		exit;
	}
}

//--------------ОБРАБОТЧИК КОНТАКТОВ

if(!$headerMETA = Niun::getInstance()->Get('Cache')->Get('contact', 3600))
{
$result_meta = Niun::getInstance()->Get('DataBase')->Query("SELECT `title`, `meta_k` FROM page WHERE id='1'");
$myrow_meta = Niun::getInstance()->Get('DataBase')->GetArray($result_meta);

	if($myrow_meta != "")
	{
		$headerMETA[0] = "Обратная связь | ".$myrow_meta['title'];
		$headerMETA[1] = "Обратная связь с администрацией";
		$headerMETA[2] = $myrow_meta['meta_k'];
	
		$headerMETA = implode("[META]",$headerMETA);
		
		Niun::getInstance()->Get('Cache')->Set("contact",$headerMETA);
	}
}

$headerMETA = explode("[META]",$headerMETA);

Niun::getInstance()->Get('Template')->header_title = $headerMETA[0];
Niun::getInstance()->Get('Template')->header_metaD = $headerMETA[1];
Niun::getInstance()->Get('Template')->header_metaK = $headerMETA[2];

function contact($mess,$error,$chpu,$server_root)
{

if($mess == 1)
{
	$sm_read = Niun::getInstance()->Get('Template')->Fetch('contacts');
	
	//Вывод ошибки
	if($error != "")
	{
		$error = explode("|",$error);
		$echoERROR .= "<p style='color:red;margin:0px;'>Обнаружены следующие ошибки:</p>";
		for($i=0;isset($error[$i]);$i++)
		{
			if($error[$i] != "")$echoERROR .= "<p style='color:red;margin:0px;'>>$error[$i]</p>";
		}
		$sm_read = str_replace("[_error]",$echoERROR,$sm_read);
	}
	else $sm_read = str_replace("[_error]","",$sm_read);
	//Вывод ошибки

	//капча
	include (ROOT . DS . 'system' . DS . 'modules' . DS . 'capcha.php');
	$cods = capcha();
	for($i=0;$i<4;$i++)
	{
		$sm_read = str_replace("[_code".$i."]",$cods[$i][1],$sm_read);
		$sm_read = str_replace("[_img".$i."]",$cods[$i][3],$sm_read);
		if($cods[$i][5] == "true")
		{
			$sm_read = str_replace("[_q]",$cods[$i][4],$sm_read);
			$sm_read = str_replace("[_hash]",$cods[$i][2],$sm_read);
		}
	}
	//капча

}

if($mess == 2)
{
	$sm_read = "<p align='center'>Ваше сообщение отправлено.</p>";
	contactCOOKIEdel($server_root);
}
if($chpu == 0)$action = "index.php?contact=1";
else $action = "contacts.html";
$sm_read = str_replace("[_action]",$action,$sm_read);

return $sm_read;
}


function contactCOOKIE($server_root)
{
	preg_match("/http:\/\/(.*?)\//s",$server_root,$cookieSITE);
	$cookieSITE = str_replace("www.","",$cookieSITE[1]);
		
	setcookie("contMESS","YES",time()+300,"/",".".$cookieSITE);
}


function contactCOOKIEdel($server_root)
{
	preg_match("/http:\/\/(.*?)\//s",$server_root,$cookieSITE);
	$cookieSITE = str_replace("www.","",$cookieSITE[1]);
		
	setcookie("contMESS","",time()-300,"/",".".$cookieSITE);
}

?>
<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//--------------ОБРАБОТЧИК КОММЕТАРИЕВ
$date_comm = time();//получим дату для записи

//Определяем посланные переменные из формы
if(isset($_POST['id_comm']))$id_comm = $_POST['id_comm'];
if(isset($_POST['txt_comm']))$txt_comm = $_POST['txt_comm'];
if(isset($_POST['author_comm']))$author_comm = $_POST['author_comm'];
if(isset($_POST['email_comm']))$email_comm = $_POST['email_comm'];
if(isset($_POST['site_comm']))$site_comm = $_POST['site_comm'];
if(isset($_POST['code_comm']))$code_comm = $_POST['code_comm'];
if(isset($_POST['recomm']))$recomm = $_POST['recomm'];
if(isset($_POST['hash']))$hash = $_POST['hash'];

if(isset($id_comm) & isset($txt_comm) & isset($author_comm))
{
	$txt_comm = htmlspecialchars($txt_comm);
	
	//проверка кода
	if($code_comm != "")
	{
		global $key_sole;
		
		if(md5($code_comm.$key_sole) != $hash)$error_comm .= "Вы выбрали не ту картинку!|";
	}
	else $error_comm .= "Вы не подтвердили, что Вы человек|";
	
	//проверка поля 'автор'
	if($author_comm != "" AND $author_comm != "Автор*")
	{
		if(!preg_match("/^[-_0-9a-zA-Zа-яА-Я ]+$/s",$author_comm))$error_comm .= "Не правильный формат поля 'Автор'|";
		if(mb_strlen($author_comm) > 25)$error_comm .= "В поле 'Автор' слишком много символов|";
	}
	else $error_comm .= "Вы не заполнили поле 'Автор'|";
	
	//проверяем заполняли ли поле текст
	if($txt_comm == "" OR $txt_comm == "Введите текст*")$error_comm .= "Вы не заполнили поле 'Текст'|";
	
	//проверка поля емайл
	if($email_comm != "" AND $email_comm != "E-Mail* (не публикуется)")
	{
		if(!preg_match("/^[-_a-zA-Z0-9.]+@[-_a-zA-Z0-9.]+\.[-_a-zA-Z]+$/s",$email_comm))$error_comm .= "Вы ввели некорректный E-mail|";
	}
	else $error_comm .= "Вы не заполнили поле 'E-mail'|";
	
	//проверка адреса сайта
	if($site_comm != "" AND $site_comm != "http://")
	{
		if(!preg_match("/^(?:http|https):\/\/[-_a-zа-я0-9.]+\.[a-zа-я]{2,6}\/{0,1}$/s",$site_comm))$error_comm .= "Некорректно введенный адрес сайта|";
	}
	else $site_comm = "";
	
	if(!preg_match("/^[0-9]+$/s",$recomm))$recomm = 0;
	
	if(!preg_match("/^[0-9]+$/s",$id_comm))$error_comm .= "Некорректный адрес заметки|";

	if(!isset($error_comm))
	{
		require_once (ROOT . DS. 'system' . DS . 'modules' . DS . 'whitelist.php');

		$txt_comm = str_replace("\\","&#92;",$txt_comm);
		
		$txt_comm = addslashes($txt_comm);

		$txt_comm = str_replace("[", "&#91;", $txt_comm);
		$txt_comm = str_replace("]", "&#93;", $txt_comm);		
		$txt_comm = str_replace("\n","<BR>",$txt_comm);

		$result_count = Niun::getInstance()->Get('DataBase')->Query("SELECT `comm`, `viewindex` FROM blog WHERE id='$id_comm'");
		$myrow_count = Niun::getInstance()->Get('DataBase')->GetArray($result_count);
		
		if($status < 3)
		{	
			//меняем кол-во комм
			$newcountCOMM = $myrow_count['comm'] + 1;
			
			//обновляем кол-во комм в бд
			$up_count = Niun::getInstance()->Get('DataBase')->Query ("UPDATE blog SET comm='$newcountCOMM' WHERE id='$id_comm'");
		}
		
		//определяем видим ли комментарий в модуле последних комментариев
		if($myrow_count['viewindex'] == 1)$view = 1;
		else $view = 0;
		
		//Добавляем сообщение в базу данных
		$result_add_comm = Niun::getInstance()->Get('DataBase')->Query ("INSERT INTO comm (author,text,date_comm,blog,email,site,comm,status,view) 
		VALUES ('$author_comm','$txt_comm','$date_comm','$id_comm','$email_comm','$site_comm','$recomm','$status','$view')");
		
		if($status < 3 AND $view == 1) Niun::getInstance()->Get('Cache')->Clean("lastcomm");
		
		header("location: ".getenv('HTTP_REFERER'));
		exit;
	}
}
//--------------ОБРАБОТЧИК КОММЕТАРИЕВ

function comm($blog,$error,$mess,$chpu,$server_root)
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM comm WHERE blog='$blog' AND status < '3' ORDER BY id");
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

if($myrow_index != "")
{
$sm_read = Niun::getInstance()->Get('Template')->Fetch('comm');
$i = 0;
do
{
	$commMASS[$i] = array($myrow_index['id'],//0
						  $myrow_index['author'],//1
						  $myrow_index['email'],//2
						  $myrow_index['site'],//3
						  $myrow_index['text'],//4
						  $myrow_index['date_comm'],//5
						  $myrow_index['blog'],//6
						  $myrow_index['comm'],//7
						  $myrow_index['status']);//8
	$i++;
}
while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));

$comm = messCOMM(0,$commMASS,$sm_read,0);
}
else $comm = "<p align='center'>Комментариев нет</p>";

$form = Niun::getInstance()->Get('Template')->Fetch('comm_form');

//Вывод ошибки
if($error != "")
{
	$error = explode("|",$error);
	$echoERROR .= "<p style='color:red;margin:0px;'>Обнаружены следующие ошибки:</p>";
	for($i=0;isset($error[$i]);$i++)
	{
		if($error[$i] != "")$echoERROR .= "<p style='color:red;margin:0px;'>>$error[$i]</p>";
	}
$form = str_replace("[_error]",$echoERROR,$form);
}
else $form = str_replace("[_error]","",$form);

if($mess != "")
{
	$form = str_replace("[_messWL]",$mess,$form);
	deletCOOKIE($server_root);
}
else $form = str_replace("[_messWL]","",$form);

//капча
require_once (ROOT . DS . 'system' . DS . 'modules' . DS . 'capcha.php');
$cods = capcha();
for($i=0;$i<4;$i++)
{
	$form = str_replace("[_code".$i."]",$cods[$i][1],$form);
	$form = str_replace("[_img".$i."]",$cods[$i][3],$form);
	if($cods[$i][5] == "true")
	{
		$form = str_replace("[_q]",$cods[$i][4],$form);
		$form = str_replace("[_hash]",$cods[$i][2],$form);
	}
}
//капча

if($chpu == 0)$link = "index.php?blog=".$blog;
else $link = $_SERVER['REQUEST_URI'];


$form = str_replace("[_action]",$link,$form);
$form = str_replace("[_id]",$blog,$form);
$comm .= $form;
return $comm;
}

function messCOMM($mess,$commMASS,$temp,$BC)
{
	$comm = '';
for($i=0;isset($commMASS[$i]);$i++)
{
	if($commMASS[$i][7] == $mess)
	{
		$edd_tamp = $temp;

		if($commMASS[$i][3] != "")$author = "<a href='".$commMASS[$i][3]."' rel='nofollow'>".$commMASS[$i][1]."</a>";//если не пустая формируем ссылку
		else $author = $commMASS[$i][1];
		$style = $BC * 10;
		
		$dateCOMM = date("d/m/Y H:i",$commMASS[$i][5]);
		
		$edd_tamp = str_replace("[_style]",$style,$edd_tamp);//отступ от края, что бы был вид "дерева"
		$edd_tamp = str_replace("[_text]",$commMASS[$i][4],$edd_tamp);//Текст
		$edd_tamp = str_replace("[_author]",$author,$edd_tamp);//Автор статьи
		$edd_tamp = str_replace("[_date_b]",$dateCOMM,$edd_tamp);//Дата размещения
		$edd_tamp = str_replace("[_email]",md5($commMASS[$i][2]),$edd_tamp);//закодированный email
		$edd_tamp = str_replace("[_id]",$commMASS[$i][0],$edd_tamp);//
		$edd_tamp = str_replace("[_from]",$commMASS[$i][1],$edd_tamp);//
		if($commMASS[$i][8] == 0){
			$imgstatus = '/templates/system/images/admin.png';
			$txtsimg = "Администратор";
		}
		if($commMASS[$i][8] == 1){
			$imgstatus = '/templates/system/images/users.png';
			$txtsimg = "Пользователь";
		}
		if($commMASS[$i][8] == 2){
			$imgstatus = '/templates/system/images/guest.png';
			$txtsimg = "Гость";
		}
		$edd_tamp = str_replace("[_imgstatus]",$imgstatus,$edd_tamp);//
		$edd_tamp = str_replace("[_txtstatusimg]",$txtsimg,$edd_tamp);//
		
		if($BC < 10)
		{
			$newBC = $BC + 1;
			$podcomm = messCOMM($commMASS[$i][0],$commMASS,$temp,$newBC);
			$edd_tamp = str_replace("[_req]","",$edd_tamp);
		}
		else
		{
			$podcomm = "";
			$edd_tamp = preg_replace("/\[_req\].*?\[_req\]/s","",$edd_tamp);
		}
		
		$edd_tamp = str_replace("[_podcomm]",$podcomm,$edd_tamp);
		$comm .= $edd_tamp;
	}
}

return $comm;
}

function deletCOOKIE($server_root)
{
	preg_match("/http:\/\/(.*?)\//s",$server_root,$cookieSITE);
	$cookieSITE = str_replace("www.","",$cookieSITE[1]);
		
	setcookie("messW","",time()-300,"/",".".$cookieSITE);
}
?>
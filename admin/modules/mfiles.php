<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//ОПРЕДЕЛЯЕМ КАКОЙ СПИСОК ОТКРЫЛ АДМИН
if(isset($_GET['scan']))$scan = $_GET['scan']; else $scan = 0;//определяем какой список открыл админ, и открыл ли его вообще
if(isset($scan))
{
	if(!preg_match("/^[0-9]+$/",$scan) OR $scan > 2)//так как переменная scan должна быть числом, то..
	{
		header("location: ?page=mfiles");//..перенаправление
		exit;//на страницу менеджера если это не так ($scan не есть число)
	}
}
//ОПРЕДЕЛЯЕМ КАКОЙ СПИСОК ОТКРЫЛ АДМИН
//СТРАНИЦА В СПИСКЕ
if(isset($_GET['list']))$list = $_GET['list']; else $list = 1;//определяем cтраницу списка
if(isset($list))
{
	if(!preg_match("/^[0-9]+$/",$list) OR $list < 1)//так как переменная list должна быть числом, то..
	{
		header("location: ?page=mfiles");//..перенаправление
		exit;//на страницу менеджера если это не так ($list не есть число)
	}
}
//СТРАНИЦА В СПИСКЕ
//УДАЛЕНИЕ ФАЙЛА
if(isset($_POST['delF']))$delF = $_POST['delF'];//определяем запущен ли процесс удаление файлов
if(isset($delF))//если да
{
	$allDEL = count($delF);//узнаем сколько файлов необходимо удалить
	$nowDEL = 0;//считалка удаленных файлов
	for($i=0;$nowDEL < $allDEL;$i++)
	{
		if(isset($delF[$i]))//если наткнулись на существующий элемент массива
		{
			unlink($delF[$i]);//удаляем файл который содержится в массиве
			$nowDEL++;//подтверждаем что удалили еще один файл
		}
	}	
	header("location: ".getenv('HTTP_REFERER'));//Перенаправление
	exit;//на главную страницу
}
//УДАЛЕНИЕ ФАЙЛА

//ДОБАВЛЕНИЕ ФАЙЛА
//Если форма была заполнена и отправлена то определяем переменную в которую запихнем файл
if(isset($_FILES['userfile']))$loadfile = $_FILES['userfile'];

if(isset($loadfile))//Если файл был отправлен
{
		//Определяем тип файла
		if($loadfile['type'] == "application/x-rar-compressed")$type = ".rar";
		if($loadfile['type'] == "application/zip")$type = ".zip";
		if($loadfile['type'] == "image/jpeg")$type = ".jpg";
		if($loadfile['type'] == "image/gif")$type = ".gif";
		if($loadfile['type'] == "image/png")$type = ".png";
		if($loadfile['type'] == "image/bmp")$type = ".bmp";
		//Определяем тип файла
		
		if(isset($type))//Если тип определен и соответсвует требованиям
		{
			//генерируем новое имя для файла
			$name_f = date("His");//имя состоит из даты
			$indifikator = mt_rand(1, 10000);//с генерированного числа от 1 до 10000
			$name_f .= $indifikator;//склеиваем дату и с генерированное число
			//генерируем новое имя для файла
			
			//Определяем в какую папку загрузить файл
			if($type == ".rar" OR $type == ".zip")//Если файл является архивом то..
			{ 
				$name_f = "files_".$name_f.$type;//...прикручиваем к названию файла приставку download и тип (download_имя.rar)
				$folder = ROOT . DS . 'upload' . DS . 'files' . DS;//так же определяем имя папки куда загрузится файл
			}
			else//Если файл является изображением
			{
				$name_f = $name_f.$type;//...прикручиваем к названию файла тип (имя.jpg)
				$folder = ROOT . DS . 'upload' . DS . 'images' . DS;//так же определяем имя папки куда загрузится файл
			}
			
			copy($loadfile['tmp_name'], $folder.$name_f);//Копируем файл с новым именем в определенную папку		
			$linkFORfile = $folder.$name_f;//Состовляем ссылку которую покажем на экране
		}
		else $linkFORfile = "Некорректный тип файла";//Сообщение о неккоректности типа файла
}
//ДОБАВЛЕНИЕ ФАЙЛА

function formfiles($linkFORfile,$typeSCAN,$list)//Функция вывода формы
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'mfiles.html');

if($typeSCAN != 0)//Определяем открыл ли админ какой-нить список
{
	$result_sm = listFILE($typeSCAN,$sm_read,$list);//запускаем функцию вывода списка
	
	$result_sm = (!empty($result_sm)) ? array('0' => '', '1' => '') : $result_sm;

	//Если результат функции пустота..
	if($result_sm[0] == "")$sm_read = str_replace("[_style]","none",$sm_read);//..то прячем всю таблицу с глаз долой
	//Если же не результат функции НЕ пустота
	else $sm_read = str_replace("[_style]","block",$sm_read);//..то показываем таблицу админу
}
else $sm_read = str_replace("[_style]","none",$sm_read);//Если админ НЕ открыл/закрыл список то прячем таблицу
$sm_read = preg_replace("/\[_file\].*?\[_file\]/s",$result_sm[0],$sm_read);//заменяем часть таблицы в шаблоне на с генерированный результат работы выше

if($result_sm[1] > 1)
{
	include(ROOT . DS . 'admin' . DS . 'modules' . DS . 'navig.php');
	if($typeSCAN == 1)$sm_read .= listnav($result_sm[1],$list,6,"imgfile");//Вывод ссылок на страницы
	if($typeSCAN == 2)$sm_read .= listnav($result_sm[1],$list,6,"arhivfile");//Вывод ссылок на страницы
}

$sm_read = str_replace("[_url]",$linkFORfile,$sm_read);//Меняем код слово на cсылку файла
$sm_read = str_replace("[_listSCRIPT]",$list,$sm_read);//определяем для js страницу

return $sm_read;//Выводим с генерированный html код
}

function listFILE($typeSCAN,$sm_read,$list)//Функция вывода списка
{
	//Определяем какую папку открыл админ
	if($typeSCAN == 1) $dir = ROOT . DS . 'upload' . DS . 'images' . DS;//папку с изображениями
	if($typeSCAN == 2) $dir = ROOT . DS . 'upload' . DS . 'files' . DS; //или папку с архивами
	
	$data = opendir($dir); //сканируем файлы в папке
	$mass = 0;//считалка первого ключа массива

	while (false !== ($one = readdir($data))) //собираем массив из результата сканирования
	{
		if($one != '.' && $one != '..') //Удаляем точки
		{
			$files[$mass][0] = filemtime($dir."/".$one);//узнаем дату создания файла
			$files[$mass][1] = $one;//формируем массив с именами файлов
			$mass++;//увеличиваем первый ключ массива
		}
	}
	closedir ($data);//закрываем папку
	
	if(isset($files))rsort($files);//сортируем список по дате
	
	preg_match("/\[_file\](.*?)\[_file\]/s",$sm_read,$copy_sm);//вырезаем копию из шаблона (<tr>...</tr>)
	
	//Навигация (расчет количества страниц)
	$full = count($files);//Сколько всего файлов
	$obj = 40;//по сколько выводить
	$links = (($full - 1) / $obj) + 1;//расчитывается количество страниц
	$links =  intval($links);//округление
	$linkSTART = $list * $obj - $obj;//расчитывается начальная позиция ( на первой странице начальная позиция равна нулю )
	$linkEND = $linkSTART + $obj;//расчитывается конечная позиция ( по умолчанию 40 )
	//Навигация (расчет количества страниц)

	for($i=$linkSTART;$i<$full AND $i<$linkEND;$i++)//генерируем строчки для таблицы
	{
		$copy_tp = $copy_sm[1];//делаем копию вырезанной части шаблона
		//Определяем директорию из которой админу нужно вывести файлы
		if($typeSCAN == 1)$img = $dir."/".$files[$i][1];//формируем предпросмотр ( предпросмотром в списке изображений являются сами изображения )
		if($typeSCAN == 2)$img = "admin/img/arh.jpg";//формируем предпросмотр ( предпросмотром в списке архивов является иконка архива )

		//замена код слов
		$copy_tp = str_replace("[_link]",$dir."/".$files[$i][1],$copy_tp);//имя
		$copy_tp = str_replace("[_img]",$img,$copy_tp);//изображение
		$copy_tp = str_replace("[_del]",$i,$copy_tp);//ключ массива для удаления файла
		$copy_tp = str_replace("[_delNAME]",$dir."/".$files[$i][1],$copy_tp);//путь к удаляемому файлу
		$copy_tp = str_replace("[_date]",date ("d.m.Y H:i:s",$files[$i][0]),$copy_tp);//переделанная дата вид день.месяц.гол часы:мин:сек
		//замена код слов
		
		$result_sm[0] .= $copy_tp;//Сохраняем сгенерированную строчку таблицы в общуюю переменную
	}
	$result_sm[1] = $links;//заносим кол-во страниц (постраничная навигация)
	
return $result_sm;//Выводим результат работы функции в виде массива
}
?>
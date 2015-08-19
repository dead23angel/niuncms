<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//---------УДАЛЕНИЕ ФОТО ИЗ ГАЛЕРЕИ (ОБРАБОТЧИК)
if(isset($_GET['delphoto']))$delphoto = $_GET['delphoto'];

if(isset($delphoto))
{
	$result_del_link = Niun::getInstance()->Get('DataBase')->Query("SELECT href FROM galery WHERE id='$delphoto'");
	$myrow_del_link = Niun::getInstance()->Get('DataBase')->GetArray($result_del_link);
	if($myrow_del_link != "")
	{
		unlink("../data/galery/big/big_".$myrow_del_link['href'].".jpg");
		unlink("../data/galery/mini/small_".$myrow_del_link['href'].".jpg");
		$result_del_link_db = Niun::getInstance()->Get('DataBase')->Query ("DELETE FROM galery WHERE id='$delphoto'");
	}
	header("location: ".getenv('HTTP_REFERER'));//Переносим пользовотеля на страницу галереи
	exit;
}
//---------УДАЛЕНИЕ ФОТО ИЗ ГАЛЕРЕИ (ОБРАБОТЧИК)
//---------РЕДАКТОР ФОТОГРАФИЙ (ОБРАБОТЧИК)
if(isset($_POST['eddidIMG']))$eddidIMG = $_POST['eddidIMG'];
if(isset($_POST['locationGAL']))$locationGAL = $_POST['locationGAL'];
if(isset($_POST['eddtitleIMG']))$eddtitleIMG = $_POST['eddtitleIMG'];
if(isset($_POST['eddtxtIMG']))$eddtxtIMG = $_POST['eddtxtIMG'];

if(isset($eddidIMG) AND isset($locationGAL) AND isset($eddtitleIMG) AND isset($eddtxtIMG))
{
	$eddtitleIMG = str_replace("'","",$eddtitleIMG);
	$eddtitleIMG = str_replace("\"","",$eddtitleIMG);
	$eddtxtIMG = str_replace("'","",$eddtxtIMG);
	$eddtxtIMG = str_replace("\"","",$eddtxtIMG);	
	
	$resulteddIMG = Niun::getInstance()->Get('DataBase')->Query ("UPDATE galery SET title_img='$eddtitleIMG',txt='$eddtxtIMG' WHERE id='$eddidIMG'");
	header("location: ?page=galery&id=".$locationGAL);//Переносим пользовотеля к списоку галерей
	exit;		
}
//---------РЕДАКТОР ФОТОГРАФИЙ (ОБРАБОТЧИК)
//---------УДАЛЕНИЕ ГАЛЕРЕИ (ОБРАБОТЧИК)
if(isset($_GET['del_gal']))$del_gal = $_GET['del_gal'];

if(isset($del_gal))
{
	$result_del_link = Niun::getInstance()->Get('DataBase')->Query("SELECT href FROM galery WHERE id_galery='$del_gal'");
	$myrow_del_link = Niun::getInstance()->Get('DataBase')->GetArray($result_del_link);
	if($myrow_del_link != "")
	{
		do
		 {
			unlink("../data/galery/big/big_".$myrow_del_link['href'].".jpg");
			unlink("../data/galery/mini/small_".$myrow_del_link['href'].".jpg");
		 }
		while($myrow_del_link = Niun::getInstance()->Get('DataBase')->GetArray($result_del_link));
	}
	$result_del_cells_db = Niun::getInstance()->Get('DataBase')->Query ("DELETE FROM galery WHERE id_galery='$del_gal'");
	$result_del_link_db = Niun::getInstance()->Get('DataBase')->Query ("DELETE FROM galery WHERE id='$del_gal'");
	header("location: ?page=galery");
	exit;
}
//---------УДАЛЕНИЕ ГАЛЕРЕИ (ОБРАБОТЧИК)
//---------ДОБАВИТЬ ГАЛЕРЕЮ (ОБРАБОТЧИК)
if(isset($_POST['addtitleGAL']))$addtitleGAL = $_POST['addtitleGAL'];

if(isset($addtitleGAL))
{
	$addtitleGAL = str_replace("'","",$addtitleGAL);
	$addtitleGAL = str_replace("\"","",$addtitleGAL);
	
	$add_new_gal = Niun::getInstance()->Get('DataBase')->Query ("INSERT INTO galery (title_galery,id_galery,title_img,txt,href) 
	VALUES ('$addtitleGAL','0','','','')");
	header("location: ?page=galery");
	exit;	
}
//---------ДОБАВИТЬ ГАЛЕРЕЮ (ОБРАБОТЧИК)
//---------РЕДАКТРОК ГАЛЕРЕИ (ОБРАБОТЧИК)
if(isset($_POST['eddidGAL']))$eddidGAL = $_POST['eddidGAL'];
if(isset($_POST['eddtitleGAL']))$eddtitleGAL = $_POST['eddtitleGAL'];

if(isset($eddidGAL) AND isset($eddtitleGAL))
{
	$eddtitleGAL = str_replace("'","",$eddtitleGAL);
	$eddtitleGAL = str_replace("\"","",$eddtitleGAL);
	$resulteddGAL = Niun::getInstance()->Get('DataBase')->Query ("UPDATE galery SET title_galery='$eddtitleGAL' WHERE id='$eddidGAL'");
	
	header("location: ?page=galery");//Переносим пользовотеля к списоку галерей
	exit;	
}
//---------РЕДАКТРОК ГАЛЕРЕИ (ОБРАБОТЧИК)
//---------ДОБАВЛЕНИЕ ИЗОБРАЖЕНИЯ В БД (ОБРАБОТЧИК)
if(isset($_FILES['galeryfile']))$galeryfile = $_FILES['galeryfile']; else $galeryfile = "";
if(isset($_POST['titleIMG']))$titleIMG = $_POST['titleIMG']; else $titleIMG = "";
if(isset($_POST['txtIMG']))$txtIMG = $_POST['txtIMG']; else $txtIMG = "";
if(isset($_POST['idIMG']))$idIMG = $_POST['idIMG']; else $idIMG = "";

if($galeryfile != "" AND isset($titleIMG) AND isset($txtIMG) AND $idIMG != "")
{
$Wnewimg = 700;//Ширина нового изображение (дефолт 700px)
$Hnewimg = 700;//Высота нового изображение (дефолт 700px)
$Wnewminiimg = 100;//Ширина нового мини изображение (дефолт 100px)
$Hnewminiimg = 100;//Высота нового мини изображение (дефолт 100px)
$max_size_img = 10;//Максимально допустимый размер изображения (дефолт 2 мб)

//Удаляем кавычки
$titleIMG = str_replace("'","",$titleIMG);
$txtIMG = str_replace("'","",$txtIMG);
$titleIMG = str_replace("\"","",$titleIMG);
$txtIMG = str_replace("\"","",$txtIMG);
//Удаляем кавычки
  
$type = $galeryfile['type'];
$kb = $galeryfile['size'];
if($type == "image/jpeg")
{
	if($kb <= $max_size_img*1024*1024)
	{
		//Имена картинок
		$name_img = date("His");
		$indifikator = mt_rand(1, 10000);
		$name_img = $name_img.$indifikator;
		$name_small = $name_img;
		$name_big = $name_img;
		//Имена картинок
		$size = getimagesize($galeryfile['tmp_name']);

		if($size[0] <= $Wnewimg AND $size[1] <= $Hnewimg)//Если фото не надо уменьшать в размере
		{
			newIMG($galeryfile['tmp_name'],$size[0],$size[1],$size[0],$size[1],$name_big,1,0,0);}//то запускаем функцию которая занесет в нужную папку наше изображениее (galery/big/)
		  
		else//Если надо (фото больше чем 700х700 px)
		{
			if($size[0] < $size[1])//Если вертикальное изображение (пример 800 на 1000 пикселей)
			{
				$h_rb = $size[1]/$Hnewimg;//высоту делим на максимальную высоту. По умолчанию на 700, получаем 1,4285
				$wb = $size[0]/$h_rb;//ширину делим на 1,4285, получаем 560,028
				$hb = $Hnewimg;//заносим максимальную высоту изображения
				//на выходе мы получаем ширину изображения 560px высоту 700px
			}
			else//Если горизонтальное изображение (пример 1000 на 800 пикселей)
			{
				$w_rb = $size[0]/$Wnewimg;//Делим ширину на максимальную ширину. Получаем 1,4285
				$hb = $size[1]/$w_rb;//делим высоту на 1,4285, получаем 560,028
				$wb = $Wnewimg;//заносим максимальную ширину
				//на выходе мы получаем изображение шириной 700px и высотой 560px
			}
			if($size[0] == $size[1])//Квадратное изображение
			{
				$wb = $Wnewimg;//заносим максимальную ширину
				$hb = $Hnewimg;//заносим максимальную высоту
			}
			
			newIMG($galeryfile['tmp_name'],$wb,$hb,$size[0],$size[1],$name_big,1,0,0);//вызываем функцию которая занесет нужное нам изображение в нужную папку (galery/big/) 
		}
		  
		//Создание мини изображения
		if($size[0] > $size[1])//Горизонтальное изображение
		{
			//то определяем на сколько необходимо обрезать изображение
			$obrez_w = $size[0] - $size[1];//определяем на сколько ширина больше высоты
			$obrez_h = 0;//так как высота меньше ширены, то ее мы не обрезаем
		}
		else//Вертикальное изображение
		{
			//то определяем на сколько необходимо обрезать изображение
			$obrez_h = $size[1] - $size[0];//определяем на сколько высота больше ширины
			$obrez_w = 0;//так как ширина меньше высоты, то обрезаем ее на ноль!
		}
		if($size[0] == $size[1])//Кавадратное
		{
			//то определяем на сколько необходимо обрезать изображение
			$obrez_h = 0;//но так как высота и ширина равны
			$obrez_w = 0;//обрезать их не нужно
		}
		newIMG($galeryfile['tmp_name'],$Wnewminiimg,$Hnewminiimg,$size[0],$size[1],$name_small,0,$obrez_w,$obrez_h);//запускаем функцию, которая создаст нам мини изображение в папке galery/mini/
		//Создание мини изображения
		
		$add_new_photo = Niun::getInstance()->Get('DataBase')->Query ("INSERT INTO galery (title_galery,id_galery,title_img,txt,href) 
		VALUES ('','$idIMG','$titleIMG','$txtIMG','$name_img')");
		
		header("location: ".getenv('HTTP_REFERER'));//Переносим пользовотеля на страницу галереи
		exit;
	  }
	  
  }
}
//---------ДОБАВЛЕНИЕ ИЗОБРАЖЕНИЯ В БД (ОБРАБОТЧИК)
//------------------------------------------------------------
function newIMG($n_up,$w_new,$h_new,$w_up,$h_up,$n_new,$b_or_m,$obrez_w,$obrez_h)
//Функция зжатия изображений до нужного разрешения
//$n_up - Загружаемый файл
//$w_new - Ширина нового файла
//$h_new - Высота нового файла
//$w_up - Ширина загружаемого файла
//$h_up - Высота загружаемого файла
//$n_new - Имя нового файла
//$b_or_m - Предпросмотор (0) или основной файл (1)
//$obrez_h - Координаты для обрезания исходного изображение (по дефолту 0)
//$obrez_w - Координаты для обрезания исходного изображение (по дефолту 0)
{
	$instant = imagecreatefromjpeg($n_up);//создаем новое изображение из загруженного файла
	$new_img = imagecreatetruecolor($w_new, $h_new);//создаем пустое изображение нужной высоты и ширины
	if($b_or_m == 0)//Если изображение является предпросмотром
	{
		$h_up -= $obrez_h;//уменьшаем высоту загруженного файла на обрезаемое количество пикселей
		$obrez_h = 0;//заносим в высоту 0
		$w_up -= $obrez_w;//уменьшаем ширину на обрезаемое количесво пикселей
		$obrez_w /= 2;//делим обрезаемое количество пикселей на 2
	}
	imagecopyresampled($new_img,$instant,0,0,$obrez_w,$obrez_h,$w_new,$h_new,$w_up,$h_up);//создаем изображение
	if($b_or_m == 0)imagejpeg($new_img, "../data/galery/mini/small_".$n_new.".jpg", 100);//записываем полученное изображение в папку /galery/mini/
	if($b_or_m == 1)imagejpeg($new_img, "../data/galery/big/big_".$n_new.".jpg", 100);//записываем полученное изображение в папку /galery/big/
	imagedestroy($new_img);//уничтожаем заготовки изображений
	imagedestroy($instant);//уничтожаем заготовки изображений
}
//------------------------------------------------------------
function addIMGgalery($id)//Функция добавление изображения
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'formgalery.html');

$sm_read = str_replace("[_id]",$id,$sm_read);//подставляем id в шаблон

$allphoto = photoGAL($id);
return $sm_read.$allphoto;
}
//------------------------------------------------------------
function allgalery()//Функция вывода списка галерей
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT id,title_galery FROM galery WHERE id_galery='0'");//Выводим заголовки галерей
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

if($myrow_index != "")
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'allgalery.html');
	
preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$tamp_while);//Находим в шаблоне тут часть, которую будет ду вайлить
	
do
{
	$copy_tamp = $tamp_while[1];//Сохраняем ту часть которая будет повторяться в отдельную переменную

	//Делаем замены код-слов
	$copy_tamp = str_replace("[_title]",$myrow_index['title_galery'],$copy_tamp);//Название галереи
	$copy_tamp = str_replace("[_link]","[NCMSgal=".$myrow_index['id']."]",$copy_tamp);//код ссылки для галереи
	$copy_tamp = str_replace("[_id]",$myrow_index['id'],$copy_tamp);//ID галереи
	
	$list .= $copy_tamp;//Объединяем результат в одну переменную
}
while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));
$sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$list,$sm_read);//Вставляем в щаблон список галерей
return $sm_read;
}
else return "В базе данных нет галереи, <a href=\"?page=addgalery\">создать?</a>";
}
//------------------------------------------------------------
function editGAL($id)//функция формы для редактирования галереи
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT title_galery FROM galery WHERE id='$id'");//Выводим заголовок галереи
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

if($myrow_index != "")
{
	$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'eddgalery.html');

	$sm_read = str_replace("[_id]",$id,$sm_read);//подставляем id в шаблон
	$sm_read = str_replace("[_titleGAL]",$myrow_index['title_galery'],$sm_read);//подставляем id в шаблон
	return $sm_read;
}
}
//------------------------------------------------------------
function addGAL()//функция формы для добавления галереи
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'addgalery.html');

return $sm_read;
}
//------------------------------------------------------------
function photoGAL($idGAL)//функция вывода фото галереи
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT title_img,txt,href,id FROM galery WHERE id_galery='$idGAL'");//Выводим инфу всех фотографий в выбранной галереи
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

if($myrow_index != "")
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'photogalery.html');

preg_match("/\[_file\](.*?)\[_file\]/s",$sm_read,$copy_sm);//вырезаем копию из шаблона (<tr>...</tr>)

do
{
	$copy_tmp = $copy_sm[1];
	$copy_tmp = str_replace("[_imgBIG]","../data/galery/big/big_".$myrow_index['href'].".jpg",$copy_tmp);
	$copy_tmp = str_replace("[_imgSMALL]","../data/galery/mini/small_".$myrow_index['href'].".jpg",$copy_tmp);
	$copy_tmp = str_replace("[_titleIMG]",$myrow_index['title_img'],$copy_tmp);
	$copy_tmp = str_replace("[_txtIMG]",$myrow_index['txt'],$copy_tmp);
	$copy_tmp = str_replace("[_id]",$myrow_index['id'],$copy_tmp);
	$result .= $copy_tmp;
}
while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));

$sm_read = preg_replace("/\[_file\].*?\[_file\]/s",$result,$sm_read);

return $sm_read;
}
return "Файлов нет!</td>
</table></div>";
}
//------------------------------------------------------------
function eddphotoGAL($idPHOTO)//функция вывода формы редактирования фото
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT id_galery,title_img,txt FROM galery WHERE id='$idPHOTO'");//Выводим инфу всех фотографий в выбранной галереи
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

if($myrow_index != "")
{
	$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'eddphoto.html');

	$sm_read = str_replace("[_id]",$idPHOTO,$sm_read);//подставляем id в шаблон
	$sm_read = str_replace("[_idGAL]",$myrow_index['id_galery'],$sm_read);
	$sm_read = str_replace("[_titleIMG]",$myrow_index['title_img'],$sm_read);
	$sm_read = str_replace("[_txtIMG]",$myrow_index['txt'],$sm_read);
return $sm_read;
}
}
?>
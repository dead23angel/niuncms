<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//ОБРАБОТЧИК
//определяем переменные
if(isset($_POST['pb']))$pb = $_POST['pb'];
if(isset($_POST['viewindex']))$viewindex = $_POST['viewindex'];
if(isset($_POST['viewcomm']))$viewcomm = $_POST['viewcomm'];
if(isset($_POST['sm']))$sm = $_POST['sm'];
if(isset($_POST['xmlsmup']))$xmlsmup = $_POST['xmlsmup'];
if(isset($_POST['xmlsmpr']))$xmlsmpr = $_POST['xmlsmpr'];
if(isset($_POST['viewrss']))$viewrss = $_POST['viewrss'];
if(isset($_POST['viewblock']))$viewblock = $_POST['viewblock'];

//обращение к БД
if(isset($pb) AND isset($viewindex) AND isset($viewcomm) AND isset($sm) AND isset($xmlsmup) AND isset($xmlsmpr) AND isset($viewrss) AND isset($viewblock))//если переменная форма была заполнена и отправленна
{
	$smCONFIGresult = Niun::getInstance()->Get('DataBase')->Query("SELECT sm,xmlsm,rss,date_b,pablick,viewindex FROM blog WHERE id='$id'");//Выводим из базы данных некоторые данные для проверки
	$smCONFIG = Niun::getInstance()->Get('DataBase')->GetArray($smCONFIGresult);
	
	$newXMLconfig = $xmlsmup."|".$xmlsmpr;//Склеиваем инфу об обновление и приоритете в одну переменную ( monthly|0.2 )
	$addrss = $smCONFIG['rss'];

	if($pb != $smCONFIG['pablick'])//если админ выбрал вариант отличный от варианта в бд
	{
		if($pb == 1)$datePOST = time();//Если админ публикует пост
		else $datePOST = $smCONFIG['date_b'];//если админ убирает пост в черновик
	}
	else $datePOST = $smCONFIG['date_b'];//оставляем старую дату

	if($viewindex != $smCONFIG['viewindex'])
	{
		if($viewindex == 0)$viewDBCOMM = 0;
		else $viewDBCOMM = 1;
		
		$newVIEW_DB_COMM = Niun::getInstance()->Get('DataBase')->Query ("UPDATE comm SET view='$viewDBCOMM' WHERE blog='$id'");
	}
	
	$newCONFIG = Niun::getInstance()->Get('DataBase')->Query ("UPDATE blog SET pablick='$pb',date_b='$datePOST',viewindex='$viewindex',viewcomm='$viewcomm',sm='$sm',xmlsm='$newXMLconfig',rss='$viewrss',block='$viewblock' WHERE id='$id'");//обнавляем настройки

	if($smCONFIG['sm'] != $sm OR $smCONFIG['xmlsm'] != $newXMLconfig) sitemap($server_root,$chpu);//Если настройки карты сайты изменились, то записываем их в файл
	if($addrss != $viewrss) rss($server_root,$chpu);//если пункт был изменен, то запускаем функцию rss()

	Niun::getInstance()->Get('Cache')->Clear("newdoc");//сообщаем что кэш модуля "Новые посты" устарел
	Niun::getInstance()->Get('Cache')->Clear("lastcomm");//делаем кэш модуля "последние комментарии" устаревшим
	Niun::getInstance()->Get('Cache')->Clear("topdoc");//делаем кэш модуля "самые читаемые посты" устаревшим
	
	header("location: ".getenv('HTTP_REFERER'));//Переносим пользовотеля на страницу с списком настроек
	exit;
}
//ОБРАБОТЧИК

function configpost($id)//Функция вывода списка настроек поста
{
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT viewindex,viewcomm,sm,xmlsm,rss,block,pablick FROM blog WHERE id='$id'");//Выводим из базы данных конфигурации поста
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);
	
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'configpost.html');

//формирование вариантов выбора настроек
//-----Режим публикации поста----
$pbQUEtxt = array("Черновик","Опубликован");//Вариант для человека
$pbQUEint = array(0,1);//Вариант для скрипта
$pb = queCFG($myrow_index['pablick'],$pbQUEtxt,$pbQUEint);//формируем option для пункта "Режим публикации поста"
//-----Режим публикации поста----

//-----Видим пост в ленте новостей?----
$viQUEtxt = array("Нет","Да");//Вариант для человека
$viQUEint = array(0,1);//Вариант для скрипта
$vi = queCFG($myrow_index['viewindex'],$viQUEtxt,$viQUEint);//формируем option для пункта "Видим пост в ленте новостей?"
//-----Видим пост в ленте новостей?----

//-----Разрешить комментировать пост?----
$vcQUEtxt = array("Нет","Да");//Вариант для человека
$vcQUEint = array(0,1);//Вариант для скрипта
$vc = queCFG($myrow_index['viewcomm'],$vcQUEtxt,$vcQUEint);//формируем option для пункта "Разрешить комментировать пост?"
//-----Разрешить комментировать пост?----

//-----Разместить в файле sitemap.xml?----
//--Подключение/отключение---
$smQUEtxt = array("Нет","Да");//Вариант для человека
$smQUEint = array(0,1);//Вариант для скрипта
$sm = queCFG($myrow_index['sm'],$smQUEtxt,$smQUEint);//формируем option для пункта "Разместить в файле sitemap.xml?" ( да или нет )
//--Подключение/отключение---
//-----
//--Частота смены содержания страницы---
$xmlsm = explode("|",$myrow_index['xmlsm']);//Делим запись в БД на массив
$smupQUEtxt = array("Страница меняется всегда",
					"Страница меняется каждый час",
					"Страница меняется каждый день",
					"Страница меняется еженедельно",
					"Страница меняется каждый месяц",
					"Страница меняется каждый год",
					"Страница не меняется");//Вариант для человека
$smupQUEint = array("always","hourly","daily","weekly","monthly","yearly","never");//Вариант для скрипта
$smup = queCFG($xmlsm[0],$smupQUEtxt,$smupQUEint);//формируем option для пункта "Разместить в файле sitemap.xml?" ( обновление )
//--Частота смены содержания страницы---
//-----
//--Приоритетность URL---
$smprQUEtxt = array("Приоритетность URL 0%",
					"Приоритетность URL 10%",
					"Приоритетность URL 20%",
					"Приоритетность URL 30%",
					"Приоритетность URL 40%",
					"Приоритетность URL 50%",
					"Приоритетность URL 60%",
					"Приоритетность URL 70%",
					"Приоритетность URL 80%",
					"Приоритетность URL 90%",
					"Приоритетность URL 100%");//Вариант для человека
$smprQUEint = array("0.0","0.1","0.2","0.3","0.4","0.5","0.6","0.7","0.8","0.9","1.0");//Вариант для скрипта
$smpr = queCFG($xmlsm[1],$smprQUEtxt,$smprQUEint);//формируем option для пункта "Разместить в файле sitemap.xml?" ( Приоритетность URL )
//--Приоритетность URL---
//-----Разместить в файле sitemap.xml?----

//-----Разместить пост в RSS ленте?----
$vrssQUEtxt = array("Нет","Да");//Вариант для человека
$vrssQUEint = array(0,1);//Вариант для скрипта
$vrss = queCFG($myrow_index['rss'],$vrssQUEtxt,$vrssQUEint);//формируем option для пункта "Разместить пост в RSS ленте?"
//-----Разместить пост в RSS ленте?----

//-----Блокировать пост на гл. стр.?----
$vblQUEtxt = array("Нет","Да");//Вариант для человека
$vblQUEint = array(0,1);//Вариант для скрипта
$vbl = queCFG($myrow_index['block'],$vblQUEtxt,$vblQUEint);//формируем option для пункта "Блокировать пост на гл. стр.?"
//-----Блокировать пост на гл. стр.?----

//Замена код-слов
$sm_read = str_replace("[_cfgpb]",$pb,$sm_read);
$sm_read = str_replace("[_id]",$id,$sm_read);//ID поста
$sm_read = str_replace("[_cfgvi]",$vi,$sm_read);//видимость поста на главной странице
$sm_read = str_replace("[_cfgcomm]",$vc,$sm_read);//комм в постах
$sm_read = str_replace("[_cfgsm]",$sm,$sm_read);//поместить в sm файл, да или нет?
$sm_read = str_replace("[_cfgsmup]",$smup,$sm_read);//вариант обновления
$sm_read = str_replace("[_cfgsmpr]",$smpr,$sm_read);//приоритет
$sm_read = str_replace("[_cfgrss]",$vrss,$sm_read);//rss лента
$sm_read = str_replace("[_cfgblock]",$vbl,$sm_read);//блокировка поста на гл стр
return $sm_read;//Выводим с генерированный html код
}

//----------------------------------------------------------------------

function queCFG($sel,$queTXT,$queINT)//Функция генерации ответов
{
$wh = count($queTXT);//Узнаем сколько вариантов ответа
$result = (!isset($result)) ? '' : $result;
for($i=0;$i<$wh;$i++)//запускаем цикл формирования
{
	//определяем какой вариант сейчас выбран
	if($sel == $queINT[$i])$result .= "<option value='".$queINT[$i]."' selected>".$queTXT[$i]."</option>";//нашли выбранный вариант и приписали selected в тег option
	else $result .= "<option value='".$queINT[$i]."'>".$queTXT[$i]."</option>";//остальные варианты будут без атрибута selected
}
return $result;//выводим с генерированный html код
}

//-----------------------------------------------------------------------

function sitemap($site,$chpu)//Генератор карты сайта
{
$header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";//Шапка xml документа
$timeNOW = date("Y-m-d",time());//регестрируем время последнего обновление главной страницы
//начальный xml код, то есть блок с главной странице
$xmlcode = "\t<url>\n\t\t<loc>".$site."</loc>\n\t\t<lastmod>".$timeNOW."</lastmod>\n\t\t<changefreq>daily</changefreq>\n\t\t<priority>1.0</priority>\n\t</url>\n";

$smRESULT = Niun::getInstance()->Get('DataBase')->Query("SELECT id,date_b,xmlsm,nameurl,cat FROM blog WHERE sm='1' ORDER BY date_b DESC");//Вытаскиваем все посты из БД
$myrow = Niun::getInstance()->Get('DataBase')->GetArray($smRESULT);
if($myrow != "")//если посты есть в БД
{
	do//запускаем цикл
	{
		$datePOST = date("Y-m-d",$myrow['date_b']);//приобразуем дату из БД в вид ГГГГ-ММ-ДД
		
		if($chpu == 0)$link = "index.php?blog=".$myrow['id'];//генерируем ссылку
		if($chpu == 1)$link = gen_catalog($myrow['cat']).$myrow['nameurl'];//генерируем ссылку
		$xmlsm = explode("|",$myrow['xmlsm']);//режим настройку из БД (колонка xmlsm) на массив. Первый элемент будет временем обновления, второй - приоритетом
		
		//подставляем сформированную дату и ссылку в xml код
		$xmlcode .= "\t<url>\n\t\t<loc>".$site.$link."</loc>\n\t\t<lastmod>".$datePOST."</lastmod>\n\t\t<changefreq>".$xmlsm[0]."</changefreq>\n\t\t<priority>".$xmlsm[1]."</priority>\n\t</url>\n";
	}
	while($myrow = Niun::getInstance()->Get('DataBase')->GetArray($smRESULT));
$end = "</urlset>";//закрывающийся тег xml документа

$map = $header.$xmlcode.$end;//склеиваем весь xml код в одну переменную

$smFILE = fopen("../upload/sitemap.xml", "w+");//открываем файл карты
fwrite($smFILE,$map);//записываем в нее полученный xml код
fclose($smFILE);//закрываем файл карты
}
}

//------------------------------------------------------------------------------

function rss($site,$chpu)//функция rss ленты
{
$rssHEADER = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM page WHERE id='1'");//Вытаскиваем инфу о сайте
$myrowHEADER = Niun::getInstance()->Get('DataBase')->GetArray($rssHEADER);

//формируем шапку
$header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\">\n\t<channel>\n\t\t<title>".$myrowHEADER['title']."</title>\n\t\t<link>".$site."</link>\n\t\t<description>".$myrowHEADER['meta_d']."</description>\n\t\t<language>ru-ru</language>\n";//Шапка xml документа

$rssRESULT = Niun::getInstance()->Get('DataBase')->Query("SELECT id,date_b,title,text,nameurl,cat FROM blog WHERE rss='1' ORDER BY date_b DESC LIMIT 5");//Вытаскиваем 5 постов из БД
$myrow = Niun::getInstance()->Get('DataBase')->GetArray($rssRESULT);

if($myrow != "")//если есть посты которые нужно поместить в rss ленту
{
	do
	{
		$datePOST = date("D, d M Y H:i:s",$myrow['date_b']);//превращаем дату в вид Thu, 16 Feb 2012 04:49:11 (пример)
		$datePOST = $datePOST." GMT";//пристыковываем к дате GMT (пример Thu, 16 Feb 2012 04:43:01 GMT)
		
		if($chpu == 0)$link = $site."index.php?blog=".$myrow['id'];//генерируем ссылку
		if($chpu == 1)$link = $site.gen_catalog($myrow['cat']).$myrow['nameurl'];//генерируем ссылку
		
		$txt = explode("<p>[end]</p>",$myrow['text']);//отделяем анонс от текста поста
		$txt = strip_tags($txt[0]);//чистим анонс от html кода
		
		//генерируем xml код
		$xmlcode .= "\t\t<item>\n\t\t\t<title>".$myrow['title']."</title>\n\t\t\t<link>".$link."</link>\n\t\t\t<description><![CDATA[".$txt."]]></description>\n\t\t\t<pubDate>".$datePOST."</pubDate>\n\t\t</item>\n";
	}
	while($myrow = Niun::getInstance()->Get('DataBase')->GetArray($rssRESULT));

$end = "\t</channel>\n</rss>";//закрываем теги xml документа
$result = $header.$xmlcode.$end;//склеиваем части xml кода

$result = iconv("CP1251","UTF-8",$result);

$rssFILE = fopen("../rss/rss.xml", "w+");//открываем файл rss ленты
fwrite($rssFILE,$result);//записываем в него полученный xml код
fclose($rssFILE);//закрываем rss ленту
}
}
?>
<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//ОБРАБОТЧИК
//определяем переменные
if(isset($_POST['cfgtitleBLOG']))$cfgtitleBLOG = $_POST['cfgtitleBLOG'];
if(isset($_POST['cfgmetaDBLOG']))$cfgmetaDBLOG = $_POST['cfgmetaDBLOG'];
if(isset($_POST['cfgmetaKBLOG']))$cfgmetaKBLOG = $_POST['cfgmetaKBLOG'];
if(isset($_POST['cfgloginBLOG']))$cfgloginBLOG = $_POST['cfgloginBLOG'];
if(isset($_POST['cfgpassDBLOG']))$cfgpassDBLOG = $_POST['cfgpassDBLOG'];
if(isset($_POST['cfgemailKBLOG']))$cfgemailKBLOG = $_POST['cfgemailKBLOG'];
if(isset($_POST['viewtd']))$viewtd = $_POST['viewtd'];
if(isset($_POST['viewpoll']))$viewpoll = $_POST['viewpoll'];
if(isset($_POST['viewwl']))$viewwl = $_POST['viewwl'];
if(isset($_POST['viewchpu']))$viewchpu = $_POST['viewchpu'];
if(isset($_POST['viewread']))$viewread = $_POST['viewread'];
if(isset($_POST['cfgrssKBLOG']))$cfgrssKBLOG = $_POST['cfgrssKBLOG'];
if(isset($_POST['cfgetwKBLOG']))$cfgetwKBLOG = $_POST['cfgetwKBLOG'];
if(isset($_POST['cfgmessKBLOG']))$cfgmessKBLOG = $_POST['cfgmessKBLOG'];
if(isset($_POST['viewlastcomm']))$viewlastcomm = $_POST['viewlastcomm'];
if(isset($_POST['viewmorepost']))$viewmorepost = $_POST['viewmorepost'];
if(isset($_POST['viewnd']))$viewnd = $_POST['viewnd'];
if(isset($_POST['listtheamBLOG']))$listtheamBLOG = $_POST['listtheamBLOG'];

//обращение к БД
if(isset($listtheamBLOG) AND isset($viewnd) AND isset($viewmorepost) AND isset($cfgtitleBLOG) AND isset($cfgmetaDBLOG) AND isset($cfgmetaKBLOG) AND isset($cfgloginBLOG) AND $cfgloginBLOG != "" AND isset($cfgpassDBLOG) AND isset($cfgemailKBLOG) AND isset($viewtd) AND isset($viewpoll) AND isset($viewwl) AND isset($viewchpu) AND isset($viewread) AND isset($cfgrssKBLOG) AND isset($cfgetwKBLOG) AND isset($cfgmessKBLOG) AND isset($viewlastcomm))//если переменная форма была заполнена и отправленна
{	
$newCONFIGpageMASSIV = $viewtd."|".$viewpoll."|".$viewwl."|".$viewchpu."|".$viewread."|".$cfgrssKBLOG."|".$cfgetwKBLOG."|".$cfgmessKBLOG."|".$viewlastcomm."|".$viewmorepost."|".$viewnd."|".$listtheamBLOG;
update_htaccess();

	$newCONFIGpage = Niun::getInstance()->Get('DataBase')->Query ("UPDATE page SET title='$cfgtitleBLOG',meta_d='$cfgmetaDBLOG',meta_k='$cfgmetaKBLOG',configblog='$newCONFIGpageMASSIV' WHERE id='1'");//обнавляем настройки
	
	if($cfgpassDBLOG != "")
	{
		global $key_sole;
		
		$newpass = md5($key_sole.md5($cfgpassDBLOG));
		
		$sql = "UPDATE user SET login='$cfgloginBLOG',pass='$newpass',email='$cfgemailKBLOG' WHERE id='1'";
	}
	else $sql = "UPDATE user SET login='$cfgloginBLOG',email='$cfgemailKBLOG' WHERE id='1'";
	
	$newCONFIGuser = Niun::getInstance()->Get('DataBase')->Query ($sql);//обнавляем настройки
	
	Niun::getInstance()->Get('Cache')->Clean("config");//Убиваем кэш с настройкими
	
	header("location: ?page=configblog");//Переносим пользовотеля на страницу с списком настроек
	exit;
}
//ОБРАБОТЧИК

function configblog()//Функция вывода списка настроек блога
{
$result_page = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM page WHERE id='1'");
$myrow_page = Niun::getInstance()->Get('DataBase')->GetArray($result_page);
	
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'configblog.html');

$result_user = Niun::getInstance()->Get('DataBase')->Query("SELECT login,email FROM user WHERE id='1'");
$myrow_user = Niun::getInstance()->Get('DataBase')->GetArray($result_user);

$configMODULS = explode("|",$myrow_page['configblog']);

//-----Топ статьи----
$vtdQUEtxt = array("Отключен","Включен");//Вариант для человека
$vtdQUEint = array(0,1);//Вариант для скрипта
$vtd = queCFG($configMODULS[0],$vtdQUEtxt,$vtdQUEint);//формируем option для пункта "Топ статьи"
//-----Топ статьи----

//-----опрос----
$vpQUEtxt = array("Отключен","Включен");//Вариант для человека
$vpQUEint = array(0,1);//Вариант для скрипта
$vp = queCFG($configMODULS[1],$vpQUEtxt,$vpQUEint);//формируем option для пункта "опрос"
//-----опрос----

//-----премодерация комментариев----
$vwlQUEtxt = array("Отключена","Включена");//Вариант для человека
$vwlQUEint = array(0,1);//Вариант для скрипта
$vwl = queCFG($configMODULS[2],$vwlQUEtxt,$vwlQUEint);//формируем option для пункта "премодерация комментариев"
//-----премодерация комментариев----

//-----ЧПУ----
$vchpQUEtxt = array("Отключен","Включен");//Вариант для человека
$vchpQUEint = array(0,1);//Вариант для скрипта
$vchp = queCFG($configMODULS[3],$vchpQUEtxt,$vchpQUEint);//формируем option для пункта "ЧПУ"
//-----ЧПУ----

//-----подписчики----
$vrdQUEtxt = array("Отключен","Включен");//Вариант для человека
$vrdQUEint = array(0,1);//Вариант для скрипта
$vrd = queCFG($configMODULS[4],$vrdQUEtxt,$vrdQUEint);//формируем option для пункта "подписчики"
//-----подписчики----

//-----Уведомления по E-mail----
$messQUEtxt = array("Отключено","Включено");//Вариант для человека
$messQUEint = array(0,1);//Вариант для скрипта
$mess = queCFG($configMODULS[7],$messQUEtxt,$messQUEint);//формируем option для пункта "Уведомления по E-mail"
//-----Уведомления по E-mail----

//-----Последние комм.----
$lcQUEtxt = array("Отключены","Включены");//Вариант для человека
$lcQUEint = array(0,1);//Вариант для скрипта
$lc = queCFG($configMODULS[8],$lcQUEtxt,$lcQUEint);//формируем option для пункта "Последние комм."
//-----Последние комм.----

//-----Похожие посты----
$mpQUEtxt = array("Отключены","Включены");//Вариант для человека
$mpQUEint = array(0,1);//Вариант для скрипта
$mp = queCFG($configMODULS[9],$mpQUEtxt,$mpQUEint);//формируем option для пункта "Похожие посты"
//-----Похожие посты.----

//-----Новые статьи----
$vndQUEtxt = array("Отключен","Включен");//Вариант для человека
$vndQUEint = array(0,1);//Вариант для скрипта
$vnd = queCFG($configMODULS[10],$vndQUEtxt,$vndQUEint);//формируем option для пункта "Новые статьи"
//-----Новые статьи----

//-----Тема----
$listTHEAM = allTHEAM();
$ltQUEtxt = $listTHEAM;//Вариант для человека
$ltQUEint = $listTHEAM;//Вариант для скрипта
$lt = queCFG($configMODULS[11],$ltQUEtxt,$ltQUEint);//формируем option для пункта "Тема"
//-----Тема----

//Замена код-слов
$sm_read = str_replace("[_cfgvmp]",$mp,$sm_read);
$sm_read = str_replace("[_cfgvlc]",$lc,$sm_read);
$sm_read = str_replace("[_cfgmess]",$mess,$sm_read);
$sm_read = str_replace("[_cfgvchp]",$vchp,$sm_read);
$sm_read = str_replace("[_cfgvrd]",$vrd,$sm_read);
$sm_read = str_replace("[_cfgvwl]",$vwl,$sm_read);
$sm_read = str_replace("[_cfgvtd]",$vtd,$sm_read);
$sm_read = str_replace("[_cfgvp]",$vp,$sm_read);
$sm_read = str_replace("[_title]",$myrow_page['title'],$sm_read);
$sm_read = str_replace("[_metaD]",$myrow_page['meta_d'],$sm_read);
$sm_read = str_replace("[_metaK]",$myrow_page['meta_k'],$sm_read);
$sm_read = str_replace("[_login]",$myrow_user['login'],$sm_read);
$sm_read = str_replace("[_email]",$myrow_user['email'],$sm_read);
$sm_read = str_replace("[_rssacc]",$configMODULS[5],$sm_read);
$sm_read = str_replace("[_twacc]",$configMODULS[6],$sm_read);
$sm_read = str_replace("[_cfgvnd]",$vnd,$sm_read);
$sm_read = str_replace("[_listtheam]",$lt,$sm_read);
$sm_read = str_replace("[_sizeceche]",sizecache(),$sm_read);
return $sm_read;//Выводим с генерированный html код
}
//----------------------------------------------------------
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
//------------------------------------------------------------
function allTHEAM()//Функция вывода всех тем (шаблонов)
{
	$data = opendir(ROOT . DS . 'templates' . DS); //сканируем файлы в папке
	$mass = 0;//считалка первого ключа массива
	while (false !== ($one = readdir($data))) //собираем массив из результата сканирования
	{
		if($one != '.' && $one != '..') //Удаляем точки
		{
			$name[$mass] = $one;//формируем массив с именами файлов
			$mass++;//увеличиваем первый ключ массива
		}
	}
	closedir ($data);//закрываем папку
	
	return $name;
}
//----------------------------------------------------------
function update_htaccess()
{
	global $viewchpu;

	$toFILE = file_get_contents(ROOT . DS . '.htaccess');
	
	if($viewchpu == 1) $htaccess = "RewriteRule ^page/([0-9]+)/\$ index.php?pagesite=\\$1 [L]\nRewriteRule ^(.*)page/([0-9]+)/\$ index.php?chpu_links=\\$1&pagesite=\\$2 [L]\nRewriteRule ^contacts.html\$ index.php?contact=1 [L]\n\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteRule ^(.*)\$ index.php?chpu_links=\\$1 [L]\n";
	
	else $htaccess = "";
	
	$toFILE = preg_replace("/#CHPU.*?#CHPU/s","#CHPU\n".$htaccess."#CHPU", $toFILE);
	
	$hccFILE = fopen(ROOT . DS . '.htaccess', "w+");//открываем файл
	fwrite($hccFILE,$toFILE);//записываем в него полученный код
	fclose($hccFILE);//закрываем
}
//----------------------------------------------------------
function sizecache()
{
	$data = opendir(ROOT . DS . 'system' . DS . 'cache' . DS); //сканируем файлы в папке

	$size = (!isset($size)) ? 0 : $size;
	
	while (false !== ($one = readdir($data))) //собираем массив из результата сканирования
	{
		if($one != '.' && $one != '..') $size += filesize(ROOT . DS . 'system' . DS . 'cache' . DS . $one);
	}
	closedir ($data);//закрываем папку
	
	if(!isset($size)) $size = 0;
	
	$size_txt = array(' байт',' кбайт',' мбайт');
	
	for($i=0;$i<3;$i++)
	{
		if ($size >= 1024)
		{
			$size = $size/1024;
			$size = round($size, 2);
		}
		else
		{
			$size = $size.$size_txt[$i];
			break;
		}
	}
	
	return $size;
}
?>
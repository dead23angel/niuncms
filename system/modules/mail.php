<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function statistictoEMAIL()
{
	$toFILE = file(ROOT . DS . "mail.xml");
	$toFILE = implode("",$toFILE);
	
	preg_match("/<hour>([0-9]+)<\/hour>/s",$toFILE,$xmHOUR);
	$hour = $xmHOUR[1];
	$nowhour = date("G");
	
	if($hour >= 0 AND $hour < 6)$timeSEND = 0;
	if($hour >= 6 AND $hour < 12)$timeSEND = 1;
	if($hour >= 12 AND $hour < 18)$timeSEND = 2;
	if($hour >= 18 AND $hour < 24)$timeSEND = 3;

	if($nowhour >= 0 AND $nowhour < 6)$timeNOW = 0;
	if($nowhour >= 6 AND $nowhour < 12)$timeNOW = 1;
	if($nowhour >= 12 AND $nowhour < 18)$timeNOW = 2;
	if($nowhour >= 18 AND $nowhour < 24)$timeNOW = 3;
	
	if($timeSEND != $timeNOW)
	{
		$emailRESULT = Registry::getInstance()->DataBase->Query("SELECT email FROM user WHERE id='1'");
		$emailDB = Registry::getInstance()->DataBase->GetArray($emailRESULT);
		
		$newcommRESULT = Registry::getInstance()->DataBase->Query("SELECT COUNT(*) FROM comm WHERE loock='0' AND status<'3'");
		$newcomm = Registry::getInstance()->DataBase->GetArray($newcommRESULT);		

		$premodercommRESULT = Registry::getInstance()->DataBase->Query("SELECT COUNT(*) FROM comm WHERE status='3'");
		$premodercomm = Registry::getInstance()->DataBase->GetArray($premodercommRESULT);
		
		$adminmessRESULT = Registry::getInstance()->DataBase->Query("SELECT COUNT(*) FROM mess_admin WHERE loock='0'");
		$adminmess = Registry::getInstance()->DataBase->GetArray($adminmessRESULT);		
		
		$email = $emailDB['email'];
		$them = "Статистика сайта";
		$mess = "Cтатистика (".date("d/m/Y H:i")."):\n\nКомментариев в базе данных (новых) - ".$newcomm[0]."\nКомментариев на премодерации - ".$premodercomm[0]."\nНовых писем - ".$adminmess[0]."\n";
		
		mail($email,$them,$mess);
		
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<statistic>\n\t<hour>".date("G")."</hour>\n</statistic>";
		$xmlFILE = fopen("mail.xml", "w+");
		fwrite($xmlFILE,$xml);
		fclose($xmlFILE);
	}
}
?>
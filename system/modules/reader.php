<?php
### NiunCMS - Community Management System ###
### Powered by SibWeb Media Group         ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined('USERPART')) die();
function select_reader($rssacc,$twacc)
{
	$date_h = date("G");
	$raderFILE = file("reader.xml");//считываем файл с подписками
	$raderFILE = implode("",$raderFILE);//функция file() возвращаем массив, поэтому склеиваем его
	preg_match("/<hour>([0-9]+)<\/hour>/s",$raderFILE,$readerHour);
	
	if($readerHour[1] != $date_h)
	{
		$rss_reader = rss_reader($rssacc);
		$twitter_reader = twitter_reader($twacc);
		if(!preg_match("/^[0-9]+$/s",$rss_reader))$rss_reader = "error";
		if(!preg_match("/^[0-9]+$/s",$twitter_reader))$twitter_reader = "error";
		
		if($rss_reader == 0)
		{
			preg_match("/<rss>([a-z0-9]+)<\/rss>/s",$raderFILE,$readerRSS);
			$rss_reader = $readerRSS[1];
		}
		if($twitter_reader == 0)
		{
			preg_match("/<twitter>([a-z0-9]+)<\/twitter>/s",$raderFILE,$readerTW);
			$twitter_reader = $readerTW[1];
		}
		
		$xmlHEADER = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<reader>\n";
		$xml = "\t<hour>".$date_h."</hour>\n\t<rss>".$rss_reader."</rss>\n\t<twitter>".$twitter_reader."</twitter>\n";
		$xmlEND = "</reader>";
		$xml = $xmlHEADER.$xml.$xmlEND;
		
		$xmlFILE = fopen("reader.xml", "w+");//открываем файл
		fwrite($xmlFILE,$xml);//записываем в него полученный xml код
		fclose($xmlFILE);//закрываем файл
	}
	else
	{
		preg_match("/<rss>([a-z0-9]+)<\/rss>/s",$raderFILE,$readerRSS);
		preg_match("/<twitter>([a-z0-9]+)<\/twitter>/s",$raderFILE,$readerTW);
		$rss_reader = $readerRSS[1];
		$twitter_reader = $readerTW[1];
	}

$sm_read = Niun::getInstance()->Get('Template')->Fetch('reader');

$sm_read = str_replace("[_rss]",$rss_reader,$sm_read);
$sm_read = str_replace("[_tw]",$twitter_reader,$sm_read);

return $sm_read;
}

function twitter_reader($acc)
{
	$tw_file = @file_get_contents("http://api.twitter.com/1/users/show.xml?screen_name=".$acc);
	if(isset($tw_file))
	{
		preg_match("/<followers_count>(.*?)<\/followers_count>/s",$tw_file,$reader);
		return $reader[1];
	}
	else return "-";
}

function rss_reader($acc)
{
	$rss_file = @file_get_contents("http://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=".$acc);
	if(isset($rss_file))
	{
		preg_match("/circulation=\"(.*?)\"/s",$rss_file,$reader);
		return $reader[1];	
	}
	else return "-";
}
?>
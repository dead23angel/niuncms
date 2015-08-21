<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function galery($gal)
{
$result_index = Registry::getInstance()->DataBase->Query("SELECT `title_img`, `txt`, `href` FROM galery WHERE id_galery = '$gal'");
$myrow_index = Registry::getInstance()->DataBase->GetArray($result_index);

if($myrow_index != "")
{

$sm_read = Registry::getInstance()->Template->Fetch('galery');

$idw=0;
do
{
	$img[$idw][0] = $myrow_index['title_img'];
	$img[$idw][1] = $myrow_index['txt'];
	$img[$idw][2] = $myrow_index['href'];
	$idw++;
}
while($myrow_index = Registry::getInstance()->DataBase->GetArray($result_index));

preg_match("/\[_tdTABLE\](.*?)\[_tdTABLE\]/s",$sm_read,$copy);

$m = 0;
for($i=0;$i<=4;$i++)
{
$copytp = $copy[1];
	if($i<4)
	{
		if(isset($img[$m]))
		{
			$copytp = str_replace("[_imgSMALL]","<img onclick=\"galery('".$img[$m][0]."','".$img[$m][1]."','../data/galery/big/big_".$img[$m][2].".jpg',0);\" class=\"galeryIMG\" src=\"../data/galery/mini/small_".$img[$m][2].".jpg\" border=\"0px\"><div style='display:none'><img src='../data/galery/big/big_".$img[$m][2].".jpg'></div>",$copytp);
			$m++;
		}
		else $copytp = str_replace("[_imgSMALL]","&nbsp;",$copytp);
	$result .= $copytp."\n";
	}
	else
	{
		if(!isset($img[$m]))
		{
			//$copytp = str_replace("[_imgSMALL]","&nbsp;",$copytp);
			//$result .= $copytp."\n";
			break;
		}
		else
		{
			$result .= "</tr>\n<tr>\n";
			$i=-1;
		}
	}
}
$sm_read = preg_replace("/\[_tdTABLE\].*?\[_tdTABLE\]/s",$result,$sm_read);
}
else $sm_read = "<p align='center'>В галереи нет фотографий</p>";

return $sm_read;
}

function viewphoto()
{
$sm_read = Registry::getInstance()->Template->Fetch('viewphoto');

return $sm_read;
}
?>
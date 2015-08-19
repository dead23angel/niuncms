<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function capcha()
{

$q[0] = "Ананас";
$q[1] = "Бананы";
$q[2] = "Арбуз";
$q[3] = "Яблоко";

$imgq[0] = server_root . 'templates/system/images/capcha/1.jpg';
$imgq[1] = server_root . 'templates/system/images/capcha/2.jpg';
$imgq[2] = server_root . 'templates/system/images/capcha/3.jpg';
$imgq[3] = server_root . 'templates/system/images/capcha/4.jpg';
for ($iall=0;$iall<4;$iall++)
{
	for($i=0;$i<8;$i++)
	{	
		$simvol = chr(rand(97,122));
		$code[$i] = $simvol;
	}
	$sort = rand(1,100);
	$code = implode("",$code);
	$cods[$iall][0] = $sort;
	$cods[$iall][1] = $code;
	$code = md5($code . key_sole);
	$cods[$iall][2] = $code;
	$cods[$iall][3] = $imgq[$iall];
	$cods[$iall][4] = $q[$iall];
	$cods[$iall][5] = "false";
	unset($code);
}
rsort($cods);
$truepars = rand(0,3);
$cods[$truepars][5] = "true";

return $cods;
}
?>
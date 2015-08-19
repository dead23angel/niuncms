<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function navig($post,$pn,$modul)
{
//Навигация (расчет количества страниц)
if($modul == "post")$sql = "SELECT COUNT(*) FROM blog";
if($modul == "user")$sql = "SELECT COUNT(*) FROM whitelist";

$result3 = Niun::getInstance()->Get('DataBase')->Query ($sql);
$myrow3 = Niun::getInstance()->Get('DataBase')->GetArray ($result3);

$full = $myrow3[0];
$links = (($full - 1) / $post) + 1;
$links =  intval($links);
$page_link = $pn * $post - $post;
//Навигация (расчет количества страниц)
$limit[0] = $page_link;
$limit[1] = $post;
$limit[2] = $links;
return $limit;
}

function listnav($links,$pn,$max,$modul)
{
		$max_pn = $max;//максимальное число кнопочек на странице [1][2][3][4][5][6]
		$left_right_links = $max_pn/2;
		
		for($i=$pn-$left_right_links;$i<$pn;$i++)
		{
			if($i>=1)
			{
				if($modul == "post")$nav .= "<a href=\"admin.php?page=all_content&pn=".$i."\">[".$i."]</a>";
				if($modul == "user")$nav .= "<a href=\"admin.php?page=user&pn=".$i."\">[".$i."]</a>";
				if($modul == "imgfile")$nav .= "<a href=\"admin.php?page=mfiles&scan=1&list=".$i."\">[".$i."]</a>";
				if($modul == "arhivfile")$nav .= "<a href=\"admin.php?page=mfiles&scan=2&list=".$i."\">[".$i."]</a>";
			}
		}
		
		$nav .= "[".$pn."]";
		
		for($i=$pn+1;$i<($pn+1)+$left_right_links;$i++)
		{
			if($i<=$links)
			{
				if($modul == "post")$nav .= "<a href=\"admin.php?page=all_content&pn=".$i."\">[".$i."]</a>";
				if($modul == "user")$nav .= "<a href=\"admin.php?page=user&pn=".$i."\">[".$i."]</a>";
				if($modul == "imgfile")$nav .= "<a href=\"admin.php?page=mfiles&scan=1&list=".$i."\">[".$i."]</a>";
				if($modul == "arhivfile")$nav .= "<a href=\"admin.php?page=mfiles&scan=2&list=".$i."\">[".$i."]</a>";
			}
		}
		
		$minLINKS = $pn - $left_right_links;
		$maxLINKS = $pn + $left_right_links;
		
		if($minLINKS > 1)
		{
			if($modul == "post")$nav = "<a href=\"admin.php?page=all_content&pn=1\">[1]</a>...".$nav;
			if($modul == "user")$nav = "<a href=\"admin.php?page=user&pn=1\">[1]</a>...".$nav;
			if($modul == "imgfile")$nav = "<a href=\"admin.php?page=mfiles&scan=1&list=1\">[1]</a>...".$nav;
			if($modul == "arhivfile")$nav = "<a href=\"admin.php?page=mfiles&scan=2&list=1\">[1]</a>...".$nav;
		}
		if($maxLINKS < $links)
		{
			if($modul == "post")$nav .= "...<a href=\"admin.php?page=all_content&pn=".$links."\">[".$links."]</a>";
			if($modul == "user")$nav .= "...<a href=\"admin.php?page=user&pn=".$links."\">[".$links."]</a>";
			if($modul == "imgfile")$nav .= "...<a href=\"admin.php?page=mfiles&scan=1&list=".$links."\">[".$links."]</a>";
			if($modul == "arhivfile")$nav .= "...<a href=\"admin.php?page=mfiles&scan=2&list=".$links."\">[".$links."]</a>";
		}
				
		$nav = "<div id=\"navig\" style=\"margin-top:15px;margin-bottom:40px;\" align=\"center\">".$nav."</div>";
		return $nav;
}
?>
<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");


function navig($post,$pn,$cat,$page,$chpu)
{
//Навигация (расчет количества страниц)
if($page == "cat") $sql = "SELECT COUNT(*) FROM blog WHERE cat='$cat' AND viewindex='1' AND pablick='1'";
if($page == "index") $sql = "SELECT COUNT(*) FROM blog WHERE viewindex='1' AND pablick='1'";

$result3 = Niun::getInstance()->Get('DataBase')->Query($sql);
$myrow3 = Niun::getInstance()->Get('DataBase')->GetArray($result3);

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

function listnav($links,$pn,$max,$cat,$page,$chpu)
{
	$max_pn = $max;
	$left_right_links = $max_pn/2;

	$nav = (!isset($nav)) ? '' : $nav;
		
	for($i=$pn-$left_right_links;$i<$pn;$i++)
	{
		if($i>=1)
		{
			if($page == "cat")$nav .= linkBLOCK($page,$chpu,$i,$cat,0);
			if($page == "index")$nav .= linkBLOCK($page,$chpu,$i,'',0);
		}
	}
		
	$nav .= linkBLOCK('','',$pn,'',1);
		
	for($i=$pn+1;$i<($pn+1)+$left_right_links;$i++)
	{
		if($i<=$links)
		{
			if($page == "cat")$nav .= linkBLOCK($page,$chpu,$i,$cat,0);
			if($page == "index")$nav .= linkBLOCK($page,$chpu,$i,'',0);
		}
	}
		
	$minLINKS = $pn - $left_right_links;
	$maxLINKS = $pn + $left_right_links;
		
	if($minLINKS > 1)
	{
		if($minLINKS == 2)$stepFUN = 0;
		else $stepFUN = 3;
		if($page == "cat")$nav = linkBLOCK($page,$chpu,1,$cat,$stepFUN).$nav;
		if($page == "index")$nav = linkBLOCK($page,$chpu,1,'',$stepFUN).$nav;
	}
	if($maxLINKS < $links)
	{
		if($links-1 == $maxLINKS)$stepFUN = 0;
		else $stepFUN = 2;
			
		if($page == "cat")$nav .= linkBLOCK($page,$chpu,$links,$cat,$stepFUN);
		if($page == "index")$nav .= linkBLOCK($page,$chpu,$links,'',$stepFUN);
	}

	$nav = '<div class="pages" align="center" style="margin-bottom:10px; margin-top:4px;"> Страницы: ' . $nav . '</div>';
	
	return $nav;
}
//-------------------------------------
function linkBLOCK($page,$chpu,$pn,$cat,$step)
{
	if($step == 0 OR $step == 2 OR $step == 3)
	{
		if($chpu == 0)
		{
			if($page == "cat")$link = "index.php?cat=".$cat."&pn=".$pn;
			if($page == "index")$link = "index.php?pn=".$pn;
		}
		if($chpu == 1)
		{
			if($page == "cat")$link = gen_catalog($cat)."page/".$pn."/";
			if($page == "index")$link = Niun::getInstance()->Get('DataBase')->server_root. "page/".$pn."/";
		}
		
		$result = "<a href='".$link."'>".$pn."</a> ";

		if($step == 2)$result = "<div class='morenavig'>...</div>".$result;
		if($step == 3)$result .= "<div class='morenavig'>...</div>";		
	}
	if($step == 1)$result = '<strong>' . $pn . '</strong> ';

return $result;
}
?>

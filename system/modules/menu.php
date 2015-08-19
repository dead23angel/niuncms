<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

//ОПРЕДЕЛЕНИЕ ОТКРЫТОЙ СТРАНИЦЫ
if(isset($blog)){$page_menunavig = "blog";$sub_menunavig = $blog;}//СТРАНИЦА ПОСТА
if(isset($cat)){$page_menunavig = "cat";$sub_menunavig = $cat;}//СТРАНИЦА КАТЕГОРИИ
if(isset($contact)){$page_menunavig = "contact";$sub_menunavig = "";}//СТРАНИЦА ОБРАТНОЙ СВЯЗИ
if(!isset($blog) AND !isset($cat) AND !isset($contact)){$page_menunavig = "index";$sub_menunavig = "";}//ГЛАВНАЯ СТРАНИЦА
//ОПРЕДЕЛЕНИЕ ОТКРЫТОЙ СТРАНИЦЫ

function DBmenunav($step,$sub)
{
	if($step == 2)
	{
		global $server_root;
		$sub = $server_root;
		$step = 0;
	}
	if($step == 0)
	{
		global $site_menu;
		
		foreach($site_menu as $value)
		{
			if($sub == $value[3])
			{
				$select_id = $value[0];
				break;
			}
		}
	}
	if($step == 1)
	{

		$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT cat FROM blog WHERE id='".$sub."'");
		$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

	}
	
	if($step == 0)
	{
		if(isset($select_id)) return $select_id;
		else return 0;
	}
	
	if($step == 1)
	{
		if($myrow_index != "") return $myrow_index['cat'];
		else return 0;
	}
}

function menunavig($canon,$page,$sub)
{
	if($page == "blog")
	{
		$id = DBmenunav(0,$canon);
		if($id == 0)$id = DBmenunav(1,$sub);
	}	
	if($page == "cat")$id = $sub;	
	if($page == "contact")$id = DBmenunav(0,$canon);
	if($page == "index")$id = DBmenunav(2,$canon);

return $id;
}

function menu($chpu,$idM)
{
global $site_menu, $config;

if(count($site_menu)>0)
{
	$sm_read = Niun::getInstance()->Get('Template')->Fetch('menu');
	
	preg_match("/\[_divmenu\](.*?)\[_divmenu\]/s",$sm_read,$div_menu);

	$menu = station(0,$site_menu,$div_menu[1],0,$chpu,$idM);

	$menu = preg_replace("/\[_divmenu\].*?\[_divmenu\]/s",$menu,$sm_read);

}
else $menu = "";
return $menu;
}

function station($stat,$commMASS,$temp,$BC,$chpu,$idM)
{
	$menu = '';
for($i=0;isset($commMASS[$i]);$i++)
{
	if($commMASS[$i][4] == $stat)
	{
		$edd_tamp = $temp;

		if($commMASS[$i][3] == "")
		{	
			if($chpu == 0)$href = "<a href=\"index.php?cat=".$commMASS[$i][0]."\">".$commMASS[$i][2]."</a>";
			else $href = "<a href=\"".gen_catalog($commMASS[$i][0])."\">".$commMASS[$i][2]."</a>";
		}
		else
		{
			if($commMASS[$i][3] != "#")$href = "<a href=\"".$commMASS[$i][3]."\">".$commMASS[$i][2]."</a>";
			else $href = "<span class='nohref'>".$commMASS[$i][2]."</span>";
		}
	$style = $BC * 10;
	$newBC = $BC + 1;
	$podmenu = station($commMASS[$i][0],$commMASS,$temp,$newBC,$chpu,$idM);

	if($idM == $commMASS[$i][0])$edd_tamp = str_replace("[_class]","TRUE",$edd_tamp);
	else $edd_tamp = str_replace("[_class]","",$edd_tamp);	
	$edd_tamp = str_replace("[_podmenu]",$podmenu,$edd_tamp);
	$edd_tamp = str_replace("[_style]",$style,$edd_tamp);
	$edd_tamp = str_replace("[_station]",$href,$edd_tamp);
	$menu .= $edd_tamp;
	}
}
return $menu;
}
?>
<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function morepost($config = array(), $cat, $blog)
{
	global $config;
$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT title,id,nameurl,cat FROM blog WHERE viewindex='1' AND pablick='1' AND cat='$cat' AND cat!='0' AND id!='$blog'");//Выводим из базы статью
$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

if($myrow_index != "")
{
$more = Niun::getInstance()->Get('Template')->Fetch('morepost');

$ps = 0;
do
{
	$post[$ps][0] = $myrow_index['title'];
	$post[$ps][1] = $myrow_index['id'];
	$post[$ps][2] = $myrow_index['nameurl'];
	$post[$ps][3] = $myrow_index['cat'];
	
	$ps++;
}
while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));

$ellem = count($post);

if($ellem > 5)
{
$maxr = $ellem - 1;

	for($i=0;$i<5;$i++)
	{
		$rand = rand(0, $maxr);
		
		if(isset($post[$rand]))
		{
			$gen[$i][0] = $post[$rand][0];//переносим заголовок
			$gen[$i][1] = $post[$rand][1];//переносим id
			$gen[$i][2] = $post[$rand][2];//переносим чпу
			$gen[$i][3] = $post[$rand][3];//переносим категорию
			
			unset($post[$rand]);
		}
		else $i--;
	}

$li = listMOREpost($gen, $config['chpu']);
}
else $li = listMOREpost($post, $config['chpu']);

$more = str_replace("[_more]",$li,$more);
return $more;
}
else return "";
}

function listMOREpost($massiv,$config = array())
{
	global $config;
	for($i=0;isset($massiv[$i]);$i++)
	{
		if($config['chpu'] == 0)$li .= "<li><a href=\"index.php?blog=".$massiv[$i][1]."\">".$massiv[$i][0]."</a></li>";
		if($config['chpu'] == 1)$li .= "<li><a href=\"".gen_catalog($massiv[$i][3]).$massiv[$i][2]."\">".$massiv[$i][0]."</a></li>";
	}

return $li;
}
?>
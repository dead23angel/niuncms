<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

if(!isset($blog) AND !isset($contact) AND !isset($cat))
{
	if($pn == 1)
	{
		if($config['chpu'] == 0)$canon = server_root;
		else $canon = server_root;
	}
	else
	{
		if($config['chpu'] == 0)$canon = server_root."index.php?pn=".$pn;
		else $canon = server_root."page/".$pn."/";
	}
}

if(isset($blog))
{
	if($config['chpu'] == 0)$canon = server_root."index.php?blog=".$blog;
	else $canon = server_root.$chpu_links;
}

if(isset($cat))
{
	if($pn == 1)
	{
		if($config['chpu'] == 0)$canon = server_root."index.php?cat=".$cat;
		else $canon = server_root.$chpu_links;
	}
	else
	{
		if($config['chpu'] == 0)$canon = server_root."index.php?cat=".$cat."&pn=".$pn;
		else $canon = server_root.$chpu_links."page/".$pn."/";		
	}
}

if(isset($contact))
{
	if($config['chpu'] == 0)$canon = server_root."index.php?contact=1";
	else $canon = server_root."contacts.html";
}
?>
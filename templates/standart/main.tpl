<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="shortcut icon" href="<?=$server_root?>favicon.ico" />
<meta name="description" content="<?=$header_metaD?>" />
<meta name="keywords" content="<?=$header_metaK?>" />
<meta name="generator" content="<?=@$generator?>" />

<title><?=$header_title?></title>

<LINK href="<?=@$rss?>" rel="alternate" type="application/rss+xml" title=""/>
<link rel="canonical" href="<?=$canon?>"/>
<base href="<?=$server_root?>">

<script type="text/javascript" src="templates/<?=$config['theme']?>/js/jquery.js"></script>
<script type="text/javascript" src="templates/<?=$config['theme']?>/js/scrollto.js"></script>
<script type="text/javascript" src="templates/<?=$config['theme']?>/js/users.js"></script>

<script type="text/javascript"> 
$(function () { 
 $(window).scroll(function () { 
 if ($(this).scrollTop() > 100) $('a#move_up').fadeIn(); 
 else $('a#move_up').fadeOut(400); 
 }); 
 $('a#move_up').click(function () { 
 $('body,html').animate({ 
 scrollTop: 0 
 }, 800); 
 return false; 
 }); 
}); 
</script>

<script type="text/javascript" language="javascript"><!--
  function atoprint(aId) {
    var atext = document.getElementById(aId).innerHTML;
    var captext = window.document.title;
    var alink = window.document.location;
    var prwin = open('');
    prwin.document.open();
    prwin.document.writeln('<html><head><title>Версия для печати<\/title><META NAME="ROBOTS" CONTENT="noindex, nofollow"><\/head><body  style="width:800px;margin: auto;" text="#000000" bgcolor="#FFFFFF"><div onselectstart="return false;" oncopy="return false;">');  
	prwin.document.writeln('<div style="padding:20px;background:#8EB9FC;"><a id="24" href="javascript://" onclick="window.print();"style="padding: 6px;background: #BFD8FF;border: 1px solid #000;text-decoration: none;color: 000;">Печать<\/a> • <a href="javascript://" onclick="window.close();"style="padding: 6px;background: #BFD8FF;border: 1px solid #000;text-decoration: none;color: 000;">Закрыть окно<\/a><div align="right">Много интересного тут: <a href="/"><?=$server_root?><\/a> | .<\/div><\/div><hr>');
    prwin.document.writeln('<h1>'+captext+'<\/h1>');
    prwin.document.writeln(atext);
    prwin.document.writeln('<hr><div style="font-size:12pt;padding:20px;background:#8EB9FC;"><?=$powered_by?><\/div>');
    prwin.document.writeln('<div style="font-size:12pt;padding:20px;background:#8EB9FC;">Статья из блога: '+alink+'<\/div>')    
  }
  --></script>

<link rel="stylesheet" href="templates/<?=$config['theme']?>/style.css" type="text/css"/>

</head>
<body>
<a id="move_up" href="#"></a>
<div class="header">
<div class="nav">
<a href="<?=$server_root?>"><img src="templates/<?=$config['theme']?>/img/logo.png"></a>
<?=$site_menu?>
</div>
</div>
<div class="content">
<table width="100%">
<tr>
<td valign="top" width="200px">
<?=$menu?>
<?=$poll?>
<?=$lastcomm?>
</td>

<td valign="top" width="100%">
<div class="block04">
<?php if(isset($reader)) echo $reader;?>
<?=$txt?>
</div>
</td>

<td valign="top" width="200px">
<?=$newdoc?>
<?=$topdoc?>
<?php if(isset($blocki)) echo $blocki;?>
</td>
</table>
<div class="clear"></div>
</div>
<div class="footer">
Powered by <a href='http://www.niun.ru/' target='_blank'>NiunCMS</a> v2.0 & Designed by <a href="http://vk.com/sibweb" target="_blank">SibWeb Media Group</a>
<div style="float:right;">
<a href="<?=@$rss?>" target="_blank" title="RSS"><img src="templates/<?=$config['theme']?>/img/rss.png"></a>
</div>
</div>
<div align = "center">
<?=$viewphoto?>
</div>
<div style="padding-top:10px"></div>
</body>
</html>
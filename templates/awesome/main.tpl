<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="shortcut icon" href="<?= $this->theme; ?>/favicon.ico" />
<meta name="description" content="<?= $this->header_metaD; ?>" />
<meta name="keywords" content="<?= $this->header_metaK; ?>" />
<meta name="generator" content="<?= $this->generator; ?>" />
<meta name="author" content="<?= $this->author; ?>" />

<title><?= $this->header_title; ?></title>

<LINK href="<?=@$rss?>" rel="alternate" type="application/rss+xml" title=""/>

<link rel="stylesheet" type="text/css" href="<?= $this->theme; ?>/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?= $this->theme; ?>/css/engine.css" />
<!--[if lt IE 6]>
<script defer type="text/javascript" src="<?= $this->theme; ?>/js/pngfix.js"></script>
<![endif]-->
<!--[if lt IE 7]>
<script defer type="text/javascript" src="<?= $this->theme; ?>/js/pngfix.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?= $this->theme; ?>/css/slider.css" />
<script type="text/javascript" src="<?= $this->theme; ?>/js/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="<?= $this->theme; ?>/js/jquery-easing-1.3.pack.js"></script>
<script type="text/javascript" src="<?= $this->theme; ?>/js/jquery-easing-compatibility.1.2.pack.js"></script>
<script type="text/javascript" src="<?= $this->theme; ?>/js/coda-slider.1.1.1.pack.js"></script>
	
<script type="text/javascript">
	
		var theInt = null;
		var $crosslink, $navthumb;
		var curclicked = 0;
		
		theInterval = function(cur){
			clearInterval(theInt);
			
			if( typeof cur != 'undefined' )
				curclicked = cur;
			
			$crosslink.removeClass("active-thumb");
			$navthumb.eq(curclicked).parent().addClass("active-thumb");
				$(".stripNav ul li a").eq(curclicked).trigger('click');
			
			theInt = setInterval(function(){
				$crosslink.removeClass("active-thumb");
				$navthumb.eq(curclicked).parent().addClass("active-thumb");
				$(".stripNav ul li a").eq(curclicked).trigger('click');
				curclicked++;
				if( 6 == curclicked )
					curclicked = 0;
				
			}, 3000);
		};
		
		$(function(){
			
			$("#main-photo-slider").codaSlider();
			
			$navthumb = $(".nav-thumb");
			$crosslink = $(".cross-link");
			
			$navthumb
			.click(function() {
				var $this = $(this);
				theInterval($this.parent().attr('href').slice(1) - 1);
				return false;
			});
			
			theInterval();
		});
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.splLink').click(function(){
      $(this).parent().children('div.splCont').toggle('normal');
      return false;
    });
  });
</script>

<script type="text/javascript" src="<?= $this->theme; ?>/js/scrollto.js"></script>
<script type="text/javascript" src="<?= $this->theme; ?>/js/users.js"></script>

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
	prwin.document.writeln('<div style="padding:20px;background:#8EB9FC;"><a id="24" href="javascript://" onclick="window.print();"style="padding: 6px;background: #BFD8FF;border: 1px solid #000;text-decoration: none;color: 000;">Печать<\/a> • <a href="javascript://" onclick="window.close();"style="padding: 6px;background: #BFD8FF;border: 1px solid #000;text-decoration: none;color: 000;">Закрыть окно<\/a><hr>');
    prwin.document.writeln('<h1>'+captext+'<\/h1>');
    prwin.document.writeln(atext);
    prwin.document.writeln('<div style="font-size:12pt;padding:20px;background:#8EB9FC;">Статья из блога: '+alink+'<\/div>')    
  }
  --></script>

</head>

<body>
<a id="move_up" href="#"></a>
<div align="center">
 <div id="page" align="left">
  <div id="padding16">
  
	<!-- Верх сайта-->
	<table width="100%"><tr>
		<td valign="top"><div class="white-top" style="padding-top: 10px;"><a href="/contacts.html">Обратная связь</a></div></td>
		<td align="right" valign="top"><?= $this->fetch('tpl.top-links'); ?></td> <!-- Навигация сверху -->
	</tr></table>
	
	<table width="100%"><tr>
		<td>
		
		<!-- Лого сайта -->
		<div id="logo-bg">
			<div id="logo"><a href="/" class="logo" border="0"></a></div>
			<?= $this->stats; ?>
		</div>
		
		</td>
		<td>
		
		<!-- Панель пользователя -->
		<div id="login-bg"><div id="login-pad" class="login">{login}</div></div>
		
		</td>
	</tr></table>
	
	<table><tr>
		<td valign="top">
		
		<!-- Поиск по сайту -->
		<div id="search-bg"><div id="search-pad"><?= $this->fetch('search-tab'); ?></div></div>
		
		</td>
		<td valign="top" align="left">
		
		<!-- Последние новости сайта -->
		<div class="lastnews" style="padding-left: 104px; padding-top: 23px;"><?= $this->newdoc; ?></div>
		
		</td>
	</tr></table>
	
	<!-- Пошла общая таблица -->
	<table width="100%"><tr>
	
		<!-- info & content -->
		<td valign="top">

			<!-- Слайдер -->
			<div id="intresting"></div> <? Niun::getInstance()->Get('Template')->Display('slider'); ?>
			
			<?=$this->txt?>
		
		</td>
		
		<!-- menu #1 -->
		<td style="padding-left: 16px;" valign="top" width="226">

			<?php echo Niun::getInstance()->Get('Template')->blocki; ?>

		</td>
		
		<!-- menu #2 -->
		<td style="padding-left: 16px;" valign="top">

		<?= $this->menu; ?>
		
		<!-- Популярные новости -->
		<div id="rmenu04"></div>
		<div id="rmenu-bg"><div id="menu-pad" class="menu"><?= $this->topdoc; ?></div></div>
		<div style="margin-bottom: 12px;" id="rmenu-bottom"></div>
		
		<!-- Опросы сайта -->
		<div id="rmenu03"></div>
		<div id="rmenu-bg"><div id="menu-pad" class="menu"><?= $this->poll; ?></div></div>
		<div style="margin-bottom: 12px;" id="rmenu-bottom"></div>

		</td>
		
	</tr></table>

     
  </div>
 </div>
 
    <!-- Подвал -->
     <div id="footer">
		<div class="lastnews" style="padding-top: 55px;">
		 <!-- Информация -->
		</div>
     </div>
 
</div>

</body>

</html>
-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 06 2013 г., 20:33
-- Версия сервера: 5.5.31-0ubuntu0.13.04.1
-- Версия PHP: 5.4.9-4ubuntu2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `niun`
--

-- --------------------------------------------------------

--
-- Структура таблицы `blocki`
--

CREATE TABLE IF NOT EXISTS `blocki` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `tpl` int(1) NOT NULL DEFAULT '0',
  `position` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `blocki`
--

INSERT INTO `blocki` (`id`, `name`, `text`, `tpl`, `position`) VALUES
(1, 'Донатеру', '<p><center>Хотите нам помочь на развитие проекта?</center></p>\r\n<p>\r\n<center><a href="donate.html"><input class="input small" type="button" value="Способы помощи"></a></center></p>\r\n<script type="text/javascript">\r\n    var reformalOptions = {\r\n        project_id: 90641,\r\n        project_host: "niun.reformal.ru",\r\n        tab_orientation: "right",\r\n        tab_indent: "50%",\r\n        tab_bg_color: "#aaaaaa",\r\n        tab_border_color: "#FFFFFF",\r\n        tab_image_url: "http://tab.reformal.ru/T9GC0LfRi9Cy0Ysg0Lgg0L%252FRgNC10LTQu9C%252B0LbQtdC90LjRjw==/FFFFFF/88128dfd6ca0743b5ccc2f8afed9f3b1/right/0/tab.png",\r\n        tab_border_width: 1\r\n    };\r\n    \r\n    (function() {\r\n        var script = document.createElement(''script'');\r\n        script.type = ''text/javascript''; script.async = true;\r\n        script.src = (''https:'' == document.location.protocol ? ''https://'' : ''http://'') + ''media.reformal.ru/widgets/v3/reformal.js'';\r\n        document.getElementsByTagName(''head'')[0].appendChild(script);\r\n    })();\r\n</script><noscript><a href="http://reformal.ru"><img src="http://media.reformal.ru/reformal.png" /></a><a href="http://niun.reformal.ru">Oтзывы и предложения для NiunCMS</a></noscript>\r\n    ', 0, 2),
(3, 'ВКонтакте', '<p>\r\n<script type="text/javascript" src="//vk.com/js/api/openapi.js?84"></script>\r\n\r\n<!-- VK Widget -->\r\n<div id="vk_groups"></div>\r\n<script type="text/javascript">\r\nVK.Widgets.Group("vk_groups", {mode: 0, width: "210", height: "300", color1: ''FFFFFF'', color2: ''4274A5'', color3: ''4274A5''}, 45890033);\r\n</script>\r\n<p>', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nameurl` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_d` varchar(255) NOT NULL,
  `meta_k` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date_b` varchar(255) NOT NULL,
  `cat` int(10) NOT NULL DEFAULT '0',
  `comm` int(10) NOT NULL DEFAULT '0',
  `block` int(1) NOT NULL DEFAULT '0',
  `viewindex` int(1) NOT NULL DEFAULT '0',
  `viewcomm` int(1) NOT NULL DEFAULT '0',
  `rss` int(1) NOT NULL DEFAULT '0',
  `xmlsm` varchar(50) NOT NULL,
  `sm` int(1) NOT NULL DEFAULT '0',
  `pablick` int(1) NOT NULL DEFAULT '0',
  `loock` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `blog`
--

INSERT INTO `blog` (`id`, `nameurl`, `title`, `meta_d`, `meta_k`, `text`, `author`, `date_b`, `cat`, `comm`, `block`, `viewindex`, `viewcomm`, `rss`, `xmlsm`, `sm`, `pablick`, `loock`) VALUES
(3, 'about.html', 'О системе', 'О системе', 'О NiunCMS', '<font face="Arial, Verdana"><b><font size="5" color="#009900">О системе</font><br></b></font><ul><li><b style="font-family: Arial, Verdana; font-size: small; ">NiunCMS</b><span style="font-family: Arial, Verdana; font-size: small; "> позволит вам создать персональный сайт в сети интернет.</span></li><li><span style="font-family: Arial, Verdana; font-size: small; "><b>NiunCMS</b> отличается высокой стабильностью и скоростью работы.</span></li><li><b style="font-family: Arial, Verdana; font-size: small; ">NiunCMS</b><span style="font-family: Arial, Verdana; font-size: small; "> разработана таким образом, чтобы выделить ваш сайт максимум возможностей.</span></li><li><span style="font-family: Arial, Verdana; font-size: small; ">С <b>NiunCMS</b> легко и удобно работать.</span></li><li><font face="Arial, Verdana" size="2"><b>NiunCMS</b> постоянно обновляется и усовершенствуется, открывая новые возможности для сайтаводов и блоггеров.</font></li><li><font face="Arial, Verdana" size="2"><b>CMS</b> не тормозит, не виснет, не нагружает сервер.</font></li><li><font face="Arial, Verdana" size="2">При помощи системы <b>NiunCMS</b>, можно за довольно короткий срок времени создать качественный и оригинальный сайт в сети интернет.</font></li></ul><font face="Arial, Verdana" size="2"><b>Лицензия:</b>&nbsp;GNU/GPL v3</font><div><font face="Arial, Verdana" size="2"><br></font></div><div><font face="Arial, Verdana" size="2"><b>Язык:</b> Русский</font></div><div><font face="Arial, Verdana" size="2"><br></font></div><div><font face="Arial, Verdana" size="2"><b>Системные требование:</b></font></div><div><ul><li><font face="Arial, Verdana" size="2">PHP 5 и выше.</font></li><li><font face="Arial, Verdana" size="2">MySQL 5 и выше.</font></li><li><font face="Arial, Verdana" size="2">mod_rewrite.</font></li><li><font face="Arial, Verdana" size="2">GD.</font></li></ul><font face="Arial, Verdana" size="2"><b>Разработчик:</b> SibWeb Media Group</font></div><div><font face="Arial, Verdana" size="2"><br></font></div><div><font face="Arial, Verdana" size="2"><div style="text-align: center;">Система распространяется по принципу "КАК ЕСТЬ" и БЕЗ ГАРАНТИЙНЫХ ОБЯЗАТЕЛЬСТВ.</div><div style="text-align: center;">Вы можете свободно использовать и модифицировать систему, но исключительно на</div><div style="text-align: center;">свой страх и риск. Вы обязаны сохранять копирайты в исходном коде.</div><div style="text-align: center;"><br></div><div style="text-align: left;"><b>Снятие копирайта:</b></div><div style="text-align: left;"><ol><li>Чтобы снять копирайт системы NiunCMS вам потребуется нам пожертвовать сумму не меньше 30 рублей.</li><li>При пожертвование вы согласны о том что мы вас заносим в список Донатеров</li><li>После пожертвование вы можете свободно снять копирайт но сохраняя копирайты в начале каждого кода в NiunCMS</li></ol></div></font></div>', 'admin', '1362126319', 0, 0, 0, 0, 1, 0, 'monthly|0.2', 0, 1, 349),
(2, 'downoload.html', 'Скачать NiunCMS', 'Скачать NiunCMS', 'NiunCMS, Скачать NiunCMS', '<font size="2" face="Tahoma" style="font-weight: normal; font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; "><b>Примеры сайтов работающих на NiunCMS:</b></font><div style="font-weight: normal; "><ul style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; "><li><font face="Arial, Verdana" size="2"><a href="http://vadimkondakov.niun.ru/">БЛОГ ВАДИМА КОНДАКОВА</a></font></li></ul><font face="Arial, Verdana" size="2"><b>Требования к серверу:</b></font></div><div style="font-weight: normal; "><ul><li><font face="Arial, Verdana" size="2"><b>PHP 5 и выше.</b></font></li><li><font face="Arial, Verdana" size="2"><b>MySQL 5 и выше.</b></font></li><li><font face="Arial, Verdana" size="2"><b>mod_rewrite.</b></font></li><li><font face="Arial, Verdana" size="2"><b>GD.</b></font></li></ul><font face="Tahoma" style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; "><div style="text-align: center;"><br></div></font></div><div style="font-weight: normal; font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; text-align: center; "><br><table class="inp" width="100%">\r\n<tbody><tr><td style="text-align: left;"><b>\r\nПоследняя версия:</b> <font color="#33cc00"><b>X1.8 beta 1\r\n</b></font></td>\r\n<td>\r\n<a href="/niuncms_v_x1.8beta_1.zip"><b>Скачать</b></a>\r\n</td>\r\n</tr></tbody></table></div><br><br>', 'admin', '1362076627', 0, 0, 0, 0, 1, 0, 'monthly|0.2', 0, 1, 631),
(4, 'modul-predlozhit-novost-v-10.html', 'Модуль &quot;Предложить новость&quot; v 1.0', 'Модуль &quot;Предложить новость&quot; v 1.0', 'Модуль &quot;Предложить новость&quot; v 1.0', 'Данный модуль позволит вашим гостям или читателям вашего сайта предлагать вам интересные записи с выбором категории.[end]<div style="font-weight: normal; "><br></div><div><b>Разработчик:</b><span style="font-weight: normal; "> <a href="http://niun.ru/">NiunCMS Team</a></span></div><div><b>Платформа:</b><span style="font-weight: normal; "> NiunCMS</span></div><div><b>Версии:</b> 1.5, 1.6, 1.7</div><div><b>Установка:</b> инструкция по установки и скиншот находится в архиве.</div><div><br></div><div style="text-align: center;"><strike><font color="#ff0000">Демо</font></strike> | <a href="http://yadi.sk/d/tAdpjGLg2vC_8">Скачать</a></div>', 'admin', '1362127641', 7, 0, 0, 1, 1, 1, 'always|1.0', 1, 1, 147),
(5, 'modul-portpholio--shablon-sophtober.html', 'Модуль &quot;Портфолио&quot; + Шаблон Софтобер', 'Модуль &quot;Портфолио&quot; + Шаблон Софтобер', 'Модуль &quot;Портфолио&quot; + Шаблон Софтобер', '<font face="Arial, Verdana" size="2">Данный модуль позволит вам создать личное портфолио работ с использование галереи +&nbsp;PrettyPhoto + записи из блога.[end]</font><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; "><br><div><div><b>Разработчик:</b> <a href="http://niun.ru/">NiunCMS Team</a></div><div><b>Платформа:</b><span style="font-weight: normal; "> NiunCMS</span></div><div><b>Версии:</b><span style="font-weight: normal; "> 1.5, 1.6, 1.7</span></div><div><b>Установка:</b><span style="font-weight: normal; "> инструкция по установки и скиншот находится в архиве.</span></div></div></div><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; "><span style="font-weight: normal; "><br></span></div><div style="text-align: center; "><font face="Arial, Verdana" size="2"><strike><font color="#ff0000">Демо</font></strike> | <a href="http://yadi.sk/d/NC5Og8nI2dlZj">Скачать</a></font></div>', 'admin', '1362128108', 7, 1, 0, 1, 1, 1, 'always|1.0', 1, 1, 250),
(10, 'shablon-neoskype.html', 'Шаблон NeoSkype', 'Шаблон NeoSkype под NiunCMS', 'Шаблон NeoSkype, Шаблон под NiunCMS', '<div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; text-align: center; "><b style="font-size: small; ">Тип:</b><span style="font-size: small; "> Оригинал</span></div><div style="text-align: center; "><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; "><font face="Arial, Verdana" size="2"><b>CMS:</b> NiunCMS v 1.7</font></div><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; "><font face="Arial, Verdana" size="2"><b>Автор:</b> SibWeb Media Group</font></div><div><font face="Arial, Verdana" size="2" style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; "><b>Тематика:</b></font><font face="Arial, Verdana" size="2" style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; "> Неофициальный блог об Skype</font></div><div style="text-align: left;"><font face="Arial, Verdana" size="2">[end]</font></div><div><font face="Arial, Verdana" size="2"><br></font></div><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; "><img src="http://cs323421.vk.me/v323421786/4e9b/jroBpZMa8wY.jpg" style="font-size: 10pt; width: 200px; height: 200px; "></div><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; "><br></div><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; "><font face="Arial, Verdana" size="2">данный шаблон предназначен для создание блога об Skype на NiunCMS v 1.7</font></div><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; "><br></div><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; "><a href="http://yadi.sk/d/vVq6jZv_36whT">СКАЧАТЬ</a></div></div>', 'admin', '1362659672', 9, 2, 0, 1, 1, 1, 'always|1.0', 1, 1, 301),
(7, 'demo.html', 'Демо', 'NiunCMS Демо', 'Демо, NiunCMS DEMO', 'Простите, но демо версии пока-что несуществует :(', 'admin', '1362333149', 0, 0, 0, 0, 0, 0, 'monthly|0.2', 0, 1, 347),
(8, 'donate.html', 'Помощь проекту', 'Пожертвование команде', 'Пожертвование', '<font face="Arial, Verdana" size="2">Добрый друг! если вы хотите нам помочь (пожертвовать на развитие проекта).</font><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; ">вы можете через <b>платёжные системы</b></div><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; "><br></div><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; "><b><font color="#ff0000">Я</font>ндекс.Деньги:</b></div><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; "><b><br></b></div><div><b style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; line-height: normal; ">№ кошелька:&nbsp;</b><font face="Arial, Verdana" size="2">410011064487253.</font></div><div><font face="Arial, Verdana" size="2"><br></font></div><div><font face="Arial, Verdana" size="2"><b><font color="#33ccff">WebMoney (WMR)</font>:</b></font></div><div><font face="Arial, Verdana" size="2"><br></font></div><div><font face="Arial, Verdana" size="2"><b>WMR номер:</b>&nbsp;R287241570118.</font></div><div><font face="Arial, Verdana" size="2"><br></font></div><div><hr><b>Добровольное пожертвование соглашение:</b></div><div><ul><li>При пожертвование любой суммы вы соглашаетесь с данным соглашением.</li><li>При пожертвование любой суммы. возрату денег не подлежит.</li><li>При пожертвование на снятие копирайта системы, вы должны связаться с нами для того чтобы мы вас добавили в базу.</li></ul></div>', 'admin', '1362334180', 0, 0, 0, 0, 1, 0, 'monthly|0.2', 0, 1, 142),
(9, 'kak-obnovitsya-s-versii-15-i-vyshe-do-17.html', 'Как обновится с версии 1.5 и выше до 1.7?', 'Обновляем старую версию на новую', 'Update NiunCMS, Как обновить сайт на NiunCMS?', '<font face="Arial, Verdana" size="2">Мы обновились до версии 1.7 (официальный сайт поддержки продукта).</font><div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; ">и если у вас уже установлена версия 1.5 и выше и вам хочется обновить продукт до 1.7 то читаем![end]</div><div><ol><li><font face="Arial, Verdana" size="2"><u>Делаем резервную копию сайта.</u></font></li><li><font face="Arial, Verdana" size="2">Сохраним файл <b>.htaccess</b> (на компьютер)</font></li><li><font face="Arial, Verdana" size="2">Сохраним в <b><u>.zip архив</u></b> папку <b>mysql</b> в папке <b>source</b> (на компьютер)</font></li><li><font face="Arial, Verdana" size="2">Удаляем полностью ваш релиз (установленный ранее)</font></li><li><font face="Arial, Verdana" size="2">Загрузим релиз 1.7 (после загрузки удалите папку <b>setup</b>)</font></li><li><font face="Arial, Verdana" size="2">Загрузим файл <b>.htaccess</b> в корень (который сохраняли на компьютер)</font></li><li><font face="Arial, Verdana" size="2">Загрузим папку <b>mysql</b> в папку <b>source</b></font></li><li><font face="Arial, Verdana" size="2">Пробуем войти в админку (в настройках очищаем кеш).</font></li></ol><font face="Arial, Verdana" size="2"><b>Готово! релиз 1.7 был успешно обновлён!</b></font></div>', 'admin', '1362615813', 10, 0, 0, 1, 1, 1, 'always|1.0', 1, 1, 121),
(11, 'phorum.html', 'Форум', 'Форум поддержки', 'Форум NiunCMS', '<iframe id="forum_embed"\r\n  src="javascript:void(0)"\r\n  scrolling="no"\r\n  frameborder="0"\r\n  width="100%"\r\n  height="700">\r\n</iframe>\r\n<script type="text/javascript">\r\n  document.getElementById(''forum_embed'').src =\r\n     ''https://groups.google.com/forum/embed/?place=forum/niuncms''\r\n     + ''&showsearch=true&showpopout=true&showtabs=false''\r\n     + ''&parenturl='' + encodeURIComponent(window.location.href);\r\n</script>', 'admin', '1363755776', 0, 0, 0, 0, 0, 0, 'monthly|0.2', 0, 1, 197),
(12, 'shablon-discuz-pod-niuncms-v-x18.html', 'Шаблон discuz под NiunCMS v X1.8', 'Шаблон discuz под NiunCMS v X1.8', 'Шаблон на NiunCMS, Бесплатные шаблоны под NiunCMS', '<div style="font-family: Arial, Verdana; font-size: 10pt; font-style: normal; font-variant: normal; font-weight: normal; line-height: normal; text-align: center; "><img width="500" height="300" src="http://dev.cms/upload/images/042119709.png" style="font-size: 10pt; "></div><div style="text-align: center; "><font face="Arial, Verdana" size="2">шаблон для создание информации об Discuz!X</font></div><div style="text-align: left;"><font face="Arial, Verdana" size="2">[end]</font></div><div style="text-align: center;"><font face="Arial, Verdana" size="2">Шаблон работает на NiunCMS v X1.8</font></div><div style="text-align: center;"><font face="Arial, Verdana" size="2"><br></font></div><div style="text-align: center;"><font face="Arial, Verdana" size="2"><b><strike><font color="#ff0000">демо</font></strike></b> | <b><a href="http://yadi.sk/d/HC0tYJx-3w5Li">скачать</a></b></font></div>', 'admin', '1365553537', 9, 0, 0, 1, 1, 1, 'always|1.0', 1, 1, 58);

-- --------------------------------------------------------

--
-- Структура таблицы `comm`
--

CREATE TABLE IF NOT EXISTS `comm` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date_comm` varchar(255) NOT NULL,
  `blog` int(10) NOT NULL,
  `comm` int(10) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL,
  `view` int(1) NOT NULL DEFAULT '0',
  `loock` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `comm`
--

INSERT INTO `comm` (`id`, `author`, `email`, `site`, `text`, `date_comm`, `blog`, `comm`, `status`, `view`, `loock`) VALUES
(4, 'ГОРОХ', 'gips@mail.ru', 'http://gips.ru', 'СПАСИБО!', '1363511038', 5, 0, 2, 1, 1),
(5, 'куул', 'besposhadnij@bk.ru', 'http://moykz.ru', 'нового давно ничего не добавляли!\r<BR>http://moykz.ru', '1363530214', 10, 0, 2, 1, 1),
(6, 'Разработчики NiunCMS', 'support@svoi-krug.ru', 'http://niun.ru', 'куул,\r<BR>что именно вы бы хотели?', '1363598847', 10, 5, 0, 1, 1),
(7, 'Admin', 'admin@mail.ru', 'http://coderweb.ru', 'Простая проверка комментариев)', '1368066334', 27, 0, 2, 1, 1),
(8, 'Admin', 'admin@mail.ru', 'http://coderweb.ru', 'Простая проверка комментариев)', '1368066604', 27, 0, 2, 1, 1),
(9, 'Test', 'test@admin.ru', 'http://niun.ru', 'Привет админ)))', '1368066657', 27, 7, 2, 1, 1),
(10, 'Test', 'test@admin.ru', 'http://ru.ru', 'F ye rf!', '1368506043', 27, 8, 2, 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `galery`
--

CREATE TABLE IF NOT EXISTS `galery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title_galery` varchar(255) NOT NULL,
  `id_galery` int(10) NOT NULL DEFAULT '0',
  `title_img` varchar(255) NOT NULL,
  `txt` text NOT NULL,
  `href` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `meta_d` varchar(255) NOT NULL,
  `meta_k` varchar(255) NOT NULL,
  `nameurl` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `podmenu` int(10) NOT NULL DEFAULT '0',
  `href` varchar(255) NOT NULL,
  `position` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `title`, `meta_d`, `meta_k`, `nameurl`, `name`, `podmenu`, `href`, `position`) VALUES
(1, '', '', '', 'glavnaya', 'Главная', 0, 'http://dev.cms/', 1),
(4, 'Заголовок категории*', 'Описание категории*', 'Ключевые слова категории*', 'skachat-niuncms', 'Скачать NiunCMS', 0, 'http://dev.cms/downoload.html', 2),
(3, '', '', '', 'contacts', 'Обратная связь', 0, 'http://dev.cms/contacts.html', 6),
(5, 'Заголовок категории*', 'Описание категории*', 'Ключевые слова категории*', 'o-sisteme', 'О системе', 0, 'http://dev.cms/about.html', 3),
(6, 'Дополнение', 'Дополнение под NiunCMS', 'Дополнение, Addons, NiunCMS', 'dopolnenie', 'Дополнение', 0, '', 5),
(7, 'Модули', 'Модули для NiunCMS', 'Модули, Modules, NiunCMS', 'moduli', 'Модули', 6, '', 7),
(8, 'Хаки/Патчи', 'Хаки/Патчи для NiunCMS', 'Хаки/Патчи, Хаки/Патчи для NiunCMS', 'hakipatchi', 'Хаки/Патчи', 6, '', 8),
(9, 'Шаблоны', 'Шаблоны для NiunCMS', 'Шаблоны, Шаблоны для NiunCMS, NiunCMS', 'shablony', 'Шаблоны', 6, '', 9),
(10, 'Документация', 'Документация на NiunCMS', 'Документация, Документация на NiunCMS, NiunCMS', 'dokumentaciya', 'Документация', 6, '', 10),
(11, 'Заголовок категории*', 'Описание категории*', 'Ключевые слова категории*', 'predlozhit-novost', 'Форум поддержки', 0, 'http://dev.cms/phorum.html', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `mess_admin`
--

CREATE TABLE IF NOT EXISTS `mess_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `them` varchar(255) NOT NULL,
  `date_g` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `loock` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `meta_d` text NOT NULL,
  `meta_k` text NOT NULL,
  `configblog` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`id`, `title`, `meta_d`, `meta_k`, `configblog`) VALUES
(1, 'NiunCMS - система управления сайтом', 'Бесплатная CMS с открытым исходным кодом, движок для сайта с широкими возможностями, удобное управление сайтом', 'Создать блог, NiunCMS, PHP скрипт, Скрипт для создание блога, Powered by NiunCMS', '1|1|1|1|0|||1|1|0|1|awesome');

-- --------------------------------------------------------

--
-- Структура таблицы `poll`
--

CREATE TABLE IF NOT EXISTS `poll` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `que` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `otvet` varchar(255) NOT NULL,
  `activ` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `poll`
--

INSERT INTO `poll` (`id`, `que`, `value`, `otvet`, `activ`) VALUES
(1, 'Как вам наша CMS?', 'Очень понравилась!|Тестирую...|Не плохо|Видел и лучше...', '28|19|3|20|5', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `pass`, `email`) VALUES
(1, 'admin', 'ef6250ad50042ac79d928cce4d04dd76', 'dead_hart_angel@mail.ru');

-- --------------------------------------------------------

--
-- Структура таблицы `whitelist`
--

CREATE TABLE IF NOT EXISTS `whitelist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `whitelist`
--

INSERT INTO `whitelist` (`id`, `email`, `status`) VALUES
(1, 'support@svoi-krug.ru', 0),
(2, 'nah@on.tabe', 2),
(3, 'gips@mail.ru', 2),
(4, 'besposhadnij@bk.ru', 2),
(5, 'admin@mail.ru', 2),
(6, 'test@admin.ru', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

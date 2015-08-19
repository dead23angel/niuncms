<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

require_once(ROOT . DS . 'system' . DS . 'data' . DS . 'dbconfig.php');
require_once (ROOT . '/system/classes/mysql.class.php');
$db = dbconn::instance($settings);
Niun::getInstance()->Set('DataBase', $db);

?>
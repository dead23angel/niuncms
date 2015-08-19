<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function about()
{
$sm_read = file_get_contents(ROOT . DS . 'admin' . DS . 'templates' . DS . 'about.html');

return $sm_read;
}
?>
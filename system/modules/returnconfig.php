<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

function returnconfig()//Функция вывода настроек блога
{
    $result_page = Registry::getInstance()->DataBase->Query("SELECT configblog FROM page WHERE id='1'");
    $myrow_page = Registry::getInstance()->DataBase->GetArray($result_page);
    
    $configs = explode('|', $myrow_page[0]);
    $config['top'] = $configs[0];
    $config['poll'] = $configs[1];
    $config['whitelist'] = $configs[2];
    $config['chpu'] = $configs[3];
    $config['reader'] = $configs[4];
    $config['rss'] = $configs[5];
    $config['tw'] = $configs[6];
    $config['email'] = $configs[7];
    $config['lastcomm'] = $configs[8];
    $config['morepost'] = $configs[9];
    $config['newpost'] = $configs[10];
    $config['theme'] = $configs[11];
    
    return $config;
}

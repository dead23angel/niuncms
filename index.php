<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

define('NiunCMS', true);
define('DEVELOPER', true);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('ENGINEDIR', dirname(__FILE__) . '/system');

if (DEVELOPER == true)
{
	error_reporting(E_ALL);
	ini_set('display_errors','On');
}
else
{
	error_reporting(E_ALL);
	ini_set('display_errors','Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT . DS . 'system' . DS . 'logs' . DS . 'error.log');
}

require_once(ROOT . DS . 'system' . DS . 'engine.php');

Registry::getInstance()->Template->theme = Request::Server('DIRECTORY_ROOT', false, false) . DS . 'templates' . DS . $config['theme']; 
Registry::getInstance()->Template->generator = 'Powered by NiunCMS v2.0 (http://niuncms.ru)';
Registry::getInstance()->Template->author= 'Developed by CWTeam';

Registry::getInstance()->Template->Display();

echo "\n" . '<!-- NiunCMS выполнила ' . Registry::getInstance()->DataBase->count . ' запроса в базу данных.-->' .
	 "\n" . '<!-- NiunCMS сгенерировала страницу за: ' . Niun::Stop() . ' секунд.-->' .
	 "\n" . '<!-- NiunCMS заняла памяти: ' . Niun::Memory() . '.-->';
<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

define('NiunCMS', true);
define('DEVELOPER', true);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

if (DEVELOPER == true) {
	error_reporting(E_ALL);
	ini_set('display_errors','On');
} else {
	error_reporting(E_ALL);
	ini_set('display_errors','Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', ROOT . DS . 'system' . DS . 'logs' . DS . 'error.log');
}

require_once(ROOT . DS . 'system' . DS . 'engine.php');

Niun::getInstance()->Get('Template')->theme = @$_SERVER['DIRECTORY_ROOT'] . DS . 'templates' . DS . $config['theme']; 
Niun::getInstance()->Get('Template')->generator = 'Powered by NiunCMS v2.0 (http://niun.ru)';
Niun::getInstance()->Get('Template')->author= 'Developed by Dead_Angel (http://rdl-team.ru)';

Niun::getInstance()->Get('Template')->Display();

echo "\n" . '<!-- NiunCMS выполнила ' . Niun::getInstance()->get('DataBase')->query_num . ' запроса в базу данных.-->' .
	 "\n" . '<!-- NiunCMS сгенерировала страницу за: ' . Niun::getInstance()->Get('Param')->Stop() . ' секунд.-->' .
	 "\n" . '<!-- NiunCMS заняла памяти: ' . Niun::getInstance()->Get('Param')->Memory() . '.-->';

?>
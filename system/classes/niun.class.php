<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

/*
 *реализация Singleton Registry
 *http://omurashov.ru/uml-and-desing-patterns/pattern-registry/
*/

if(!defined('NiunCMS')) die('Доступ запрещен');

class Niun {
	static private $_instance = null;
 
    private $_registry = array(); 
 
    static public function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }
 
        return self::$_instance;
    }
 
    static public function set($key, $object) {
        self::getInstance()->_registry[$key] = $object;
    }
 
    static public function get($key) {
        return self::getInstance()->_registry[$key];
    }
 
    private function __wakeup() {
    }
 
    private function __construct() {
    }
 
    private function __clone() {
    }

}
?>
<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined('NiunCMS')) die('Доступ запрещен');

class Registry
{
    static private $_instance = null;
 
    private $_registry = array();
    
    function __construct() {}
 
    static public function getInstance()
    {
        if (is_null(self::$_instance))
        {
            self::$_instance = new self;
        }
 
        return self::$_instance;
    }
 
    public function __set($key, $object)
    {
        self::getInstance()->_registry[$key] = $object;
    }
 
    public function __get($key)
    {
        return self::getInstance()->_registry[$key];
    }

    private function __wakeup() {}

    private function __clone() {}
}
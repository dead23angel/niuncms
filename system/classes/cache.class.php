<?php
### NiunCMS - Community Management System ###
### Powered by Dead_Angel                 ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined('NiunCMS')) die('Доступ запрещен');

class Cache
{
	
	function Get($name, $timeout = 3600, $is_array = false)
	{	
		$cache_file = ROOT . DS . 'system' . DS . 'cache' . DS . $name .'.cache';
		if (!file_exists($cache_file))
			return FALSE;
        if(filemtime($cache_file) < (time() - $timeout))
            return false;
        if($is_array)
            return unserialize(@file_get_contents($cache_file));
        else
            return file_get_contents($cache_file);
	}

	function Set($name, $value)
    {
        if(is_array($value))
            $value = serialize($value);
        $cache_file = ROOT . DS . 'system' . DS . 'cache' . DS . $name .'.cache';
        $f = fopen($cache_file, "w+");
        @chmod($cache_file, 0666);
        fwrite($f, $value);
        fclose($f);
    }

	function Clean($name = false)
    {
        if(!$name)
        {
            $handle = opendir(ROOT . DS . 'system' . DS . 'cache');
            while(($file = readdir($handle)) !== false)
                if($file !== '.' and $file !== '..' and $file !== '.htaccess')
                    $cache_files[] = $file;
            closedir($handle);
            foreach($cache_files as $file)
                @unlink(ROOT . DS . 'system' . DS . 'cache' . DS . $name .'.cache');
        }
    }

}    

?>
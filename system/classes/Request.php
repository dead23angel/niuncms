<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

class Request 
{
    function __construct(){}
    
    /**
    * Публичный метод обертка над статичным методом GetParam, для быстрого доступа к глобальной переменной $_GET
    * @return array | bool | object | string
    * @static
    */
    public static function Get($var = '', $save = true, $default_value = false)
    {
        return self::GetParam(['var' => $var, 'save' => $save, 'method' => 'GET', 'default' => $default_value]);
    }

    /**
    * Публичный метод обертка над статичным методом GetParam, для быстрого доступа к глобальной переменной $_POST
    * @return array | bool | object | string
    * @static
    */
    public static function Post($var = '', $save = true, $default_value = false)
    {
        return self::GetParam(['var' => $var, 'save' => $save, 'method' => 'POST', 'default' => $default_value]);
    }
    
    /**
    * Публичный метод обертка над статичным методом GetParam, для быстрого доступа к глобальной переменной $_SERVER
    * @return array | bool | object | string
    * @static
    */
    public static function Server($var = '', $save = true, $default_value = false)
    {
        return self::GetParam(['var' => $var, 'save' => $save, 'method' => 'SERVER', 'default' => $default_value]);
    }

    /**
    * Публичный метод обертка над статичным методом GetParam, для быстрого доступа к глобальной переменной $_REQUEST
    * @return array | bool | object | string
    * @static
    */
    public static function Request($var = '', $save = true, $default_value = false)
    {
        return self::GetParam(['var' => $var, 'save' => $save, 'method' => 'REQUEST', 'default' => $default_value]);
    }

    /**
    * Публичный метод обертка над статичным методом GetParam, для быстрого доступа к глобальной переменной $_COOKIE
    * @return array | bool | object | string
    * @static
    */
    public static function Cookie($var = '', $save = true, $default_value = false)
    {
        return self::GetParam(['var' => $var, 'save' => $save, 'method' => 'COOKIE', 'default' => $default_value]);
    }
    
    /**
    * Статичный метод GetParam для доступа к видам глобальных переменных POST, GET, REQUEST, SERVER, COOKIE с возможностью мгновенной фильтрации данных
    * @return array | bool | object | string
    * @static
    */
    public static function GetParam(array $param = [])
    {
        if(!is_array($param))
            return false;

        if(empty($param['method']) OR !$param['method'])
            $param['method'] = 'GET';

        else if(!in_array($param['method'], array('GET', 'POST', 'REQUEST', 'SERVER', 'COOKIE')))
            return false;

        if(empty($param['var']) && !empty($param['method']))
            $param['var'] = self::method($param['method']);
        
        if(empty($param['save']))
            $param['save'] = false;

        if(is_array($param['var']))
        {
            $return = [];

            foreach ($param['var'] as $key => $val)
            {
                //Проверяем, глобальные настройки, или же персональные для каждой переменной
                $save = false;
                if(is_array($param['save']) && isset($param['save'][$key])) 
                    $save = $param['save'][$key];

                if (is_array($val))
                {
                    $return[$key] = self::GetParam(['var' => $key, 'method' => $param['method']]);
                    continue;
                }

                $return[$key] = self::Filter(self::method($param['method'], $key), $save);

                // В случае если одна из переменных не существует, обрываем и выдаем false
                // if(!$return[$key] && $param['method'] != 'SERVER')
                // {
                //     return false;
                // }
            }

            //Возвращаем массив проверенных переменных
            return $return;
        } 
        else
        {
            if(!self::method($param['method'], $param['var'])) 
                return !isset($param['default']) ? false : $param['default'];

            return $param['save'] == true ? self::Filter(self::method($param['method'], $param['var']), $param['save']) : self::method($param['method'], $param['var']);
        }
    }

    /**
    * Статичный метод для доступа к не фильтруемым данным + проверка на существование ключа
    * @return array | bool | object | string
    * @static 
    */
    public static function method($method = 'GET', $var = false){
        switch(mb_strtoupper($method)){
            case 'GET':
                if(empty($var) OR !$var)
                    return $_GET;

                return isset($_GET[$var]) ? $_GET[$var] : false;
                break;
            case 'POST':
                if(empty($var) OR !$var)
                    return $_POST;

                return isset($_POST[$var]) ? $_POST[$var] : false;
                break;
            case 'REQUEST':
                if(empty($var) OR !$var)
                    return $_REQUEST;

                return isset($_REQUEST[$var]) ? $_REQUEST[$var] : false;
                break;
            case 'SERVER':
                if(empty($var) || !$var)
                    return $_SERVER;

                return isset($_SERVER[$var]) ? $_SERVER[$var] : false;
                break;
            case 'COOKIE':
                if(empty($var) || !$var)
                    return $_COOKIE;

                return isset($_COOKIE[$var]) ? $_COOKIE[$var] : false;
                break;
        }
    }

    /**
    * Статичный метод обертка над функцией filter_var, используется для фильтрации или валидации входящих данных по шаблону
    * @return bool | string
    * @static
    */
    public static function Filter($value, $type = 'default'){
        if(empty($value))
            return false;

        $return = array();

        switch(mb_strtolower($type)){
            case "int":
                $return['filter'] = FILTER_SANITIZE_NUMBER_INT;
            break;
            case "intval":
                $return['filter'] = FILTER_VALIDATE_INT;
            break;
            case "float":
                $return['filter'] = FILTER_SANITIZE_NUMBER_FLOAT;
            break;
            case "floatval":
                $return['filter'] = FILTER_VALIDATE_FLOAT;
            break;
            default:
                $return['filter'] = FILTER_SANITIZE_STRING;
            break;

        }

        if(is_array($return['filter']))
            return filter_var($value, $return['filter']);
        
        return filter_var($value, $return['filter']);
    }

    /**
    * Статичный метод для индентификации наличия POST запроса
    * @return bool
    * @static
    */
    public static function isPost()
    {
        return !empty($_POST) ? true : false;
    }

    /**
    * Метод является оберткой над функцией заголовков(Header), в случае не возможности отсылки заголовка, метод завершит себя.
    * @return void | bool
    * @static
    */
    public static function Header($value)
    {
        if(!headers_sent())
            header($value);
        else
            return false;
    }
}
<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!defined("NiunCMS")) die("Доступ запрещен");

class DataBase
{
	public  $host,
            $user,
            $pass,
            $db_name,
			$adapter,
			$charset,
			$server_root,
			$key_sole,
            $host_id = false,
            $query_id = false,
            $count = 0,
            $connected = false,
            $version,
            $error = false,
            $pdo = false;
			
	function __construct() {
		require_once(ENGINEDIR . DS . 'data' . DS . 'dbconfig.php');
		
		$this->adapter     = $db_config['adapter'];
		$this->host        = $db_config['host'];
		$this->user        = $db_config['user'];
		$this->pass        = $db_config['pass'];
		$this->db_name     = $db_config['db'];
		$this->charset     = $charset;
		$this->server_root = $server_root;
		$this->key_sole    = $key_sole;
		
		$this->Connect();
	}

    /**
     * Коннект к базе данных
     * @access public
     * @since 0.1
     * @return bool
     */
    public function Connect()
    {
       	$this->pdo = new \PDO($this->adapter.':host='.$this->host.';dbname='.$this->db_name, $this->user, $this->pass, array(\PDO :: MYSQL_ATTR_INIT_COMMAND => 'SET NAMES `'.$this->charset.'`'));
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
        $this->connected = true;
        $this->pdo->exec('SET CHARACTER SET '. $this->charset);
        $this->pdo->exec('SET SESSION collation_connection = \''. $this->charset .'_general_ci\';');
        return true;
    }

    /**
     * Выполнение запроса к бд
     * @access public
     * @since 0.1
     * @param string $query
     * @return object
     */
    public function Query($query, $execute = false, $error = true)
    {
        if(!$this->connected)
            $this->Connect();
        
        $this->query_id = $this->pdo->prepare($query);
        if(!$this->query_id->execute())
        {
            //TODO: вывод ошибок MySQL
            #$this->error = mysql_error();
            if($error) echo $this->error;
            return false;
        }
        $this->count++;
        return $this->query_id;
    }

    /**
     * Обрабатывает ряд результата запроса и возвращает ассоциативный массив
     * @access public
     * @since 0.1
     * @param resource $query_id
     * @return array
     */
    public function GetRow($query_id = false)
    {
        if(!$query_id)
            $query_id = $this->query_id;
        return $query_id->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Обрабатывает ряд результата запроса, возвращая ассоциативный массив, численный массив или оба
     * @access public
     * @since 0.1
     * @param resource $query_id
     * @return array
     */
    public function GetArray($query_id = false)
    {
        if(!$query_id)
            $query_id = $this->query_id;
        return $query_id->fetch(\PDO::FETCH_BOTH);
    }

    /**
     * Обрабатывает ряд результата запроса и возвращает объект
     * @access public
     * @since 0.1
     * @param resource $query_id
     * @return object
     */
    public function GetObject($query_id = false)
    {
        if(!$query_id)
            $query_id = $this->query_id;
        return $query_id->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Возвращает количество рядов результата запроса
     * @access public
     * @since 0.1
     * @param resource $query_id
     * @return int
     */
    public function GetNumRows($query_id = false)
    {
        if(!$query_id)
            $query_id = $this->query_id;
        return $query_id->rowCount();
    }

    /**
     * Экранирует SQL спец-символы для mysql_query
     * @access public
     * @since 0.1
     * @param string $string
     * @return string
     */
    public function EscapeString($string)
    {
        return $this->pdo->quote($string);
    }

    /**
     * Возвращает ID, сгенерированный при последнем INSERT-запросе
     * @access public
     * @since 0.1
     * @return int
     */
    public function InsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Возвращает информацию о последнем запросе
     * @access public
     * @since 0.1
     * @return string
     */
    public function Info()
    {
        #return mysql_info($this->host_id);
    }

    /**
     * Освобождает память от результата запроса
     * @access public
     * @since 0.1
     * @param resource $query_id
     * @return bool
     */
    public function Free($query_id = false)
    {
        if(!$query_id)
            $query_id = $this->query_id;
        $this->query_id = NULL;
    }

    /**
     * Закрывает соединение с сервером MySQL
     * @access public
     * @since 0.1
     * @return bool
     */
    public function Close()
    {
        $this->pdo = NULL;
    }
}
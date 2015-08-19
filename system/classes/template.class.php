<?php

/**
* Template class
* @copyright NiunCMS
* @author Dead_Angel
*/

if(!defined("NiunCMS")) die("Доступ запрещен");

class Template
{
	
	private $vars = array();
	private $template_dir = null;

	public function __construct($config)
	{
		$this->template_dir = ROOT . DS . 'templates' . DS . $config . DS;
		//$this->vars['theme'] = $this->template_dir;
	}

	public function __set($name, $value)
	{
		$this->vars[$name] = $value;
	}

	public function __get($name)
	{
		if(isset($this->vars[$name]))
			return $this->vars[$name];

		return '';
	}

	public function clear()
	{
		$this->vars = array();
	}

	public function display($name = 'main')
	{
		$template = $this->template_dir . $name .'.tpl';
		if (!file_exists($template)) die('Шаблона ' . $name . ' не существует!');

		ob_start();
		include_once($template);
		echo ob_get_clean();
	}

	public function fetch($name)
	{
		$template = $this->template_dir . $name . '.tpl';
		if (!file_exists($template)) die('Шаблона ' . $name . ' не существует!');
		return file_get_contents($template);
	}

	public function fetch_module($module, $name)
	{
		$template = ROOT . DS . 'system' . DS . 'inc' . DS . $module . DS . 'templates' . DS . $name . '.tpl';
		if (!file_exists($template)) die('Шаблона ' . $name . ' не существует!');
		return file_get_contents($template);
	}

}

?>
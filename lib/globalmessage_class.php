<?php
	require_once "config_class.php";
	
	abstract class GlobalMessage { // класс глобальных сообщений
		
		private $data;
		
		public function __construct ($file) {
			$config = new Config();
			$this->data = parse_ini_file($config->dir_text.$file.".ini"); // читаем ini файл
		}
		
		public function getTitle ($name) { // метод получения заголовка сообщения по названию
			return $this->data[$name."_TITLE"];
		}
		
		public function getText ($name) { // метод получения текста сообщения по названию
			return $this->data[$name."_TEXT"];
		}
	}
?>
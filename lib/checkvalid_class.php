<?php
	
	require_once "config_class.php";
	
	class CheckValid{ // класс проверки данных на корректность
	
		private $config;
		
		public function __construct() {
			$this->config = new Config();
		}
		
		public function validID($id) { // метод проверки id на корректность
			if (!$this->isIntNumber($id)) return false;
			if ($id <= 0) return false;
			return true;
		}
		
		public function validLogin ($login) { // метод проверки логина на коректность
			if ($this->isContaintQuotes($login)) return false;
			if (preg_match("/^\d*$/", $login)) return false; // проверка на наличие в логине хотя-бы 1 буквы
			return $this->validString($login, $this->config->min_login, $this->config->max_login);
		}
		
		public function isvalidEmail($email) { // проверяет на валидность email
			if(strlen($email) > 255) return false;
			if(!preg_match("/^[a-z0-9]+[a-z0-9\.-_]*[a-z0-9]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z0-9]+/i", $email)) return false;
			return true;
		}
		
		public function validName($name) {
			if ($this->isContaintQuotes($name)) return false;
			if (preg_match("/^\d*$/", $name)) return false;
			return $this->validString($name, 2, 255);	
		}
		
		public function validGroup($group) {
			return preg_match("/[0-9]{4}/", $group);	
		}
		
		
		public function validHash ($hash) { // метод проверки хэша на коректность
			if (!$this->validString($hash, 32, 32)) return false;
			if (!$this->isOnlyLettersAndDigits($hash)) return false;
			return true;
		}
		
		public function validTimeStamp ($time) { // метод проверки времени на коректность
			return $this->isNoNegativeInteger($time);
		}
		
		public function validTitle ($title) {
			if (!$this->validString($title, 4, 255)) return false;
			return true;
		}
		
		
		private function isIntNumber($number) { // метод проверки являеться ли число целым
			if (!is_int($number) && !is_string($number)) return false;
			if (!preg_match("/^-?(([1-9][0-9]*|0))$/", $number)) return false;
			return true;
		}
		
		private function isNoNegativeInteger ($number) { // метод проверят число на то что оно больше или равно (>=) 0
			if (!$this->isIntNumber($number)) return false;
			if ($number < 0) return false;
			return true;
		}
						 
		private function isOnlyLettersAndDigits ($string) { // метод проверки наличия в строке только букв и цифр
			if (!is_int($string) && (!is_string($string))) return false;
			if (!preg_match("/[a-zа-я0-9]*/i", $string)) return false;
			return true;
		}
		
		private function validString ($string, $min_length, $max_length) { // метод проверяет на валидность строку
			if (!is_string($string)) return false;
			if (strlen($string) < $min_length) return false;
			if (strlen($string) > $max_length) return false;
			return true;
		}
		
		private function isContaintQuotes ($string) { // метод проверки на наличие в сттроке кавычек
			$array = array("\"", "'", "`", "&quot;", "&apos;");
			foreach ($array as $key => $value) {
				if (strpos($string, $value) !== false) return true;
			}
			return false;
		}
		
		
	}
	
?>
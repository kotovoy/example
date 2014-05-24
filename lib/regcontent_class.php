<?php
	require_once "modules_class.php";
	
	class RegContent extends Modules{ 
	
		
		public function __construct($db) {
			parent::__construct($db);
			
		}
		
		protected function getTitle() {
			return "Регистрация на сайте";
		}
		
		protected function getDescription() {
			return "Регистрация пользователя на сайте.";
		}
		
		protected function getKeyWords() {
			return "Регистрация, пользователь, сайт, ЧТТКТ, тест, тесты";
		}
		
		protected function getText() {
			$sr["message"] = $this->getMessage();
			$sr["login"] = $_SESSION["login"];
			$sr["email"] = $_SESSION["email"];
			$sr["name"] = $_SESSION["name"];
			$sr["surname"] = $_SESSION["surname"];
			$sr["group"] = $_SESSION["group"];
			return $this->getReplaceTemplate($sr, "form_reg");
		}
		
		
	}
?>
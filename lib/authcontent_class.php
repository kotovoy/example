<?php
	require_once "modules_class.php";
	
	class AuthContent extends Modules{ // страница авторизации
	
		
		public function __construct($db) {
			parent::__construct($db);
			
		}
		
		protected function getTitle() {
			return "Авторизация на сайте";
		}
		
		protected function getDescription() {
			return "Авторизация пользователя на сайте.";
		}
		
		protected function getKeyWords() {
			return "Авторизация, пользователь, сайт, ЧТТКТ, тест, тесты";
		}
		
		protected function getText() {
			$sr["message"] = $this->getMessage();
			$sr["login"] = $_SESSION["login"];
			return $this->getReplaceTemplate($sr, "form_auth");
		}
		
		
	}
?>
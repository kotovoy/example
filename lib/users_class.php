<?php
	require_once "global_class.php";
	
	class Users extends GlobalClass {
		public function __construct ($db) {
			parent::__construct("users", $db);
		}
		
		public function addUser ($login, $password, $regdate, $email, $name, $surname, $group) { // метод добавления юзера
			if (!$this->checkValid($login, $password, $regdate, $email, $name, $surname, $group)) return false;
			return $this->add(array("login" => $login, "password" => $password, "regdate" => $regdate, "email" => $email, "name" => $name, "surname" => $surname, "group" => $group, "is_teacher" => 0));
		}
	
		
		public function isExistsLogin($login) { // метод проверки существования данного логина
			return $this->isExists("login", $login);
		}
		
		
		public function checkUser($login, $password) { // проверка на существование юзера
			$user = $this->getUserOnLogin($login);
			if (!$user) return false;
			return $user["password"] === $password;
		}
		
		public function checkEmail($email) { // проверяем на существование записи с таким емейлом
			$user = $this->getAllOnField("email", $email);
			if (!$user) return false;
			return true;
		}
		
		public function getUserOnID ($id) { //метод получения всех данных по id
			return $this->get($id);
		}
		
		public function getUserOnLogin ($login) { //метод получения всех данных по логину
			$id = $this->getField("id", "login", $login);
			return $this->get($id);
		}
		
		public function validEmail($email){ // проверяем на валидность емейл
			return $this->valid->isvalidEmail($email);
		}
		
		private function checkValid ($login, $password, $regdate, $email, $name, $surname, $group) { // метод который проверяет все данные на корректность
			if (!$this->valid->validLogin($login)) return false;
			if (!$this->valid->validHash($password)) return false;
			if (!$this->valid->validTimeStamp($regdate)) return false;
			if (!$this->valid->isvalidEmail($email)) return false;
			if (!$this->valid->validName($name)) return false;
			if (!$this->valid->validName($surname)) return false;
			if (!$this->valid->validGroup($group)) return false;
			return true;
		}
	}
?>
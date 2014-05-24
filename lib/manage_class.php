<?php
	require_once "config_class.php";
	require_once "users_class.php";
	require_once "questions_class.php";
	require_once "stat_class.php";
	
	class Manage { // класс отвечающий за регистрацию пользователей
		
		private $config;
		private $user;
		private $data;
		private $question;
		private $rating;
		
		public function __construct($db) {
			session_start();
			$this->config = new Config();
			$this->user = new Users($db);
			$this->data = $this->secureData(array_merge($_POST, $_GET)); // обmеденяем данные переданые методом пост и гет
			if($this->data["test_id"]) {
				$this->question = new Questions($db);	
				$this->rating = new Stat($db);
			}
		}
		
		private function secureData($data) { // обрабатывает массив дата
			foreach($data as $key => $value) {
				if (is_array($value)) $this->secureData($value);
				else $data[$key] = htmlspecialchars($value);	
			}
			return $data;
		}
		
		public function redirect($link) { // делает редирект
			header("Location: $link");
			exit;
		}
		
		public function regUser() { // регистрация пользователя
			$link_reg = $this->config->address."?view=reg";
			$captcha = $this->data["captcha"];
			if(($_SESSION["rand"] != $captcha) && ($_SESSION["rand"] != "")) {
				return $this->returnMessage("ERROR_CAPTCHA", $link_reg);	
			}
			$login = $this->data["login"];
			if($this->user->isExistsLogin($login)) return $this->returnMessage("EXISTS_LOGIN", $link_reg);
			$password = $this->data["pass"];
			$password2 = $this->data["pass2"];
			if($password != $password2) return $this->returnMessage("PASSWORDS_DO_NOT_MATCH", $link_reg);
			if($password == "") return $this->returnMessage("PASSWORD_IS_NOT_ENTERED", $link_reg);
			$password = $this->hashPassword($password);
			$email = $this->data["email"];
			if(!$this->user->validEmail($email)) return $this->returnMessage("EMAIL_IS_NOT_VALID", $link_reg);
			$name = $this->data["name"];
			$surname = $this->data["surname"];
			$group = $this->data["group"];
			$result = $this->user->addUser($login, $password, time(), $email, $name, $surname, $group);
			if($result) return $this->returnPageMessage("SECCESS_REG", $this->config->address."?view=message");
			else return $this->unknownError($link_reg);
			
		}
		
		public function login() { // авторизация пользователя
			$login = $this->data["login"];
			$password = $this->data["password"];
			$password = $this->hashPassword($password);
			$r = $_SERVER["HTTP_REFERER"];
			if($r == $this->config->address."?view=auth") $r = $this->config->address;
			if($this->user->checkUser($login, $password)){
				$_SESSION["login"] = $login;
				$_SESSION["password"] = $password;
				return $r;
			}
			else {
				$_SESSION["message"] = "ERROR_AUTH";
				return $this->config->address."?view=auth";
			}
		}
		
		public function logout() { // логаут
			unset($_SESSION["login"]);
			unset($_SESSION["password"]);
			return $_SERVER["HTTP_REFERER"];
		}
		
		public function test() {
			$test_id = $this->data["test_id"];
			$test_info = $this->question->get($test_id);
			$correct = 0;
			for($i = 1; $i <= 10; $i++){
				$field = "q$i";
				$info = $test_info[$field];	
				$answers = explode("|", $info);
				if($answers[1] === $this->data[$field]) $correct++;
			}
			$u = $this->user->getUserOnLogin($_SESSION["login"]);
			$stat_info = $this->rating->selectStat($u["id"], $this->data["subject_id"]);
			if($stat_info){
				$correct_answers = $correct + $stat_info["correct_answers"];
				$all_questions = $stat_info["all_questions"] + 10;
				$rating = $correct_answers / $all_questions * 100;
				$rating = substr($rating, 0, 4);
				if(!$this->rating->edit($stat_info["id"], array("user_id" => $stat_info["user_id"], "subject_id" => $stat_info["subject_id"], "all_questions" => $all_questions, "correct_answers" => $correct_answers, "rating" => $rating))) return $this->returnPageMessage("UNKNOWN_ERROR", $this->config->address."?view=message");
				else{
					$this->redirect($this->config->address."?view=result&correct_answers=".$correct);	
				}
			}
			else {
				$rating = $correct / 10 * 100;
				$rating = substr($rating, 0, 4);
				if(!$this->rating->add(array("user_id" => $u["id"], "subject_id" => $this->data["subject_id"], "all_questions" => 10, "correct_answers" => $correct, "rating" => $rating))) return $this->returnPageMessage("UNKNOWN_ERROR", $this->config->address."?view=message");
				else {
					$this->redirect($this->config->address."?view=result&correct_answers=".$correct);	
				}
			}
		}
		
		
		private function hashPassword($password) { // хеширует пароль
			return md5($password.$this->config->secret);
		}
		
		
		private function unknownError($r) { // неизвестная ошибка
			return $this->returnMessage("UNKNOWN_ERROR", $r);
		}
		
		private function returnMessage($message, $r) { // выводит сообщение и делает редирект
			$_SESSION["message"] = $message;
			return $r;
		}
		
		private function returnPageMessage($message, $r) { // выводит сообщение на отдельной странице и делает редирект
			$_SESSION["page_message"] = $message;
			return $r;
		}
	}
?>
<?php
	require_once "config_class.php";
	require_once "message_class.php";
	require_once "pages_class.php";
	require_once "questions_class.php";
	require_once "stat_class.php";
	require_once "subject_class.php";
	require_once "users_class.php";

	
	abstract class Modules {
		
		protected $config;
		protected $message;
		protected $page;
		protected $question;
		protected $rating;
		protected $subject;
		protected $user;
		protected $data;
		protected $user_info;
		
		public function __construct($db) {
			session_start();
			$this->config = new Config();
			$this->message = new Message();
			$this->page = new Pages($db);
			$this->question = new Questions($db);
			$this->rating = new Stat($db);
			$this->subject = new Subject($db);
			$this->user = new Users($db);
			$this->data = $this->secureData($_GET);
			$this->user_info = $this->getUser();
			
		}
		
		private function getUser() { 
			$login = $_SESSION["login"];
			$password = $_SESSION["password"];
			if ($this->user->checkUser($login, $password)) return $this->user->getUserOnLogin($login);
			else return false;
		}
		
		public function getContent() { 
			$sr["title"] = $this->getTitle();
			$sr["meta_key"] = $this->getKeyWords();
			$sr["meta_desc"] = $this->getDescription();
			$sr["auth_user"] = $this->getAuthUser();
			$sr["menu"] = $this->getMenu();
			$sr["text"] = $this->getText();
			return $this->getReplaceTemplate($sr, "main");
		}
		
		abstract protected function getTitle(); 
		abstract protected function getDescription();
		abstract protected function getKeyWords();
		abstract protected function getText();
		
		protected function getAuthUser() { 
			if ($this->user_info) {
				$sr["username"] = $this->user_info["login"];
				return $this->getReplaceTemplate($sr, "user_panel");	
			}
			else {
				$sr["message"] = "";
				return $this->getReplaceTemplate($sr, "form_auth");
			}
		}
		
		protected function getMenu() {
			$text = $this->getReplaceTemplate($sr, "menu");
			return $text;	
		}
		
		
		private function secureData($data) { 
			foreach($data as $key => $value) {
				if (is_array($value)) $this->secureData($value);
				else $data[$key] = htmlspecialchars($value);	
			}
			return $data;
		}
		
		
		
		protected function formatDate($time) { 
			return date("Y-m-d H:i:s", $time);
		}
		
		protected function getMessage($message = "") { 
			if ($message == "") {
				$message = $_SESSION["message"];
				unset($_SESSION["message"]);
			}
			$sr["message"] = $this->message->getText($message);
			return $this->getReplaceTemplate($sr, "message_string");
		}
		
		
		protected function getTemplate($name) { 
			$text = file_get_contents($this->config->dir_tmpl.$name.".tpl");
			return str_replace("%address%", $this->config->address, $text);
		}
		
		protected function getReplaceTemplate($sr, $template) { 
			return $this->getReplaceContent($sr, $this->getTemplate($template));
		}
		
		private function getReplaceContent($sr, $content) { 
			$search = array();
			$replace = array();
			$i = 0;
			foreach((array)$sr as $key => $value){
				$search[$i] = "%$key%";
				$replace[$i] = $value;
				$i++;
			}
			return str_replace($search, $replace, $content);
		}
		
		protected function redirect($link) {
			header("Location: $link");
			exit;
		}
		
		protected function notFound() {
			$this->redirect($this->config->address."?view=notfound");
		}
	}
?>
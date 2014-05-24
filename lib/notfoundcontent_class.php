<?php
	require_once "modules_class.php";
	
	class NotFoundContent extends Modules{ // страница не найдена
	
		private $subject_info;
		private $test_info;
		
		public function __construct($db) {
			parent::__construct($db);
			header("HTTP/1.0 404 Not Found");
		}
		
		protected function getTitle() {
			return "Страница не найдена - 404";
		}
		
		protected function getDescription() {
			return "Запрошенная страница не существует.";
		}
		
		protected function getKeyWords() {
			return "страница не найдена, страница не существет, 404";
		}
		
		protected function getText() {
			return $this->getTemplate("notfound");
		}
		
		
	}
?>
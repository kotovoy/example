<?php
	require_once "modules_class.php";
	
	class ResultContent extends Modules{ // клас который формирует главную страницу
	
		private $correct_answers;
		
		public function __construct($db) {
			parent::__construct($db);
			$this->correct_answers = $this->data["correct_answers"];
		}
		
		protected function getTitle() {
			return "Результаты прохождения теста";
		}
		
		protected function getDescription() {
			return "Результаты прохождения теста";
		}
		
		protected function getKeyWords() {
			return "результаты, тест, чтткт, result, test";
		}
		
		protected function getText() {
			$sr["count"] = $this->correct_answers;
			$rating = $this->correct_answers / 10 * 100;
			$rating = substr($rating, 0, 4);
			$sr["rating"] = $rating;
			return $this->getReplaceTemplate($sr, "result");
		}
		
		
	}
?>
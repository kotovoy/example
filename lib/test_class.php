<?php
	require_once "modules_class.php";
	
	class Test extends Modules{ // тест
	
		private $test_info;
		
		public function __construct($db) {
			parent::__construct($db);
			if(!$this->user_info) {
				$_SESSION["message"] = "NEED_AUTH";
				$this->redirect($this->config->address."?view=auth");
			}
			$id = (isset($this->data["id"]))? $this->data["id"] : 1;
			$this->test_info = $this->question->get($id);
		}
		
		protected function getTitle() {
			return "Тест на тему - ".$this->test_info["name"];
		}
		
		protected function getDescription() {
			return "Тест на тему - ".$this->test_info["name"];
		}
		
		protected function getKeyWords() {
			return "выбор теста, тест, выбор, ЧТТКТ, тесты, tests, ".$this->test_info["name"];
		}
		
		protected function getText() {
			for($i = 1; $i <= 10; $i++){
				$field = "q$i";
				$info = $this->test_info[$field];
				$answers = explode("|", $info);
				$question = array_shift($answers);
				shuffle($answers);
				for($j = 0; $j < count($answers); $j++){
					$sr1["name"] = $field;
					$sr1["title"] = $answers[$j];
					$text1 .= $this->getReplaceTemplate($sr1, "answer");			
				}
				$sr2["number"] = $i;
				$sr2["question"] = $question;
				$sr2["answers"] = $text1;
				$text2 .= $this->getReplaceTemplate($sr2, "testquestion");
				$text1 = "";	
			}
			$sr["title"] = $this->test_info["name"];
			$sr["id"] = $this->test_info["id"];
			$sr["subject_id"] = $this->test_info["subject_id"];
			$sr["questions"] = $text2;
			$text .= $this->getReplaceTemplate($sr, "test");	
			return htmlspecialchars_decode($text);
		}
		
		
	}
?>
<?php
	require_once "modules_class.php";
	
	class SelectTest extends Modules{ 
	
		private $subject_info;
		private $test_info;
		
		public function __construct($db) {
			parent::__construct($db);
			$id = (isset($this->data["subject_id"]))? $this->data["subject_id"] : 1;
			$this->test_info = $this->question->getAllOnSubjectID($id);
			if(!$this->test_info) $this->notFound();
			$this->subject_info = $this->subject->getField ("title", "id", $this->data["subject_id"]);
		}
		
		protected function getTitle() {
			return "Выбор теста ЧТТКТ по предмету ".$this->subject_info;
		}
		
		protected function getDescription() {
			return "Выбор теста ЧТТКТ по предмету ".$this->subject_info;
		}
		
		protected function getKeyWords() {
			return "выбор предмета, предмет, выбор, ЧТТКТ, тесты, tests, ".$this->subject_info;
		}
		
		protected function getText() {
			for($i = 0; $i < count($this->test_info); $i++){
				$sr["link"] = $this->config->address."?view=test&amp;id=".$this->test_info[$i]["id"];
				$sr["title"] = $this->test_info[$i]["name"];	
				$text .= $this->getReplaceTemplate($sr, "listtestitem");	
			}
			$rr["title"] = $this->subject_info;
			$rr["item"] = $text;
			return htmlspecialchars_decode($this->getReplaceTemplate($rr, "listtest"));
		}
		
		
	}
?>
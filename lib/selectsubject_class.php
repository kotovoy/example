<?php
	require_once "modules_class.php";
	
	class SelectSubject extends Modules{ // выбор предмета
	
		private $subject_info;
		
		public function __construct($db) {
			parent::__construct($db);
			$this->subject_info = $this->subject->getAll();
		}
		
		protected function getTitle() {
			return "Выбор предмета ЧТТКТ tests";
		}
		
		protected function getDescription() {
			return "Выбор предмета ЧТТКТ tests";
		}
		
		protected function getKeyWords() {
			return "выбор предмета, предмет, выбор, ЧТТКТ, тесты, tests";
		}
		
		protected function getText() {
			for($i = 0; $i < count($this->subject_info); $i++){
				$sr["image_link"] = $this->subject_info[$i]["image"];
				$sr["title"] = $this->subject_info[$i]["title"];
				$sr["link"] = $this->config->address."?view=selecttest&amp;subject_id=".$this->subject_info[$i]["id"];
				$text .= $this->getReplaceTemplate($sr, "selecttestitem");	
			}
			return htmlspecialchars_decode($text);
		}
		
		
	}
?>
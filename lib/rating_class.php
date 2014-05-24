<?php
	require_once "modules_class.php";
	
	class Rating extends Modules{ 
	
		private $subject_info;
		private $rating_info;
		private $user_name;
		
		public function __construct($db) {
			parent::__construct($db);
			$id = (isset($this->data["subject_id"]))? $this->data["subject_id"] : 1;
			$this->rating_info = $this->rating->getAllOnSubjectID($id);
			if(!$this->rating_info) $this->notFound();
			$this->user_name = $this->user->getAll();
			$this->subject_info = $this->subject->getField ("title", "id", $this->data["subject_id"]);
		}
		
		protected function getTitle() {
			return "Статистика по предмету ".$this->subject_info;
		}
		
		protected function getDescription() {
			return "Статистика по предмету ".$this->subject_info;
		}
		
		protected function getKeyWords() {
			return "предмет, ЧТТКТ, тесты, tests, статистика".$this->subject_info;
		}
		
		protected function getText() {
			for($i = 0; $i < count($this->rating_info); $i++){
				$user_id = $this->rating_info[$i]["user_id"];
				for($j = 0; $j < count($this->user_name); $j++){
					if($user_id === $this->user_name[$j]["id"]) $name = $this->user_name[$j]["name"]." ".$this->user_name[$j]["surname"];		
				}
				$sr1["number"] = $i + 1;
				$sr1["name"] = $name;
				$sr1["percent"] = $this->rating_info[$i]["rating"];
				$text .= $this->getReplaceTemplate($sr1, "stat_item");
			}
			$sr2["title"] = $this->subject_info;
			$sr2["stat_items"] = $text;
			return htmlspecialchars_decode($this->getReplaceTemplate($sr2, "stat"));
		}
		
		
	}
?>
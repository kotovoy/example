<?php
	require_once "modules_class.php";
	
	class FrontPageContent extends Modules{ // клас который формирует главную страницу
	
		private $text;
		
		public function __construct($db) {
			parent::__construct($db);
			$id = (isset($this->data["id"]))? $this->data["id"] : 1;
			$this->text = $this->page->get($id);
			if(!$this->text) $this->notFound();
		}
		
		protected function getTitle() {
			return $this->text["title"];
		}
		
		protected function getDescription() {
			return $this->text["meta_d"];
		}
		
		protected function getKeyWords() {
			return $this->text["meta_k"];
		}
		
		protected function getText() {
			return htmlspecialchars_decode($this->text["text"]);
		}
		
		
	}
?>
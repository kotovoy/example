<?php
	require_once "global_class.php";
	
	class Questions extends GlobalClass {
		public function __construct ($db) {
			parent::__construct("questions", $db);
		}
		
		public function getAllOnSubjectID ($subject_id) {
			return $this->getAllOnField("subject_id", $subject_id);
		}
	}
?>
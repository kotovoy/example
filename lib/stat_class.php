<?php
	require_once "global_class.php";
	
	class Stat extends GlobalClass {
		public function __construct ($db) {
			parent::__construct("stat", $db);
		}
		
		public function getAllOnSubjectID ($subject_id) {
			return $this->getAllOnField("subject_id", $subject_id);
		}
		
		public function selectStat($user_id, $subject_id){
			$data = $this->select(array("*"), "`user_id`='".addslashes($user_id)."' AND `subject_id`='".addslashes($subject_id)."'");
			return $data[0];
		}
	}
?>
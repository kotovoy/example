<?php
	require_once "global_class.php";
	
	class Subject extends GlobalClass {
		public function __construct ($db) {
			parent::__construct("subject", $db);
		}	
	}
?>
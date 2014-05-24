<?php
	require_once "global_class.php";
	
	class Pages extends GlobalClass {
		public function __construct ($db) {
			parent::__construct("pages", $db);
		}	
	}
?>
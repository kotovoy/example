<?php
	mb_internal_encoding("UTF-8");
	require_once "lib/database_class.php";
	require_once "lib/frontpagecontent_class.php";
	require_once "lib/selectsubject_class.php";
	require_once "lib/selecttest_class.php";
	require_once "lib/selectstat_class.php";
	require_once "lib/rating_class.php";
	require_once "lib/test_class.php";
	require_once "lib/regcontent_class.php";
	require_once "lib/authcontent_class.php";
	require_once "lib/messagecontent_class.php";
	require_once "lib/resultcontent_class.php";
	require_once "lib/notfoundcontent_class.php";
	
	$db = new DataBase();
	$view = $_GET["view"];
	
	switch ($view) {
		case "": 
			$content = new FrontPageContent($db);
			break;
		case "selectsubject":
			$content = new SelectSubject($db);
			break;
		case "selecttest":
			$content = new SelectTest($db);
			break;
		case "test":
			$content = new Test($db);
			break;
		case "reg":
			$content = new RegContent($db);
			break;
		case "auth":
			$content = new AuthContent($db);
			break;
		case "message":
			$content = new MessageContent($db);
			break;
		case "result":
			$content = new ResultContent($db);
			break;
		case "selectstat":
			$content = new SelectStat($db);
			break;
		case "rating":
			$content = new Rating($db);
			break;
		case "notfound":
			$content = new NotFoundContent($db);	
			break;
		default:
			$content = new NotFoundContent($db);	
	}
	
	echo $content->getContent();
?>
<?php
	require_once "lib/database_class.php";
	require_once "lib/manage_class.php";
	
	$db = new DataBase();
	$manage = new Manage($db);
	
	if ($_POST["reg"]) { // если форма была отправлена, то регестрируем пользователя
		$r = $manage->regUser();	
	}
	elseif ($_POST["auth"]) { 
		$r = $manage->login();	
	}
	elseif ($_GET["logout"]) { 
		$r = $manage->logout();	
	}
	elseif ($_POST["test"]) { 
		$r = $manage->test();	
	}
	else exit;
	
	$manage->redirect($r);
?>
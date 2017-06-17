<?php
session_start();
include_once 'includes/global.php';
include_once 'includes/goto_login.php';
include_once 'includes/connect.php';

if(isset($_REQUEST['do'])){
	$do = $_REQUEST['do'];
}else{
	$do = "";
}

$query ="";
$table = "";
$title = "Главная страница админки";
switch ($do){

	case "show_users":
		$table = "bibl_user";
		$title = "Список пользователей";
		break;

	case "show_user_visits":
		$table = 'bibl_user_visit';
		$title = "Визиты пользователей";
		break;

	case "show_publications":
		$table = 'bibl_publication';
		$title = "Список публикаций";
		break;
		
	case "logout":
		    unset($_SESSION["admin_authorized"]);
			header("Location: login.html");
			exit;
		



}
if($table){
	$rows = array();
	$query = 'SELECT * FROM ' . $table;

	$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
	if($result){

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$rows[] = $row;
		}
	}

	$query = 'SHOW COLUMNS FROM ' . $table;
	$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
			$columns[] = $row['Field'];
		

	}


	
	
	$smarty->assign("rows", $rows);
	$smarty->assign("columns", $columns);
}
$smarty->assign("title", $title);
$smarty->display("templates/index.tpl");
?>


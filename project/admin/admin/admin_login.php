<?php
session_start();
//include_once 'includes/global.php';

//if(isset($_REQUEST['unreg'])){
//	unset($_SESSION["logged_user"]);
//	 header("Location: index.php");
//         exit;
//}
//echo "ddddddddddd";
$login = isset($_REQUEST['login']) ?  trim($_REQUEST['login']) : null;
$password = isset($_REQUEST['password']) ?  trim($_REQUEST['password']) : null;

$password = md5($password);
$admin_pass = md5("1qaz+2wsx");



if($login == "admin" && $password==$admin_pass){

		 
	//$_SESSION["admin"]= (array) $logged_user;
	$_SESSION["admin_authorized"]= 1;

	//$smarty->display('templates/index.tpl');
	header("Location: index.php");
	exit;


	//		$smarty->assign('result',true);
	//		$smarty->assign('message',"Авторизация прошла успешно");
	//
	//		$smarty->assign('title',"Авторизация прошла успешно");
	//
	//		$smarty->display('templates/general_message.tpl');


}else{
	header("Location: login.html");
}




?>
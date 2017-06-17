<?php
session_start();
include_once 'includes/global.php';


$to = ADMIN_EMAIL;
$from = ADMIN_EMAIL;
$subject = "From email " . trim($_REQUEST['email']). ": " . trim($_REQUEST['subject']);
$message = "From email " . trim($_REQUEST['email']) . "<p>" . trim($_REQUEST['question_content']);

$text_message = "";
$title = "";

if($from && $subject && $message){
	$result = mail_utf8($to, $from, $subject, $message);

	if($result){
        $title = "Сообщение успешно отправлено";
		$text_message = '<div style="color: green;">' .$title . '</div>';

	}else{
		$title ="Сообщение не было отправлено, проверьте правильно ли указана Ваша почта, обратитесь к администратору.";
		$text_message = '<div style="color: red;">' . $title . '</div>';
	}
}else{
	$title ="Сообщение не было отправлено, проверьте все ли поля заполнены.";
	$text_message = '<div style="color: red;">' . $title . '</div>';
}




if(!isset($_SESSION["authorized"]) || $_SESSION["authorized"] != 1){
	$smarty->assign('authorized',0);
	$smarty->assign('email',"");
}else{
	$smarty->assign('authorized',1);
	$smarty->assign('email',$_SESSION['user']['username_email']);
}
	
	
$smarty->assign('title',$title);
$smarty->assign('message',$text_message);


$smarty->display('templates/feedback.tpl');


?>
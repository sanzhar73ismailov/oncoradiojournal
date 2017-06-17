<?php
if(!isset($_SESSION["admin_authorized"]) || $_SESSION["admin_authorized"] != 1){
	header("Location: login.html");
}
?>
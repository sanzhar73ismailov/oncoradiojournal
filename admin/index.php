<?php
session_start();

//exit("exit on <b>" . basename(__FILE__) . "</b> page ");

include_once 'includes/global.php';
$LOGGER = Logger::getLogger("index.php", null, TO_LOG);


$page = isset($_REQUEST['page'])== true ? $_REQUEST['page'] : "index" ;

$LOGGER->log("START " . $page . " LOGGING");

$doid= array("do" => "view", "id" => 0, "type_publ" => "" );

if(isset($_REQUEST['do'])){
	$doid['do'] = $_REQUEST['do'];
}

if(isset($_REQUEST['id'])){
	$doid['id'] = $_REQUEST['id'];
}

if(isset($_REQUEST['type_publ'])){
	$doid['type_publ'] = $_REQUEST['type_publ'];
}

$nav_obj = FabricaNavigate::createNavigate($page, $_SESSION, $_REQUEST, $doid);

$nav_obj->display();
//var_dump($nav_obj);

$LOGGER->log("END " . $page . " LOGGING");

?>
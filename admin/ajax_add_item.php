<?php
session_start();
include_once 'includes/global.php';

$object = trim($_POST['object']);
$item = null;

if($object == 'journal'){
	$item = new Journal();
	$item->id = null;
	$item->country = trim($_POST['country']);
	$item->issn = trim($_POST['issn']);
	$item->name = trim($_POST['name']);
	$item->periodicity = trim($_POST['periodicity']);
	$item->izdatelstvo_mesto_izdaniya = trim($_POST['izdatelstvo_mesto_izdaniya']);
} elseif ($object == 'conference'){
	$item = new Conference();
	$item->id=null;
	$item->name=trim($_POST['name']);
	$item->sbornik_name=trim($_POST['sbornik_name']);
	$item->city=trim($_POST['city']);
	$item->country=trim($_POST['country']);
	$item->type_id=trim($_POST['type_id']);
	$item->level_id=trim($_POST['level_id']);
	$item->date_start=getDateFromFormatDate(trim($_POST['date_start']));
	$item->date_finish=getDateFromFormatDate(trim($_POST['date_finish']));
	$item->add_info=trim($_POST['add_info']);
}elseif ($object == 'patent_type'){
	$item = new DicIdName(null, null);
	$item->id=null;
	$item->name=trim($_POST['name']);
	$item->table_name = "patent_type";
}

$item->user=$_SESSION['user']['username_email'];
$inserId = $dao->insert($item);
$item->id = $inserId;
$entGet = $dao->get($item);

//var_export($_SESSION['user']);
//var_export ($entGet);

echo json_encode($entGet);

?>
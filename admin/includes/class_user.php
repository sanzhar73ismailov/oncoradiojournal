<?php

include_once 'includes/config.php';
include_once 'includes/class_entity.php';
include_once 'includes/class_patient.php';
include_once 'includes/class_investigation.php';

class User{

	public	$id;
	public	$username_email;
	public	$password;
	public	$active;
	public	$last_name;
	public	$first_name;
	public	$patronymic_name;
	public	$last_name_en;
	public	$first_name_en;
	public	$patronymic_name_en;
	public	$departament;
	public	$status;
	public	$sex_id;
	public	$date_birth;
	public	$project;
	public	$comments;
	public	$role;
	
	public	$user;
	public	$insert_date;

}

?>
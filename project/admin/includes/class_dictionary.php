<?php
class Dictionary{

	public  $id;
	public  $value;

	function __construct($id, $value){
		$this->id = $id;
		$this->value=$value;
	}

}

class DicIdName{

	public  $id;
	public  $name;
	public  $table_name;

	function __construct($id, $name){
		$this->id = $id;
		$this->name=$name;
	}

}



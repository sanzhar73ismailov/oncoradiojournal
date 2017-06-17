<?php
class ListNavigateSections extends AbstractNavigate{
	public function __construct($smarty, $session, $request){
		parent::__construct($smarty, $session);
	}

	public function init(){
		global $dao;
		$this->restricted = true;
		$this->title = "Список разделов (секций)";
		$this->template = 'list_sections.tpl';
		$this->message = "";
		$pub_array = array();
		$list = $dao->getAll(new Section());
		//var_dump($list);
		//exit("<h1>STOP</h1>");
		$this->smartyArray['list'] = $list;
	}
}
?>
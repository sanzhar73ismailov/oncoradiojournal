<?php
class ListNavigateOrganizations extends AbstractNavigate{
	public function __construct($smarty, $session, $request){
		parent::__construct($smarty, $session);
	}

	public function init(){
		global $dao;
		$this->restricted = true;
		$this->title = "Список организаций";
		$this->template = 'list_organizations.tpl';
		$this->message = "";
		$pub_array = array();
		$list = $dao->getAll(new Organization());
		//var_dump($list);
		//exit("<h1>STOP</h1>");
		$this->smartyArray['list'] = $list;
	}
}
?>
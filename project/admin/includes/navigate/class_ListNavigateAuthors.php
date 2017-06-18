<?php
class ListNavigateAuthors extends AbstractNavigate{

	public function __construct($smarty, $session, $request){
		parent::__construct($smarty, $session);
	}

	public function init(){
		global $dao;
		$this->restricted = true;
		$this->title = "Список авторов";
		$this->template = 'list_authors.tpl';
		$this->message = "";
		$pub_array = array();
		$list = $dao->getAll(new Author());
		//var_dump($list);
		//exit("<h1>STOP</h1>");
		
		$this->smartyArray['list'] = $list;
	}
}
?>
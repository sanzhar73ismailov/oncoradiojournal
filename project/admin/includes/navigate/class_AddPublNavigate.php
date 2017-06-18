<?php
class AddPublNavigate extends AbstractNavigate{
	private $do;
	private $id;
	private $type_publ;
	private $request;
	private $step;

	public function __construct($smarty, $session){
		parent::__construct($smarty, $session);

	}

	public function init(){
		global $dao;
		$this->restricted = true;
		$this->message = "";
		$this->title = "Выбор типа публикаций для добавления";
		$this->template = 'select_publ_menu.tpl';

	}
}
?>
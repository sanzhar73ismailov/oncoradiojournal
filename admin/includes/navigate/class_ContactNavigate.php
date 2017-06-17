<?php
class ContactNavigate extends AbstractNavigate{

	public function __construct($smarty, $session){
		parent::__construct($smarty, $session);
	}

	public function init(){
		$this->title = "Контакты";
		$this->template = 'contacts.tpl';
		$this->smartyArray['admin_email']= ADMIN_EMAIL;
	}
}
?>
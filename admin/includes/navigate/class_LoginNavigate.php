<?php
class LoginNavigate extends AbstractNavigate{
	public function __construct($smarty, $session){
		parent::__construct($smarty, $session);
	}

	public function init(){
		$this->title = "Вход";
		$this->template = 'login.tpl';
		$this->smartyArray['object'] = new User();
	}
}
?>
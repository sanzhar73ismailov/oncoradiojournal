<?php
class RegistrationNavigate extends AbstractNavigate{

	public function __construct($smarty, $session){
		parent::__construct($smarty, $session);
	}

	public function init(){
		$this->title = "Регистрация";
		$this->template = 'register.tpl';
		$this->smartyArray['result']= 0;
		$this->smartyArray['object']= new User();

	}
}
?>
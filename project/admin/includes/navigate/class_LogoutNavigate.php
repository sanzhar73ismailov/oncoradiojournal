<?php
class LogoutNavigate extends AbstractNavigate{
	public function __construct($smarty, $session){
		parent::__construct($smarty, $session);
	}

	public function init(){
		$this->title = "Выход";
		$this->template = 'general_message.tpl';
		$this->message = "До встречи!";
		$this->smartyArray['authorized'] = false;
		$this->smartyArray['result'] = true;
		$_SESSION = array(); //Очищаем сессию
		//session_destroy(); //Уничтожаем
	}

}
?>
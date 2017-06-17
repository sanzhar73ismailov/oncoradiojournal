<?php
class ActivationNavigate extends AbstractNavigate{

	public function __construct($smarty, $session){
		parent::__construct($smarty, $session);
	}

	public function init(){
		global  $dao;
		//echo "init work in ActivationNavigate<p>";

		$this->title = "Активация учетной записи";
		$this->template = 'general_message.tpl';
		$this->smartyArray['result']= 0;

		$result_activation = $dao->activate_user($_REQUEST['username_email']);
		if($result_activation){
			$this->smartyArray['result']= true;
			$this->message = "Уважаемый " . $_REQUEST['username_email'] . ", ваша учетная запись активирована!";
		}else{
			$this->smartyArray['result']= false;
			$this->message = "Уважаемый " . $_REQUEST['username_email'] . ", ваша учетная запись не активирована, обратитесь а администратору";
		}
	}
}
?>
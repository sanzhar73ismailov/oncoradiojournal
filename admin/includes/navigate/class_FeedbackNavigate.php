<?php
class FeedbackNavigate extends AbstractNavigate{

	public function __construct($smarty, $session){
		parent::__construct($smarty, $session);
	}

	public function init(){
		$this->title = "Обратная связь";
		$this->template = 'feedback.tpl';
		$email = "";
		if($this->authorized){
			$email = $this->session['user']['username_email'];
		}

		$this->smartyArray['email']= $email;
			
	}
}
?>
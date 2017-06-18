<?php
abstract class AbstractNavigate{
	protected $title;
	protected $template;
	protected $smartyArray = array();
	protected $smarty;
	protected $session;
	protected $restricted = false;
	protected $authorized;
	protected $message = "";

	public function __construct($smarty, $session){
		$this->smarty = $smarty;
		$this->session = $session;

		//echo "<h1>_SESSION[authorized]" .$_SESSION["authorized"]."</h1>";


		if(!isset($_SESSION["authorized"]) || $_SESSION["authorized"] != 1){
			$this->authorized = false;
			//$this->authorized = true;
			$smarty->assign('authorized',0);
		}else{
			$this->authorized = true;
			$smarty->assign('authorized',1);
			$smarty->assign('user',$_SESSION['user']);
		}
	}


	public function display(){

		$this->init();

		$this->smarty->assign('title',$this->title);
		$this->smarty->assign('message',$this->message);

		foreach($this->smartyArray as $key => $value){
			$this->smarty->assign($key,$value);
		}

		if(!$this->restricted || ($this->restricted && $this->authorized)){
			$this->smarty->display('templates/' . $this->template);
		}else{
			$this->smarty->assign('title',"Вход");
			$this->smarty->assign('message',"Необходимио авторизоваться");
			$this->smarty->display('templates/login.tpl');
			exit;
		}
	}

	public abstract  function init();

}
?>
<?php
class SavePossibleNavigate extends AbstractNavigate{

	public function __construct($smarty, $session){
		parent::__construct($smarty, $session);
	}

	public function init(){
		global  $dao;
		//echo "init work in ActivationNavigate<p>";

		$this->title = "Сохранение публикаций";
		$this->template = 'index.tpl';
		//$this->smartyArray['result']= 0;

		$ids = $_REQUEST['ids'];

		//var_dump($ids);

		foreach ($ids as $pub_id) {
			$entity = new PublicationUser();
			$entity->user_id = $_SESSION['user']['id'];
			$entity->publication_id = $pub_id;
			$entity->responsible = 0;
			$entity->coauthor = 1;

			$dao->insert($entity);
		}

		$this->smartyArray['result']= true;
		$this->message = "Публикации добавлены!";

	}
}
?>
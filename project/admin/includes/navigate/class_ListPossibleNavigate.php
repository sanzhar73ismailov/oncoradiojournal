<?php
class ListPossibleNavigate extends AbstractNavigate{


	public function __construct($smarty, $session){
		parent::__construct($smarty, $session);
	}

	public function init(){
		global $dao;
		$this->restricted = true;
		$this->title = "Список возможных ваших публикаций";
		$this->template = 'list_possible.tpl';
		$this->message = "";


		//		$object1 = TestObjectCreator::createTstObject(new Publication());
		//		$object2 = TestObjectCreator::createTstObject(new Publication());
		//		$object3 = TestObjectCreator::createTstObject(new Publication());
		//

		//var_dump($publs);
		if($this->authorized){
			$publsPossibleIsAuthor = $dao->getPossiblePublications();
			//$this->smartyArray['publications'] = array($object1,$object2,$object3);
			$this->smartyArray['publications'] = getPublicationsAsArrayPresentation($publsPossibleIsAuthor);
		}
	}
}
?>
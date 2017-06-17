<?php
class ListNavigateIssues extends AbstractNavigate{
	public function __construct($smarty, $session, $request){
		parent::__construct($smarty, $session);
	}

	public function init(){
		global $dao;
		$this->restricted = true;
		$this->title = "Список номеров";
		$this->template = 'list_issues.tpl';
		$this->message = "";
		$pub_array = array();
		$list = $dao->getAll(new Issue());
		foreach ($list as $issue){
			$issue->sections = $dao->getListSectionByIssue($issue->id);
		}
		//var_dump($list);
		//exit("<h1>STOP</h1>");
		$this->smartyArray['list'] = $list;
	}
}
?>
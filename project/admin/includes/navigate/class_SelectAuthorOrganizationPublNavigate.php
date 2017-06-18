<?php
class SelectAuthorOrganizationPublNavigate extends AbstractNavigate{
	private $do;
	private $id;
	private $type_publ;
	private $request;
	private $step;

	public function __construct($smarty, $session,$doid, $request){
		parent::__construct($smarty, $session);
		$this->do = $doid['do'];
		$this->id = $doid['id'];
		$this->request = $request;
	}

	public function init(){
		global $dao;
		$this->restricted = true;
		$this->message = "";
		$this->title = "Выбор авторов и организация для публикации";
		$this->template = 'select_author_organization_menu.tpl';
		
		//var_dump($this->id);
		$issue_id = ''; 
		$object = new Publication();
		if(isset($this->id) && $this->id > 0){
			$object->id = $this->id;
			$object = $dao->get($object);
			$issue_id = $object->issue_id;
		}else{
			$issue_id = $object->issue_id;
		}
		
		//$listIssueSection = $dao->getByNativeQuery( new IssueSection(), "select * from bibl_issue_section where issue_id=" . $issueId);
		//$publ_sections = $dao->getAll(new Section(), " order by name_rus ");
		//if()
		$publ_sections = $this->getListOfSectionsForThisJournal($issue_id);
		$this->smartyArray['sections']= $publ_sections;
		
		$publ_authors = $dao->getAll(new Author(), " order by last_name_rus ");
		$this->smartyArray['authors']= $publ_authors;

		$publ_organizations = $dao->getAll(new Organization(), " order by name_rus ");
		$this->smartyArray['organizations']= $publ_organizations;
		
		$this->smartyArray['issue_id']= $issue_id;
		$issue = new Issue();
		$issue->id = $issue_id;
		$issue = $dao->get($issue);
		$this->smartyArray['issue']= $issue;
		$this->smartyArray['object']= $object;
		var_dump($object);

	}
	
	public function getListOfSectionsForThisJournal($issue_id){
			global $dao;
	$listIssueSection = $dao->getByNativeQuery( new IssueSection(), "select * from bibl_issue_section where issue_id=" . $issue_id);
	//var_dump($issue_id);
	//var_dump($listIssueSection);
	$sectionArray = array();
	//echo "<hr/>";
	foreach ($listIssueSection as $key => $issueSection){
		//var_dump($issueSection);
		$sectionEntity = new Section();
		$sectionEntity->id = $issueSection->section_id;
		$sectionEntity = $dao->get($sectionEntity);
		//var_dump($sectionEntity);
		$sectionArray[] = $sectionEntity;
	}
	//echo "<hr/>";
	//var_dump($sectionArray);
	return $sectionArray;
	}
}
?>
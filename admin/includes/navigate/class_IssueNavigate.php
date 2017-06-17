<?php
class IssueNavigate extends AbstractNavigate{
	private $do;
	private $id;

	private $request;

	public function __construct($smarty, $session, $doid, $request=null){
		parent::__construct($smarty, $session);

		$this->do = $doid['do'];
		$this->id = $doid['id'];
		$this->request = $request;
	}

	public function init(){
		global $dao;

		//$publ_types = $dao->getDicValues("type");
		$entity = new Issue();
		//$this->smartyArray['type_publ']= $this->type_publ;
		$this->smartyArray['entity']= "issue";
		//$this->smartyArray['generate_script']= $this->generateJScript($publ_types);
		$this->template = 'issue.tpl';

		$this->smartyArray['readonly']="readonly='readonly'";
		$this->smartyArray['disabled']="disabled='disabled'";
		$this->smartyArray['edit']=false;
		$this->smartyArray['class_req_input']="class='read_only_input'";
		$this->smartyArray['class']="class='read_only_input'";

		if(isset($this->request['ce']) ){
			$this->smartyArray['can_edit']=$this->request['ce'];
		}

		if($_SESSION["user"]['role'] == 'secretary'){
			$this->smartyArray['can_edit'] = 1;
		}
		$listSections = array();
		$listSections = $dao->getAll(new Section());
		
		$debug = 0;
		$debugStr = "";
		$debugStr .= '$listSections count = ' . count($listSections) . "<br/>\r\nssss"; // будет отображаться на странице, если  $debug = 1;

		switch($this->do){
			case "view":
				$entity->id= $this->id;
				$entity = $dao->get($entity);
				$entity->sections = $dao->getListSectionByIssue($entity->id);
				break;

			case "save":
				$entity = $dao->parse_form_to_object($this->request);
							
				$inserId = 0;
				if($entity->id > 0){
					$inserId = $dao->update($entity);
					$this->smartyArray['message'] = "Данные обновлены";
				}else{
					$inserId = $dao->insert($entity);
					$entity->id = $inserId;
					$this->smartyArray['message'] = "Данные сохранены";
				}

				$entity = $dao->get($entity);
				$arrSectionIds = explode(",", $this->request['sections']); 
				
				if(count($arrSectionIds) > 0){ 
					$dao->saveIssueSections($inserId, $arrSectionIds);
				}
				$entity->sections = $dao->getListSectionByIssue($inserId);
				break;

			case "edit":
				
				if($this->id > 0){
					$entity->id= $this->id;
					$entity = $dao->get($entity);
					$entity->sections = $dao->getListSectionByIssue($entity->id);
					
				}
				$this->smartyArray['readonly']="";
				$this->smartyArray['disabled']="";
				$this->smartyArray['class']="";
				$this->smartyArray['class_req_input']="class='req_input'";
				$this->smartyArray['edit']=true;
				
				break;
		}
		$debugStr .= '$entity->sections count = ' . count($entity->sections) . "<br/>\r\n";
		//$debugStr .= '$entity->sections  = ' . print_r($entity->sections, TRUE) . "<br/>\r\n";
		if(count($entity->sections) > 0){
			$arraySectIds = array_map(create_function('$o', 'return $o->id;'), $entity->sections);
			$debugStr .= '$arraySectIds  = ' . print_r($arraySectIds, TRUE) . "<br/>\r\n";
			//$newArrayListSections = array();
			foreach($listSections as $sectionElement){
				$sectionElement->checked = "";
				if(in_array($sectionElement->id, $arraySectIds)){
					$sectionElement->checked = "checked";
				}
				//$newArrayListSections[] = $sectionElement;
			}
			//$listSections = $newArrayListSections;
		}
		
		if($debug){
			$this->smartyArray['debugStr']="start debug -------------------- \r\n" . $debugStr . "\r\nend debug --------------------";
		}else{
			$this->smartyArray['debugStr']="";
		}

		//$this->converDatesToFormVariant($entity);
		$this->smartyArray['object']= $entity;
		$this->smartyArray['listSections']= $listSections;
		//echo "<h1>object :".$entity ."</h1>";
		//$organizations = $dao->getAll(new Organization(), " order by name_rus ");
		//$this->smartyArray['organizations']= $organizations;
	}

}
?>
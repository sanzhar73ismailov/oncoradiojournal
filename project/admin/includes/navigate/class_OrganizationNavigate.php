<?php
class OrganizationNavigate extends AbstractNavigate{
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
		$entity = new Organization();
		//$this->smartyArray['type_publ']= $this->type_publ;
		$this->smartyArray['entity']= "organization";
		//$this->smartyArray['generate_script']= $this->generateJScript($publ_types);
		$this->template = 'organization.tpl';

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

		switch($this->do){
			case "view":
				$entity->id= $this->id;
				$entity = $dao->get($entity);
				break;

			case "save":
				$entity = $dao->parse_form_to_object($this->request);
				if($entity->id > 0){
					$inserId = $dao->update($entity);
					$this->smartyArray['message'] = "Данные обновлены";
				}else{
					$inserId = $dao->insert($entity);
					$entity->id = $inserId;
					$this->smartyArray['message'] = "Данные сохранены";
				}
				
				$entity = $dao->get($entity);
				break;

			case "edit":
				if($this->id > 0){
				  $entity->id= $this->id;
				  $entity = $dao->get($entity);
				}
				$this->smartyArray['readonly']="";
				$this->smartyArray['disabled']="";
				$this->smartyArray['class']="";
				$this->smartyArray['class_req_input']="class='req_input'";
				$this->smartyArray['edit']=true;
				break;
		}
		$this->smartyArray['object']= $entity;
	}

}
?>
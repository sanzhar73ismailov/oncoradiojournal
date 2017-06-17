<?php
//AuthorNavigate

class AuthorNavigate extends AbstractNavigate{
	private $do;
	private $id;
	private $log_file = 1;

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
		$entity = new Author();
		//$this->smartyArray['type_publ']= $this->type_publ;
		$this->smartyArray['entity']= "author";
		//$this->smartyArray['generate_script']= $this->generateJScript($publ_types);
		$this->template = 'author.tpl';

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
				log_echo($entity, $this->log_file);
				
				if($entity->id > 0){
					$inserId = $dao->update($entity);
					$this->smartyArray['message'] = "Данные обновлены";
				}else{
					$inserId = $dao->insert($entity);
					$entity->id = $inserId;
					$this->smartyArray['message'] = "Данные сохранены";
					log_echo("\$inserId" . $inserId, $this->log_file);
					//exit("STOP");
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

		//$this->converDatesToFormVariant($entity);
		$this->smartyArray['object']= $entity;
		//echo "<h1>object :".$entity ."</h1>";
		$organizations = $dao->getAll(new Organization(), " order by name_rus ");
		$this->smartyArray['organizations']= $organizations;
	}

}
?>
<?php
class PublicationNavigate extends AbstractNavigate{

	private $do;
	private $id;
	private $type_publ;
	private $request;

	public function __construct($smarty, $session, $doid, $request=null){
		parent::__construct($smarty, $session);
		log_echo("<<<< PublicationNavigate __construct");
		$this->do = $doid['do'];
		$this->id = $doid['id'];
		$this->type_publ = $doid['type_publ'];
		$this->request = $request;
		log_echo("request:");
		log_echo($request);
		log_echo(">>>> PublicationNavigate __construct");
	}

	public function init(){
		log_echo("START PublicationNavigate.init");
		global $dao;

		$publ_types = $dao->getDicValues("type");
		$entity = new Publication();
		$this->smartyArray['type_publ']= $this->type_publ;
		$this->smartyArray['entity']= "publication";
		$generatedJScript = $this->generateJScript($publ_types);
		$this->smartyArray['generate_script']= $generatedJScript;
		log_echo("<<< generatedJScript:\r\n");
		log_echo($generatedJScript);
		log_echo(">>> generatedJScript");
		//authors_orgs
		if(isset($this->request['authors_orgs'])){
        //echo "<h1>". $this->request['authors_orgs']. "</h1>";
		}
		//echo "<pre>";
		//var_dump($this->request);
		//echo "</pre>";
		log_echo("\$this->type_publ: " . $this->type_publ);
		switch($this->type_publ){
			case "paper_classik":
				//$this->title = sprintf("Журнал: год %s, номер %s, выпуск %s", $issue->year, $issue->number, $issue->issue);
				$this->smartyArray['types']= $publ_types;
				//$publ_journals = $dao->getDicValues("journal", "name");
				//$this->smartyArray['journals']= $publ_journals;
				$this->template = 'publication.tpl';
				$entity->type_id = 1;
				break;
					
			case "tezis_paper_spec":
				$this->title = "Статья в спец. выпуске журнала конференции(семинара, симпозиума), сборников трудов";
				$this->smartyArray['types']= $publ_types;
				$publ_journals = $dao->getDicValues("journal", "name");
				$this->smartyArray['journals']= $publ_journals;
				$this->smartyArray['conferences']= $dao->getDicValues("conference");
				$this->smartyArray['conference_types']= $dao->getDicValues("conference_type");
				$this->smartyArray['conference_levels']= $dao->getDicValues("conference_level");

				//$this->smartyArray['conference_type_pubs']= $dao->getDicValues("conference_type_pub");
				$this->template = 'tezis_paper_spec.tpl';
				$entity->type_id = 3;
				$entity->tezis_type = 'paper_spec';
				break;

			case "tezis_paper":
				$this->title = "Статья в материалах ( работа более 3 страниц) конференции(семинара, симпозиума), сборников трудов";
				$this->smartyArray['types']= $publ_types;
				$this->smartyArray['conferences']= $dao->getDicValues("conference");
				$this->smartyArray['conference_types']= $dao->getDicValues("conference_type");
				$this->smartyArray['conference_levels']= $dao->getDicValues("conference_level");
				$this->template = 'tezis_paper.tpl';
				$entity->type_id = 3;
				$entity->tezis_type = 'paper';
				break;

			case "tezis_tezis":
				$this->title = "Тезис из материалов конференции(семинара, симпозиума), сборников трудов";
				$this->smartyArray['conferences']= $dao->getDicValues("conference");
				$this->smartyArray['conference_types']= $dao->getDicValues("conference_type");
				$this->smartyArray['conference_levels']= $dao->getDicValues("conference_level");

				//$this->smartyArray['conference_type_pubs']= $dao->getDicValues("conference_type_pub");
				$this->template = 'tezis.tpl';
				$entity->type_id = 3;
				$entity->tezis_type = 'tezis';
				break;

			case "patent":
				$this->title = "Авторское изобретение (патент, предпатент и т.д.)";
				$this->smartyArray['patent_types']= $dao->getDicValues("patent_type");
				$this->template = 'patent.tpl';
				$entity->type_id = 5;
				break;

			case "book":
				$this->title = "Книга (монография)";
				$this->template = 'book.tpl';
				$entity->type_id = 2;
				break;

			case "method_recom":
				$this->title = " Методические рекомендации";
				$this->template = 'method_recom.tpl';
				$entity->type_id = 6;
				break;


		}

		$this->smartyArray['readonly']="readonly='readonly'";
		$this->smartyArray['disabled']="disabled='disabled'";
		$this->smartyArray['edit']=false;
		$this->smartyArray['class_req_input']="class='read_only_input'";
		$this->smartyArray['class']="class='read_only_input'";

		if(isset($this->request['ce']) ){
			$this->smartyArray['can_edit']=$this->request['ce'];
		}

		log_echo("\$_SESSION['user']['role']:" . $_SESSION["user"]['role'] );
		if($_SESSION["user"]['role'] == 'secretary'){
			$this->smartyArray['can_edit'] = 1;
		}
		log_echo("\$this->do=" . $this->do );
		switch($this->do){
			case "save":
				$entity = $dao->parse_form_to_object($this->request);
				
				log_echo("\$entity->id=" . $entity->id);
				if($entity->id > 0) {
					log_echo("update entity");
					$inserId = $dao->update($entity);
					$this->smartyArray['message'] = "Данные обновлены";
				} else {
					log_echo("insert entity");
					$inserId = $dao->insert($entity);
					$entity->id = $inserId;
					$this->smartyArray['message'] = "Данные сохранены";
				}
				
				$entity = $this->getPub($entity);
				//				$entity->conference_date_start=getFormatStringFromDate($entity->conference_date_start);
				//				$entity->conference_date_finish=getFormatStringFromDate($entity->conference_date_finish);
				$entity->patent_date=getFormatStringFromDate($entity->patent_date);
				//echo "<h1>" . $entity->patent_date . "</h1>";
				break;
			case "view":
					$entity->id= $this->id;
					if($this->id > 0){
						$entity = $this->getPub($entity);
					}
					break;
					
			case "edit":
				$entity->id= $this->id;
				if($this->id > 0){
					$entity = $this->getPub($entity);
				}
				if($this->id == 0){
					$entity->electron = isset($this->request['electron']) ? 1: 0;
				}else{
					$entity->id= $this->id;
					$entity = $this->getPub($entity);
					$entity->patent_date=getFormatStringFromDate($entity->patent_date);
				}
				$this->smartyArray['readonly']="";
				$this->smartyArray['disabled']="";
				$this->smartyArray['class']="";
				$this->smartyArray['class_req_input']="class='req_input'";
				$this->smartyArray['edit']=true;
				break;
		}
		if($this->do == "view" or $this->do == "edit"){
			$this->smartyArray['kyew']="";
		}
		
		// {{{{{{{{{{{{{{{{{{{{{{{{{{{
		$issue = new Issue();
		if(isset($this->request['issue_id'])){
			$issue->id = $this->request['issue_id'];
		}else{
			$issue->id = $entity->issue_id;
		}
		$issue = $dao->get($issue);
		$this->smartyArray['issue']= $issue;
		log_echo("<<< issue:");
		log_echo($issue);
		log_echo(">>> issue");
		$this->title = sprintf("Журнал: год %s, номер %s, выпуск %s", $issue->year, $issue->number, $issue->issue);
		
		$publ_sections = $this->getListOfSectionsForThisJournal($issue->id);
		$this->smartyArray['sections']= $publ_sections;
		
		$publ_authors = $dao->getAll(new Author(), " order by last_name_rus ");
		$this->smartyArray['authors']= $publ_authors;
		
		$publ_organizations = $dao->getAll(new Organization(), " order by name_rus ");
		$this->smartyArray['organizations']= $publ_organizations;
		
		$this->smartyArray['issue_id']= $issue->id;
		//$array = $dao->getKeywordsByPublicationId(4);
		
		$this->smartyArray['keywords_kaz']= "";
		$this->smartyArray['keywords_rus']= "";
		$this->smartyArray['keywords_eng']= "";
		if($entity->id > 0){
			$this->smartyArray['keywords_kaz']= $this->getKeywordAsSeparatedStrings($dao->getKazKeywordsByPublicationId($entity->id));
			$this->smartyArray['keywords_rus']= $this->getKeywordAsSeparatedStrings($dao->getRusKeywordsByPublicationId($entity->id));
			$this->smartyArray['keywords_eng']= $this->getKeywordAsSeparatedStrings($dao->getEngKeywordsByPublicationId($entity->id));
		}
		// }}}}}}}}}}}}}}}}}}}}}}}}}}}}

		//$this->converDatesToFormVariant($entity);
		$this->smartyArray['object']= $entity;
		log_echo("FINISH PublicationNavigate.init");
	}

	private function getPub($entity){
		global $dao;
		$entity = $dao->get($entity);
		/*
		 	public $abstract_rus_to_check; // для отображения в проверочном варианте (с выделенными абзацами и т.д.)
	public $abstract_kaz_to_check;
	public $abstract_eng_to_check;
		 */
		$entity->abstract_rus_to_check = $entity->abstract_rus;
		$entity->abstract_kaz_to_check = $entity->abstract_kaz;
		$entity->abstract_eng_to_check = $entity->abstract_eng;
		
		$entity->abstract_rus_to_check = str_replace("- ","<span style='color:red;font-size:x-large;font-weight: bold;'>-*</span>", $entity->abstract_rus_to_check);
		$entity->abstract_kaz_to_check = str_replace("- ","<span style='color:red;font-size:x-large;font-weight: bold;'>-*</span>", $entity->abstract_kaz_to_check);
		$entity->abstract_eng_to_check = str_replace("- ","<span style='color:red;font-size:x-large;font-weight: bold;'>-*</span>", $entity->abstract_eng_to_check);
		
		$entity->abstract_rus_to_check = str_replace(" ,","<span style='color:red;font-size:x-large;font-weight: bold;'>*, </span>", $entity->abstract_rus_to_check); // меняем " ,", красный "*,"
		$entity->abstract_kaz_to_check = str_replace(" ,","<span style='color:red;font-size:x-large;font-weight: bold;'>*, </span>", $entity->abstract_kaz_to_check); // меняем " ,", красный "*,"
		$entity->abstract_eng_to_check = str_replace(" ,","<span style='color:red;font-size:x-large;font-weight: bold;'>*, </span>", $entity->abstract_eng_to_check); // меняем " ,", красный "*,"
		
		$entity->abstract_rus_to_check = str_replace(" .","<span style='color:red;font-size:x-large;font-weight: bold;'>*. </span>", $entity->abstract_rus_to_check); // меняем " .", красный "*."
		$entity->abstract_kaz_to_check = str_replace(" .","<span style='color:red;font-size:x-large;font-weight: bold;'>*. </span>", $entity->abstract_kaz_to_check); // меняем " .", красный "*."
		$entity->abstract_eng_to_check = str_replace(" .","<span style='color:red;font-size:x-large;font-weight: bold;'>*. </span>", $entity->abstract_eng_to_check); // меняем " .", красный "*."
		
		
		$entity->abstract_rus_to_check = str_replace("¬","<span style='color:red;font-size:x-large;font-weight: bold;'>¬</span>", $entity->abstract_rus_to_check);
		$entity->abstract_kaz_to_check = str_replace("¬","<span style='color:red;font-size:x-large;font-weight: bold;'>¬</span>", $entity->abstract_kaz_to_check);
		$entity->abstract_eng_to_check = str_replace("¬","<span style='color:red;font-size:x-large;font-weight: bold;'>¬</span>", $entity->abstract_eng_to_check);
		/*
		$entity->abstract_rus_to_check = preg_replace("/,(\S)/","<span style='color:red;font-size:x-large;font-weight: bold;'>,$1</span>", $entity->abstract_rus_to_check);
		$entity->abstract_kaz_to_check = preg_replace("/,(\S)/","<span style='color:red;font-size:x-large;font-weight: bold;'>,$1</span>", $entity->abstract_kaz_to_check);
		$entity->abstract_eng_to_check = preg_replace("/,(\S)/","<span style='color:red;font-size:x-large;font-weight: bold;'>,$1</span>", $entity->abstract_eng_to_check);
		
		$entity->abstract_rus_to_check = preg_replace("/\.,(\S)/","<span style='color:red;font-size:x-large;font-weight: bold;'>.$1</span>", $entity->abstract_rus_to_check);
		$entity->abstract_kaz_to_check = preg_replace("/\.,(\S)/","<span style='color:red;font-size:x-large;font-weight: bold;'>.$1</span>", $entity->abstract_kaz_to_check);
		$entity->abstract_eng_to_check = preg_replace("/\.,(\S)/","<span style='color:red;font-size:x-large;font-weight: bold;'>.$1</span>", $entity->abstract_eng_to_check);
		*/
		
		$pubUser = new PublicationUser();
			
		$queryFoPubUsetr = sprintf("select * from bibl_publication_user where publication_id='%s' and user_id='%s'", $entity->id, $_SESSION['user']['id']);
		$pubUserRows = $dao->selectJustNative($queryFoPubUsetr);
			
		if($pubUserRows){
			$pubUser->coauthor = $pubUserRows[0]['coauthor'];
		}else{
			$pubUser->coauthor = 0;
		}
		//$entity->responsible= $pubUser->responsible;
		$entity->coauthor= $pubUser->coauthor;
		return $entity;
	}

	private function converDatesToFormVariant(&$entity){
		$entity->conference_date_start=getFormatStringFromDate($entity->conference_date_start);
		$entity->conference_date_finish=getFormatStringFromDate($entity->conference_date_finish);
		$entity->patent_date=getFormatStringFromDate($entity->patent_date);
	}


	private function  generateJScript($publ_types){
		$script= "<script>%s\n</script>";
		$function1 = "\nfunction getArraReferences(){\nreturn [";
		foreach ($publ_types as $dic) {
			$function1 .=  "[". $dic->id . ", '" .  $dic->value . "'],\n";
		}
		$function1 .= "];\n}\n";
		$function2 = "\nfunction getCurrentUser(){\n";
		$user = $_SESSION['user'];
		$function2 .= "var user = new Object();\n";
		$function2 .= "user.id = " . $user['id'] . ";\n";
		$function2 .= "user.l_name = '" . $user['last_name'] . "';\n";
		$function2 .= "user.f_name = '" . $user['first_name'] . "';\n";
		$function2 .= "user.p_name = '" . $user['patronymic_name'] . "';\n";
		$function2 .= "user.org = '" . ORG_NAME . "';\n";
		$function2 .= "return user;\n}\n";
		return sprintf($script, $function1 . $function2);

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
	
	public function getListOfKeywordsForPaper(){
		global $dao;
		$listKeywords = array();
		if($this->id == 0){
			return $listKeywords;
		}
		$listIssueSection = $dao->getByNativeQuery( new Keyword(), "select * from bibl_issue_section where issue_id=" . $issue_id);
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

	function getKeywordAsSeparatedStrings($arrayKeywords){
		$names = array_map(create_function('$o', 'return $o->name;'), $arrayKeywords);
		//var_dump($catIds);
		$comma_separated = implode(",", $names);
		return $comma_separated;
	}
}
?>
<?php
class ListNavigate extends AbstractNavigate{
	public  $type_publ;
	public  $user_id;
	public  $responsible_coauthor;
	public  $all_rows_need = true;
	public  $nums_all;
	public  $nums_selected;
	public  $download=false;


	public function __construct($smarty, $session, $request){
		parent::__construct($smarty, $session);
		if(isset($request["type_publ"])){
			$this->type_publ = $request["type_publ"];
		}else{
			$this->type_publ = 'all';
		}
		
		$this->user_id =  $_SESSION['user']['id'];
		/*if(isset($request["users"]) && $request["users"] == "all"){
			$this->user_id = null;
		$this->smartyArray['users'] = "all";
		}else{
		$this->user_id =  $_SESSION['user']['id'];
		$this->smartyArray['users'] = "mine";
		}*/

		$this->smartyArray['registrator_author']=1;
		$this->smartyArray['registrator_notauthor']=1;
		$this->smartyArray['notregistrator_author']=1;
		$this->smartyArray['notregistrator_notauthor']=1;

		if(isset($request['download'])){
			$this->download = true;
		}
		//echo "<h1>this->type_publ:" . $this->type_publ . "</h1>";
		//echo "<h1>filter:" . isset($request['filter']) . "</h1>";
		
		if(isset($request['filter'])){
			$this->smartyArray['registrator_author']=$request['registrator_author'];
			$this->smartyArray['registrator_notauthor']=$request['registrator_notauthor'];
			$this->smartyArray['notregistrator_author']=$request['notregistrator_author'];
			$this->smartyArray['notregistrator_notauthor']=$request['notregistrator_notauthor'];

			if($request['registrator_author']==1){
				$this->responsible_coauthor[] = array('responsible'=>1,'coauthor'=>1);
			}else{
				$this->all_rows_need = false;
			}

			if($request['registrator_notauthor']==1){
				$this->responsible_coauthor[] = array('responsible'=>1,'coauthor'=>0);
			}else{
				$this->all_rows_need = false;
			}

			if($request['notregistrator_author']==1){
				$this->responsible_coauthor[] = array('responsible'=>0,'coauthor'=>1);
			}else{
				$this->all_rows_need = false;
			}

			if($request['notregistrator_notauthor']==1){
				$this->responsible_coauthor[] = array('responsible'=>0,'coauthor'=>0);
			}else{
				$this->all_rows_need = false;
			}
		}
		
	}

	public function init(){
		global $dao;
		$this->restricted = true;

		if($this->user_id == null){
			$this->title = "Список публикаций всех сотрудников";
		}else{
			$this->title = "Список моих публикаций";
		}


		$this->template = 'list.tpl';

		$this->message = "";

		$pub_array = array();
		$publs = array();

		$this->smartyArray['type_publ'] = $this->type_publ;
		$this->smartyArray['list_issues'] = $dao->getAll(new Issue());
		$object = new Publication();
		$object->type_id = PAPER;
		$publs = $dao->getAll($object, "order by issue_id, p_first");
		
		//exit("<h1>in class_ListNavigate.php init()</h1>");
		/*
		if($this->all_rows_need){
			$publs = $dao->getFilteredPublicationsRespCoauthor($this->user_id);
		}else{
			$publs = $dao->getFilteredPublicationsRespCoauthor($this->user_id, $this->responsible_coauthor);
		}

		switch ($this->type_publ){
			case 'all':
					
				$publs = $dao->getFilteredPublicationsByType($publs);
				break;

			case "paper":
				$publs = $dao->getFilteredPublicationsByType($publs, PAPER);
				break;

			case "book":
				$publs = $dao->getFilteredPublicationsByType($publs, BOOK);
				break;

			case "tezis":
				$publs = $dao->getFilteredPublicationsByType($publs, TEZIS);
				break;

			case "elres":
				$publs = $dao->getFilteredPublicationsByType($publs, ELRES);
				break;

			case "patent":
				$publs = $dao->getFilteredPublicationsByType($publs, PATENT);
				break;

			case "method_recom":
				$publs = $dao->getFilteredPublicationsByType($publs, METHOD_RECOM);
				break;

		}
		*/
			

		//$object = new Publication();
		
		$pub_array = getPublicationsAsArrayPresentation($publs);
		
		if($this->authorized){
			
			$this->nums_all = count($dao->getAll(new Publication()));
			
			$this->nums_selected = count($publs);
			
			$this->smartyArray['publications'] = $pub_array;
			$this->smartyArray['nums_all'] = $this->nums_all;
			$this->smartyArray['nums_selected'] =$this->nums_selected;

			if($this->download){
				//$this->template = 'list_download.tpl';
				header ("Content-type: text/plain");
				$file_name = "list_publications_"  . date("m.d.Y") . ".txt";

				if (ob_get_level()) {
					ob_end_clean();
				}
				// заставляем браузер показать окно сохранения файла
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename=' . $file_name);
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				//header('Content-Length: ' . filesize($file));
				// читаем файл и отправляем его пользователю
				//readfile($file);
				//exit;

				$i = 0;
				foreach ($pub_array as $item){
					echo (++$i . ". ");

					$auth_index = 0;
					foreach ($item['authors_array'] as $a){
						if($auth_index++ > 0){
							echo (", ");
						}
						echo ($a->last_name . " " . $a->first_name . "." . $a->patronymic_name . ".");
					}
					echo(" ". $item['name'] ." // " .$item['source'] . ". " . $item['year'] . "\n");
				}
				exit;
			}
		} 

	}
}
?>
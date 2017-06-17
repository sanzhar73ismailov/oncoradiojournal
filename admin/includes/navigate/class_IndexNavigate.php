<?php
class IndexNavigate extends AbstractNavigate{
	public function __construct($smarty, $session){
		parent::__construct($smarty, $session);
	}

	public function init(){
		global $dao;
		$this->restricted = true;
		$this->title = "Главная страница";
		$this->template = 'index.tpl';
		$this->smartyArray['statistica'] = "";

		if($this->authorized){
			//$publsPossibleIsAuthor = $dao->getPossiblePublications();
// 			$lengthArray = count($publsPossibleIsAuthor);
			$lengthArray = 0;
			//$lengthArray = array();
			if($lengthArray > 0){
				$message = "Найдено " . $lengthArray . " работы, соавтором которых Вы возможно являетесь. Перейдите по данной ссылке, для потдверждения.";
				$message .= "<a href=index.php?page=list_possible> Перейти</a>";
				$this->smartyArray['message'] ='<div style="color: green; width: 700px; padding: 50px; ">' . $message . "</div>";
			}


			//$stat_query = "select t.name, p.type_id, count(*) as quantity from bibl_publication p INNER JOIN bibl_type t ON p.type_id=t.id GROUP BY p.type_id";
				
			$stat_query = "select t.name, p.tezis_type, p.type_id, count(*) as quantity from bibl_publication p " .
					" INNER JOIN bibl_type t ON p.type_id=t.id " .
					" GROUP BY p.type_id,p.tezis_type";
			//echo "<h1>" . $stat_query . "</h1>";


			$rows = $dao->selectJustNative($stat_query);
			//exit("exit on <b>" . basename(__FILE__) . "</b> file ");
			$statistica = array();

			foreach ($rows as $key => $value) {
				$item = array();
				$name = "";
				$item['quantity'] = $value['quantity'];
				$item['type_id'] =$value['type_id'];
				if($value['type_id'] == PAPER){
					$name = "Статей";
				}elseif($value['type_id'] == BOOK){
					$name = "Книг";
				}elseif($value['type_id'] == TEZIS){
						
					if($value['tezis_type'] == 'paper_spec'){
						$name = "Конференции - статьи в спец. выпуске";
					}elseif($value['tezis_type'] == 'paper'){
						$name = "Конференции - статьи";
					}elseif($value['tezis_type'] == 'tezis'){
						$name = "Конференции- тезисы";
					}
						
				}elseif($value['type_id'] == ELRES){
					$name = "Эл публикаций";
				}elseif($value['type_id'] == PATENT){
					$name = "Охранных документов";
				}elseif($value['type_id'] == METHOD_RECOM){
					$name = "Методичек";
				}
				$item['type_name'] =$name;
				$statistica[]=$item;
			}
			$this->smartyArray['statistica'] = $statistica;
		}
		//var_dump($publsPossibleIsAuthor);


	}

}
?>
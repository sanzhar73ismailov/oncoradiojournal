<?php
class PublicationQuery extends DaoQuery{


	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_publication';
	}

	public function insertQuery(){
		$insetIdOfPublication = $this->insertOnlyPublication();
		$this->object->id = $insetIdOfPublication;
		global $dao;

		if($this->object->author_orgs_array != null){

			foreach ($this->object->author_orgs_array as $key=>$entity){
				$entity->publication_id = $insetIdOfPublication;
				$daoQuery = FabricaQuery::createQuery($this->pdo, $entity);
				$entity->user = $this->object->user;
				$daoQuery->insertQuery();
			}
			/*
			foreach ($this->object->keywords_array as $key=>$entity){
				$entity->publication_id = $insetIdOfPublication;
				$daoQuery = FabricaQuery::createQuery($this->pdo, $entity);
				//$entity->user = $this->object->user;
				$daoQuery->insertQuery();
				
			
			}
			*/
			/*
			foreach ($this->object->keywords_array as $keyword){
				$keyword = $dao->getKeywordByNameAndLang($keyword->name, $keyword->lang);
				$pubKeyWord = new PublicationKeyword();
				$pubKeyWord->keyword_id = $keyword->id;
				$pubKeyWord->publication_id = $insetIdOfPublication;
				$insertedId = $dao->insert($pubKeyWord);
				//echo "<h3>insertedId of PubKeyw:".$insertedId."</h3>";
			}
			*/
			$this->updatePublicationByKeywords();
		}
/*
		if($this->object->references_array != null){
			foreach ($this->object->references_array as $key=>$entity){
				$entity->publication_id = $insetIdOfPublication;
				$daoQuery = FabricaQuery::createQuery($this->pdo, $entity);
				$entity->user = $this->object->user;
				$daoQuery->insertQuery();
			}

		}
*/
		$publUserObj = new PublicationUser();
		$publUserObj->publication_id = $insetIdOfPublication;
		//$publUserObj->user_id = $_SESSION['user']['id'];
		$publUserObj->user_id = $_SESSION['user']['id'];
		$publUserObj->responsible = 1;
		//$publUserObj->coauthor = $this->object->coauthor;

		//$daoQuery = FabricaQuery::createQuery($this->pdo, $publUserObj);
		//$daoQuery->insertQuery();

		return $insetIdOfPublication;
	}

	public function bindValue(&$stmt){
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':name_kaz', $this->object->name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':name_rus', $this->object->name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':name_eng', $this->object->name_eng, PDO::PARAM_STR);
		$stmt->bindValue(':electron', $this->object->electron, PDO::PARAM_STR);
		$stmt->bindValue(':url', $this->object->url, PDO::PARAM_STR);
		$stmt->bindValue(':doi', $this->object->doi, PDO::PARAM_STR);
		$stmt->bindValue(':abstract_original', $this->object->abstract_original, PDO::PARAM_STR);
		$stmt->bindValue(':abstract_rus', $this->object->abstract_rus, PDO::PARAM_STR);
		$stmt->bindValue(':abstract_kaz', $this->object->abstract_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':abstract_eng', $this->object->abstract_eng, PDO::PARAM_STR);
		$stmt->bindValue(':language', $this->object->language, PDO::PARAM_STR);
		//$stmt->bindValue(':keywords', $this->object->keywords, PDO::PARAM_STR);
		$stmt->bindValue(':number_ilustrations', $this->object->number_ilustrations, PDO::PARAM_STR);
		$stmt->bindValue(':number_tables', $this->object->number_tables, PDO::PARAM_STR);
		$stmt->bindValue(':number_references', $this->object->number_references, PDO::PARAM_STR);
		$stmt->bindValue(':number_references_kaz', $this->object->number_references_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':code_udk', $this->object->code_udk, PDO::PARAM_STR);
		$stmt->bindValue(':type_id', $this->object->type_id, PDO::PARAM_STR);
		$stmt->bindValue(':journal_id', $this->object->journal_id, PDO::PARAM_STR);
		//$stmt->bindValue(':journal_name', $this->object->journal_name, PDO::PARAM_STR);
		//$stmt->bindValue(':journal_country', $this->object->journal_country, PDO::PARAM_STR);
		//$stmt->bindValue(':journal_issn', $this->object->journal_issn, PDO::PARAM_STR);
		//$stmt->bindValue(':journal_periodicity', $this->object->journal_periodicity, PDO::PARAM_STR);
		//$stmt->bindValue(':journal_izdatelstvo_mesto_izdaniya', $this->object->journal_izdatelstvo_mesto_izdaniya, PDO::PARAM_STR);
		$stmt->bindValue(':year', $this->object->year, PDO::PARAM_STR);
		$stmt->bindValue(':month', $this->object->month, PDO::PARAM_STR);
		$stmt->bindValue(':day', $this->object->day, PDO::PARAM_STR);
		$stmt->bindValue(':number', $this->object->number, PDO::PARAM_STR);
		$stmt->bindValue(':volume', $this->object->volume, PDO::PARAM_STR);
		$stmt->bindValue(':issue', $this->object->issue, PDO::PARAM_STR);
		$stmt->bindValue(':p_first', $this->object->p_first, PDO::PARAM_STR);
		$stmt->bindValue(':p_last', $this->object->p_last, PDO::PARAM_STR);
		$stmt->bindValue(':pmid', $this->object->pmid, PDO::PARAM_STR);
		$stmt->bindValue(':conference_id', $this->object->conference_id, PDO::PARAM_STR);
		$stmt->bindValue(':tezis_type', $this->object->tezis_type, PDO::PARAM_STR);

		//$stmt->bindValue(':conference_name', $this->object->conference_name, PDO::PARAM_STR);
		//$stmt->bindValue(':conference_city', $this->object->conference_city, PDO::PARAM_STR);
		//$stmt->bindValue(':conference_country', $this->object->conference_country, PDO::PARAM_STR);
		//$stmt->bindValue(':conference_type_id', $this->object->conference_type_id, PDO::PARAM_STR);
		//$stmt->bindValue(':conference_level_id', $this->object->conference_level_id, PDO::PARAM_STR);

		//$stmt->bindValue(':conference_type_pub_id', $this->object->conference_type_pub_id, PDO::PARAM_STR);
		//$stmt->bindValue(':conference_date_start', getSqlDateFromDate($this->object->conference_date_start), PDO::PARAM_STR);
		//$stmt->bindValue(':conference_date_finish', getSqlDateFromDate($this->object->conference_date_finish), PDO::PARAM_STR);


		$stmt->bindValue(':patent_type_id', $this->object->patent_type_id, PDO::PARAM_STR);
		$stmt->bindValue(':patent_type_number', $this->object->patent_type_number, PDO::PARAM_STR);
		$stmt->bindValue(':patent_date',  getSqlDateFromDate($this->object->patent_date), PDO::PARAM_STR);
		$stmt->bindValue(':book_city', $this->object->book_city, PDO::PARAM_STR);
		$stmt->bindValue(':book_pages', $this->object->book_pages, PDO::PARAM_STR);
		$stmt->bindValue(':izdatelstvo', $this->object->izdatelstvo, PDO::PARAM_STR);
		$stmt->bindValue(':user', $this->object->user, PDO::PARAM_STR);


		$stmt->bindValue(':method_recom_bbk', $this->object->method_recom_bbk, PDO::PARAM_STR);
		$stmt->bindValue(':isbn', $this->object->isbn, PDO::PARAM_STR);
		$stmt->bindValue(':method_recom_edited', $this->object->method_recom_edited, PDO::PARAM_STR);
		$stmt->bindValue(':method_recom_stated', $this->object->method_recom_stated, PDO::PARAM_STR);
		$stmt->bindValue(':method_recom_approved', $this->object->method_recom_approved, PDO::PARAM_STR);
		$stmt->bindValue(':method_recom_published_with_the_support', $this->object->method_recom_published_with_the_support, PDO::PARAM_STR);
		$stmt->bindValue(':method_recom_reviewers', $this->object->method_recom_reviewers, PDO::PARAM_STR);
		$stmt->bindValue(':issue_id', $this->object->issue_id, PDO::PARAM_STR);
		$stmt->bindValue(':section_id', $this->object->section_id, PDO::PARAM_STR);
		$stmt->bindValue(':file', $this->object->file, PDO::PARAM_STR);


	}

	private function insertOnlyPublication(){
		$query = "INSERT INTO
				  `" . $this->table . "`
						(
						  `id`,
						  `name_kaz`,
				  		  `name_rus`,
				  		  `name_eng`,
						  `electron`,
						  `url`,
						  `doi`,
						  `abstract_original`,
						  `abstract_rus`,
						  `abstract_kaz`,
						  `abstract_eng`,
						  `language`,
						  `number_ilustrations`,
						  `number_tables`,
						  `number_references`,
						  `number_references_kaz`,
						  `code_udk`,
						  `type_id`,
						  `journal_id`,
						   `year`,
						  `month`,
						  `day`,
						  `number`,
						  `volume`,
						  `issue`,
						  `p_first`,
						  `p_last`,
						  `pmid`,
						  `conference_id`,
						  `tezis_type`,
						  `patent_type_id`,
						  `patent_type_number`,
						  `patent_date`,
						  `book_city`,
						  `book_pages`,
						  `izdatelstvo`,
						  `user`,
						  `method_recom_bbk`,
						  `isbn`,
						  `method_recom_edited`,
						  `method_recom_stated`,
						  `method_recom_approved`,
						  `method_recom_published_with_the_support`,
						  `method_recom_reviewers`,
				  		  `issue_id`,
				  		  `section_id`,
				  		  `file`
						)
						VALUE (
						  :id,
						  :name_kaz,
				  		  :name_rus,
				  		  :name_eng,
						  :electron,
						  :url,
						  :doi,
						  :abstract_original,
						  :abstract_rus,
						  :abstract_kaz,
						  :abstract_eng,
						  :language,
						  :number_ilustrations,
						  :number_tables,
						  :number_references,
						  :number_references_kaz,
						  :code_udk,
						  :type_id,
						  :journal_id,
						  :year,
						  :month,
						  :day,
						  :number,
						  :volume,
						  :issue,
						  :p_first,
						  :p_last,
						  :pmid,
						  :conference_id,
						  :tezis_type,
						  :patent_type_id,
						  :patent_type_number,
						  :patent_date,
						  :book_city,
						  :book_pages,
						  :izdatelstvo,
						  :user,
						  :method_recom_bbk,
						  :isbn,
						  :method_recom_edited,
						  :method_recom_stated,
						  :method_recom_approved,
						  :method_recom_published_with_the_support,
						  :method_recom_reviewers,
				  		  :issue_id,
				  		  :section_id,
				  		  :file
						)";

		$stmt = $this->pdo->prepare($query);
		$this->bindValue($stmt);


		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				die("Ошибка, объект не сохранен");
			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		return $this->pdo->lastInsertId();

	}

	public  function updateQuery($by_column=null){
		$this->updateOnlyPublication();
		$this->updatePublicationByKeywords();
		$this->updateAuthors();
		//$this->updateAlsoForeignTables($this->object->authors_array, new Author());
		//$this->updateAlsoForeignTables($this->object->references_array, new Reference());
		//$publUserObj = new PublicationUser();
		//$publUserObj->publication_id =  $this->object->id;
		//$publUserObj->coauthor = $this->object->coauthor;
		//todo
		//$daoQuery = FabricaQuery::createQuery($this->pdo, $publUserObj);
		//$daoQuery->updateCoauthorColumnByPublicationId();
		return $this->object->id;
	}

	private function getNewObject($foreignEntity){
		$object = null;
		if(get_class($foreignEntity) == "Author"){
			$object = new Author();
		}elseif (get_class($foreignEntity) == "Reference"){
			$object = new Reference();
		}
		return $object;
	}

	private function updateAlsoForeignTables($fieldArray,$foreignEntity){
		// 1) смотрим все ли авторы имеют id, если все имеют значит ничего инсертить не надо.
		//    если есть без id, из них создаем массив для инсерта и publication_id данного объекта
		$arrayAuthorsForInsert = array(); // массив авторов, которых надо добавить
		$arrayAuthorObjInFormToUpdate= array(); // массив авторов, которых надо обновить
		$arrayAuthorIdInFormToUpdate = array(); // массив id (айдишников_ авторов), которых надо обновить, нужно для того чтобы вычисчить тех которых удалить надо
		$arrayAuthorIdInDb = array(); //массив id (айдишников_ авторов), в базе по этой публикации
		$arrayAuthorIdToDelete = array(); //массив id (айдишников_ авторов), которых надо удалить
		//echo "<br>" . "Новые авторы:" . "<br>";
		foreach ($fieldArray as $key=>$entity){
			$entity->publication_id = $this->object->id;
			if($entity->id == null){
				$arrayAuthorsForInsert[] = $entity;
				//	echo "<br>" . "Новые объект:" . $entity . "<br>";
			}else{
				$arrayAuthorObjInFormToUpdate [] = $entity;
				$arrayAuthorIdInFormToUpdate[] = $entity->id;
				//echo "<br>" . "Старый объект:" . $entity . "<br>";
			}
		}

		// 2) вытаскиваем всех авторов по этой публикации и сравниваем с тем что пришло с формы.
		//    если все без изменений, то просто все записи обновляем
		$authorQuery =FabricaQuery::createQuery($this->pdo, $this->getNewObject($foreignEntity));
		$conditionArray = array(new QueryCondition("publication_id", $this->object->id));
		$arrayAuthorsFromDb = $authorQuery->selectQueryManyByCondition($conditionArray, "id");
		//echo "<br>---------------<br>";
		foreach ($arrayAuthorsFromDb as $key=>$entity){
			$arrayAuthorIdInDb[] = $entity->id;
			//echo "<br>" . "Автор в БД :" . $entity . "<br>";
		}
		// вытаскиваем те id которые в базе лишние
		$arrayAuthorIdToDelete = array_diff($arrayAuthorIdInDb, $arrayAuthorIdInFormToUpdate);

		//echo "<br>-------arrayAuthorIdInFormToUpdate--------<br>";
		//var_dump($arrayAuthorIdInFormToUpdate);

		//echo "<br>-------arrayAuthorObjInFormToUpdate--------<br>";
		//var_dump($arrayAuthorObjInFormToUpdate);

		//echo "<br>-------arrayAuthorIdInDb--------<br>";
		//var_dump($arrayAuthorIdInDb);

		//echo "<br>---------------<br>";
		//var_dump($arrayAuthorIdToDelete);

		//удаляем их из базы
		foreach ($arrayAuthorIdToDelete as $key=>$id_to_delete){
			$entity = $this->getNewObject($foreignEntity);
			$entity->id=$id_to_delete;
			$daoQuery = FabricaQuery::createQuery($this->pdo, $entity);
			$daoQuery->deleteQuery();
		}

		//обновляем в базе из формы, тех что с id
		foreach ($arrayAuthorObjInFormToUpdate as $key=>$entity){
			//echo "<br>---------------<br>";
			//var_dump($entity);
			$daoQuery = FabricaQuery::createQuery($this->pdo, $entity);
			$entity->user = $this->object->user;
			$daoQuery->updateQuery();
		}

		//инсертим если таковые есть
		foreach ($arrayAuthorsForInsert as $key=>$entity){
			$daoQuery = FabricaQuery::createQuery($this->pdo, $entity);
			$entity->user = $this->object->user;
			$daoQuery->insertQuery();
		}
	}

	public  function updateOnlyPublication($by_column=null){
		$query = "UPDATE
				  `" . $this->table . "`
								SET
				  `name_kaz` = :name_kaz,
				  `name_rus` = :name_rus,
				  `name_eng` = :name_eng,
				  `electron` = :electron,
				  `url` = :url,
				  `doi` = :doi,
				  `abstract_original` = :abstract_original,
				  `abstract_rus` = :abstract_rus,
				  `abstract_kaz` = :abstract_kaz,
				  `abstract_eng` = :abstract_eng,
				  `language` = :language,
				  `number_ilustrations` = :number_ilustrations,
				  `number_tables` = :number_tables,
				  `number_references` = :number_references,
				  `number_references_kaz` = :number_references_kaz,
				  `code_udk` = :code_udk,
				  `type_id` = :type_id,
				  `journal_id` = :journal_id,
				  `year` = :year,
				  `month` = :month,
				  `day` = :day,
				  `number` = :number,
				  `volume` = :volume,
				  `issue` = :issue,
				  `p_first` = :p_first,
				  `p_last` = :p_last,
				  `pmid` = :pmid,
				  `conference_id` = :conference_id,
				  `tezis_type` = :tezis_type,
				  `patent_type_id` = :patent_type_id,
				  `patent_type_number` = :patent_type_number,
				  `patent_date` = :patent_date,
				  `book_city` = :book_city,
				  `book_pages` = :book_pages,
				  `izdatelstvo` = :izdatelstvo,
				  `user` = :user,
				   method_recom_bbk=:method_recom_bbk,
				   isbn=:isbn,
				   method_recom_edited=:method_recom_edited,
				   method_recom_stated=:method_recom_stated,
				   method_recom_approved=:method_recom_approved,
				   method_recom_published_with_the_support=:method_recom_published_with_the_support,
				   method_recom_reviewers=:method_recom_reviewers,
				   issue_id=:issue_id,
				   section_id=:section_id,
				   file=:file		
				WHERE
				  `id` = :id";

		$stmt = $this->pdo->prepare($query);
		$this->bindValue($stmt);

		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				//die("Ошибка, объект не обновлен");
			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		return $this->object->id;
	}

	private function getDicValues($object){
		$queryArr = FabricaQuery::createQuery($this->pdo, $object);
		$conditionArray = array(new QueryCondition("publication_id", $this->object->id));
		return $queryArr->selectQueryManyByCondition($conditionArray, "id");
	}

	public function fromRowsToArrayObjects($rows){
		$returnObjects = array();
		foreach ($rows as $row){
			$object = new Publication();
			$object->id=$row['id'];
			$object->name_kaz=$row['name_kaz'];
			$object->name_rus=$row['name_rus'];
			$object->name_eng=$row['name_eng'];
			$object->electron=$row['electron'];
			$object->url=$row['url'];
			$object->doi=$row['doi'];
			$object->abstract_original=$row['abstract_original'];
			$object->abstract_rus=$row['abstract_rus'];
			$object->abstract_kaz=$row['abstract_kaz'];
			$object->abstract_eng=$row['abstract_eng'];
			$object->language=$row['language'];
			$object->number_ilustrations=$row['number_ilustrations'];
			$object->number_tables=$row['number_tables'];
			$object->number_references=$row['number_references'];
			$object->number_references_kaz=$row['number_references_kaz'];
			$object->code_udk=$row['code_udk'];
			$object->type_id=$row['type_id'];
			$object->journal_id=$row['journal_id'];
			$object->year=$row['year'];
			$object->month=$row['month'];
			$object->day=$row['day'];
			$object->number=$row['number'];
			$object->volume=$row['volume'];
			$object->issue=$row['issue'];
			$object->p_first=$row['p_first'];
			$object->p_last=$row['p_last'];
			$object->pmid=$row['pmid'];

			//$object->conference_id=$row['conference_id'];

			$object->conference_id=$row['conference_id'];
			$object->tezis_type=$row['tezis_type'];


			$object->patent_type_id=$row['patent_type_id'];
			$object->patent_type_number=$row['patent_type_number'];
			$object->patent_date=getDateFromSqlDate($row['patent_date']);

			$object->book_city=$row['book_city'];
			$object->book_pages=$row['book_pages'];
			$object->izdatelstvo=$row['izdatelstvo'];

			$object->user=$row['user'];
			$object->insert_date=$row['insert_date'];


			$object->method_recom_bbk=$row['method_recom_bbk'];
			$object->isbn=$row['isbn'];
			$object->method_recom_edited=$row['method_recom_edited'];
			$object->method_recom_stated=$row['method_recom_stated'];
			$object->method_recom_approved=$row['method_recom_approved'];
			$object->method_recom_published_with_the_support=$row['method_recom_published_with_the_support'];
			$object->method_recom_reviewers=$row['method_recom_reviewers'];
			
			$object->issue_id=$row['issue_id'];
			
			$issueObj = new Issue();
			$issueObj->id = $object->issue_id;
			$daoQuery1 = FabricaQuery::createQuery($this->pdo, $issueObj);
			$issueObj = $daoQuery1->selectQueryOneById();
			//echo "{".$issueObj->id . "-" . $issueObj->year . "}<br/>";
			$object->issueObj=$issueObj;
			
			$object->section_id=$row['section_id'];
			$object->file=$row['file'];
				
			if(isset($row['responsible'])){
				$object->responsible = $row['responsible'];
			}
				
			if(isset($row['coauthor'])){
				$object->coauthor = $row['coauthor'];
			}

			if(isset($row['user_responsible'])){
				$object->user_responsible = $row['user_responsible'];
			}

			$daoQuery = FabricaQuery::createQuery($this->pdo, new PublicationAuthor());
			$condArray = array(new QueryCondition("publication_id", $object->id));
// 			$object->authors_array = array(0=>new Author(), 1=>new Author()); // $daoQuery->selectQueryManyByCondition($condArray, "id");
			//$object->authors_array = $daoQuery->selectQueryManyByCondition($condArray, "id");
			$query_authors = sprintf("SELECT 
			  bibl_publication_author.*,
			  bibl_publication.name_rus publication_name,
			  CONCAT(bibl_author.last_name_rus,' ',SUBSTRING(bibl_author.first_name_rus,1,1),' ',SUBSTRING(bibl_author.patronymic_name_rus,1,1)) author_name,
			  bibl_organization.name_rus organization_name
			FROM
			  bibl_publication_author
			  INNER JOIN bibl_publication ON (bibl_publication_author.publication_id = bibl_publication.id)
			  INNER JOIN bibl_author ON (bibl_publication_author.author_id = bibl_author.id)
			  INNER JOIN bibl_organization ON (bibl_publication_author.organization_id = bibl_organization.id)
			 WHERE  bibl_publication_author.publication_id='%s'					
			 ORDER BY bibl_publication_author.id;",  $object->id);
			
			//$object->authors_array = $daoQuery->selectQueryNative($condArray, "id");
			$object->author_orgs_array = $daoQuery->selectQueryNative($query_authors);
			log_echo("<<<\$object->author_orgs_array");
			log_echo($object->author_orgs_array);
			log_echo(">>>");
			
			$daoQuery = FabricaQuery::createQuery($this->pdo, new Keyword());
			$query_keywords = sprintf("SELECT 
				k.id,
				k.name,
				k.lang
			FROM bibl_publication p
				inner join bibl_publication_keyword pk on p.id=pk.publication_id
				inner join bibl_keyword k on k.id=pk.keyword_id
			WHERE 
				p.id = '%s' 
			ORDER BY k.lang, k.name", $object->id);
			$object->keywords_array = $daoQuery->selectQueryNative($query_keywords);
			
			$daoQuery = FabricaQuery::createQuery($this->pdo, new Reference());
			$condArray = array(new QueryCondition("publication_id", $object->id));
			//$object->references_array = $daoQuery->selectQueryManyByCondition($condArray, "id");

			//$object->author_orgs_array = $daoQuery->selectQueryManyByCondition($condArray, "id");
			//$object->author_orgs_array = $daoQuery->
			$returnObjects[] = $object;
		}
		return $returnObjects;
	}
	
	function updatePublicationByKeywords(){
		//echo "<h3>start updatePublicationByKeywords</h3>";
		global $dao;
		try{
			$pub_id = $this->object->id;
			$arrayOfKeywords = $this->object->keywords_array;
			log_echo($arrayOfKeywords);
			$count = $dao->deleteNative("delete from bibl_publication_keyword where publication_id=" . $pub_id);
			//echo "<h3>count deleted:".$count."</h3>";
			//echo "<h3>-------------</h3>";
			foreach($arrayOfKeywords as $keyword){
				log_echo("<<< keyword");
				log_echo($keyword);
				log_echo(">>> keyword");
				$keyword = $dao->getKeywordByNameAndLang($keyword->name, $keyword->lang);
				$pubKeyWord = new PublicationKeyword();
				$pubKeyWord->keyword_id = $keyword->id;
				$pubKeyWord->publication_id = $pub_id;
				$insertedId = $dao->insert($pubKeyWord);
				//echo "<h3>insertedId of PubKeyw:".$insertedId."</h3>";
			}
		}catch (Exception $e) {
			echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
		}
		//echo "<h3>end updatePublicationByKeywords</h3>";
	}
	
	function updateAuthors(){
		log_echo("<<< start updateAuthors");
		//echo "<h3>start updateAuthors</h3>";
		global $dao;
		try{
			$pub_id = $this->object->id;
			$count = $dao->deleteNative("delete from bibl_publication_author where publication_id=" . $pub_id);
			log_echo("count deleted:". $count);
			//$author_orgs_array
			foreach($this->object->author_orgs_array as $pubAuthorObj){
				$pubAuthorObj->publication_id=$pub_id;
				$insertedId = $dao->insert($pubAuthorObj);
				//echo "<h3>insertedId of PublicationAuthor:".$insertedId."</h3>";
			}
			//var_dump($authors_orgs_twoArray);
		}catch (Exception $e) {
			echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
		}
		//echo "<h3>end updateAuthors</h3>";
		log_echo(">>> finish updateAuthors");
	}
}
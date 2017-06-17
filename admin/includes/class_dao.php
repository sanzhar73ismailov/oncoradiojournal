<?php
// session_start();
include_once 'includes/config.php';
include_once 'includes/class_entity.php';
include_once 'includes/class_patient.php';
include_once 'includes/class_investigation.php';
include_once 'includes/class_parse_object.php';
include_once 'includes/class_test_object_creator.php';
include_once 'includes/class_dao_query.php';
class QueryCondition {
	public $column;
	public $operator;
	public $value;
	public $type;
	function __construct($column, $value, $operator = "=", $type = "str") {
		$this->column = $column;
		$this->value = $value;
		$this->operator = $operator;
		$this->type = $type;
	}
}
class Dao {
	private $pdo;
	private $user;
	function __construct() {
		$this->connect ();
		// $this->user = $_SESSION["user"]['username_email'];
		$this->user = "test_user";
	}
	function __destruct() {
		// $this->pdo = null;
	}
	public function getPdo() {
		return $this->pdo;
	}
	public function connect() {
		if ($this->pdo == null) {
			$connect_string = sprintf ( 'mysql:host=%s;dbname=%s', HOST, DB_NAME );
			$this->pdo = new PDO ( $connect_string, DB_USER, DB_PASS, array (
					PDO::ATTR_PERSISTENT => true 
			) );
			$this->pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$this->pdo->query ( "SET NAMES 'utf8'" );
		}
	}
	public function getDicValues($dic_name, $order_by = null) {
		$results = array ();
		$query = '';
		$order = $order_by == null ? " order by id" : " order by " . $order_by;
		if ($dic_name == 'journal') {
			$query = "SELECT id,
		               CONCAT(IFNULL(name,'_Название не указано'),' (' , CONCAT_WS(', ', country, issn, izdatelstvo_mesto_izdaniya) , ')') as name 
		                FROM  " . DB_PREFIX . $dic_name . $order;
		} elseif ($dic_name == 'conference') {
			$query = "SELECT id, CONCAT(name, ' (', CONCAT_WS(', ',  city,  country, 'даты ' ,date_start,  date_finish),')')   as name FROM " . DB_PREFIX . $dic_name . $order;
		} else {
			$query = "SELECT * FROM " . DB_PREFIX . $dic_name . $order;
		}
		// echo $query;
		try {
			$stmt = $this->pdo->query ( $query );
			foreach ( $stmt as $row ) {
				$results [] = new Dictionary ( $row ['id'], $row ['name'] );
			}
		} catch ( PDOException $ex ) {
			echo "Ошибка:" . $ex->getMessage ();
		}
		return $results;
	}
	public function addDicValue($dic_name, $value) {
		$results = array ();
		
		$query = sprintf ( "INSERT INTO %s (id, name) VALUE(null, '%s') ", DB_PREFIX . $dic_name, $value );
		// echo "1:" . $query . "\n<br>";
		try {
			$result = $this->pdo->exec ( $query );
			
			$dic = new Dictionary ( $this->pdo->lastInsertId (), $value );
			// echo $query . "\n<br>";
		} catch ( PDOException $ex ) {
			// echo "Ошибка:" . $ex->getMessage();
			return new Dictionary ( 0, "Такой вариант уже есть" );
		}
		return $dic;
	}
	public function parse_form_to_object($request) {
		$parseObject = null;
		if ($request ['entity'] == 'publication') {
			
			switch ($request ['type_publ']) {
				case 'paper_classik' :
				case 'tezis_tezis' :
				case 'tezis_paper_spec' :
				case 'tezis_paper' :
				case 'patent' :
				case 'book' :
				case 'method_recom' :
					$parseObject = new ParsePublication ( $request );
					break;
				// $parseObject = new ParsePatent($request);
				// $parseObject = new ParseBook($request);
				// break;
				default :
					exit ( "Unsupported type bibl in parse_form_to_object() " );
					break;
			}
		} elseif ($request ['entity'] == 'user') {
			$parseObject = new ParseUser ( $request );
		} elseif ($request ['entity'] == 'author') {
			$parseObject = new ParseAuthor ( $request );
		} elseif ($request ['entity'] == 'organization') {
			// $parseObject = new ParseOrganizationAuthor($request);
			$parseObject = new ParseOrganizationAuthor ( $request );
		} elseif ($request ['entity'] == 'issue') {
			$parseObject = new ParseIssue ( $request );
		} elseif ($request ['entity'] == 'section') {
			$parseObject = new ParseSection ( $request );
		} else {
			exit ( "Unsupported (see file class_dao.php parse_form_to_object)" );
		}
		
		$parseObject->parse ();
		// var_dump($request);
		// var_dump($parseObject->getParsedObject());
		// //exit("Stop");
		
		return $parseObject->getParsedObject ();
	}
	public function getUserByLogin($username) {
		$row = array ();
		$query = "SELECT * FROM bibl_user WHERE username_email = :username_email";
		
		try {
			$stmt = $this->pdo->prepare ( $query );
			$stmt->bindValue ( ':username_email', $username, PDO::PARAM_STR );
			
			$stmt->execute ();
			$row = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $ex ) {
			echo "Ошибка:" . $ex->getMessage ();
		}
		if ($stmt->rowCount () == 0) {
			return null;
		}
		
		$object = new User ();
		
		$object->id = $row [0] ['id'];
		$object->username_email = $row [0] ['username_email'];
		$object->password = $row [0] ['password'];
		$object->active = $row [0] ['active'];
		$object->last_name = $row [0] ['last_name'];
		$object->first_name = $row [0] ['first_name'];
		$object->patronymic_name = $row [0] ['patronymic_name'];
		
		$object->last_name_en = $row [0] ['last_name_en'];
		$object->first_name_en = $row [0] ['first_name_en'];
		$object->patronymic_name_en = $row [0] ['patronymic_name_en'];
		
		$object->departament = $row [0] ['departament'];
		$object->status = $row [0] ['status'];
		$object->sex_id = $row [0] ['sex_id'];
		$object->date_birth = $row [0] ['date_birth'];
		$object->project = $row [0] ['project'];
		$object->comments = $row [0] ['comments'];
		$object->role = $row [0] ['role'];
		
		return $object;
	}
	public function is_user_exist($username, $pass = null, $active = null) {
		$row = array ();
		// $query = "SELECT * FROM bibl_user WHERE username_email = :username_email AND active=1";
		$query = "SELECT * FROM bibl_user WHERE username_email = :username_email";
		if ($active != null) {
			// echo "<h1>asdasd</h1>";
			$query .= " AND active = :active";
		}
		if ($pass != null) {
			// echo "<h1>asdasd</h1>";
			$query .= " AND password = :password";
		}
		
		try {
			$stmt = $this->pdo->prepare ( $query );
			$stmt->bindValue ( ':username_email', $username, PDO::PARAM_STR );
			if ($active != null) {
				// echo "<h1>asdasd</h1>";
				$stmt->bindValue ( ':active', $active, PDO::PARAM_STR );
			}
			if ($pass != null) {
				$stmt->bindValue ( ':password', $pass, PDO::PARAM_STR );
			}
			
			$stmt->execute ();
			$row = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $ex ) {
			echo "Ошибка:" . $ex->getMessage ();
		}
		if ($stmt->rowCount () == 0) {
			return false;
		}
		return true;
	}
	public function activate_user($user_name) {
		$query = "UPDATE
			  `bibl_user`  
			SET 
			  `active` = 1
			  WHERE 
			  `username_email` = :username_email
			;";
		
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindValue ( ':username_email', $user_name, PDO::PARAM_STR );
		
		// echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute ();
			
			$affected_rows = $stmt->rowCount ();
			// echo $affected_rows.' строка добавлена';
			if ($affected_rows > 0) {
				return true;
			}
		} catch ( PDOException $ex ) {
			echo "Ошибка:" . $ex->getMessage ();
		}
		
		return false;
	}
	public function insert_user_visit($object) {
		$query = "INSERT INTO
		  `bibl_user_visit`
		(
		  `id`,
		  `username`
		   		  ) 
		VALUE (
		  null,
		  :username
		);";
		
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindValue ( ':username', $object->username_email, PDO::PARAM_STR );
		
		// echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute ();
			
			$affected_rows = $stmt->rowCount ();
			// echo $affected_rows.' пациент добавлен';
			if ($affected_rows < 1) {
				die ( "Ошибка, объект не сохранен" );
			}
		} catch ( PDOException $ex ) {
			echo "Ошибка:" . $ex->getMessage ();
		}
		
		return $this->pdo->lastInsertId ();
	}
	public function insert($entity) {
		$daoQuery = FabricaQuery::createQuery ( $this->pdo, $entity );
		return $daoQuery->insertQuery ();
	}
	public function get($entity) {
		$queryStatement = FabricaQuery::createQuery ( $this->pdo, $entity );
		return $queryStatement->selectQueryOneById ( $entity );
	}
	public function getByNativeQuery($entity, $query) {
		$queryStatement = FabricaQuery::createQuery ( $this->pdo, $entity );
		return $queryStatement->selectQueryNative ( $query );
	}
	public function getPossiblePublications() {
		$query = sprintf ( "select * from bibl_publication p where id in (
					select  DISTINCT(a.publication_id)  from bibl_author a where a.publication_id in
					(select pu.publication_id from bibl_publication_user pu where 
					pu.publication_id not in
					(select publication_id from bibl_publication_user  where user_id = %s))
					and (a.last_name like '%s' or a.last_name like '%s')) 
					order by p.id", $_SESSION ['user'] ['id'], "%" . $_SESSION ['user'] ['last_name'] . "%", "%" . $_SESSION ['user'] ['last_name_en'] . "%" );
		
		// echo "<h1>" .$query . "</h1>";
		
		$publsPossibleIsAuthor = $this->getByNativeQuery ( new Publication (), $query );
		return $publsPossibleIsAuthor;
	}
	public function getAll($entity, $orderBy = null) {
		$queryStatement = FabricaQuery::createQuery ( $this->pdo, $entity );
		$objs = $queryStatement->selectQueryAll ( $orderBy );
		// var_dump($objs);
		return $objs;
	}
	public function getMyPublications($user_id = null, $type_id = null) {
		if ($user_id != null) {
			$entity = new PublicationUser ();
			$entity->user_id = $user_id;
			
			// $queryStatement= new PublicationUserQuery($pdo, $object);
			
			$queryStatement = FabricaQuery::createQuery ( $this->pdo, $entity );
			
			$array_cond_query = array ();
			
			if ($user_id != null) {
				$array_cond_query [] = new QueryCondition ( "user_id", $user_id );
			}
			$pubUserArray = $queryStatement->selectQueryManyByCondition ( $array_cond_query, "publication_id" );
			$idInRespArray = array ();
			$idInNotRespArray = array ();
			
			foreach ( $pubUserArray as $userPub ) {
				
				if ($userPub->responsible) {
					$idInRespArray [] = $userPub->publication_id;
				} else {
					$idInNotRespArray [] = $userPub->publication_id;
				}
				
				// var_dump ($value);
				// echo "<br>";
			}
			
			$publArrayResp = array ();
			$publArrayReadOnly = array ();
			
			$queryStatement = FabricaQuery::createQuery ( $this->pdo, new Publication () );
			
			// echo "SELECT * FROM bibl_publication WHERE id IN " . $idInRespArray . " order by id";
			// resp
			
			$andTypeIdPart = "";
			if ($type_id != null) {
				$andTypeIdPart = " AND type_id = " . $type_id;
			}
			
			if ($idInRespArray) {
				$idInRespArray = implode ( ", ", $idInRespArray );
				$publArrayResp = $queryStatement->selectQueryNative ( "SELECT * FROM bibl_publication WHERE id IN (" . $idInRespArray . ")" . $andTypeIdPart . " order by id" );
			}
			// readonly papers
			if ($idInNotRespArray) {
				$idInNotRespArray = implode ( ", ", $idInNotRespArray );
				$publArrayReadOnly = $queryStatement->selectQueryNative ( "SELECT * FROM bibl_publication WHERE id IN (" . $idInNotRespArray . ")" . $andTypeIdPart . " order by id" );
			}
			foreach ( $publArrayResp as $pub ) {
				$pub->responsible = 1;
			}
			foreach ( $publArrayReadOnly as $pub ) {
				$pub->responsible = 0;
			}
			
			// $objs = $queryStatement->selectQueryAll();
			// var_dump($publArray);
			return array_merge ( $publArrayResp, $publArrayReadOnly );
		} else {
			
			$entity = new Publication ();
			$array_cond_query = array ();
			
			if ($type_id != null) {
				$array_cond_query [] = new QueryCondition ( "type_id", $type_id );
			}
			$queryStatement = FabricaQuery::createQuery ( $this->pdo, $entity );
			$pubUserArray = $queryStatement->selectQueryManyByCondition ( $array_cond_query, "id" );
			
			return $pubUserArray;
		}
	}
	public function getPublicationsRespCoauthor($user_id) {
		$pubAll = $this->getAll ( new Publication () );
		
		foreach ( $pubAll as $item ) {
			try {
				// echo inverse(5) . "\n";
				// echo inverse(0) . "\n";
				
				$query = sprintf ( "select * from bibl_publication_user where user_id=%s and publication_id=%s", $user_id, $item->id );
				echo "<h1>" . $query . "</h1>";
				$rows = $this->selectJustNative ( $query );
				
				$queryForUserDetec = sprintf ( "select user_id from bibl_publication_user where responsible=1 and publication_id=%s", $item->id );
				$rowsForUserDetec = $this->selectJustNative ( $queryForUserDetec );
				$user_of_this_pub = new User ();
				$user_of_this_pub->id = $rowsForUserDetec [0] ['user_id'];
				$user_of_this_pub = $this->get ( $user_of_this_pub );
				
				$item->user_responsible = $user_of_this_pub;
				
				if ($rows != null) {
					// echo "<br>" . $item->id . " not null";
					$row = $rows [0];
					$item->responsible = $row ['responsible'];
					$item->coauthor = $row ['coauthor'];
				} else {
					// echo "<br>" . $item->id . " ----null";
					$item->responsible = 0;
					$item->coauthor = 0;
				}
			} catch ( Exception $e ) {
				echo 'Выброшено исключение: ', $e->getMessage (), "\n";
			}
			
			// echo $item->id . ") " . $item->name . " " .$item->responsible . "-" .$item->coauthor . "<br>";
		}
		
		return $pubAll;
	}
	public function getFilteredPublicationsRespCoauthor($user_id, $resp_coauthor_condition = null) {
		$pubAll = $this->getPublicationsRespCoauthor ( $user_id );
		
		$pubFiltered = array ();
		
		if ($resp_coauthor_condition == null) {
			$pubFiltered = $pubAll;
		} else {
			foreach ( $pubAll as $item ) {
				if ($this->checkIfOneCondRetTrue ( $item, $resp_coauthor_condition )) {
					$pubFiltered [] = $item;
				}
			}
		}
		return $pubFiltered;
	}
	private function checkIfOneCondRetTrue($pubItem, $resp_coauthor_condition) {
		foreach ( $resp_coauthor_condition as $cond ) {
			if ($pubItem->responsible == $cond ['responsible'] && $pubItem->coauthor == $cond ['coauthor']) {
				return true;
			}
		}
		return false;
	}
	public function getFilteredPublicationsByType($publs, $type = null) {
		$pubFiltered = array ();
		if ($type == null) {
			return $publs;
		} else {
			foreach ( $publs as $item ) {
				if ($item->type_id == $type) {
					$pubFiltered [] = $item;
				}
			}
		}
		return $pubFiltered;
	}
	public function update($entity) {
		$queryStatement = FabricaQuery::createQuery ( $this->pdo, $entity );
		return $queryStatement->updateQuery ( $entity );
	}
	public function delete($entity) {
		$queryStatement = FabricaQuery::createQuery ( $this->pdo, $entity );
		return $queryStatement->deleteQuery ( $entity );
	}
	public function getYearDateFromRussianString($dateRus) {
		if (strlen ( $dateRus ) == 0) {
			return "null";
		}
		$parts = explode ( '/', $dateRus );
		return "'$parts[2]'";
	}
	public function getTestObject($object) {
	}
	public function selectJustNative($query) {
		$rows = array ();
		try {
			$stmt = $this->pdo->prepare ( $query );
			// $stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->execute ();
			$rows = $stmt->fetchAll ( PDO::FETCH_ASSOC );
		} catch ( PDOException $ex ) {
			echo "Ошибка:" . $ex->getMessage ();
		}
		return $rows;
	}
	
	/**
	 *
	 * @param unknown $query        	
	 * @return $count - количество удаленных записей
	 */
	public function deleteNative($query) {
		$count = 0;
		try {
			// $stmt = $this->pdo->prepare($query);
			// $stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$count = $this->pdo->exec ( $query );
		} catch ( PDOException $ex ) {
			echo "Ошибка:" . $ex->getMessage ();
		}
		return $count;
	}
	public function getListOfSectionsByIssueSections($listIssueSection) {
		$arrOfId = array ();
		foreach ( $listIssueSection as $key => $issueSectionEntity ) {
			$arrOfId [] = issueSectionEntity . id;
		}
		$comma_separated = implode ( ",", $arrOfId );
		$listOfSections = $this->selectQueryNative ( "select * from section where id in (" . $comma_separated . ")" );
		return $listOfSections;
	}
	function getKazKeywordsByPublicationId($publ_id) {
		return $this->getKeywordsByPublicationId ( $publ_id, "kaz" );
	}
	function getRusKeywordsByPublicationId($publ_id) {
		return $this->getKeywordsByPublicationId ( $publ_id, "rus" );
	}
	function getEngKeywordsByPublicationId($publ_id) {
		return $this->getKeywordsByPublicationId ( $publ_id, "eng" );
	}
	function getKeywordsByPublicationId($publ_id, $lang = null) {
		log_echo ( "START class_dao.php-getKeywordsByPublicationId" );
		global $dao;
		$array = array ();
		try {
			$object = new PublicationKeyword ();
			$array = $dao->getByNativeQuery ( $object, "select * from bibl_publication_keyword where publication_id=" . $publ_id );
			if (count ( $array ) > 0) {
				log_echo ( $array );
				$catIds = array_map ( create_function ( '$o', 'return $o->keyword_id;' ), $array );
				$comma_separated = implode ( ",", $catIds );
				$langAnd = "";
				if ($lang != null and $lang != "") {
					$langAnd = " and lang='" . $lang . "'";
				}
				$query = "select * from bibl_keyword where id in (" . $comma_separated . ")" . $langAnd;
				log_echo ( $query );
				$array = $dao->getByNativeQuery ( new Keyword (), $query );
				log_echo ( $array );
			}
		} catch ( Exception $e ) {
			echo 'Выброшено исключение: ', $e->getMessage (), "\n";
		}
		log_echo ( "START class_dao.php-getKeywordsByPublicationId" );
		return $array;
	}
	function getKeywordByNameAndLang($name, $lang) {
		// echo "<h3>start getKeywordByNameAndLang</h3>";
		log_echo ( "start getKeywordByNameAndLang" );
		global $dao;
		$keyword = new Keyword ();
		$array = $dao->getByNativeQuery ( new Keyword (), sprintf ( "select * from bibl_keyword where name = '%s' and lang='%s'", $name, $lang ) );
		if (count ( $array ) == 1) {
			$keyword = $array [0];
		} else {
			$keyword->name = $name;
			$keyword->lang = $lang;
			$id = $dao->insert ( $keyword );
			$keyword->id = $id;
		}
		log_echo ( "end getKeywordByNameAndLang" );
		return $keyword;
	}
	public function getListSectionByIssue($issueId) {
		log_echo ( "start getSectionBySection" );
		global $dao;
		$arrayRes  = array();
		$query = sprintf ( "select s.* from bibl_issue_section t \r\n
                  inner join bibl_section s on s.id=t.section_id  \r\n
                  where t.issue_id='%s' order by t.order_field, t.id", $issueId );
		$array = $dao->getByNativeQuery ( new Section (), $query );
		//echo "query:" . $query . "<br/>";
		if(count($array) > 0){
			$arrayRes = $array;
		}
		log_echo ( "end getSectionBySection" );
		return $arrayRes;
	}
	
	public function saveIssueSections($issueId, $arraySectionsId){
		global $dao;
		//$dao - 
		$deleteQuery = sprintf("delete from bibl_issue_section where issue_id = '%s'", $issueId);
		$this->deleteNative($deleteQuery);
		foreach($arraySectionsId as $secId){
			$issueSection = new IssueSection();
			$issueSection->section_id = $secId;
			$issueSection->issue_id = $issueId;
			$issueSection->order_field = 1;
			$dao->insert($issueSection);
		}
	}
}

?>
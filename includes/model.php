<?php
include_once 'config.php';
include_once 'objects.php';
include_once 'util.php';

class Model{
	private $pdo;

	function __construct(){
		$this->connect();
	}

	public function connect(){
		if($this->pdo == null){
			$connect_string = sprintf('mysql:host=%s;dbname=%s', HOST, DB_NAME);
			$this->pdo = new PDO($connect_string, DB_USER, DB_PASS,	array(PDO::ATTR_PERSISTENT => true));
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->query("SET NAMES 'utf8'");
		}
	}


	/**
	 * Возвращает последний (текущий) номер журнала со вложенными объектами
	 */
	function getLastIssue($lang='rus'){
		return $this->getIssue(0, $lang);
	}

	/**
	 * Возвращает номер журнала со вложенными объектами
	 */
	function getIssue($id, $lang='rus'){
		$issue = new Issue();
		$issue = $this->getOnlyIssue($id);
		//$issue->is_filled_by_papers = $this->isIssueFulledByPapers($id);
		$issue->section_array = $this->getSectionsByIssueId($issue->id, $lang);
		/* заполняем секции статьяти */
		$issue->section_array = $this->fillSectionsByPapers($issue->section_array, $issue->id, $lang);
		return $issue;
	}
	/**
	 * Возвращает номер журнала без вложенных объектов
	 */
	function getOnlyIssue($id=0){
		$issue = new Issue();
		$id = (int) $id;
		$query = "select * from bibl_issue where id=:id";
		try {
			if($id == 0){ // 0 - to get the last issue
				$stmt = $this->pdo->prepare("select * from bibl_issue where id=(select max(id) from bibl_issue)");
			}else{
				$stmt = $this->pdo->prepare($query);
				$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			}
			$stmt->execute();
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $ex) {
			exit("Error:" . $ex->getMessage());
		}
		if($stmt->rowCount() == 1){
			$issue->id = $row[0]['id'];
			$issue->year = $row[0]['year'];
			$issue->number = $row[0]['number'];
			$issue->issue = $row[0]['issue'];
			$issue->file = $row[0]['file'];
		}else{
			exit("Error: the issue with id $id not found");
		}
		return $issue;
	}

	function getPublicationsOfSpecifiedIssue($issueId='last', $lang='rus'){
		if($issueId=='last'){
			$issueId = '(select max(issue_id) from bibl_publication)';
		}
		$query="select p.*, \r\n" .
			"	(\r\n" . 
			"		select\r\n" . 
			"		GROUP_CONCAT(DISTINCT\r\n" . 
			"			 concat(\r\n" . 
			"			UCASE(LEFT(a.last_name_$lang, 1)),\r\n" . 
			"			LCASE(SUBSTRING(a.last_name_$lang, 2)),\r\n" . 
			"			' ',\r\n" . 
			"			UCASE(SUBSTRING(a.first_name_$lang,1,1)),\r\n" . 
			"			'.',\r\n" . 
			"			UCASE(SUBSTRING(a.patronymic_name_$lang,1,1)),\r\n" . 
			"			'.'\r\n" . 
			"			)\r\n" . 
			"			SEPARATOR ', '\r\n" . 
			"		)\r\n" . 
			"		from bibl_publication_author pa\r\n" . 
			"		inner join bibl_author a on pa.author_id=a.id\r\n" . 
			"		where pa.publication_id=p.id\r\n" . 
			"	)  AS authors,\r\n" . 
			"	(\r\n" . 
			"		select GROUP_CONCAT(distinct LCASE(k.name) SEPARATOR ', ') \r\n" . 
			"		from bibl_publication_keyword pk\r\n" . 
			"		inner join bibl_keyword k on pk.keyword_id=k.id\r\n" . 
			"		where pk.publication_id=p.id\r\n" . 
			"		and k.lang='$lang'\r\n" . 
			"	) AS keywords\r\n" . 
		// "	s.name AS section_name \r\n" .
			"from bibl_publication p \r\n" . 
		// "inner join bibl_section s on p.section_id=s.id \r\n" .
			"where p.issue_id=$issueId\r\n" . 
			"order by p.p_first";
		//printInHtml($query);
		$stmt = $this->pdo->query($query);
		/*
		 $stmtSectors = $pdo->query("select * from bibl_issue_section where issue_id=$issueId order by id");
		 $sectorArray = array();
		 foreach($stmtSectors as $sector) {
			$newSector = array();
		 }
		 */
		return $stmt;
	}
	/**
	 * Возвращает true, если в базе есть статьи для данного выпуска
	 */
	function isIssueFulledByPapers($issueId){
		$query="select p.* from bibl_publication p where issue_id=$issueId";
		//printInHtml($query);
		$stmt = $this->pdo->query($query);
		//printInHtml($stmt->rowCount());
		return ($stmt->rowCount() > 0);
	}

	function getSectionsByIssueId($issueId, $lang='rus'){
		$section_array = array();
		$section = new Section();
		$query = "SELECT  \r\n" .
				"  is_sec.id, \r\n" .
				"  is_sec.issue_id, \r\n" .
				"  is_sec.section_id, \r\n" .
				"  is_sec.order_field, \r\n" .
				"  s.name_kaz s_name_kaz, \r\n" .
				"  s.name_rus s_name_rus, \r\n" .
				"  s.name_eng s_name_eng \r\n" .
				"FROM " .
				"  bibl_issue_section is_sec \r\n" .
				"  INNER JOIN bibl_section s ON (is_sec.section_id = s.id) \r\n" .
				"WHERE is_sec.issue_id=:issue_id \r\n" .
				"ORDER BY \r\n" .
				"  is_sec.id";
		//printInHtml($query);
		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->bindValue(':issue_id', $issueId, PDO::PARAM_INT);
			$stmt->execute();
		} catch(PDOException $ex) {
			exit("Error:" . $ex->getMessage());
		}
		if($stmt->rowCount() > 0){
			foreach ($stmt as $row) {
				$section = new Section();
				$section->id = $row['section_id'];
				$section->name = $row['s_name_' . $lang];
				$section_array[] = $section;
			}
		}else{
			exit("Error: the issue with id $id not found");
		}
		return $section_array;
	}

	function fillSectionsByPapers($section_array, $issueId, $lang='rus'){
		//printInHtml("START fillSectionsByPapers");
		$stmtPubls = $this->getPublicationsOfSpecifiedIssue($issueId, $lang);
		$rowOfPublArray = array();
		foreach ($stmtPubls as $rowOfPubl){
			$rowOfPublArray[] = $rowOfPubl;
		}
		$section = new Section();
		foreach ($section_array as $section) {
			//printInHtml("<<< " . $section->id . " " .  $section->name);
			$section->publication_array = array();
			foreach ($rowOfPublArray as $rowOfPubl){
				//printInHtml($rowOfPubl['section_id']);
				//printInHtml($section->id . " <> " . $rowOfPubl['section_id']);
				if($section->id ==  $rowOfPubl['section_id']){
					//printInHtml("in equals");
					/**
					 public $id;
					 public $name;
					 public $abstract;
					 public $authors;
					 public $keywords;
					 public $udk;
					 public $email;
					 */
					$publObj = new Publication();
					$publObj->id = $rowOfPubl['id'];
					$publObj->name = $rowOfPubl['name_' . $lang];
					$publObj->abstract = $rowOfPubl['abstract_' . $lang];
					$publObj->authors = $rowOfPubl['authors'];
					$publObj->keywords = $rowOfPubl['keywords'];
					$publObj->udk = $rowOfPubl['udk'];
					$publObj->email = ''; //$rowOfPubl['udk'];
					$publObj->p_first = $rowOfPubl['p_first'];
					$publObj->p_last = $rowOfPubl['p_last'];
					$publObj->file = $rowOfPubl['file'];
					$section->publication_array[]=$publObj;
				}
			}
		}
		//printInHtml("FINISH fillSectionsByPapers");
		return $section_array;
	}
	/**
	 * Возвращает публикацию для вывода на странице реферата
	 */
	function getPublicationWithAbstract($id, $lang='rus'){
		$query="select p.*, \r\n" .
			"	(\r\n" . 
			"		select GROUP_CONCAT(distinct LCASE(k.name) SEPARATOR ', ') \r\n" . 
			"		from bibl_publication_keyword pk\r\n" . 
			"		inner join bibl_keyword k on pk.keyword_id=k.id\r\n" . 
			"		where pk.publication_id=p.id\r\n" . 
			"		and k.lang='$lang'\r\n" . 
			"	) AS keywords, \r\n" . 
		    "	s.name_$lang AS section_name \r\n" .
			"from bibl_publication p \r\n" . 
		    "inner join bibl_section s on p.section_id=s.id \r\n" .
			"where p.id = $id \r\n";
		//printInHtml($query);
		$stmt = $this->pdo->query($query);
		$publObj = new Publication();
		foreach ($stmt as $rowOfPubl){
			$publObj->id = $rowOfPubl['id'];
			$publObj->name = $rowOfPubl['name_' . $lang];
			$publObj->abstract = $rowOfPubl['abstract_' . $lang];
			$publObj->keywords = $rowOfPubl['keywords'];
			$publObj->udk = $rowOfPubl['udk'];
			$publObj->email = ''; //$rowOfPubl['udk'];
			$publObj->p_first = $rowOfPubl['p_first'];
			$publObj->p_last = $rowOfPubl['p_last'];
			$publObj->file = $rowOfPubl['file'];
			$publObj->sector_id = $rowOfPubl['sector_id'];
			$publObj->section_name = $rowOfPubl['section_name'];
			$publObj->code_udk = $rowOfPubl['code_udk'];
			$publObj->p_first = $rowOfPubl['p_first'];
			$publObj->p_last = $rowOfPubl['p_last'];
			$publObj->issue_id = $rowOfPubl['issue_id'];
		}
		$publObj->author_orgs = $this->getAuthorsAndOrgs($id, $lang);
		return $publObj;
	}

	function getAuthorsAndOrgs($pubId, $lang='rus'){
		$array_publ_authors = array();
		$array_authors = array();
		$array_orgs = array();
		$query = " select pa.*, \r\n" .
			" a.last_name_kaz,a.first_name_kaz,a.patronymic_name_kaz, \r\n" .
			" a.last_name_rus,a.first_name_rus,a.patronymic_name_rus, \r\n" .
			" a.last_name_eng,a.first_name_eng,a.patronymic_name_eng, \r\n" .
	        " a.email, \r\n" .
			" o.name_kaz organization_kaz, \r\n" .
			" o.name_rus organization_rus, \r\n" .
			" o.name_eng organization_eng  \r\n" .
			" from bibl_publication_author pa  \r\n" .
			" inner join bibl_author a on a.id=pa.author_id \r\n" .
			" inner join bibl_organization o on o.id=pa.organization_id \r\n" .
			" where pa.publication_id = $pubId";
		//printInHtml($query);
		$stmt = $this->pdo->query($query);
		foreach ($stmt as $row){
			$publicationAuthor = new PublicationAuthor();
			$publicationAuthor->publ_id = $pubId;
			$author = new Author();
			$author->id = $row['author_id'];
			$author->last_name = $row['last_name_' . $lang];
			$author->first_name = $row['first_name_' . $lang];
			$author->patronymic_name = $row['patronymic_name_' . $lang];
			$author->is_contact = $row['is_contact'];
			$author->email = $row['email'];
			$publicationAuthor->author = $author;
			$organization = new Organization();
			$organization->id = $row['organization_id'];
			$organization->name = $row['organization_' . $lang];
			$publicationAuthor->organization = $organization;
			$array_publ_authors[] =  $publicationAuthor;
		}
		$tempArray = array();
		foreach ($array_publ_authors as $publicationAuthor){
			if(!in_array($publicationAuthor->organization->id, $tempArray)){
				$array_orgs[] = $publicationAuthor->organization;
				$tempArray[] = $publicationAuthor->organization->id;
			}
		}
		foreach ($array_publ_authors as $publicationAuthor){
			$author = $publicationAuthor->author;
			foreach ($tempArray as $key => $value) {
				if($publicationAuthor->organization->id == $value){
					$author->org_num = $key + 1;
					$array_authors[] = $author;
				}
			}
		}

		$author_orgs = array($array_authors,$array_orgs);
		return $author_orgs;
	}
	public function getIssues(){
		$issue_array = array();
		$query = "select i.*,
				 (select count(*) from `bibl_publication` p where p.issue_id=i.id) pub_count
 				 from bibl_issue i 
				 order by id;";
		$stmt = $this->pdo->query($query);
		foreach ($stmt as $row) {
			$issue = new Issue();
			$issue->id = $row['id'];
			$issue->year = $row['year'];
			$issue->number = $row['number'];
			$issue->issue = $row['issue'];
			$issue->file = $row['file'];
			$issue->is_filled_by_papers = ($row['pub_count'] > 0);
			$issue_array[] = $issue;
		}
		return $issue_array;
	}
	public function insertPublStatistics($type="p",$itemId, $lang, $ip, $user_agent, $action='view'){
		$newId = 0;
		try {
			$query = "INSERT INTO
			  bibl_publication_statistics
			(
			  type,
			  item_id,
			  lang,
			  ip,
			  user_agent,
			  action
			) 
			VALUE (
			  :type,  
			  :item_id,
			  :lang,
			  :ip,
			  :user_agent,
			  :action
			)";
			//printInHtml($query);
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':type', $type, PDO::PARAM_STR);
			$stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
			$stmt->bindParam(':lang', $lang, PDO::PARAM_STR);
			$stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
			$stmt->bindParam(':user_agent', $user_agent, PDO::PARAM_STR);
			$stmt->bindParam(':action', $action, PDO::PARAM_STR);
			$stmt->execute();
			$newId = $this->pdo->lastInsertId();
		} catch(PDOException $ex) {
			exit("Error:" . $ex->getMessage());
		}
		
		return $newId;
	}
	/*
	 *   `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	 `search_text` VARCHAR(200) COLLATE utf8_general_ci NOT NULL DEFAULT '',
	 `search_criteria` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '',
	 `sortby` VARCHAR(4) COLLATE utf8_general_ci NOT NULL DEFAULT '',
	 `lang` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '',
	 `ip` VARCHAR(30) COLLATE utf8_general_ci DEFAULT NULL,
	 `user_agent` VARCHAR(200) COLLATE utf8_general_ci DEFAULT NULL,
	 */
	public function insertSerchStatistics($search_text, $search_criteria, $sortby,$lang, $ip, $user_agent){
		$newId = 0;
		try {
			$query = "INSERT INTO
					  bibl_search_statistics
					(
					  search_text,
					  search_criteria,
					  sortby,
					  lang,
					  ip,
					  user_agent
					 ) 
					VALUE (
					  :search_text,
					  :search_criteria,
					  :sortby,
					  :lang,
					  :ip,
					  :user_agent
					)";
			//printInHtml($query);
			$stmt = $this->pdo->prepare($query);
			$stmt->bindParam(':search_text', $search_text, PDO::PARAM_STR);
			$stmt->bindParam(':search_criteria', $search_criteria, PDO::PARAM_STR);
			$stmt->bindParam(':sortby', $sortby, PDO::PARAM_STR);
			$stmt->bindParam(':lang', $lang, PDO::PARAM_STR);
			$stmt->bindParam(':ip', $ip, PDO::PARAM_STR);
			$stmt->bindParam(':user_agent', $user_agent, PDO::PARAM_STR);
			$stmt->execute();
			$newId = $this->pdo->lastInsertId();
		} catch(PDOException $ex) {
			exit("Error:" . $ex->getMessage());
		}
		return $newId;
	}
	/**
	 *
	 * Получаем список статей по критерию
	 * @param $issueId
	 * @param $lang
	 */
	function getPublicationsByCriteria($str, $criteria, $lang, $sortBy="asc"){
		$str = trim($str);
		$str = mb_strtoupper($str);
		$where="";
		$having="";
		if($criteria=='title'){
			$where = "".
			" and p.name_kaz like '%" .$str . "%'" . 
			" or  p.name_rus like '%" .$str . "%'" .
			" or  p.name_eng like '%" .$str . "%'"; 
		} elseif ($criteria=='keywords'){
			$having = "".
			" and keywords_kaz like '%" .$str . "%'" . 
			" or  keywords_rus like '%" .$str . "%'" .
			" or  keywords_eng like '%" .$str . "%'"; 
		} elseif ($criteria=='author'){
			$having = "".
			" and authors_kaz like '%" .$str . "%'" . 
			" or  authors_rus like '%" .$str . "%'" .
			" or  authors_eng like '%" .$str . "%'"; 
		} elseif ($criteria=='abstract'){
			$where = "".
			" and UCASE(abstract_kaz) like '%" .$str . "%'" . 
			" or  UCASE(abstract_rus) like '%" .$str . "%'" .
			" or  UCASE(abstract_eng) like '%" .$str . "%'"; 
		}
		$query="select p.*, i.year i_year, i.number i_number, i.issue i_issue,  \r\n" .
			"	(\r\n" . 
			"		select\r\n" . 
			"		GROUP_CONCAT(DISTINCT\r\n" . 
			"			 concat(\r\n" . 
			"			UCASE(LEFT(a.last_name_$lang, 1)),\r\n" . 
			"			LCASE(SUBSTRING(a.last_name_$lang, 2)),\r\n" . 
			"			' ',\r\n" . 
			"			UCASE(SUBSTRING(a.first_name_$lang,1,1)),\r\n" . 
			"			'.',\r\n" . 
			"			UCASE(SUBSTRING(a.patronymic_name_$lang,1,1)),\r\n" . 
			"			'.'\r\n" . 
			"			)\r\n" . 
			"			SEPARATOR ', '\r\n" . 
			"		)\r\n" . 
			"		from bibl_publication_author pa\r\n" . 
			"		inner join bibl_author a on pa.author_id=a.id\r\n" . 
			"		where pa.publication_id=p.id\r\n" . 
			"	)  AS authors,\r\n" .

			"	(select\r\n" . 
			"		GROUP_CONCAT(DISTINCT\r\n" . 
			"			concat(UCASE(a.last_name_kaz), ' ', UCASE(a.first_name_kaz),' ', UCASE(a.patronymic_name_kaz)\r\n" . 
			"			)\r\n" . 
			"			SEPARATOR ', '\r\n" . 
			"		)\r\n" . 
			"		from bibl_publication_author pa\r\n" . 
			"		inner join bibl_author a on pa.author_id=a.id\r\n" . 
			"		where pa.publication_id=p.id\r\n" . 
			"	)  AS authors_kaz,\r\n" . 

			"	(select\r\n" . 
			"		GROUP_CONCAT(DISTINCT\r\n" . 
			"			concat(UCASE(a.last_name_rus), ' ', UCASE(a.first_name_rus),' ', UCASE(a.patronymic_name_rus))\r\n" . 
			"			SEPARATOR ', '\r\n" . 
			"		)\r\n" . 
			"		from bibl_publication_author pa\r\n" . 
			"		inner join bibl_author a on pa.author_id=a.id\r\n" . 
			"		where pa.publication_id=p.id\r\n" . 
			"	)  AS authors_rus,\r\n" . 

			"	(select\r\n" . 
			"		GROUP_CONCAT(DISTINCT\r\n" . 
			"			concat(UCASE(a.last_name_eng), ' ', UCASE(a.first_name_eng),' ', UCASE(a.patronymic_name_eng))\r\n" . 
			"			SEPARATOR ', '\r\n" . 
			"		)\r\n" . 
			"		from bibl_publication_author pa\r\n" . 
			"		inner join bibl_author a on pa.author_id=a.id\r\n" . 
			"		where pa.publication_id=p.id\r\n" . 
			"	)  AS authors_eng,\r\n" . 

			"	(\r\n" . 
			"		select GROUP_CONCAT(distinct LCASE(k.name) SEPARATOR ', ') \r\n" . 
			"		from bibl_publication_keyword pk\r\n" . 
			"		inner join bibl_keyword k on pk.keyword_id=k.id\r\n" . 
			"		where pk.publication_id=p.id\r\n" . 
			"		and k.lang='$lang'\r\n" . 
			"	) AS keywords,\r\n" . 

		"	(\r\n" . 
			"		select GROUP_CONCAT(distinct LCASE(k.name) SEPARATOR ', ') \r\n" . 
			"		from bibl_publication_keyword pk\r\n" . 
			"		inner join bibl_keyword k on pk.keyword_id=k.id\r\n" . 
			"		where pk.publication_id=p.id\r\n" . 
			"		and k.lang='kaz'\r\n" . 
			"	) AS keywords_kaz,\r\n" . 
		"	(\r\n" . 
			"		select GROUP_CONCAT(distinct LCASE(k.name) SEPARATOR ', ') \r\n" . 
			"		from bibl_publication_keyword pk\r\n" . 
			"		inner join bibl_keyword k on pk.keyword_id=k.id\r\n" . 
			"		where pk.publication_id=p.id\r\n" . 
			"		and k.lang='rus'\r\n" . 
			"	) AS keywords_rus,\r\n" . 
		"	(\r\n" . 
			"		select GROUP_CONCAT(distinct LCASE(k.name) SEPARATOR ', ') \r\n" . 
			"		from bibl_publication_keyword pk\r\n" . 
			"		inner join bibl_keyword k on pk.keyword_id=k.id\r\n" . 
			"		where pk.publication_id=p.id\r\n" . 
			"		and k.lang='eng'\r\n" . 
			"	) AS keywords_eng\r\n" . 

		// "	s.name AS section_name \r\n" .
			"from bibl_publication p \r\n" . 
		// "inner join bibl_section s on p.section_id=s.id \r\n" .
		   "inner join bibl_issue i on p.issue_id=i.id \r\n" .
			 "where 1=1 " . $where . "\r\n" .
			 "having 1=1 " . $having . "\r\n" .  
			"order by p.issue_id " . $sortBy . ", p.p_first " . $sortBy;
		//printInHtml($query);
		$stmt = $this->pdo->query($query);
		$rowOfPublArray = array();

		foreach ($stmt as $rowOfPubl){
			//printInHtml($rowOfPubl['section_id']);
			//printInHtml($section->id . " <> " . $rowOfPubl['section_id']);
			/**
			 public $id;
			 public $name;
			 public $abstract;
			 public $authors;
			 public $keywords;
			 public $udk;
			 public $email;
			 */
			$publObj = new Publication();
			$publObj->id = $rowOfPubl['id'];
			$publObj->name = $rowOfPubl['name_' . $lang];
			$publObj->abstract = $rowOfPubl['abstract_' . $lang];
			$publObj->authors = $rowOfPubl['authors'];
			$publObj->keywords = $rowOfPubl['keywords'];
			$publObj->udk = $rowOfPubl['udk'];
			$publObj->email = ''; //$rowOfPubl['udk'];
			$publObj->p_first = $rowOfPubl['p_first'];
			$publObj->p_last = $rowOfPubl['p_last'];
			$publObj->file = $rowOfPubl['file'];
			//year i_year, number i_number, issue i_issue
			$publObj->year = $rowOfPubl['i_year'];
			$publObj->number = $rowOfPubl['i_number'];
			$publObj->issue = $rowOfPubl['i_issue'];
			$rowOfPublArray[] = $publObj;
		}
		return $rowOfPublArray;
	}

} //end of class

?>
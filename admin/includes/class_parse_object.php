<?php
include_once 'includes/class_publication.php';

abstract class ParseForm{
	protected  $parsedObject;
	protected $request;


	public function __construct($request){
		foreach ($request as $key => $value){
			$request[$key] = $this->getNullForObjectFieldIfStringEmpty($value);
		}
		if(isset($_SESSION['user'])){
			$request['user'] = $_SESSION['user']['username_email'];
			//var_dump($_SESSION['user']);
		}
		$this->request=$request;
	}

	public abstract function parse();

	protected function getNullForObjectFieldIfStringEmpty($val){
		if(gettype($val) == "array"){
			foreach ($val as $key => $value){
				$val[$key] = $this->getNullForObjectFieldIfStringEmpty($value);
			}
			return $val;
		}
		if(!isset($val)){
			return null;
		}
		if($val == null){
			return null;
		}
		//$val = trim(mysql_real_escape_string($val));
		$val = trim($val);
		$val = strval($val);
		//echo strlen ($str) . "<br>";
		if(strlen ($val) == 0){
			return null;
		}
		return 	$val;
	}

	public  function getParsedObject(){
		return  $this->parsedObject;
	}
}

class ParsePublication extends ParseForm{

	public function __construct($request){
		parent::__construct($request);
		//$this->request=$request;
	}

	public function parse(){
		log_echo("<<<start ParseForm.parse</h3>");
		$this->parsedObject = new Publication();
		$object = $this->parsedObject;
		$request=$this->request;

		$fields = $object->getFields();

		foreach ($fields as $f_name => $value) {
			if(isset($request[$f_name])){
				if($f_name=='patent_date'){
					//$object->patent_date=getDateFromFormatDate($request['patent_date']);
					$object->$f_name = getDateFromFormatDate($request[$f_name]);
				}else{
					$object->$f_name = $request[$f_name];
				}
			}
		}
		
		$object->author_orgs_array = $this->getAuthorsFromRequest();
		$object->keywords_array = $this->getKeyWordsFromRequest();//$this->mergeKeywordFromAllLangs($keywords_kaz,$keywords_rus,$keywords_eng);
		log_echo($object->author_orgs_array);
		log_echo($object->keywords_array);
		log_echo(">>>end ParseForm.parse</h3>");
	}
	
	function getAuthorsFromRequest(){
		$author_orgs_array = array();
		$request = $this->request;
		
		if(isset($request['authors_orgs'])){
			try{
				$authors_orgs = $request['authors_orgs']; //array("1^1", "3^1","4^3");
				$is_contacts =  $request['is_contact'];
				log_echo("<<< is_contacts");
				log_echo($is_contacts);
				log_echo(">>>");
				foreach($authors_orgs as $key => $item) {
					$arr = explode("^",$item);
					$pubAuthorObj = new PublicationAuthor();
					$pubAuthorObj->author_id = $arr[0];
					$pubAuthorObj->organization_id = $arr[1];
					$pubAuthorObj->is_contact = 0;
					$is_contact_of_this_author = ($item == $is_contacts);
					log_echo("is_contact_of_this_author:$is_contact_of_this_author");
					if($is_contact_of_this_author){
						$pubAuthorObj->is_contact = 1;
					}
					$author_orgs_array[] = $pubAuthorObj;
				}
			} catch (Exception $e) {
				echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
			}
		}else{
			die("поле authors_orgs отсутствует");
		}
		return $author_orgs_array;
	}
	
	function getKeyWordsFromRequest(){
		$request = $this->request;
		$keywords_array = array();
		$keywords_kaz = array();
		$keywords_rus = array();
		$keywords_eng = array();
		if(isset($request['keywords_kaz'])){
			$keywords_kaz = $this->getKeywords($request['keywords_kaz'],"kaz");
		}else{
			die("поле keywords_kaz отсутствует");
		}
		if(isset($request['keywords_rus'])){
			$keywords_rus = $this->getKeywords($request['keywords_rus'],"rus");
		}else{
			die("поле keywords_rus отсутствует");
		}
		if(isset($request['keywords_eng'])){
			$keywords_eng = $this->getKeywords($request['keywords_eng'],"eng");
		}else{
			die("поле keywords_rus отсутствует");
		}
		
		$keywords_array = $this->mergeKeywordFromAllLangs($keywords_kaz,$keywords_rus,$keywords_eng);
		return $keywords_array;
	}
	
	function mergeKeywordFromAllLangs($keywords_kaz, $keywords_rus,$keywords_eng){
		$countKaz = count($keywords_kaz);
		$countRus = count($keywords_rus);
		$countEng = count($keywords_eng);
		if(($countKaz <> $countRus) or ($countKaz <> $countEng) ) {
			throw new Exception(sprintf("Разное количество ключевых слов для казахского (n=%s), русского (n=%s) и английского языков (n=%s)", $countKaz, $countRus, $countEng));
		}
		//echo "<h3>keywords before:".$keywords."</h3>";
		$keywords = array_merge($keywords_kaz, $keywords_rus, $keywords_eng);
		return $keywords;
	}
	
	function getKeywords($keywords, $lang){
		try{
			//echo "<h3>keywords before:".$keywords."</h3>";
			$keywords = trim($keywords); // убираем пробелы по бокам
			$keywords = trim($keywords,","); // убираем запятые по бока
			$keywords = trim($keywords); // опять убираем пробелы по бокам
			$keywords = str_replace(", ", ",", $keywords); // убираем пробеы после запятых
			$pieces = explode(",", $keywords);
			$pieces = array_map('trim', $pieces); //убираем пробелы по бокам во всех элементах массива
			$pieces = array_map("mb_strtoupper", $pieces); //переводим все элементы в верхний регистр
			$arrayOfKeywords = array();
			foreach($pieces as $str){
				$keywObj = new Keyword();
				$keywObj->name = $str;
				$keywObj->lang = $lang;
				$arrayOfKeywords[] = $keywObj;
			}
			return $arrayOfKeywords;
		}catch (Exception $e) {
			echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
		}
	}
	
}


class ParseTezis extends ParseForm{

	public function __construct($request){
		parent::__construct($request);
		//$this->request=$request;
	}

	public function parse(){
		exit("ParseTezis deprecated");
		$this->parsedObject = new Publication();
		$object = $this->parsedObject;
		$request=$this->request;

		$object->id=$request['id'];
		$object->name=$request['name'];

		$object->type_id=$request['type_id'];

		$object->p_first=$request['p_first'];
		$object->p_last=$request['p_last'];

		$object->conference_name=$request['conference_name'];
		$object->conference_city=$request['conference_сity'];
		$object->conference_country=$request['conference_country'];
		$object->conference_type_id=$request['conference_type_id'];
		$object->conference_level_id=$request['conference_level_id'];
		$object->conference_type_pub_id=$request['conference_type_pub_id'];
		$object->conference_date_start=getDateFromFormatDate($request['conference_date_start']);
		$object->conference_date_finish=getDateFromFormatDate($request['conference_date_finish']);

		//echo "<h1>" . $request['conference_date_start'] . "</h1>";
		//var_dump($object);



		$object->user=$request['user'];

		/* foreign keys (arrays) */

		$authors_last_names = array();
		if(isset($request['c07_authors_lastname'])){
			$authors_ids = isset($request['c07_authors_id']) ? $request['c07_authors_id'] : null ;
			$authors_l_names = $request['c07_authors_lastname'];
			$authors_f_names = $request['c07_authors_firstname'];
			$authors_p_names = $request['c07_authors_patrname'];
			$authors_places_work = $request['c08_place_working_authors'];

			//["c07_authors_me"]=>
			//exit("What about c07_authors_me?");
			if(count($authors_l_names) > 1 ||  (count($authors_l_names) == 1 && trim($authors_l_names[0]) != "")){

				for ($i = 0; $i < count($authors_l_names); $i++) {
					$author = new Author();
					$author->publication_id = $object->id != 0 ? $object->id : null;
					if($authors_ids != null && isset($authors_ids[$i])){
						$author->id =  $authors_ids[$i];
					}
					$author->last_name = $authors_l_names[$i];
					$author->first_name = $authors_f_names[$i];
					$author->patronymic_name = $authors_p_names[$i];
					$author->organization_name = $authors_places_work[$i];
					$object->authors_array[] = $author;
				}
			}
		}
	}
}

class ParsePatent extends ParseForm{

	public function __construct($request){
		parent::__construct($request);
		//$this->request=$request;
	}

	public function parse(){
		exit("ParsePatent deprecated");
		$this->parsedObject = new Publication();
		$object = $this->parsedObject;
		$request=$this->request;

		$object->id=$request['id'];
		$object->name=$request['name'];

		$object->type_id=$request['type_id'];

		$object->patent_type_id=$request['patent_type_id'];
		$object->patent_type_number=$request['patent_type_number'];
		$object->patent_date=getDateFromFormatDate($request['patent_date']);

		$object->user=$request['user'];

		/* foreign keys (arrays) */

		$authors_last_names = array();
		if(isset($request['c07_authors_lastname'])){
			$authors_ids = isset($request['c07_authors_id']) ? $request['c07_authors_id'] : null ;
			$authors_l_names = $request['c07_authors_lastname'];
			$authors_f_names = $request['c07_authors_firstname'];
			$authors_p_names = $request['c07_authors_patrname'];
			$authors_places_work = $request['c08_place_working_authors'];

			//["c07_authors_me"]=>
			//exit("What about c07_authors_me?");
			if(count($authors_l_names) > 1 ||  (count($authors_l_names) == 1 && trim($authors_l_names[0]) != "")){

				for ($i = 0; $i < count($authors_l_names); $i++) {
					$author = new Author();
					$author->publication_id = $object->id != 0 ? $object->id : null;
					if($authors_ids != null && isset($authors_ids[$i])){
						$author->id =  $authors_ids[$i];
					}
					$author->last_name = $authors_l_names[$i];
					$author->first_name = $authors_f_names[$i];
					$author->patronymic_name = $authors_p_names[$i];
					$author->organization_name = $authors_places_work[$i];
					$object->authors_array[] = $author;
				}
			}
		}
	}
}


class ParseBook extends ParseForm{

	public function __construct($request){
		parent::__construct($request);
		//$this->request=$request;
	}

	public function parse(){
		$this->parsedObject = new Publication();
		$object = $this->parsedObject;
		$request=$this->request;

		$object->id=$request['id'];
		$object->name=$request['name'];

		$object->type_id=$request['type_id'];

		$object->year=$request['year'];
		$object->book_city=$request['book_city'];
		$object->book_pages=$request['book_pages'];
		$object->izdatelstvo=$request['izdatelstvo'];


		$object->code_udk=$request['code_udk'];
		$object->method_recom_bbk=$request['method_recom_bbk'];
		$object->journal_issn=$request['journal_issn'];
		$object->isbn=$request['isbn'];
		$object->method_recom_edited=$request['method_recom_edited'];
		$object->method_recom_stated=$request['method_recom_stated'];
		$object->method_recom_approved=$request['method_recom_approved'];
		$object->method_recom_published_with_the_support=$request['method_recom_published_with_the_support'];
		$object->abstract_original=$request['abstract_original'];
		$object->method_recom_reviewers=$request['method_recom_reviewers'];
		$object->number_tables=$request['number_tables'];
		$object->number_ilustrations=$request['number_ilustrations'];





		$object->user=$request['user'];

		/* foreign keys (arrays) */

		$authors_last_names = array();
		if(isset($request['c07_authors_lastname'])){
			$authors_ids = isset($request['c07_authors_id']) ? $request['c07_authors_id'] : null ;
			$authors_l_names = $request['c07_authors_lastname'];
			$authors_f_names = $request['c07_authors_firstname'];
			$authors_p_names = $request['c07_authors_patrname'];
			$authors_places_work = $request['c08_place_working_authors'];

			//["c07_authors_me"]=>
			//exit("What about c07_authors_me?");
			if(count($authors_l_names) > 1 ||  (count($authors_l_names) == 1 && trim($authors_l_names[0]) != "")){

				for ($i = 0; $i < count($authors_l_names); $i++) {
					$author = new Author();
					$author->publication_id = $object->id != 0 ? $object->id : null;
					if($authors_ids != null && isset($authors_ids[$i])){
						$author->id =  $authors_ids[$i];
					}
					$author->last_name = $authors_l_names[$i];
					$author->first_name = $authors_f_names[$i];
					$author->patronymic_name = $authors_p_names[$i];
					$author->organization_name = $authors_places_work[$i];
					$object->authors_array[] = $author;
				}
			}
		}
	}
}

class ParseUser extends ParseForm{

	public function __construct($request){
		parent::__construct($request);
		//$this->request=$request;
	}

	public function parse(){
		$this->parsedObject = new User();
		$object = $this->parsedObject;
		$request=$this->request;

		$object->id=$request['id'];
		$object->username_email=$request['username_email'];
		$object->password=$request['password'];
		$object->last_name=$request['last_name'];
		$object->first_name=$request['first_name'];
		$object->patronymic_name=$request['patronymic_name'];
		$object->last_name_en=$request['last_name_en'];
		$object->first_name_en=$request['first_name_en'];
		$object->patronymic_name_en=$request['patronymic_name_en'];
		$object->departament=$request['departament'];
		$object->status=$request['status'];
		$object->sex_id=$request['sex_id'];
		//$object->date_birth=$request['date_birth'];
		//$object->project=$request['project'];
		//$object->comments=$request['comments'];

	}
}

class ParseAuthor extends ParseForm{

	public function __construct($request){
		parent::__construct($request);
		//$this->request=$request;
	}

	public function parse(){
		$this->parsedObject = new Author();
		$object = $this->parsedObject;
		$request=$this->request;

		$object->id=$request['id'];
		$object->last_name_kaz=$this->trim_and_to_upper($request['last_name_kaz']);
		$object->first_name_kaz=$this->trim_and_to_upper($request['first_name_kaz']);
		$object->patronymic_name_kaz=$this->trim_and_to_upper($request['patronymic_name_kaz']);
		
		$object->last_name_rus=$this->trim_and_to_upper($request['last_name_rus']);
		$object->first_name_rus=$this->trim_and_to_upper($request['first_name_rus']);
		$object->patronymic_name_rus=$this->trim_and_to_upper($request['patronymic_name_rus']);
		
		$object->last_name_eng=$this->trim_and_to_upper($request['last_name_eng']);
		$object->first_name_eng=$this->trim_and_to_upper($request['first_name_eng']);
		$object->patronymic_name_eng=$this->trim_and_to_upper($request['patronymic_name_eng']);
		
		$object->organization_name=null;
		$object->organization_id=$request['organization_id'];
		$object->email=$request['email'];
		$object->degree=$request['degree'];
		$object->user=$request['user'];

	}
	
	function trim_and_to_upper($str){
		$str = trim($str);
		$str = mb_strtoupper($str);
		return $str;
	}
	
}

class ParseOrganizationAuthor extends ParseForm{

	public function __construct($request){
		parent::__construct($request);
		//$this->request=$request;
	}

	public function parse(){
		$this->parsedObject = new Organization();
		$object = $this->parsedObject;
		$request=$this->request;

		$object->id=$request['id'];
		$object->name_kaz=$request['name_kaz'];
		$object->name_rus=$request['name_rus'];
		$object->name_eng=$request['name_eng'];
	}
}

class ParseSection extends ParseForm{

	public function __construct($request){
		parent::__construct($request);
		//$this->request=$request;
	}

	public function parse(){
		$this->parsedObject = new Section();
		$object = $this->parsedObject;
		$request=$this->request;

		$object->id=$request['id'];
		$object->name_kaz=$request['name_kaz'];
		$object->name_rus=$request['name_rus'];
		$object->name_eng=$request['name_eng'];
	}
}

class ParseIssue extends ParseForm{
	public function __construct($request){
		parent::__construct($request);
		//$this->request=$request;
	}
	
	public function parse(){
		$this->parsedObject = new Issue();
		$object = $this->parsedObject;
		$request=$this->request;
		$object->id=$request['id'];
		$object->year=$request['year'];
		$object->number=$request['number'];
		$object->issue=$request['issue'];
		$object->file=$request['file'];
	}
}


?>
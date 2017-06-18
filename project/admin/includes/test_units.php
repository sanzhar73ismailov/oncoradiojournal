<?php
class User1{
	public $name;
	public $age;
	
}


function checkGetPublicationsRespCoauthor (){
	
	global $dao;
	$entity = new Publication();
	$pubs = $dao->getPublicationsRespCoauthor(5);
	//var_dump($pubs);
	
}

function test_object(){
	$user = new User1();
	$f_name = "name";
	//$user->{"name"} = "123123";
	$user->{$f_name} = "777555123123";
	echo $user->name;
	
	
}

function test_getAll(){
	global $dao;
	$entity = new Author();
	//$pubs = $dao->getPublicationsRespCoauthor(5);

	//$array = $dao->getAll($entity);
	//getByNativeQuery
	//selectQueryAll
	//$array = $dao->getByNativeQuery($entity,"select * from bibl_author order by last_name_rus");
	$array = $dao->selectQueryAll($entity,"select * from bibl_author order by last_name_rus");
	echo "<h1>".count($array) . "</h1>";
	
	foreach ($array as $key => $value){
		echo "<h3>". $value->last_name_rus . "</h3>";
	}
}

function test_getAllPubls(){
	global $dao;
	$object = new Publication();
	$object->type_id = PAPER;
	$publs = $dao->getAll($object);
	foreach ($publs as $key=>$publcation){
		echo "$key) $publcation->id $publcation->name<br/>";
		var_dump($publcation->authors_array);
	}
}

function test_getAllKeywords(){
	global $dao;
	$object = new Keyword();
	$array = $dao->getAll($object);
	var_dump($array);
}

function test_getAllKeywordsByLang(){
	global $dao;
	$object = new PublicationKeyword();
	$publ_id = 4;
	$lang = "kaz";
	$array = $dao->getByNativeQuery($object, "select * from bibl_publication_keyword where publication_id=" .  $publ_id);
	var_dump($array);
	$catIds = array_map(create_function('$o', 'return $o->id;'), $array);
	var_dump($catIds);
	$comma_separated = implode(",", $catIds);
	var_dump($comma_separated);
	$array = $dao->getByNativeQuery(new Keyword(), "select * from bibl_keyword where id in (" .  $comma_separated .")". " and lang='" . $lang . "'");
	var_dump($array);
}

function test_getAllKeywordsByLang2(){
	global $dao;
	$object = new PublicationKeyword();
	$array = $dao->getKeywordsByPublicationId(4);
	var_dump($array);
	$array = $dao->getKeywordsByPublicationId(4, "rus");
	var_dump($array);
	//$array = $dao->getEngKeywordsByPublicationId(4);
	//var_dump($array);
}


function test_getListSectionByIssue(){
	global $dao;
	$array = $dao->getListSectionByIssue(1);
	var_dump($array);
}
function test_getAllSections(){
	global $dao;
	$object = new Section();
	$list = $dao->getAll($object);
	foreach ($list as $key=>$entity){
		echo "$key) $entity<br/>";
	}
}

function test_getSectionsByIssue($issueId){
	global $dao;
	$list = $dao->getByNativeQuery( new IssueSection(), "select is_sec.*, s.name as section_name  from bibl_issue_section is_sec 
			inner join bibl_section s on (is_sec.section_id=s.id) where is_sec.issue_id=" . $issueId);
	foreach ($list as $key=>$entity){
		echo "$key) $entity<br/>";
	}
}

//getListOfSectionsByIssueSections
function test_getSectionsObjectsByListOfIssuesIssue($issueId){
	global $dao;
	$listSections = $dao->getByNativeQuery( new IssueSection(), "select * from bibl_issue_section where issue_id=" . $issueId);
	
	$list = $dao->getListOfSectionsByIssueSections($listSections);
	foreach ($list as $key=>$entity){
		echo "$key) $entity<br/>";
	}
}

function test_json(){
	$obj = new User1();
	$obj->name = "Вася";
	$obj->age = 11;
	
	$obj2 = new User1();
	$obj2->name = "John";
	$obj2->age = 16;
	
	$coded1 = json_encode($obj); 
	echo $coded1;
	
	$coded2 = json_encode($obj2); 
	echo $coded2;
	
	$decoded = json_decode($coded1); 
	var_dump($decoded);
}

function test_mail(){
	
	$to = "sanzhar73@gmail.com";
	$from= ADMIN_EMAIL; 
	$subject= "тест"; 
	$message= "привет";
	echo "<h1>test mail</h1><br>"; 
	
	$subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: $from\r\n";

	
	
	$res = mail_utf8($to, $from, $subject, $message);
	//$res = mail($to, $subject, $message, $headers);
	echo "<h1>result:". $res . "</h1><br>";
	

	/*
$message = "Line 1\nLine 2\nLine 3";

// На случай если какая-то строка письма длиннее 70 символов мы используем wordwrap()
$message = wordwrap($message, 70);

// Отправляем

$res= mail('sanzhar73@gmail.com', 'My Subject', $message);
echo "<h1>result:". $res . "</h1><br>";
*/
}
function get_publ_array(){
	$arr = array("id",
  "name",
  "abstract_original",
  "abstract_rus",
  "abstract_kaz",
  "abstract_eng",
  "language",
  "keywords",
  "number_ilustrations",
  "number_tables",
  "number_references",
  "number_references_kaz",
  "code_udk",
  "type_id",
  "journal_id",
  "journal_name",
  "journal_country",
  "journal_issn",
  "journal_periodicity",
  "journal_izdatelstvo_mesto_izdaniya",
  "year",
  "month",
  "day",
  "number",
  "volume",
  "issue",
  "p_first",
  "p_last",
  "pmid",
  "conference_name",
  "conference_city",
  "conference_country",
  "conference_type_id",
  "conference_level_id",
  "conference_type_pub_id",
  "conference_date_start",
  "conference_date_finish",
  "patent_type_id",
  "patent_type_number",
  "patent_date",
  "book_city",
  "book_pages",
  "izdatelstvo",
  "user");
	return $arr;
}

function create_script(){
	$arr = get_publ_array();
	foreach ($arr as $value){
		//echo sprintf("\$investigation->%s= \$this->getNullForObjectFieldIfStringEmpty(\$request['%s']);<br>",$value,$value);
		//echo sprintf("\$investigation->%s=\$row[0]['%s'];<br>", $value,$value);
		//echo sprintf("<td>{if \$item->%s == null} - {else} + {/if}</td>\n", $value);

		//echo sprintf("<th>%s</th>\n", ++$i);

		//echo sprintf("\$investigation->%s= \$this->getNullForObjectFieldIfStringEmpty(\$request['%s']);<br>",$value,$value);
		//echo sprintf("\$investigation->%s=\$row[0]['%s'];<br>", $value,$value);
		echo sprintf("\$stmt->bindValue(':%s', \$this->object->%s, PDO::PARAM_STR);<br>", $value,$value);


	}

}
function checkUser(){
	//$obj = new User();
	//$obj->first_name="Петр";
	//$_SESSION['user1'] = $obj;
	//var_dump($obj);
	var_dump($_SESSION['user']['first_name']);

}

function test_insert_publication($id=null){

	global $dao;
	$entity = new Publication();
	$entity->id = $id;
	$object = TestObjectCreator::createTstObject($entity);
	var_dump($object);
	echo "<p><p>----------------";
	$insertId =$dao->insert($object);
	echo("insertId=$insertId<br>");
	return $insertId;
}

function test_insert_author(){
	global $dao;
	$object = TestObjectCreator::createTstObject(new Author());
	$insertId =$dao->insert($object);
	echo("insertId=$insertId<br>");
	return $insertId;
}

function test_update_author(){
	global $dao;
	$object = TestObjectCreator::createTstObject(new Author());
	$insertId =$dao->update($object);
	echo("updateId=$insertId<br>");
	return $insertId;
}

function test_insert_organization(){
	global $dao;
	$object = TestObjectCreator::createTstObject(new Organization());
	$insertId =$dao->insert($object);
	echo("insertId=$insertId<br>");
	return $insertId;
}

function test_update_organization(){
	global $dao;
	$object = TestObjectCreator::createTstObject(new Organization());
	$object->id = 2;
	$insertId =$dao->update($object);
	echo("insertId=$insertId<br>");
	return $insertId;
}

function test_insert_reference(){
	global $dao;
	$object = TestObjectCreator::createTstObject(new Reference());
	$insertId =$dao->insert($object);
	echo("insertId=$insertId<br>");
	return $insertId;
}

function test_select_author(){
	global $dao;
	$insertId =test_insert_author();
	//echo(  "insertId=$insertId<br>");

	$objectToGet = new Author();
	$objectToGet->id = $insertId;
	$objectToGet = $dao->get($objectToGet);
	var_dump($objectToGet);
}

function test_select_reference(){
	global $dao;
	$insertId =test_insert_reference();
	//echo(  "insertId=$insertId<br>");

	$objectToGet = new Reference();
	$objectToGet->id = $insertId;
	$objectToGet = $dao->get($objectToGet);
	var_dump($objectToGet);
}

function test_select_author_by_condition(){
	global $dao;


	// $pub_id = test_insert_publication();
	$pub_id = 82398;
	$publQuery =FabricaQuery::createQuery($dao->getPdo(), new Author());
	$arr = $publQuery->selectQueryManyByCondition(array(
	new QueryCondition("publication_id", $pub_id, "<"),
	new QueryCondition("first_name", '%гоша', "like")
	), "last_name desc");

	var_dump($arr);
}

function test_select_reference_by_condition(){
	global $dao;


	// $pub_id = test_insert_publication();
	$pub_id = 36377;
	$publQuery =FabricaQuery::createQuery($dao->getPdo(), new Reference());
	$arr = $publQuery->selectQueryManyByCondition(array(
	new QueryCondition("publication_id", $pub_id, "=")
	), "name desc");

	var_dump($arr);
}

function getListOfSectionsForThisJournal($issue_id){
	global $dao;
	$listIssueSection = $dao->getByNativeQuery( new IssueSection(), "select * from bibl_issue_section where issue_id=" . $issue_id);
	//var_dump($issue_id);
	//var_dump($listIssueSection);
	$sectionArray = array();
	echo "<hr/>";
	foreach ($listIssueSection as $key => $issueSection){
		//var_dump($issueSection);
		$sectionEntity = new Section();
		$sectionEntity->id = $issueSection->section_id;
		$sectionEntity = $dao->get($sectionEntity);
		//var_dump($sectionEntity);
		$sectionArray[] = $sectionEntity;
	}
	echo "<hr/>";
	var_dump($sectionArray);
	return $sectionArray;
}

function test_select_publicatio_by_id($id=null){
	global $dao;


	// $pub_id = test_insert_publication();
	$pub_id = $id != null ? $id : 36377;
	$objectToGet = new Publication();
	$objectToGet->id = $pub_id;
	$objectToGet = $dao->get($objectToGet);

	return $objectToGet;
}

function test_update_publication_by_id(){
	global $dao;
	// $pub_id = test_insert_publication();
	$pub_id = 49897;
	$objectToGet =  TestObjectCreator::createTstObject(new Publication());
	$objectToGet->id = $pub_id;
	$dao->update($objectToGet);
	$objectToGet = $dao->get($objectToGet);



	var_dump($objectToGet);
}

function test_big_update_publication_by_id(){
	global $dao;
	//$insertId = test_insert_publication(1);
	$insertId = 1;

	$publFromDb = test_select_publicatio_by_id($insertId);

	$publFromDb->name = "123Нанотехнологии123 909090";
	$publFromDb->authors_array[2]->last_name = "Петрюшин123";

	$authNew = new Author();
	$authNew->last_name="Аношин555";
	$publFromDb->authors_array[] = $authNew;

	$authNew = new Author();
	$authNew->last_name="Митрофанов555";
	$publFromDb->authors_array[] = $authNew;

	unset($publFromDb->authors_array[3]);

	$dao->update($publFromDb);

	$publFromDb = test_select_publicatio_by_id($insertId);
	echo "<p>\n";
	var_dump($publFromDb);

}

function test_delete_item(){
	global $dao;
	$ins_id = test_insert_publication();
	//$ins_id=781861;

	//588746 452271 612458 573945


	//test_insert_reference();
	//test_insert_publication();

	$entity = new Publication();
	$entity->id=$ins_id;
	echo($dao->delete($entity));

}

function test_arrays(){

	$array1 = array(3,4,6,1,89,22);
	$array2 = array(5,3,4,6,1,89,77, 22);

	$arr_dif = array_diff($array2, $array1);


	//var_dump($arrayUnsorted);
	//sort($arrayUnsorted);
	echo "<br>";
	var_dump($array1);
	echo "<br>";
	var_dump($array2);
	echo "<br>";
	var_dump($arr_dif);



}

function test_select_publicationUser_by_user_id($user_id){
	global $dao;
	//$insertId = test_insert_publication(1);
	$dao->getMyPublications($user_id);
}

/**
 * 
 * @param unknown $pub_id
 * @param unknown $keywords - строка ключ слов, разделенных запятой (после запятой может быть пробел, а может и не быть)
 */
function updatePublicationByKeywords($pub_id=6, $keywords="1ключ сл2, 2ключ. сл3", $lang="kaz"){
	global $dao;
	try{
		echo "<h3>keywords before:".$keywords."</h3>";
		$keywords = str_replace(", ", ",", $keywords);
		echo "<h3>keywords after replace:".$keywords."</h3>";
		$pieces = explode(",", $keywords);
		//убираем пробелы по бокам во всех элементах массива
		$pieces = array_map('trim', $pieces);
		//переводим все элементы в верхний регистр
		$pieces = array_map("strtoupper", $pieces);
		$arrayOfKeywords = array();
		foreach($pieces as $str){
			$keywObj = $dao->getKeywordByNameAndLang($str, $lang);
			$arrayOfKeywords[] = $keywObj;
		}
		var_dump($arrayOfKeywords);
		$count = $dao->deleteNative("delete from bibl_publication_keyword where publication_id=" . $pub_id);
		echo "<h3>count deleted:".$count."</h3>";
		echo "<h3>-------------</h3>";
		foreach($arrayOfKeywords as $keyword){
			 $pubKeyWord = new PublicationKeyword();
			 $pubKeyWord->keyword_id = $keyword->id;
			 $pubKeyWord->publication_id = $pub_id;
			 $insertedId = $dao->insert($pubKeyWord);
			 echo "<h3>insertedId of PubKeyw:".$insertedId."</h3>";
		}
	}catch (Exception $e) {
    	echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
    }
	var_dump($pieces);
}

function updatePublicationByAuthors($pub_id=5, $authors_orgs=""){
	global $dao;
	try{
		$authors_orgs = array("1^1", "3^1","4^3");
		$authors_orgs_twoArray = array();
		var_dump($authors_orgs);
		// удаляем из таблицы bibl_publication_author все записи по этой публикации
		$count = $dao->deleteNative("delete from bibl_publication_author where publication_id=" . $pub_id);
		echo "<h3>count deleted:". $count . "</h3>";
		foreach($authors_orgs as $item){
			$arr = explode("^",$item);
			$pubAuthorObj = new PublicationAuthor();
			$pubAuthorObj->publication_id = $pub_id;
			$pubAuthorObj->author_id = $arr[0];
			$pubAuthorObj->organization_id = $arr[1];
			//$authors_orgs_twoArray[] = $pubAuthorObj;
			$insertedId = $dao->insert($pubAuthorObj);
			echo "<h3>insertedId of PublicationAuthor:".$insertedId."</h3>";
		}
		var_dump($authors_orgs_twoArray);
	}catch (Exception $e) {
		echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
	}
	//var_dump($pieces);
}

function testDeleteNative(){
	global $dao;
	$count = $dao->deleteNative("delete from bibl_publication_keyword where publication_id=5");
	var_dump($count);
}

function getKeywordAndInsertIfNotExist(){
	global $dao;
	$keywname = "фывфыв111";
	$lang = "kaz";
	$keywObj = $dao->getKeywordByNameAndLang($keywname, $lang);
	var_dump($keywObj);
}

function testParsePublication(){
	$parseObj = new ParsePublication(array());
	$keywords_kaz=array("aaa_kaz", "bbb_kaz", "ccc_kaz"); 
	$keywords_rus=array("aaa_rus", "bbb_rus", "ccc_rus");
	$keywords_eng=array("aaa_eng", "bbb_eng", "ccc_eng");
	$keywCommon = array();
	try{
		$keywCommon = $parseObj->getKeywordFromAllLangs($keywords_kaz, $keywords_rus, $keywords_eng);
	}catch (Exception $e) {
		echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
	}
	var_dump($keywCommon);
}

function test_smarty(){
	$smarty = new Smarty();
	$smarty->assign('title',"Заглавие");
	$smarty->assign('name',"Имя");
	$smarty->assign('address',"Адрес");
	
	$smarty->assign('id', array(1,2,3,4,5));
	$smarty->assign('names', array('bob','jim','joe','jerry','fred'));
	
	// assign an array of data
	//$smarty->assign('names', array('bob','jim','joe','jerry','fred'));
	
	// assign an associative array of data
	$smarty->assign('users', array(
			array('name' => 'bob', 'phone' => '555-3425'),
			array('name' => 'jim', 'phone' => '555-4364'),
			array('name' => 'joe', 'phone' => '555-3422'),
			array('name' => 'jerry', 'phone' => '555-4973'),
			array('name' => 'fred', 'phone' => '555-3235')
	));
	
	
	$smarty->display('templates/test_smarty.tpl');

}

function test_showListPubl() {
	
	$nav_obj = FabricaNavigate::createNavigate($page, $_SESSION, $_REQUEST, $doid);
	
}

function testStrRemoveZapyatie(){
	$str = ",ddd,";
	echo("-1) \$str:". $str."<br/>");
	$str = trim($str,",");
	echo("0) \$str:". $str."<br/>");
	/*
	$str1 = ltrim($str,",");
	echo("1) \$str1:<". $str1."><br/>");
	
	$str = rtrim($str,",");
	echo("1) \$str:<". $str ."><br/>");
	
	
	$firstSymb = substr($str,(0),1);
	if($firstSymb==","){
		$str = substr($str, 1, strlen($str));
	}
	echo("2) \$str:<$str><br/>");
	$lastSymb = substr($str,(strlen ($str)-1),1);
	if($lastSymb==","){
		$str = substr($str, 0, (strlen($str)-1));
	}
	echo("3) \$str:<$str><br/>");
	echo("\$firstSymb:<$firstSymb><br/>");
	echo("\$lastSymb:<$lastSymb><br/>");
	echo("\$str:<$str>");
	*/
	
}
function testInsertManyIssueSections(){
	$issueId = 22;
	$array = array(1,5,2);
	global $dao;
	$dao->saveIssueSections($issueId, $array);
}
?>
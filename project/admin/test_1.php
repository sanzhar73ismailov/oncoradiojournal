<?php
session_start();
include_once 'includes/global.php';
include_once 'includes/test_units.php';

function run(){
	//test_insert_publication();
	//test_insert_author();
	
	//test_update_author();
	//test_insert_organization();
	//test_update_organization();
	//test_insert_reference();
	//test_select_author();
	//test_select_reference();
	//	test_select_author_by_condition();
	//test_select_reference_by_condition();
	//test_select_publicatio_by_id();
	//test_update_publicatio_by_id();
	
	
	//test_big_update_publication_by_id();
	
	//test_arrays();
	//test_delete_item();
	//checkUser();
	
	//test_select_publicationUser_by_user_id(6);
	//create_script();
	//test_mail();
	//test_json();
	//test_getAll();
// 	test_getAll();
// 	 test_getAllPubls();
	//test_getAllSections();
	
	 //test_getAllKeywords();
// 	 test_getAllKeywordsByLang();
//	 test_getAllKeywordsByLang2();
//	 test_getListSectionByIssue();
testInsertManyIssueSections();
	
	 //test_getSectionsByIssue(1);
	//getListOfSectionsForThisJournal(1);
	 //test_getSectionsByIssue
	//test_object();
	//checkGetPublicationsRespCoauthor();
	
	//test_smarty();
	//$nav_obj = FabricaNavigate::createNavigate($page, $_SESSION, $_REQUEST, $doid);
	//test_showListPubl();
	
  	// updatePublicationByKeywords();
//   	updatePublicationByAuthors();
  	// testParsePublication();
	//getKeywordAndInsertIfNotExist();
    //testDeleteNative();
    //echo strtoupper("adasd ываыва");
//testStrRemoveZapyatie();

	//echo mb_strtoupper("ываыва");
}




run();
?>

<script>

var str = ", sdfsdf ,";
console.log("<" + str + ">");
str = getTrimedWithoutComma(str);
console.log("<" + str + ">");
// возвращает подстроку без пробелов и запятых по бокам
function getTrimedWithoutComma(val){
	val = val.trim();
	if(val.startsWith(",")){
		val = val.substr(1, val.length);
	}
	if(val.endsWith(",")){
		val = val.substr(0, val.length-1);
	}
	val = val.trim();
	return val;
}

/*
console.log(Math.floor(Math.random()));
var array = [[1, "Статья из периодического издания"], 
 			[2, "Книга"], 
 			[3, "Публикация из материалов конференции(семинара, симпозиума), сборников трудов"], 
             [4, "Электронный ресурс"]];

for(var i = 0; i <  array.length; i++){
	console.log(array[i][0] + " - " + array[i][1]);
}
*/
</script>

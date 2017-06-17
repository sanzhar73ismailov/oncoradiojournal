<?php
include_once 'includes/global.php';
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');
// The JSON standard MIME header.
header('Content-type: application/json');

$author_id = $_GET['author_id'];
$authors = null;
$org_id = 0;
if($author_id != ""){
	$query = sprintf("select * from bibl_author a where a.id='%s'", $author_id);
	//echo $query;
	$authors = $dao->getByNativeQuery(new Author(), $query);
	if(count($authors) == 1){
		$org_id = $authors[0]->organization_id;
	}
	// var_dump($authors);
	// var_dump($authors[0]);
}
//$arr = array("org_id" => $author->id);
//echo($author->id);
//echo gettype($authors[0]);
echo json_encode($org_id);
?>
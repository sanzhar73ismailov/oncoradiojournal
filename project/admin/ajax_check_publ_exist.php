<?php
include_once 'includes/global.php';
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');
// The JSON standard MIME header.
header('Content-type: application/json');

$pub_name = $_GET['pub_name'];
$pub_name = $pub_name == null ? "" : trim($pub_name);
$publ = "";
if($pub_name != ""){
	$substr = "";
	$probel_pos = stripos($pub_name, " ");
	
	if($probel_pos == 0){
		$substr = $pub_name;
	}else{
		$substr = substr($pub_name, 0, $probel_pos);	
	}
	
	$query = "select * from bibl_publication where name like '" . $substr . "%'";
	
	$publ = $dao->getByNativeQuery(new Publication(), $query);
	
	
	
}

//$data = array(111, $_GET['pub_name'] . " - " . $probel_pos . "-" . $substr . "-");
//$data =  array(111, $query);

//echo json_encode($data);

$publ_as_item_array = getPublicationsAsArrayPresentation($publ);
echo json_encode($publ_as_item_array);


?>
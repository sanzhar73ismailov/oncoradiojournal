<?php
include_once 'includes/global.php';

$issue_id = trim($_GET['issue_id']);
$item = null;

$publ_sections = getListOfSectionsForThisJournal($issue_id);
$publ_authors = $dao->getAll(new Author(), " order by last_name_rus ");
$publ_organizations = $dao->getAll(new Organization(), " order by name_rus ");

$jsonArray = array(
"sections"=>$publ_sections,
"authors"=>$publ_authors,
"organizations"=>$publ_organizations
);

echo json_encode($jsonArray);
//echo json_encode($publ_authors);
//echo json_encode($publ_organizations);


function getListOfSectionsForThisJournal($issue_id){
		global $dao;
		$listIssueSection = $dao->getByNativeQuery( new IssueSection(), "select * from bibl_issue_section where issue_id=" . $issue_id);
		//var_dump($issue_id);
		//var_dump($listIssueSection);
		$sectionArray = array();
		//echo "<hr/>";
		foreach ($listIssueSection as $key => $issueSection){
			//var_dump($issueSection);
			$sectionEntity = new Section();
			$sectionEntity->id = $issueSection->section_id;
			$sectionEntity = $dao->get($sectionEntity);
			//var_dump($sectionEntity);
			$sectionArray[] = $sectionEntity;
		}
		//echo "<hr/>";
		//var_dump($sectionArray);
		return $sectionArray;
}
	

?>
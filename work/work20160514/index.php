<?php
define ( 'SMARTY_DIR', './Smarty-3.1.18/libs/' );
require_once (SMARTY_DIR . 'Smarty.class.php');
// include_once 'includes/functions.php';
include_once 'includes/global.php';
include_once 'includes/stat.php';
include_once 'includes/model.php';
//include_once 'includes/tabgeo_country_v4.php';

$smarty = new Smarty ();
$model = new Model();

$page = isset ( $_REQUEST ['page'] ) == true ? $_REQUEST ['page'] : "index";

$contentPage = "main";

include('lang/' . $lang . '.php');
//print_r($_LANG);
$smarty->assign('text', $_LANG);
$smarty->assign('lang', $lang);
$smarty->assign('include_metrica', $include_metrica);
if(isset ( $_REQUEST ['id'] )){
	$smarty->assign('id', $_REQUEST ['id']);
}


$title = $_LANG['journal_name'];

switch ($page) {
	case "index" :
		break;
	case "editorial-board" :
		$title = $_LANG['editorial-board_menu'];
		$contentPage = "editorial-board";
		break;
	case "regulations" :
		$title = $_LANG['regulations_menu'];
		$contentPage = "regulations";
		$smarty->assign ( 'sumPerPage', SUM_PER_PAGE );
		break;
	case "current_issue" :
		$contentPage = "current_issue";
		$lang_for_model = "rus";
		if($lang=="kz"){
			$lang_for_model = "kaz";
		}elseif ($lang=="en"){
			$lang_for_model = "eng";
		}else{
			$lang_for_model = "rus";
		}
		$issue = null;
		if(isset ( $_REQUEST ['id'] )){
			$issue = $model->getIssue($_REQUEST ['id'],$lang_for_model);
			$title = $_LANG['content'] . " " .$issue->year . "-" .$issue->issue . "(" . $issue->number . ")";//$_LANG['current_issue_menu'];
		}else{
			$title = $_LANG['current_issue_menu'];
			$issue = $model->getLastIssue($lang_for_model);
		}
		
		$ip = getRealIpAddr();
		$userAgent = getUserAgent();
		$model->insertPublStatistics("i",$issue->id, $lang_for_model, $ip, $userAgent);
		
		$smarty->assign ( 'issue', $issue );
		//printInHtml($issue->year);
		break;
	case "abstract" :
		$contentPage = "abstract";
		$lang_for_model = "rus";
		if($lang=="kz"){
			$lang_for_model = "kaz";
		}elseif ($lang=="en"){
			$lang_for_model = "eng";
		}else{
			$lang_for_model = "rus";
		}
		$publication = $model->getPublicationWithAbstract($_REQUEST ['id'], $lang_for_model);
		$ip = getRealIpAddr();
		$userAgent = getUserAgent();
		$model->insertPublStatistics("p",$_REQUEST ['id'], $lang_for_model, $ip, $userAgent);
		$title = $_LANG['abstract'] . ": " . $publication->getAuthorNames() . " " .$publication->name;
		$smarty->assign ( 'publication', $publication );
		$smarty->assign ( 'authors', $publication->author_orgs[0] );
		$smarty->assign ( 'orgs', $publication->author_orgs[1] );
		$issue = $model->getOnlyIssue($publication->issue_id ,$lang_for_model);
		$smarty->assign ( 'issue', $issue );
		//printInHtml($issue->year);
		break;
	case "archive" :
		$title = $_LANG['archive_menu'];
		$contentPage = "archive";
		//$smarty->assign ( 'journals', getJournalArray() );
		$smarty->assign ( 'journals', $model->getIssues() );
		break;
	case "contacts" :
		$title = $_LANG['contacts_menu'];
		$contentPage = "contacts";
		break;
}

$smarty->assign ( 'title', $title );
$smarty->assign ( 'contentPage', $lang . "/".$contentPage );
$smarty->assign ( 'page', $page);
$smarty->display ( 'templates/index.tpl' );




?>
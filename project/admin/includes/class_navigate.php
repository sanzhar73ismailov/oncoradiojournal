<?php
include_once 'navigate/class_AbstractNavigate.php';
include_once 'navigate/class_ActivationNavigate.php';
include_once 'navigate/class_AddPublNavigate.php';
include_once 'navigate/class_AuthorNavigate.php';
include_once 'navigate/class_ContactNavigate.php';
include_once 'navigate/class_EditNavigate.php';
include_once 'navigate/class_FeedbackNavigate.php';
include_once 'navigate/class_IndexNavigate.php';
include_once 'navigate/class_ListNavigate.php';
include_once 'navigate/class_ListPossibleNavigate.php';
include_once 'navigate/class_LoginNavigate.php';
include_once 'navigate/class_LogoutNavigate.php';
include_once 'navigate/class_PublicationNavigate.php';
include_once 'navigate/class_RegistrationNavigate.php';
include_once 'navigate/class_SavePossibleNavigate.php';
include_once 'navigate/class_SelectAuthorOrganizationPublNavigate.php';
include_once 'navigate/class_OrganizationNavigate.php';
include_once 'navigate/class_IssueNavigate.php';
include_once 'navigate/class_SectionNavigate.php';
include_once 'navigate/class_ListNavigateAuthors.php';
include_once 'navigate/class_ListNavigateOrganizations.php';
include_once 'navigate/class_ListNavigateIssues.php';
include_once 'navigate/class_ListNavigateSections.php';


class FabricaNavigate{

	public  static function createNavigate($str_path, $session, $request, $doid){
		global $smarty;
		

		$navigate_obj = null;

		switch ($str_path){
			case 'add_publication':

				$navigate_obj = new AddPublNavigate($smarty, $session, $doid, $request);
				break;
			case 'add_publication_authors_organizations':
				
				$navigate_obj = new SelectAuthorOrganizationPublNavigate($smarty, $session, $doid, $request);
				break;
			case 'publication':

				$navigate_obj = new PublicationNavigate($smarty, $session, $doid, $request);
				break;
			case 'author':
				
				$navigate_obj = new AuthorNavigate($smarty, $session, $doid, $request);
				break;
			case 'organization':
				
				$navigate_obj = new OrganizationNavigate($smarty, $session, $doid, $request);
				break;
			case 'section':	
				
				$navigate_obj = new SectionNavigate($smarty, $session, $doid, $request);
				break;
			case 'issue':
				
				$navigate_obj = new IssueNavigate($smarty, $session, $doid, $request);
				break;
			case 'contacts':

				$navigate_obj = new ContactNavigate($smarty, $session);
				break;
			case 'feedback':

				$navigate_obj = new FeedbackNavigate($smarty, $session);
				break;
			case 'register':

				$navigate_obj = new RegistrationNavigate($smarty, $session);
				break;
			case 'activate_account':

				$navigate_obj = new ActivationNavigate($smarty, $session);
				break;
			case 'login':

				$navigate_obj = new LoginNavigate($smarty, $session);
				break;
			case 'logout':

				$navigate_obj = new LogoutNavigate($smarty, $session);
				break;
			case 'list_abs_data':

				exit("Unsupported operation");
				break;
			case "listPublications":

				$navigate_obj = new ListNavigate($smarty, $session, $request);
				break;
			case "listAuthors":
				
				$navigate_obj = new ListNavigateAuthors($smarty, $session, $request);
				break;
			case "listOrganizations":
					
				$navigate_obj = new ListNavigateOrganizations($smarty, $session, $request);
				break;
			case "listSections":
						
				$navigate_obj = new ListNavigateSections($smarty, $session, $request);
				break;
			case "listIssues":
						
				$navigate_obj = new ListNavigateIssues($smarty, $session, $request);
				break;
			case "list_possible":
				$navigate_obj = new ListPossibleNavigate($smarty, $session);
				break;

			case "save_possible":
				$navigate_obj = new SavePossibleNavigate($smarty, $session);
				break;

			default:
				$navigate_obj = new IndexNavigate($smarty, $session);
				break;
		}
		return $navigate_obj;

	}

}
?>
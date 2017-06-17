<?php
include_once 'daoquery/class_AuthorQuery.php';
include_once 'daoquery/class_ConferenceQuery.php';
include_once 'daoquery/class_DaoQuery.php';
include_once 'daoquery/class_DictionaryQuery.php';
include_once 'daoquery/class_JournalQuery.php';
include_once 'daoquery/class_OrganizationQuery.php';
include_once 'daoquery/class_PublicationQuery.php';
include_once 'daoquery/class_PublicationUserQuery.php';
include_once 'daoquery/class_ReferenceQuery.php';
include_once 'daoquery/class_UserQuery.php';
include_once 'daoquery/class_PublicationAuthorQuery.php';
include_once 'daoquery/class_IssueQuery.php';
include_once 'daoquery/class_SectionQuery.php';
include_once 'daoquery/class_IssueSectionQuery.php';
include_once 'daoquery/class_IssueSectionQuery.php';
include_once 'daoquery/class_KeywordQuery.php';
include_once 'daoquery/class_PublicationKeywordQuery.php';

class FabricaQuery{

	public static function createQuery($pdo, $object){
		$query = null;

		switch(get_class($object)){
			case "Publication":
				$query = new PublicationQuery($pdo, $object);
				break;

			case "Author":
				$query = new AuthorQuery($pdo, $object);
				break;
				
			case "PublicationAuthor":
				$query = new PublicationAuthorQuery($pdo, $object);
				break;
				
			case "Organization":
				$query = new OrganizationQuery($pdo, $object);
				break;

			case "Issue":
				$query = new IssueQuery($pdo, $object);
				break;
				
			case "Reference":
				$query = new ReferenceQuery($pdo, $object);
				break;

			case "User":
				$query = new UserQuery($pdo, $object);
				break;
					
			case "PublicationUser":
				$query = new PublicationUserQuery($pdo, $object);
				break;

			case "Journal":
				$query = new JournalQuery($pdo, $object);
				break;

			case "Conference":
				$query = new ConferenceQuery($pdo, $object);
				break;
				
			case "DicIdName":
				$query = new DictionaryQuery($pdo, $object);
				break;
				
			case "Section":
				$query = new SectionQuery($pdo, $object);
				break;
				
			case "IssueSection":
				$query = new IssueSectionQuery($pdo, $object);
				break;
			
			case "Keyword":
				$query = new KeywordQuery($pdo, $object);
				break;
				
			case "PublicationKeyword":
				$query = new PublicationKeywordQuery($pdo, $object);
				break;
			default:
				exit("Unsupported object - see FabricaQuery::createQuery()");
				break;
		}

		return $query;
	}
}
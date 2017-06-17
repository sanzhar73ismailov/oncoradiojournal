<?php
include_once 'util.php';
class Issue {
	public $id;
	public $year;
	public $issue;
	public $number;
	public $section_array;
	public $file;
	public $is_filled_by_papers;
}

class Section{
	public $id;
	public $name;
	public $publication_array;
}

class Publication{
	public $id;
	public $name;
	public $abstract;
	public $authors;
	public $keywords;
	public $udk;
	public $email;
	public $p_first;
	public $p_last;
	public $file;
	public $section_id;
	public $issue_id;
	public $section_name;
	public $author_orgs; // двумерный массив (авторый и организации) для вывода на странице абстракта
	public function getAuthorNames(){
		$authors = $this->author_orgs[0];
		$str = "";
		$i = 0;
		foreach ($authors as $key => $author) {
			$i++;
			$str .= getFistLetterBig($author->last_name) . " " .
			mb_substr($author->first_name,0,1) . "." .
			mb_substr($author->patronymic_name,0,1) . "."
			;
			if($i < count($authors)){
				$str .= ", ";
			}
		}
		return $str;
	}
}

class Author{
	public $id;
	public $last_name;
	public $first_name;
	public $patronymic_name;
	public $org_num; // номер организации в публикации (для вывода абстракта)
	public $is_contact;
	public $email;
}

class Organization{
	public $id;
	public $name;
	public $org_num; // номер организации в публикации (для вывода абстракта)
}

class PublicationAuthor{
	public $publ_id;
	public $author;
	public $organization;
}
?>
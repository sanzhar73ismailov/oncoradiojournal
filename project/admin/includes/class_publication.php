<?php
class Publication {
	public $id;
	public $name_kaz;
	public $name_rus;
	public $name_eng;
	public $electron;
	public $url;
	public $doi;
	public $abstract_original;
	public $abstract_rus;
	public $abstract_kaz;
	public $abstract_eng;
	public $abstract_rus_to_check; // для отображения в проверочном варианте (с выделенными абзацами и т.д.)
	public $abstract_kaz_to_check;
	public $abstract_eng_to_check;
	public $language;
	public $keywords;
	public $number_ilustrations;
	public $number_tables;
	public $number_references;
	public $number_references_kaz;
	public $code_udk;
	public $type_id;
	public $journal_id;
	public $year;
	public $month;
	public $day;
	public $number;
	public $volume;
	public $issue;
	public $p_first;
	public $p_last;
	public $pmid;
	public $conference_id;
	public $tezis_type;
	public $user_id;
	public $responsible;
	public $patent_type_id;
	public $patent_type_number;
	public $patent_date;
	public $book_city;
	public $book_pages;
	public $izdatelstvo;
	public $method_recom_bbk;
	public $isbn;
	public $method_recom_edited;
	public $method_recom_stated;
	public $method_recom_approved;
	public $method_recom_published_with_the_support;
	public $method_recom_reviewers;
	public $user;
	public $insert_date;
	public $issue_id; // новое поле, ключ к issue
	public $issueObj;
	public $section_id;
	public $file;
	/* foreign keys (arrays) */
	// public $authors_array = array();
	// public $references_array = array();
	public $author_orgs_array = array ();
	public $keywords_array = array ();
	public function getFields() {
		return get_object_vars ( $this );
	}
}
class Author {
	public $id;
	// public $publication_id;
	public $last_name_kaz;
	public $first_name_kaz;
	public $patronymic_name_kaz;
	public $last_name_rus;
	public $first_name_rus;
	public $patronymic_name_rus;
	public $last_name_eng;
	public $first_name_eng;
	public $patronymic_name_eng;
	public $organization_name;
	public $organization_id;
	public $email;
	public $degree;
	public $user;
	public $insert_date;
	public function __toString() {
		return "id: " . $this->id . ", last_name_rus: " . $this->last_name_rus;
	}
}
class PublicationAuthor {
	public $id;
	public $publication_id;
	public $publication_name;
	public $author_id;
	public $author_name;
	public $organization_id;
	public $organization_name;
	public $is_contact;
	public $insert_date;
	public function __toString() {
		return "id: " . $this->id . ", publication_id: " . $this->publication_id . "author_id: " . $this->author_id . "organization_id: " . $this->organization_id;
	}
}
class Organization {
	public $id;
	public $name_kaz;
	public $name_rus;
	public $name_eng;
	public $user;
	public $insert_date;
	public function __toString() {
		return $this->id . ", name_kaz: " . $this->name_kaz . ", name_rus: " . $this->name_rus . ", name_eng: " . $this->name_eng;
	}
}
class Section {
	public $id;
	public $name_kaz;
	public $name_rus;
	public $name_eng;
	public $checked = ""; // для отображения чекбокса при создании/редактирования номера журнала
	public function __toString() {
		return $this->id . ", name_kaz: " . $this->name_kaz . ", name_rus: " . $this->name_rus . ", name_eng: " . $this->name_eng;
	}
}
class Keyword {
	public $id;
	public $name;
	public $lang;
	public function __toString() {
		return $this->id . ", name: " . $this->name . ", lang: " . $this->lang;
	}
}
class PublicationKeyword {
	public $id;
	public $publication_id;
	public $keyword_id;
	public function __toString() {
		return $this->id . ", publication_id: " . $this->publication_id . ", keyword_id: " . $this->keyword_id;
	}
}
class IssueSection {
	public $id;
	public $issue_id;
	public $section_id;
	public $section_name;
	public $order_field;
	public function __toString() {
		return $this->id . ", issue_id: " . $this->issue_id . ", section_id: " . $this->section_id . ", section_name: " . $this->section_name . ", order_field: " . $this->order_field;
	}
}
class Reference {
	public $id;
	public $publication_id;
	public $type_id;
	public $name;
	public $user;
	public $insert_date;
	public function __toString() {
		return $this->id . ", publication_id" . $this->publication_id . ", name" . $this->name;
	}
}
class PublicationUser {
	public $id;
	public $publication_id;
	public $user_id;
	public $responsible;
	public $coauthor;
}
class Journal {
	public $id;
	public $name;
	public $country;
	public $issn;
	public $periodicity;
	public $izdatelstvo_mesto_izdaniya;
	public $user;
	public $insert_date;
}
class Conference {
	public $id;
	public $name;
	public $sbornik_name;
	public $city;
	public $country;
	public $type_id;
	public $level_id;
	public $date_start;
	public $date_finish;
	public $add_info;
	public $user;
	public $insert_date;
}
class Issue {
	public $id;
	public $year;
	public $number;
	public $issue;
	public $file;
	public $sections = array();
	
	public function __toString() {
		return "$this->id, year: $this->year, number: $this->number, issue: $this->issue";
	}
}
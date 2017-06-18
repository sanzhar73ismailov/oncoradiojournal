<?php
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
				"user_id",
				"conference_id",
				"izdatelstvo",
				"user",
				"insert_date"
				);



foreach ($arr as $key => $value){
	//echo sprintf("\$stmt->bindValue(':%s', \$this->object->%s, PDO::PARAM_STR);<br>", $value,$value);
	//echo sprintf("\$retObj->%s=\$row[0]['%s'];<br>", $value,$value);
	echo sprintf("\$object->%s=\$row[0]['%s'];<br>", $value,$value);
	
}


?>
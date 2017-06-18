<?php
class PublicationAuthorQuery extends DaoQuery{

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_publication_author';
	}
	public  function insertQuery(){
		$query = "INSERT INTO
				  `". $this->table . "`
				(
				  `id`,
				  `publication_id`,
				  `author_id`,
				  `organization_id`,
				  `is_contact`		
				)
				VALUE (
				  :id,
				  :publication_id,
				  :author_id,
				  :organization_id,
				  :is_contact		
				);";

		$stmt = $this->pdo->prepare($query);
		$this->bindValue($stmt);

		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				die("Ошибка, объект не сохранен");
			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		return $this->pdo->lastInsertId();
	}

	public  function updateQuery($by_column=null){
		exit("UnsupportedOperationException");
	}

	public function fromRowsToArrayObjects($rows){
		$returnObjects = array();

		if($rows != null){
			foreach ($rows as $row){
				$object = new PublicationAuthor();
				$object->id=$row['id'];
				$object->publication_id=$row['publication_id'];
				$object->publication_name=$row['publication_name'];
				$object->author_id=$row['author_id'];
				$object->author_name=$row['author_name'];
				$object->organization_name=$row['organization_name'];
				$object->organization_id=$row['organization_id'];
				$object->is_contact=$row['is_contact'];
				$returnObjects[] = $object;
			}
		}
		return $returnObjects;
	}

	public function bindValue(&$stmt){
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':author_id', $this->object->author_id, PDO::PARAM_STR);
		$stmt->bindValue(':organization_id', $this->object->organization_id, PDO::PARAM_STR);
		$stmt->bindValue(':is_contact', $this->object->is_contact, PDO::PARAM_STR);
	}


}
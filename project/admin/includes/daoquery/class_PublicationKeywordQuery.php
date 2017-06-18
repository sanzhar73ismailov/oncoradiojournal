<?php
include_once 'class_DaoQuery.php';
class PublicationKeywordQuery extends DaoQuery{

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_publication_keyword';
	}

	public  function insertQuery(){
		$query = "INSERT INTO
			  `" . $this->table. "`
			(
			  `id`,
			  `publication_id`,
			  `keyword_id`
			)
			VALUE (
			  :id,
			  :publication_id,
			  :keyword_id
			)";



		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':keyword_id', $this->object->keyword_id, PDO::PARAM_STR);
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
		//echo "<h1>" .$this->pdo->lastInsertId() . "</h1>";
		return $this->pdo->lastInsertId();
	}

	public  function updateQuery($by_column=null){
		$query = "UPDATE
					  `" . $this->table . "`
					SET
					  `publication_id` = :publication_id,
					  `keyword_id` = :keyword_id
					WHERE
					  `id` = :id
				";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':keyword_id', $this->object->keyword_id, PDO::PARAM_STR);
		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				die("Ошибка, объект не обновлен");
			}

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		return $this->object->id;
	}

	public function fromRowsToArrayObjects($rows){
		$returnObjects = array();

		if($rows != null){
			foreach ($rows as $row){
				$object = new PublicationKeyword();
				$object->id=$row['id'];
				//$object->publication_id=$row['publication_id'];
				$object->publication_id=$row['publication_id'];
				$object->keyword_id=$row['keyword_id'];
				$returnObjects[] = $object;
			}
		}
		return $returnObjects;
	}

	public function bindValue(&$stmt){
		exit("UnsupportedOperation");
	}
}
?>
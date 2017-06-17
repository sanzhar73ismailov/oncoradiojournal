<?php
include_once 'class_DaoQuery.php';
class KeywordQuery extends DaoQuery{

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_keyword';
	}

	public  function insertQuery(){
		$query = "INSERT INTO
			  `" . $this->table. "`
			(
			  `id`,
			  `name`,
			  `lang`
			)
			VALUE (
			  :id,
			  :name,
			  :lang
			)";



		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		//$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':name', $this->object->name, PDO::PARAM_STR);
		$stmt->bindValue(':lang', $this->object->lang, PDO::PARAM_STR);
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
					  `name` = :name,
					  `language` = :language
					WHERE
					  `id` = :id
				";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $this->object->name, PDO::PARAM_STR);
		$stmt->bindValue(':lang', $this->object->lang, PDO::PARAM_STR);
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
				$object = new Keyword();
				$object->id=$row['id'];
				//$object->publication_id=$row['publication_id'];
				$object->name=$row['name'];
				$object->lang=$row['lang'];
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
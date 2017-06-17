<?php
include_once 'class_DaoQuery.php';
class IssueQuery extends DaoQuery{

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_issue';
	}

	public  function insertQuery(){
		$query = "INSERT INTO
			  `" . $this->table. "`
				(
				  `id`,
				  `year`,
				  `number`,
				  `issue`,
			  	   file
				) 
				VALUE (
				  :id,
				  :year,
				  :number,
				  :issue,
			  	  :file
				)";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':year', $this->object->year, PDO::PARAM_STR);
		$stmt->bindValue(':number', $this->object->number, PDO::PARAM_STR);
		$stmt->bindValue(':issue', $this->object->issue, PDO::PARAM_STR);
		$stmt->bindValue(':file', $this->object->file, PDO::PARAM_STR);
	
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
					  `year` = :year,
					  `number` = :number,
					  `issue` = :issue,
					  `file` = :file				
					WHERE
					  `id` = :id
				";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':year', $this->object->year, PDO::PARAM_STR);
		$stmt->bindValue(':number', $this->object->number, PDO::PARAM_STR);
		$stmt->bindValue(':issue', $this->object->issue, PDO::PARAM_STR);
		$stmt->bindValue(':file', $this->object->file, PDO::PARAM_STR);
		
		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();

			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				//echo("Объект не обновлен");
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
				$object = new Author();
				$object->id=$row['id'];
				//$object->publication_id=$row['publication_id'];
				$object->year=$row['year'];
				$object->number=$row['number'];
				$object->issue=$row['issue'];
				$object->file=$row['file'];
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
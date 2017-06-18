<?php
class SectionQuery extends DaoQuery{
	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_section';
	}

	public  function insertQuery(){
		$query = "INSERT INTO
			  `" . $this->table. "`
			(
			  `id`,
			  `name_kaz`,
			  `name_rus`,
			  `name_eng`
			)
			VALUE (
			  :id,
			  :name_kaz,
			  :name_rus,
			  :name_eng
			)";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		//$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':name_kaz', $this->object->name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':name_rus', $this->object->name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':name_eng', $this->object->name_eng, PDO::PARAM_STR);
		
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
		$query = "UPDATE
					  `" . $this->table . "`
					SET
					  `name_kaz` = :name_kaz,
					  `name_rus` = :name_rus,
					  `name_eng` = :name_eng
					WHERE
					  `id` = :id
				";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':name_kaz', $this->object->name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':name_rus', $this->object->name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':name_eng', $this->object->name_eng, PDO::PARAM_STR);
			
		//echo "<br>".$stmt->queryString . "<br>";
		try {
			$stmt->execute();
			$affected_rows = $stmt->rowCount();
			//	echo $affected_rows.' пациент добавлен';
			if($affected_rows < 1){
				//die("Ошибка, объект не обновлен");
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
				$object = new Section();
				$object->id=$row['id'];
				$object->name_kaz=$row['name_kaz'];
				$object->name_rus=$row['name_rus'];
				$object->name_eng=$row['name_eng'];
				$returnObjects[] = $object;
			}
		}
		return $returnObjects;
	}

	public function bindValue(&$stmt){
		exit("UnsupportedOperation");
	}

}
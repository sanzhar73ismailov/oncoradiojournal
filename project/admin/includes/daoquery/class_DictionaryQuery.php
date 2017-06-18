<?php
class DictionaryQuery extends DaoQuery{

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_' . $object->table_name;
	}
	public  function insertQuery(){
		$query = "INSERT INTO
				  `". $this->table . "`
				(
				  `id`,
				  `name`
				)
				VALUE (
				:id,
				:name
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
		$query = "UPDATE
			  `". $this->table . "`
			SET
			  `name` = :name
			 WHERE
			  `id` = :id";



		$stmt = $this->pdo->prepare($query);
		$this->bindValue($stmt);


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
				$object = new DicIdName($row['id'], $row['name']);
				$returnObjects[] = $object;
			}
		}

		return $returnObjects;
	}
	public function bindValue(&$stmt){
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $this->object->name, PDO::PARAM_STR);
	}

}
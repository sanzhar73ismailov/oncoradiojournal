<?php
class ReferenceQuery extends DaoQuery{

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_reference';
	}
	public  function insertQuery(){
		$query = "INSERT INTO
				  `". $this->table . "`
				(
				  `id`,
				  `publication_id`,
				  `type_id`,
				  `name`,
				  `user`,
				  `insert_date`
				)
				VALUE (
				  :id,
				  :publication_id,
				  :type_id,
				  :name,
				  :user,
				  :insert_date
				);";



		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':type_id', $this->object->type_id, PDO::PARAM_STR);
		$stmt->bindValue(':name', $this->object->name, PDO::PARAM_STR);
		$stmt->bindValue(':user', $this->object->user, PDO::PARAM_STR);
		$stmt->bindValue(':insert_date', $this->object->insert_date, PDO::PARAM_STR);
			
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
			  `publication_id` = :publication_id,
			  `type_id` = :type_id,
			  `name` = :name,
			  `user` = :user
			WHERE
			  `id` = :id";


		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':type_id', $this->object->type_id, PDO::PARAM_STR);
		$stmt->bindValue(':name', $this->object->name, PDO::PARAM_STR);
		$stmt->bindValue(':user', $this->object->user, PDO::PARAM_STR);


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
				$object = new Reference();
				$object->id=$row['id'];
				$object->publication_id=$row['publication_id'];
				$object->type_id=$row['type_id'];
				$object->name=$row['name'];
				$object->user=$row['user'];
				$object->insert_date=$row['insert_date'];
				$returnObjects[] = $object;
			}
		}

		return $returnObjects;
	}
	public function bindValue(&$stmt){
		exit("UnsupportedOperation");
	}
}
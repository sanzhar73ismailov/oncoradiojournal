<?php
class JournalQuery extends DaoQuery{

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_journal';
	}
	public  function insertQuery(){
		$query = "INSERT INTO
				  `". $this->table . "`
				(
				  `id`,
				  `country`,
				  `issn`,
				  `name`,
				  `periodicity`,
				  `izdatelstvo_mesto_izdaniya`,
				  `user`,
				  `insert_date`
				)
				VALUE (
				  :id,
				  :country,
				  :issn,
				  :name,
				  :periodicity,
				  :izdatelstvo_mesto_izdaniya,
				  :user,
				  :insert_date
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
			  `country` = :country,
			  `issn` = :issn,
			  `name` = :name,
			  `periodicity` = :periodicity,
			  `izdatelstvo_mesto_izdaniya` = :izdatelstvo_mesto_izdaniya,
			  `name` = :name,
			  `user` = :user
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
				$object = new Journal();
				$object->id=$row['id'];
				$object->country=$row['country'];
				$object->issn=$row['issn'];
				$object->name=$row['name'];
				$object->periodicity=$row['periodicity'];
				$object->izdatelstvo_mesto_izdaniya=$row['izdatelstvo_mesto_izdaniya'];
				$object->user=$row['user'];
				$object->insert_date=$row['insert_date'];
				$returnObjects[] = $object;
			}
		}

		return $returnObjects;
	}
	public function bindValue(&$stmt){
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':country', $this->object->country, PDO::PARAM_STR);
		$stmt->bindValue(':issn', $this->object->issn, PDO::PARAM_STR);
		$stmt->bindValue(':name', $this->object->name, PDO::PARAM_STR);
		$stmt->bindValue(':periodicity', $this->object->periodicity, PDO::PARAM_STR);
		$stmt->bindValue(':izdatelstvo_mesto_izdaniya', $this->object->izdatelstvo_mesto_izdaniya, PDO::PARAM_STR);
		$stmt->bindValue(':user', $this->object->user, PDO::PARAM_STR);
		$stmt->bindValue(':insert_date', $this->object->insert_date, PDO::PARAM_STR);
	}

}



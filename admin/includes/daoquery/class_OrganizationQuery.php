<?php
class OrganizationQuery extends DaoQuery{
	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_organization';
	}

	public  function insertQuery(){
		$query = "INSERT INTO
			  `" . $this->table. "`
			(
			  `id`,
			  `name_kaz`,
			  `name_rus`,
			  `name_eng`,
			  `user`
			)
			VALUE (
			  :id,
			  :name_kaz,
			  :name_rus,
			  :name_eng,
			  :user
			)";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		//$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':name_kaz', $this->object->name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':name_rus', $this->object->name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':name_eng', $this->object->name_eng, PDO::PARAM_STR);
		$stmt->bindValue(':user', $this->object->user, PDO::PARAM_STR);

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
					  `name_eng` = :name_eng,
					  `user` = :user
					WHERE
					  `id` = :id
				";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':name_kaz', $this->object->name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':name_rus', $this->object->name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':name_eng', $this->object->name_eng, PDO::PARAM_STR);
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
				$object = new Author();
				$object->id=$row['id'];
				$object->name_kaz=$row['name_kaz'];
				$object->name_rus=$row['name_rus'];
				$object->name_eng=$row['name_eng'];
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
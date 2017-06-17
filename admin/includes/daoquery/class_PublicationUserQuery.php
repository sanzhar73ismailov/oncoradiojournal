<?php
class PublicationUserQuery extends DaoQuery{

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_publication_user';
	}
	public  function insertQuery(){
		$query = "INSERT INTO
				  `". $this->table . "`
				(
				  `id`,
				  `publication_id`,
				  `user_id`,
				  `responsible`,
				  `coauthor`
				)
				VALUE (
				  :id,
				  :publication_id,
				  :user_id,
				  :responsible,
				  :coauthor
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
				$object = new PublicationUser();
				$object->id=$row['id'];
				$object->publication_id=$row['publication_id'];
				$object->user_id=$row['user_id'];
				$object->responsible=$row['responsible'];
				$returnObjects[] = $object;
			}
		}

		return $returnObjects;
	}

	public function bindValue(&$stmt){
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':user_id', $this->object->user_id, PDO::PARAM_STR);
		$stmt->bindValue(':responsible', $this->object->responsible, PDO::PARAM_STR);
		$stmt->bindValue(':coauthor', $this->object->coauthor, PDO::PARAM_STR);
	}

	public function updateCoauthorColumnByPublicationId(){
		$query = "UPDATE
			  `". $this->table . "`
			SET
			  `coauthor` = :coauthor
			WHERE
			  `publication_id` = :publication_id";

		$stmt = $this->pdo->prepare($query);

		$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':coauthor', $this->object->coauthor, PDO::PARAM_STR);


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

}
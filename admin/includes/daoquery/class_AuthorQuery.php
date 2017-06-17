<?php
include_once 'class_DaoQuery.php';
class AuthorQuery extends DaoQuery{
	private $log_file = 1;

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_author';
	}

	public  function insertQuery(){
		$query = "INSERT INTO
			  `" . $this->table. "`
			(
			  `id`,
			  `last_name_kaz`,
			  `last_name_rus`,
			  `last_name_eng`,
			  `first_name_kaz`,
			  `first_name_rus`,
			  `first_name_eng`,
			  `patronymic_name_kaz`,
			  `patronymic_name_rus`,
			  `patronymic_name_eng`,
			  `organization_name`,
			  `organization_id`,
			  `email`,
			  `degree`,
			  `user`
			)
			VALUE (
			  :id,
			  :last_name_kaz,
			  :last_name_rus,
			  :last_name_eng,
			  :first_name_kaz,
			  :first_name_rus,
			  :first_name_eng,
			  :patronymic_name_kaz,
			  :patronymic_name_rus,
			  :patronymic_name_eng,
			  :organization_name,
			  :organization_id,
			  :email,
			  :degree,				
			  :user
			)";

		log_echo($query, $this->log_file);
		

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		//$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':last_name_kaz', $this->object->last_name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':last_name_rus', $this->object->last_name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':last_name_eng', $this->object->last_name_eng, PDO::PARAM_STR);

		$stmt->bindValue(':first_name_kaz', $this->object->first_name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':first_name_rus', $this->object->first_name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':first_name_eng', $this->object->first_name_eng, PDO::PARAM_STR);

		$stmt->bindValue(':patronymic_name_kaz', $this->object->patronymic_name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name_rus', $this->object->patronymic_name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name_eng', $this->object->patronymic_name_eng, PDO::PARAM_STR);
		
		$stmt->bindValue(':organization_name', $this->object->organization_name, PDO::PARAM_STR);
		$stmt->bindValue(':organization_id', $this->object->organization_id, PDO::PARAM_STR);
		
		$stmt->bindValue(':email', $this->object->email, PDO::PARAM_STR);
		$stmt->bindValue(':degree', $this->object->degree, PDO::PARAM_STR);
		
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
		//echo "<h1>" .$this->pdo->lastInsertId() . "</h1>";
		return $this->pdo->lastInsertId();
	}

	public  function updateQuery($by_column=null){
		$query = "UPDATE
					  `" . $this->table . "`
					SET
					  `last_name_kaz` = :last_name_kaz,
					  `last_name_rus` = :last_name_rus,
					  `last_name_eng` = :last_name_eng,
					  `first_name_kaz` = :first_name_kaz,
					  `first_name_rus` = :first_name_rus,
					  `first_name_eng` = :first_name_eng,
					  `patronymic_name_kaz` = :patronymic_name_kaz,
					  `patronymic_name_rus` = :patronymic_name_rus,
					  `patronymic_name_eng` = :patronymic_name_eng,
					  `organization_name` = :organization_name,
					  `organization_id` = :organization_id,
					  `email` = :email,
					  `degree` = :degree,				
					  `user` = :user
					WHERE
					  `id` = :id
				";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':last_name_kaz', $this->object->last_name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':last_name_rus', $this->object->last_name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':last_name_eng', $this->object->last_name_eng, PDO::PARAM_STR);
		$stmt->bindValue(':first_name_kaz', $this->object->first_name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':first_name_rus', $this->object->first_name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':first_name_eng', $this->object->first_name_eng, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name_kaz', $this->object->patronymic_name_kaz, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name_rus', $this->object->patronymic_name_rus, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name_eng', $this->object->patronymic_name_eng, PDO::PARAM_STR);
		$stmt->bindValue(':organization_name', $this->object->organization_name, PDO::PARAM_STR);
		$stmt->bindValue(':organization_id', $this->object->organization_id, PDO::PARAM_STR);
		$stmt->bindValue(':email', $this->object->email, PDO::PARAM_STR);
		$stmt->bindValue(':degree', $this->object->degree, PDO::PARAM_STR);
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
				//$object->publication_id=$row['publication_id'];
				$object->last_name_kaz=$row['last_name_kaz'];
				$object->first_name_kaz=$row['first_name_kaz'];
				$object->patronymic_name_kaz=$row['patronymic_name_kaz'];
				$object->last_name_rus=$row['last_name_rus'];
				$object->first_name_rus=$row['first_name_rus'];
				$object->patronymic_name_rus=$row['patronymic_name_rus'];
				$object->last_name_eng=$row['last_name_eng'];
				$object->first_name_eng=$row['first_name_eng'];
				$object->patronymic_name_eng=$row['patronymic_name_eng'];
				$object->organization_name=$row['organization_name'];
				$object->organization_id=$row['organization_id'];
				$object->email=$row['email'];
				$object->degree=$row['degree'];
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
?>
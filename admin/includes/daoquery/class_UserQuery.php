<?php
class UserQuery extends DaoQuery{

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_user';
	}
	public  function insertQuery(){
		$query = "INSERT INTO
				  `". $this->table . "`
				(
				  `id`,
				  `username_email`,
				  `password`,
				  `active`,
				  `last_name`,
				  `first_name`,
				  `patronymic_name`,
				  `last_name_en`,
				  `first_name_en`,
				  `patronymic_name_en`,
				  `departament`,
				  `status`,
				  `sex_id`,
				  `date_birth`,
				  `project`,
				  `comments`,
				  `user`,
				  `insert_date`
				)
				VALUE (
				  :id,
				  :username_email,
				  :password,
				  :active,
				  :last_name,
				  :first_name,
				  :patronymic_name,
				  :last_name_en,
				  :first_name_en,
				  :patronymic_name_en,
				  :departament,
				  :status,
				  :sex_id,
				  :date_birth,
				  :project,
				  :comments,
				  :user,
				  :insert_date
				)";



		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':username_email', $this->object->username_email, PDO::PARAM_STR);
		$stmt->bindValue(':password', $this->object->password, PDO::PARAM_STR);
		$stmt->bindValue(':active', $this->object->active, PDO::PARAM_STR);
		$stmt->bindValue(':last_name', $this->object->last_name, PDO::PARAM_STR);
		$stmt->bindValue(':first_name', $this->object->first_name, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name', $this->object->patronymic_name, PDO::PARAM_STR);
		$stmt->bindValue(':last_name_en', $this->object->last_name_en, PDO::PARAM_STR);
		$stmt->bindValue(':first_name_en', $this->object->first_name_en, PDO::PARAM_STR);
		$stmt->bindValue(':patronymic_name_en', $this->object->patronymic_name_en, PDO::PARAM_STR);
		$stmt->bindValue(':departament', $this->object->departament, PDO::PARAM_STR);
		$stmt->bindValue(':status', $this->object->status, PDO::PARAM_STR);
		$stmt->bindValue(':sex_id', $this->object->sex_id, PDO::PARAM_STR);
		$stmt->bindValue(':date_birth', $this->object->date_birth, PDO::PARAM_STR);
		$stmt->bindValue(':project', $this->object->project, PDO::PARAM_STR);
		$stmt->bindValue(':comments', $this->object->comments, PDO::PARAM_STR);
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
		exit("UnsupportedOperationException");
	}

	public function fromRowsToArrayObjects($rows){
		$returnObjects = array();

		if($rows != null){
			foreach ($rows as $row){
				$object = new User();
				$object->id=$row['id'];
				$object->username_email=$row['username_email'];
				$object->password=$row['password'];
				$object->active=$row['active'];

				$object->last_name=$row['last_name'];
				$object->first_name=$row['first_name'];
				$object->patronymic_name=$row['patronymic_name'];

				$object->last_name_en=$row['last_name_en'];
				$object->first_name_en=$row['first_name_en'];
				$object->patronymic_name_en=$row['patronymic_name_en'];

				$object->departament=$row['departament'];
				$object->status=$row['status'];
				$object->sex_id=$row['sex_id'];
				$object->date_birth=$row['date_birth'];
				$object->project=$row['project'];
				$object->comments=$row['comments'];
				$object->role=$row['role'];
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
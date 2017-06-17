<?php
class ConferenceQuery extends DaoQuery{

	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_conference';
	}
	public  function insertQuery(){
		$query = "INSERT INTO
				  `". $this->table . "`
				(
				  `id`,
				  `name`,
				  `sbornik_name`,
				  `city`,
				  `country`,
				  `type_id`,
				  `level_id`,
				  `date_start`,
				  `date_finish`,
				  `add_info`,
				  `user`,
				  `insert_date`
				)
				VALUE (
				:id,
				:name,
				:sbornik_name,
				:city,
				:country,
				:type_id,
				:level_id,
				:date_start,
				:date_finish,
				:add_info,
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
			  `name` = :name,
			  `sbornik_name` = :sbornik_name,
			  `city` = :city,
			  `country` = :country,
			  `type_id` = :type_id,
			  `level_id` = :level_id,
			  `date_start` = :date_start,
			  `date_finish` = :date_finish,
			  `add_info` = :add_info,
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
				$object = new Conference();
				$object->id=$row['id'];
				$object->name=$row['name'];
				$object->sbornik_name=$row['sbornik_name'];
				$object->city=$row['city'];
				$object->country=$row['country'];
				$object->type_id=$row['type_id'];
				$object->level_id=$row['level_id'];
				$object->date_start=getDateFromSqlDate($row['date_start']);
				$object->date_finish=getDateFromSqlDate($row['date_finish']);
				$object->add_info=$row['add_info'];
				$object->user=$row['user'];
				$object->insert_date=$row['insert_date'];
				$returnObjects[] = $object;
			}
		}

		return $returnObjects;
	}
	public function bindValue(&$stmt){
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $this->object->name, PDO::PARAM_STR);
		$stmt->bindValue(':sbornik_name', $this->object->sbornik_name, PDO::PARAM_STR);
		$stmt->bindValue(':city', $this->object->city, PDO::PARAM_STR);
		$stmt->bindValue(':country', $this->object->country, PDO::PARAM_STR);
		$stmt->bindValue(':type_id', $this->object->type_id, PDO::PARAM_STR);
		$stmt->bindValue(':level_id', $this->object->level_id, PDO::PARAM_STR);
		$stmt->bindValue(':date_start', getSqlDateFromDate($this->object->date_start), PDO::PARAM_STR);
		$stmt->bindValue(':date_finish', getSqlDateFromDate($this->object->date_finish), PDO::PARAM_STR);
		$stmt->bindValue(':add_info', $this->object->add_info, PDO::PARAM_STR);
		$stmt->bindValue(':user', $this->object->user, PDO::PARAM_STR);
		$stmt->bindValue(':insert_date', $this->object->insert_date, PDO::PARAM_STR);
	}

}
?>
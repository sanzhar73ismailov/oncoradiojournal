<?php
class IssueSectionQuery extends DaoQuery{
	public function __construct($pdo, $object){
		parent::__construct($pdo, $object);
		$this->table = 'bibl_issue_section';
	}

	public  function insertQuery(){
		$query = "INSERT INTO
			  `" . $this->table. "`
			(
			  `id`,
			  `issue_id`,
			  `section_id`,
			  `order_field`
			)
			VALUE (
			  :id,
			  :issue_id,
			  :section_id,
			  :order_field
			)";
		//echo "query:" . $query . "</br>";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		//$stmt->bindValue(':publication_id', $this->object->publication_id, PDO::PARAM_STR);
		$stmt->bindValue(':issue_id', $this->object->issue_id, PDO::PARAM_STR);
		$stmt->bindValue(':section_id', $this->object->section_id, PDO::PARAM_STR);
		$stmt->bindValue(':order_field', $this->object->order_field, PDO::PARAM_STR);
		
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
					  `issue_id` = :issue_id,
					  `section_id` = :section_id,
					  `order_field` = :order_field
					WHERE
					  `id` = :id
				";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
		$stmt->bindValue(':issue_id', $this->object->issue_id, PDO::PARAM_STR);
		$stmt->bindValue(':section_id', $this->object->section_id, PDO::PARAM_STR);
		$stmt->bindValue(':order_field', $this->object->order_field, PDO::PARAM_STR);
			
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
				$object = new IssueSection();
				$object->id=$row['id'];
				$object->issue_id=$row['issue_id'];
				$object->section_id=$row['section_id'];
				if(isset($row['section_name'])){
				  $object->section_name=$row['section_name'];
				}
				$object->order_field=$row['order_field'];
				$returnObjects[] = $object;
			}
		}
		return $returnObjects;
	}
	


	public function bindValue(&$stmt){
		exit("UnsupportedOperation");
	}

}
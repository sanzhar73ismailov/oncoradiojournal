<?php
//include_once '../global.php';
//$LOGGER = Logger::getLogger("index.php", null, TO_LOG);
abstract class DaoQuery{

	protected  $pdo;
	protected $object;
	protected $table;

	public function __construct($pdo, $object){
		$this->pdo = $pdo;
		$this->object = $object;
	}

	public abstract function insertQuery();

	public abstract  function updateQuery($by_column=null);

	public  function selectQueryAll($order=null){

		$returnObjects = array();
		$query =  "SELECT *	FROM `" . $this->table . "` p ";
		if($order != null){
			$query .= $order;
		}
		log_echo ("DaoQuery.selectQueryAll query:" . $query);
		try {
			$stmt = $this->pdo->prepare($query);
			//$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		if(count($rows) == 0){
			return null;
		}
		$returnObjects = $this->fromRowsToArrayObjects($rows);
		//var_dump($returnObjects);
		return $returnObjects;

			
	}

	public  function selectQueryManyByCondition($conditionArray, $order=null){
		$returnObjects = array();
		$rows = $this->forSelectQueryManyByCondition($this->table, $conditionArray, $order);
		$returnObjects = $this->fromRowsToArrayObjects($rows);
		return $returnObjects;
	}

	public  function selectQueryOneById(){
		$rows = array();
		$retObjs = array();
		$query =  "SELECT * FROM `" . $this->table . "`  WHERE id = :id";
		try {
			$stmt = $this->pdo->prepare($query);
			$stmt->bindValue(':id', $this->object->id, PDO::PARAM_INT);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}

		if(count($rows) == 0){
			return null;
		}
		$retObjs = $this->fromRowsToArrayObjects($rows);

		return $retObjs[0];

	}

	public  function selectQueryNative($query){
		$returnObjects = array();
		$rows = array();

		try {
			$stmt = $this->pdo->prepare($query);
			//$stmt->bindValue(':name', $name, PDO::PARAM_STR);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		if(count($rows) == 0){
			return $returnObjects;
		}

		$returnObjects = $this->fromRowsToArrayObjects($rows);
		//var_dump($returnObjects);

		return $returnObjects;
	}
	public abstract  function fromRowsToArrayObjects($rows);
	protected  function forSelectQueryManyByCondition( $table, $conditionArray, $order="id"){

		$returnObjects = array();
		$rows = array();
		$query =  "SELECT * FROM " .$table . " t  WHERE 1=1 ";
		foreach ($conditionArray as $condition_object){

			$query .= " AND " . $condition_object->column ." " . $condition_object->operator . " :" .  $condition_object->column;

		}
		$query .=  " order by " . $order;

		//echo $query . "<br>";
		//exit("<h1>" .$query ."</h1>");

		try {
			$stmt = $this->pdo->prepare($query);

			foreach ($conditionArray as $condition_object){
				if($condition_object->type == "str"){
					$stmt->bindValue(":" .  $condition_object->column,  $condition_object->value, PDO::PARAM_STR);

				}elseif($condition_object->type == "int"){
					$stmt->bindValue(":" .  $condition_object->column,  $condition_object->value, PDO::PARAM_INT);
				}
			}

			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		//if(count($rows) == 0){
		//	return null;
		//}
		return $rows;
	}
	public function deleteQuery(){
		return $this->forDeleteQuery();
	}
	protected  function forDeleteQuery(){
		$query = "DELETE FROM `" . $this->table ."`	WHERE `id` = :id";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindValue(':id', $this->object->id, PDO::PARAM_STR);
		try {
			$stmt->execute();
			$affected_rows = $stmt->rowCount();
			if($affected_rows < 1){
				die("Ошибка, объект не удален");
			}
		} catch(PDOException $ex) {
			echo "Ошибка:" . $ex->getMessage();
		}
		return $affected_rows;
	}
	public abstract function bindValue(&$stmt);
}
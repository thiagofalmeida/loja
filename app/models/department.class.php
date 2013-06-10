<?php 
class Department extends Base {

	private $name;

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public static function findById($id){
		$db_conn = Database::getConnection();
		$sql = "select * from departments where id = $1;";
		$params = array($id);
		$resp = pg_query_params($db_conn, $sql, $params);
		
		if (!$resp) { pg_close($db_conn); return null; }

		if ($row = pg_fetch_assoc($resp)) {
			$department = new Department($row);
			pg_close($db_conn);
			return $department;
		}
		
		pg_close($db_conn);
		return null;
	}

	public function validates() {
		Validations::notEmpty($this->name, 'name', $this->errors);
		Validations::notEmpty($this->id, 'id', $this->errors);
	}

	public function delete() {
		$db_conn = Database::getConnection();
		$params = array($this->id);
		$sql = "delete from departments where id = $1";
		$resp = pg_query_params($db_conn, $sql, $params);

		pg_close($db_conn);
		return $resp;
	}

	public static function getAll(){
      	$sql = "select * from departments;";
      	$resp = pg_query(Database::getConnection(), $sql);
      	$departments = array();

      	while ($row = pg_fetch_assoc($resp)) {
       		$departments[] = new Department($row);
      	}

      	return $departments;
    }

    public static function nextVal(){
		$sql = "select max(id) from departments";
		$resp = pg_query(Database::getConnection(), $sql);
		
		$result = pg_fetch_assoc($resp);
		$result = $result['max'] + 1;
	    return $result;
	}

	public function save() {
		if (!$this->isvalid()) return false;
		
		$sql = "INSERT INTO departments (name, createdAt) values ($1, $2) RETURNING ID;";
		$params = array($this->name, $this->createdAt);
		$db_conn = Database::getConnection();
		$resp = pg_query_params($db_conn, $sql, $params);

		if (!$resp) {
			Logger::getInstance()->log("Falha para salvar o objeto: " . print_r($this, TRUE), Logger::ERROR);
			Logger::getInstance()->log("Error: " . print_r(error_get_last(), true), Logger::ERROR);
			pg_close($db_conn);
			return false;
		}

		$this->setId(pg_fetch_assoc($resp)['id']);
		pg_close($db_conn);
		return true;
	}

	public function update() {
		if (!$this->isValid()) return false;
		
		$db_conn = Database::getConnection();
		$params = array($this->name, $this->id);
		$sql = "update departments set name=$1 where id = $2";

		$resp = pg_query_params($db_conn, $sql, $params);
		pg_close($db_conn);
		return $resp;
	}
}
?>

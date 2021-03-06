<?php 
class Product extends Base {

	private $name;
	private $description;
	private $price;
	private $stock;
	private $feactured;
	private $department_id;
	private $photo;
	private $photoName;

	public function __construct($data = array()) {
		parent::__construct($data);
		$this->photo = new Photo(array(), 'products');
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}

	public function setPhoto($photo) {
		$this->photo = $photo;
		$this->setPhotoName($photo->getName());
	}

	public function getPhoto() {
		return $this->photo;
	}

	public function setPhotoName($photoName) {
		$this->photoName = $photoName;
	}

	public function getPhotoName() {
		return $this->photoName;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setPrice($price) {
		$this->price = $price;
	}

	public function getPrice() {
		return $this->price;
	}

	public function setStock($stock) {
		$this->stock = $stock;
	}

	public function getStock() {
		return $this->stock;
	}

	public function setFeactured($feactured) {
		$this->feactured = $feactured;
	}

	public function getFeactured() {
		return $this->feactured == 't';
	}

	public function setDepartment_Id($department_id) {
		$this->department_id = $department_id;
	}

	public function getDepartment_Id() {
		return $this->department_id;
	}

	public static function getFeacturedProducts(){
		$sql = "select * from products where feactured = 't';";
      	$resp = pg_query(Database::getConnection(), $sql);
      	$products = array();

      	while ($row = pg_fetch_assoc($resp)) {
       		$products[] = new Product($row);
      	}

      	return $products;
	}

	public function validates() {
		Validations::notEmpty($this->name, 'name', $this->errors);
		Validations::notEmpty($this->description, 'description', $this->errors);
		Validations::notANumber($this->price, 'price', $this->errors);
		Validations::notEmpty($this->price, 'price', $this->errors);
		Validations::notANumber($this->stock, 'stock', $this->errors);
		Validations::notEmpty($this->stock, 'stock', $this->errors);
		
		/* se a foto existir e não for valida */
		if ($this->photo && $this->photo->hasImage() && !$this->photo->isValid()) {
			$this->errors['photo'] = array_values($this->photo->errors())[0];
		}
	}
	
	public static function getStockById($id) {
		$db_conn = Database::getConnection();
		$sql = "select stock from products where id = $1;";
		$params=array($id);
      	$resp = pg_query_params($db_conn, $sql, $params);
      	
		if (!$resp) { pg_close($db_conn); return null; }

		if ($row = pg_fetch_assoc($resp)) {
			$product = new Product($row);
			return $product->getStock();
		}
		
		return null;
	}
	
	public static function decreaseStock($id, $qnt) {
		$db_conn = Database::getConnection();
		$sql = "update products set stock=stock-$1 where id=$2";
		$params=array($qnt, $id);
      	$resp = pg_query_params($db_conn, $sql, $params);
		
		return $resp;
	}

	public static function getAll(){
      	$sql = "select * from products;";
      	$resp = pg_query(Database::getConnection(), $sql);
      	$products = array();
	
      	while ($row = pg_fetch_assoc($resp)) {
       		$products[] = new Product($row);
      	}

      	return $products;
    }
	
	public static function getAllByPage($qnt, $pageNum) {
		$db_conn = Database::getConnection();
		$sql = "select * from products limit $1 offset $2;";
		$inicial=($pageNum-1) * $qnt;
		$params=array($qnt,$inicial);
      	$resp = pg_query_params($db_conn, $sql, $params);
      	$products = array();

      	while ($row = pg_fetch_assoc($resp)) {
       		$products[] = new Product($row);
      	}

      	return $products;	
	}
	
	public static function findByName($name) {
		$name=strtolower($name);
		$sql = "select * from products where LOWER(name) like '%$name%'; ";
      	$resp = pg_query(Database::getConnection(), $sql);
      	$products = array();
	
      	while ($row = pg_fetch_assoc($resp)) {
       		$products[] = new Product($row);
      	}

      	return $products;	
	}

    public static function findById($id){
		$db_conn = Database::getConnection();
		$sql = "select * from products where id = $1;";
		$params = array($id);
		$resp = pg_query_params($db_conn, $sql, $params);
		
		if (!$resp) { pg_close($db_conn); return null; }

		if ($row = pg_fetch_assoc($resp)) {
			$product = new Product($row);
			return $product;
		}
		
		return null;
	}

	public static function getDepartmentName($id) {
		$db_conn = Database::getConnection();
		$sql = "select name from departments where id = $1;";
		$params = array($id);
		$resp = pg_query_params($db_conn, $sql, $params);

		if (!$resp) { pg_close($db_conn); return null; }

		if ($row = pg_fetch_assoc($resp)) {
			$department = new Department($row);
			pg_close($db_conn);
			return $department->getName();
		}

		pg_close($db_conn);
		return null;
	}

	public static function findByDepartment($id) {
		$db_conn = Database::getConnection();
		// PEGANDO QUANTIDADE DE REGISTROS
		$sql_qnt = "select * from products where department_id = $1";
		$params = array($id);
		$resp = pg_query_params($db_conn, $sql_qnt, $params);
		$numRows = pg_num_rows($resp);
		
		// SQL COM PAGINACAO
		$sql = "select * from products where department_id = $1 limit $2 offset $3;";
		
		// QUANTIDADE DE REGISTROS PERMITIDOS
		$pageNum = 1;
		
		if (isset($_GET['pagina'])) {
			$pageNum=$_GET['pagina'];
		}

		$inicial = ($pageNum-1) * QNT_PROD;
		$params = array($id, QNT_PROD, $inicial);
		$resp = pg_query_params($db_conn, $sql, $params);

		if (!$resp) { pg_close($db_conn); return null; }
		
		$products = array();

      	while ($row = pg_fetch_assoc($resp)) {
       		$products[] = new Product($row);
      	}
		

		pg_close($db_conn);
		$ret = array('products' => $products, 'numRows' => $numRows);
		return $ret;
	}

	public function delete() {
		$db_conn = Database::getConnection();
		$params = array($this->id);
		$sql = "delete from products where id = $1";
		$resp = pg_query_params($db_conn, $sql, $params);
		
		$this->photo->setName($this->photoName);
		$this->photo->delete();

		pg_close($db_conn);
		return $resp;
	}

    public function save() {
    	if (!$this->isvalid()) return false;

    	if ($this->photo && $this->photo->hasImage())
    		$this->photo->saveToDisc();

    	$this->photoName = $this->photo->getName();

    	$sql = "INSERT INTO products (name, description, photoName, price, feactured, stock, createdAt, department_id) values ($1, $2, $3, $4, $5, $6, $7, $8) RETURNING ID;";
		$params = array($this->name, $this->description,  $this->photoName, $this->price, $this->feactured, $this->stock, $this->createdAt, $this->department_id);
		$db_conn = Database::getConnection();
		$resp = pg_query_params($db_conn, $sql, $params);

    	if (!$resp) {
    		Logger::getInstance()->log("Falha para salvar o objeto: " . print_r($this, TRUE), Logger::ERROR);
    		Logger::getInstance()->log("Error: " . print_r(error_get_last(), true), Logger::ERROR);
    		return false;
    	}

    	$this->setId(pg_fetch_assoc($resp)['id']);
    	pg_close($db_conn);
    	return true;
    }

    public function update() {
		if (!$this->isValid()) return false;
		
		$db_conn = Database::getConnection();
		$params = array($this->name, $this->description,  $this->photoName, $this->price, $this->feactured, $this->stock, $this->department_id, $this->id);
		$sql = "UPDATE products SET name=$1, description=$2, photoName=$3, price=$4, feactured=$5, stock=$6, department_id=$7 WHERE id = $8";

		$resp = pg_query_params($db_conn, $sql, $params);
		pg_close($db_conn);
		return $resp;
	}

	public static function nextVal(){
		$sql = "select max(id) from products";
		$resp = pg_query(Database::getConnection(), $sql);
		
		$result = pg_fetch_assoc($resp);
		$result = $result['max'] + 1;
		return $result;
	}

}
?>
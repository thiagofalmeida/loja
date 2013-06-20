<?php
class Order extends Base {
	private $status;
	private $total;
	private $user_id;

	public function validates() {}
	
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->photo = new Photo(array(), 'products');
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setTotal($total) {
		$this->total = $total;
	}

	public function getTotal() {
		return $this->total;
	}

	public function setUser_id($user_id) {
		$this->user_id = $user_id;
	}

	public function getUser_id() {
		return $this->user_id;
	}
	
	public static function findById($id){
		$db_conn = Database::getConnection();
		$sql = "select * from orders where id = $1;";
		$params = array($id);
		$resp = pg_query_params($db_conn, $sql, $params);
		
		if (!$resp) { pg_close($db_conn); return null; }

		if ($row = pg_fetch_assoc($resp)) {
			$order = new Order($row);
			pg_close($db_conn);
			return $order;
		}
		
		pg_close($db_conn);
		return null;
	}
	
	public static function getAllByPage() {
		$db_conn = Database::getConnection();
		// PEGANDO QUANTIDADE DE REGISTROS
		$sql_qnt = "select * from orders";
		$resp = pg_query($db_conn, $sql_qnt);
		$numRows = pg_num_rows($resp);
		
		// SQL COM PAGINACAO
		$sql = "select * from orders limit $1 offset $2;";
		
		// QUANTIDADE DE REGISTROS PERMITIDOS
		$pageNum = 1;
		
		if (isset($_GET['pagina'])) {
			$pageNum=$_GET['pagina'];
		}

		$inicial = ($pageNum-1) * QNT_PROD;
		$params = array(QNT_PROD, $inicial);
		$resp = pg_query_params($db_conn, $sql, $params);

		if (!$resp) { pg_close($db_conn); return null; }
		
		$orders = array();

      	while ($row = pg_fetch_assoc($resp)) {
       		$orders[] = new Order($row);
      	}
		

		pg_close($db_conn);
		$ret = array('orders' => $orders, 'numRows' => $numRows);
		return $ret;
	}
	
	
	public function saveProducts() {
		$products = $_COOKIE['cart'];
		$db_conn = Database::getConnection();
		foreach ($products as $key => $value) {
			$sql = "INSERT INTO items_orders (order_id, product_id, product_value, qnt) values ($1, $2, $3, $4);";
			$params = array($this->id, $key, Product::findById($key)->getPrice(), $value);	
			$resp = pg_query_params($db_conn, $sql, $params);
			if (!$resp) {
    			Logger::getInstance()->log("Falha para salvar o objeto: " . print_r($this, TRUE), Logger::ERROR);
    			Logger::getInstance()->log("Error: " . print_r(error_get_last(), true), Logger::ERROR);
    			return false;
    		}
		}
		pg_close($db_conn);
    	return true;
	}
	
	public function save() {
    	$sql = "INSERT INTO orders (createdAt, status, total, user_id) values ($1, $2, $3, $4) RETURNING ID;";
		$params = array($this->createdAt, $this->status, $this->total, $this->user_id);
		$db_conn = Database::getConnection();
		$resp = pg_query_params($db_conn, $sql, $params);

    	if (!$resp) {
    		Logger::getInstance()->log("Falha para salvar o objeto: " . print_r($this, TRUE), Logger::ERROR);
    		Logger::getInstance()->log("Error: " . print_r(error_get_last(), true), Logger::ERROR);
    		return false;
    	}

    	$this->setId(pg_fetch_assoc($resp)['id']);
    	$this->saveProducts();

    	//setcookie("cart[{$this->product_id}]", "", time() - 3600 * 48, '/');
		$products = $_COOKIE['cart'];
		foreach ($products as $key => $value) {
			setcookie("cart[{$key}]", "", time() - 3600 * 48, '/');
		}
		
			//print_r($key);
		//}
		//print_r($_COOKIE['cart']);
		//var_dump($products);
		//print_r($products);
    	return true;
    }
}
?>
<?php 
class ItemOrder extends Base {
	private $qnt;
	private $product_value;
	private $order_id;
	private $product_id;

	public function validates() {}
	
	public function initialize() {}

	public static function getTotalFromItems() {
		if (isset($_COOKIE['cart'])) {
			$products = $_COOKIE['cart'];
			$total = 0;
			foreach ($products as $key => $value) {
				$total = $total + (Product::findById($key)->getPrice() * $value);
			}
			return $total;
		}
		return false;
	}
	
	public static function deleteItemsFromOrder($orderId) {
		$db_conn = Database::getConnection();
		$params = array($orderId);
		$sql = "delete from items_orders where order_id = $1";
		$resp = pg_query_params($db_conn, $sql, $params);
		if ($resp) {
			return true;
		}
		return false;
	}

	public function setQnt($qnt) {
		$this->qnt = $qnt;
	}

	public function getQnt() {
		return $this->qnt;
	}

	public function setProduct_value($product_value) {
		$this->product_value = $product_value;
	}

	public function getProduct_value() {
		return $this->product_value;
	}

	public function setOrder_id($order_id) {
		$this->order_id = $order_id;
	}

	public function getOrder_id() {
		return $this->order_id;
	}

	public function setProduct_id($product_id) {
		$this->product_id = $product_id;
	}

	public function getProduct_id() {
		return $this->product_id;
	}
}
?>
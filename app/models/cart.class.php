<?php 
class Cart {

	private function exist($id) {
		if (!isset($_COOKIE["cart"][$id]))
			return false;
		
		return true;
	}

	public function add($id) {
		if ($this->exist($id)) {
			$qnt = $_COOKIE["cart"][$id] + 1;
			setcookie("cart[{$id}]", $qnt, time() + 3600 * 48);
			return true;
		} else {
			setcookie("cart[{$id}]", 1, time() + 3600 * 48);
			return true;
			
		}
		return false;
			
	}

	public static function getItemsOnCart() {
		if (isset($_COOKIE['cart'])){
			return sizeof($_COOKIE['cart']);
		}

		return 0;
	}

	public static function getProducts() {
		if (isset($_COOKIE['cart'])) {
			return $_COOKIE['cart'];
		}
		return false;
	}

	public function getPrice($id){
		$sql= "SELECT price FROM products WHERE id = '$id';";
		$resp = pg_query(Database::getConnection(), $sql);
		$resp = pg_fetch_row($resp);
		$price = $resp[0];
		return $price;
	}

	public static function getItemName($id){
		$sql= "SELECT name FROM products WHERE id = '$id';";
		$result = pg_query($sql);
		$result = pg_fetch_row($result);
		$name = $result[0];
		return $name;
	}

	public function setItemQuantity($id, $quantity){
		if ($quantity > 0) {
			setcookie("cart[{$id}]", $quantity, time() + 3600 * 48);
		} else {
			setcookie("cart[{$id}]", "", time() - 3600 * 48);
		}
	}
}
?>
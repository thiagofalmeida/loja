<?php
class Order extends Base {
	private $orderIn;
	private $status;
	private $total;
	private $user_id;

	public function validates() {}

	public function setOrderIn($orderIn) {
		$this->orderIn = $orderIn;
	}

	public function getOrderIn() {
		return $this->orderIn;
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
}
?>
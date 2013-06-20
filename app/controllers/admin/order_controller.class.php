<?php
	namespace Admin;

	class OrderController extends \BaseController {
		
		function index() {
			$ret= \Order::getAllByPage();
			extract($ret);
			$this->render(array('view' => 'admin/orders/index.phtml', 'orders' => $orders, 'numRows' => $numRows));
		}
		
		function details($id) {
			$order=\Order::findById($id);
			$this->render(array('view' => 'admin/orders/details.phtml', 'order' => $order));
		}
	}
?>
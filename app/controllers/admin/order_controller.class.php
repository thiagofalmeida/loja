<?php
	namespace Admin;

	class OrderController extends \BaseController {
		
		function index() {
			$ret= \Order::getAllByPage();
			extract($ret);
			$this->render(array('view' => 'admin/orders/index.phtml', 'orders' => $orders, 'numRows' => $numRows));
		}
		
		function show($id) {
			$order=\Order::findById($id);
			$this->render(array('view' => 'admin/orders/show.phtml', 'order' => $order));
		}
		
		function destroy($id){
			$order=\Order::findById($id);
			$order->delete();
			flash('success', 'Pedido removido com sucesso!');
			redirect_to("/admin/pedidos");
		}
	}
?>
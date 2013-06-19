<?php
	class OrderController extends BaseController {
		
		
		public function index (){
			
  		}
		
		public function create() {
			$order = new Order();
			$order->setStatus('GERADO BOLETO');
			$order->setUser_id(2);
			$order->setTotal(ItemOrder::getTotalFromItems());
			$order->save();
			
			
			
			//$this->render(array('view' => 'order/finish.phtml', 'order' => $order));
		}
		
	
	}
?>
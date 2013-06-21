<?php
	class OrderController extends BaseController {
		
		
		public function index($id) {
			$order = Order::getAllByUser($id);
			$this->render(array('view' => 'order/index.phtml','orders' => $order));
		}
		
		public function create() {
			$cart = Cart::getProducts();
			$order = new Order();
			$order->setStatus('Boleto Gerado');
			
  			should_be_autenticated();

			$order->setUser_id(current_user()->getId());

			if (ItemOrder::getTotalFromItems() !== false) {
				$order->setTotal(ItemOrder::getTotalFromItems());

				if ($order->save()) {
					flash('success', 'Pedido realizado com sucesso!');
					$cart=null;
					$order = Order::findById($order->getid());
					$this->render(array('view' => 'order/list.phtml', 'cart' => $cart, 'order'=> $order));
				} else {
					flash('error', 'Não foi possivel realizar seu pedido por favor tente mais tarde!');
				}
			} else {
				flash('error', 'Não é possivel gerar um boleto com o carrinho vazio');
			}
			
			$this->render(array('view' => 'cart/index.phtml', 'cart' => $cart));
		}
		
		public function id($id) {
			$order = Order::findById($id);
			$this->render(array('view'=>'order/finish.phtml', 'order' => $order));
		}
		
		public function show($id) {
			$order = Order::findById($id);
			$this->render(array('view'=>'order/list.phtml', 'order' => $order));
		}
	}
?>
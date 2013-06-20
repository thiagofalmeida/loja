<?php
	class OrderController extends BaseController {
		
		
		public function index (){
			
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
					redirect_to("/");
				} else {
					flash('error', 'Não foi possivel realizar seu pedido por favor tente mais tarde!');
				}
			} else {
				flash('error', 'Não é possivel gerar um boleto com o carrinho vazio');
			}
			
			$this->render(array('view' => 'cart/index.phtml', 'cart' => $cart));
		}
	}
?>